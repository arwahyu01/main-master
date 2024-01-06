<?php

namespace App\Http\Controllers\Backend\Faq;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index()
    {
        return view($this->view.'.index');
    }

    public function create()
    {
        $data['menu'] = Menu::pluck('title', 'id');
        return view($this->view.'.create', $data);
    }

    public function data(Request $request)
    {
        $data=$this->model::all();
        $user=$request->user();
        return datatables()->of($data)
            ->addColumn('action', function ($data) use ($user) {
                $button ='';
                if($user->read){
                    $button .= '<button type="button" class="btn-action btn btn-sm btn-outline" data-title="Detail" data-action="show" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Tampilkan"><i class="fa fa-eye text-info"></i></button>';
                }
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
            ->make(TRUE);
    }

    public function store(Request $request)
    {
        $validated=Validator::make($request->all(), [
            'title' => 'required',
			'description' => 'nullable',
			'file' => 'nullable',
			'link' => 'nullable',
			'visitors' => 'required',
			'like' => 'required',
			'dislike' => 'required',
			'publish' => 'nullable',
        ]);
        if ($validated->fails()) {
            $response=[
                'status'=>FALSE,
                'message'=>'Data gagal disimpan',
                'data'=>$validated->errors(),
            ];
        }
        else {
            $description=$request->description;
            $request->except(['description']);
            if ($data=$this->model::create($request->all())) {
                $data->update(['description'=>$this->help::uploadImageBase64($description, $data)]);
                if($request->hasFile('file')){
                    $data->file()->create([
                        'data'=>[
                            'name'=>$request->file('file')->getClientOriginalName(),
                            'disk'=>config('filesystems.default'),
                            'target'=>Storage::putFile($data->folder, $request->file('file')),
                        ],
                    ]);
                }
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
        $data = $this->model::find($id);
        return view($this->view.'.show', compact('data'));
    }

    public function edit($id)
    {
        $data['data'] = $this->model::find($id);
        $data['menu'] = Menu::pluck('title', 'id');
        return view($this->view.'.edit', $data);
    }

    public function update(Request $request, $id)
    {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'visitors' => 'required',
                'like' => 'required',
                'dislike' => 'required',
            ]);

            $data=$this->model::find($id);
            if(!$request->has('publish')){
                $request->merge(['publish'=>0]);
            }
            $request->merge(['description' => $this->help::uploadImageBase64($request->description, $data)]);
            if($data->update($request->all())){
                if ($request->hasFile('file')) {
                    if ($data->file) {
                        $data->file->forceDelete();
                    }
                    $data->file()->create([
                        'data'=>[
                            'disk'=>config('filesystems.default'),
                            'target'=>Storage::putFile($data->folder, $request->file('file')),
                            'name'=>$request->file('file')->getClientOriginalName(),
                        ],
                    ]);
                }
                $response=[
                    'status'=>TRUE, 'message'=>'Data berhasil disimpan',
                ];
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
        if ($file=$data->file) {
            $file->forceDelete();
        }
        if ($data->delete()) {
            $response=[
                'status'=>TRUE, 'message'=>'Data berhasil dihapus',
            ];
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'Data gagal dihapus']);
    }
}
