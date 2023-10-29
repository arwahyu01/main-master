<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\AccessGroup;
use App\Models\Level;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view($this->view.'.index');
    }

    public function create()
    {
        $level = Level::filterLevel()->pluck('name', 'id');
        $access_group = AccessGroup::filterLevel()->pluck('name', 'id');
        return view($this->view.'.create', compact('level', 'access_group'));
    }

    public function data(Request $request)
    {
        $data = $this->model::filterLevel()->with('level', 'access_group');
        $user = $request->user();
        return datatables()->of($data)
            ->filterColumn('name',function($query,$keyword){
                $sql = "CONCAT(first_name,' ',last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addColumn('action', function ($data) use ($user) {
                $button ='';
                if($user->update){
                    $button.='<button class="btn-action btn btn-sm btn-outline" data-title="Edit" data-action="edit" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Edit"> <i class="fa fa-edit text-warning"></i> </button> ';
                }
                if($user->delete){
                    $button.='<button class="btn-action btn btn-sm btn-outline" data-title="Delete" data-action="delete" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Delete"> <i class="fa fa-trash text-danger"></i> </button>';
                }
                return "<div class='btn-group'>".$button."</div>";
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'nullable|min:3',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
            'level_id' => 'required|exists:levels,id',
            'access_group_id' => 'required|exists:access_groups,id',
        ]);
        if ($this->model::create($request->all())) {
            $response = ['status' => TRUE, 'message' => 'Data berhasil disimpan'];
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal disimpan']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = $this->model::findOrFail($id);
        $level = Level::filterLevel()->pluck('name', 'id');
        $access_group = AccessGroup::filterLevel()->pluck('name', 'id');
        return view($this->view.'.edit', compact('data', 'level', 'access_group'));
    }

    public function update(Request $request, $id)
    {
        $is_required = $request->password ? 'required' : 'nullable';
        $request->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'nullable|min:3',
            'level_id' => 'nullable|exists:levels,id',
            'access_group_id' => 'nullable|exists:access_groups,id',
            'email' => 'required|email|unique:users,email,'.$id.',id,deleted_at,NULL',
            'password' => $is_required.'|min:8|confirmed',
            'password_confirmation' => $is_required.'|min:8|same:password',
        ]);

        $data = $this->model::find($id);
        if ($data->update($request->all())) {
            $response = ['status' => TRUE, 'message' => 'Data berhasil disimpan'];
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal disimpan']);
    }

    public function delete($id)
    {
        $data=$this->model::find($id);
        return view($this->view.'.delete', compact('data'));
    }

    public function destroy($id)
    {
        $data=$this->model::find($id);
        if($data->delete()){
            $response=['status'=>TRUE, 'message'=>'Data berhasil dihapus'];
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'Data gagal dihapus']);
    }
}
