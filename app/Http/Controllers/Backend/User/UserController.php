<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\AccessGroup;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return view($this->view.'.index');
    }

    public function create()
    {
        $level = Level::pluck('name', 'id');
        $access_group = AccessGroup::pluck('name', 'id');
        return view($this->view.'.create', compact('level', 'access_group'));
    }

    public function data()
    {
        $data = $this->model::with('level', 'access_group');
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                $button ='';
                if(Auth::user()->create){
                    $button.='<button class="btn-action btn btn-sm btn-outline" data-title="Edit" data-action="edit" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Edit"> <i class="fa fa-edit text-warning"></i> </button> ';
                }
                if(Auth::user()->delete){
                    $button.='<button class="btn-action btn btn-sm btn-outline" data-title="Delete" data-action="delete" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Delete"> <i class="fa fa-trash text-danger"></i> </button>';
                }
                return "<div class='btn-group'>".$button."</div>";
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated=Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
            'level_id'=>'required',
            'access_group_id'=>'required',
        ]);
        if ($validated->fails()) {
            $response=[
                'status'=>FALSE,
                'message'=>'Data gagal disimpan',
                'data'=>$validated->errors(),
            ];
        }
        else {
            if ($this->model::create($request->all())) {
                $response=[
                    'status'=>TRUE, 'message'=>'Data berhasil disimpan',
                ];
            }
            else {
                $response=[
                    'status'=>FALSE, 'message'=>'Data gagal disimpan',
                ];
            }
        }
        return response()->json($response);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = $this->model::findOrFail($id);
        $level = Level::pluck('name', 'id');
        $access_group = AccessGroup::pluck('name', 'id');
        return view($this->view.'.edit', compact('data', 'level', 'access_group'));
    }

    public function update(Request $request, $id)
    {
        $validated=Validator::make($request->all(), [
            'name'=>'required',
            'level_id'=>'required',
            'access_group_id'=>'required',
        ]);
        if($validated->fails()){
            $response=[
                'status'=>FALSE,
                'message'=>'Data gagal disimpan',
                'data'=>$validated->errors(),
            ];
        }
        else{
            if($request->password){
                $request->merge(['password'=>bcrypt($request->password)]);
            }
            $data=$this->model::find($id);
            if($data->update($request->all())){
                $response=[
                    'status'=>TRUE,
                    'message'=>'Data berhasil disimpan',
                ];
            }
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'Data gagal disimpan']);
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
            $response=[
                'status'=>TRUE,
                'message'=>'Data berhasil dihapus',
            ];
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'Data gagal dihapus']);
    }
}
