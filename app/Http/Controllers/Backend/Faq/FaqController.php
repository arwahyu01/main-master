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

    public function data()
    {
        $data=$this->model::all();
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                $button ='';
                if(Auth::user()->read){
                    $button .= '<button type="button" class="btn-action btn btn-sm btn-outline" data-title="Detail" data-action="show" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Tampilkan"><i class="fa fa-eye text-info"></i></button>';
                }
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
            ->make(TRUE);
    }

    public function indexID($id)
    {
        return view($this->view.'.index', compact('id'));
    }

    public function dataSub()
    {
        $data=$this->model::all();
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                $button ='';
                if(Auth::user()->create){
                    $button .= '<a href="'.url($this->url.'/faq-sub/index/'.$data->id).'" class="btn btn-sm btn-outline" data-title="Sub FAQ" data-action="show" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Tampilkan"><i class="fa fa-eye text-info"></i></button>';
                }
                if(Auth::user()->read){
                    $button .= '<button type="button" class="btn-action btn btn-sm btn-outline" data-title="Detail" data-action="show" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Tampilkan"><i class="fa fa-eye text-info"></i></button>';
                }
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
            ->make(TRUE);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:faqs',
            'description' => 'nullable',
            'file' => 'nullable',
            'link' => 'nullable',
            'visitors' => 'required|numeric',
            'like' => 'required|numeric',
            'dislike' => 'required|numeric',
            'publish' => 'nullable|boolean',
        ]);

        if ($data = $this->model::create($request->all())) {
            if ($request->hasFile('file')) {
                $data->file()->create([
                    'data' => [
                        'name'=>$request->file('file')->getClientOriginalName(),
                        'disk' => config('filesystems.default'),
                        'target' => Storage::putFile($data->folder, $request->file('file')),
                    ],
                ]);
            }
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
        $data['data'] = $this->model::find($id);
        $data['menu'] = Menu::pluck('title', 'id');
        return view($this->view.'.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:faqs,title,' . $id,
            'description' => 'nullable',
            'file' => 'nullable',
            'link' => 'nullable',
            'visitors' => 'required|numeric',
            'like' => 'required|numeric',
            'dislike' => 'required|numeric',
            'publish' => 'nullable|boolean',
        ]);

        $data = $this->model::find($id);
        if (!$request->has('publish')) {
            $request->merge(['publish' => 0]);
        }
        if ($data->update($request->all())) {
            if ($request->hasFile('file')) {
                if ($data->file) {
                    $data->file->forceDelete();
                }
                $data->file()->create([
                    'data' => [
                        'name'=>$request->file('file')->getClientOriginalName(),
                        'disk' => config('filesystems.default'),
                        'target' => Storage::putFile($data->folder, $request->file('file')),
                    ],
                ]);
            }
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
        if ($file=$data->file) {
            $file->forceDelete();
        }
        if ($data->delete()) {
            $response=['status'=>TRUE, 'message'=>'Data berhasil dihapus'];
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'Data gagal dihapus']);
    }
}
