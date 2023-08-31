<?php

namespace App\Http\Controllers\Backend\Level;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        return view($this->view.'.index');
    }

    public function create()
    {
        return view($this->view.'.create');
    }

    public function data(Request $request)
    {
        $user=$request->user();
        $data=$this->model::all();
        return datatables()->of($data)
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
            ->editColumn('access', function ($data) {
                $access = '';
                foreach (collect(config('master.app.level')) as $level) {
                    if (in_array($level, ($data->access ?? []))) {
                        if ($data->access[$level] ?? false) {
                            $access.='<span class="badge badge-success">'.$level.'</span> ';
                        }
                        else {
                            $access.='<span class="badge badge-gray disabled">'.$level.'</span> ';
                        }
                    }
                }
                return $access;
            })
            ->addIndexColumn()
            ->rawColumns(['action','access'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:levels',
            'code' => 'required|unique:levels',
            'access' => 'required',
        ]);
        $request->merge(['access' => $this->model::makeLevelArray($request)]);
        if ($this->model::create($request->all())) {
            $response = ['status' => TRUE, 'message' => 'Data berhasil disimpan'];
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal disimpan']);
    }

    public function show($id)
    {
        $data = $this->model::find($id);
        return view($this->view.'.show', compact('data'));
    }

    public function edit($id)
    {
        $data = $this->model::find($id);
        return view($this->view.'.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:levels,name,' . $id . ',id',
            'code' => 'required|unique:levels,code,' . $id . ',id',
            'access' => 'required',
        ]);
        $data = $this->model::find($id);
        $request->merge(['access' => $this->model::makeLevelArray($request)]);
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
