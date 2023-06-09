<?php

namespace App\Http\Controllers\Backend\Pengumuman;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index() : object
    {
        return view($this->view.'.index');
    }

    public function create() : object
    {
        $data=[
            'menu'=>Menu::pluck('title','id'),
            'parent'=>$this->model::pluck('title','id'),
        ];
        return view($this->view.'.create',$data);
    }

    public function data() : object
    {
        $data=$this->model::with('menu');
        return datatables()->of($data)
            ->editColumn('publish', function ($data) {
                return $data->publish ? '<span class="badge badge-success">Ya</span>' : '<span class="badge badge-danger">Tidak</span>';
            })
            ->addColumn('action', function ($data) {
                $button ='';
                if(auth()->user()->read){
                    $button .= '<button type="button" class="btn-action btn btn-sm btn-outline" data-title="Detail" data-action="show" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Tampilkan"><i class="fa fa-eye text-info"></i></button>';
                }
                if(auth()->user()->create){
                    $button.='<button class="btn-action btn btn-sm btn-outline" data-title="Edit" data-action="edit" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Edit"> <i class="fa fa-edit text-warning"></i> </button> ';
                }
                if(auth()->user()->delete){
                    $button.='<button class="btn-action btn btn-sm btn-outline" data-title="Delete" data-action="delete" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Delete"> <i class="fa fa-trash text-danger"></i> </button>';
                }
                return "<div class='btn-group'>".$button."</div>";
            })
            ->addIndexColumn()
            ->rawColumns(['action','publish'])
            ->make(TRUE);
    }

    public function store(Request $request) : object
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'title' => 'required',
            'start' => 'required|date|before:end',
            'end' => 'required|date|after:start',
            'content' => 'required',
            'urgency' => 'required',
            'publish' => 'nullable',
            'parent_id' => 'nullable',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        if ($pengumuman = $this->model::create($request->all())) {
            if ($request->hasFile('file')) {
                $pengumuman->file()->create([
                    'data' => [
                        'name' => $request->file('file')->getClientOriginalName(),
                        'disk' => config('filesystems.default'),
                        'target' => Storage::disk(config('filesystems.default'))->putFile($this->code . '/' . date('Y') . '/' . date('m') . '/' . date('d'), $request->file('file')),
                    ]
                ]);
            }
            $users = $request->user()->all_user_id;
            $this->help::sendNotification($pengumuman, $users, [
                'title' => 'Pengumuman Baru',
                'link' => $pengumuman->link,
                'icon' => 'fa fa-bullhorn',
                'color' => 'text-info',
                'content' => $pengumuman->title
            ]);
            $response = ['status' => TRUE, 'message' => 'Data berhasil disimpan'];
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal disimpan']);
    }

    public function show($id) : object
    {
        $data = $this->model::find($id);
        return view($this->view.'.show', compact('data'));
    }

    public function edit($id) : object
    {
        $data=[
            'menu'=>Menu::pluck('title', 'id'),
            'data'=>$this->model::find($id),
            'parent'=>$this->model::pluck('title', 'id'),
        ];
        return view($this->view.'.edit', $data);
    }

    public function update(Request $request, $id) : object
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'title' => 'required',
            'start' => 'required|date|before:end',
            'end' => 'required|date|after:start',
            'content' => 'required',
            'urgency' => 'required',
            'publish' => 'nullable',
            'parent_id' => 'nullable',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        $request->has('publish') ? $request->merge(['publish' => 1]) : $request->merge(['publish' => 0]);
        $data = $this->model::find($id);
        if ($data->update($request->all())) {
            $response = ['status' => TRUE, 'message' => 'Data berhasil disimpan'];
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal disimpan']);
    }

    public function delete($id) : object
    {
        $data=$this->model::find($id);
        return view($this->view.'.delete', compact('data'));
    }

    public function destroy($id) : object
    {
        $data=$this->model::find($id);
        if($data->delete()){
            $response=['status'=>TRUE, 'message'=>'Data berhasil dihapus'];
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'Data gagal dihapus']);
    }

    public function detail($id, $title) : object
    {
        if($data=$this->model::find($id)) {
            return view($this->view.'.detail', compact('data', 'title'));
        }
        abort(404, 'Halaman tidak ditemukan');
    }
}
