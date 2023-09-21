<?php

namespace App\Http\Controllers\Backend\AccessMenu;

use App\Http\Controllers\Controller;
use App\Models\AccessGroup;
use App\Models\Menu;
use Illuminate\Http\Request;

class AccessMenuController extends Controller
{
    public function index()
    {
        return view($this->view . '.index');
    }

    public function create()
    {
        return view($this->view . '.create');
    }

    public function data(Request $request)
    {
        $data = AccessGroup::all();
        $user = $request->user();
        return datatables()->of($data)
            ->addColumn('action', function ($data) use ($user) {
                $button = '';
                if ($user->read) {
                    $button .= '<button type="button" class="btn-action btn btn-sm btn-outline" data-title="Detail" data-action="show" data-url="' . $this->url . '" data-id="' . $data->id . '" title="Tampilkan"><i class="fa fa-eye text-info"></i></button>';
                }
                if ($user->create) {
                    $button .= '<button class="btn-action btn btn-sm btn-outline" data-title="Edit" data-action="edit" data-url="' . $this->url . '" data-id="' . $data->id . '" title="Edit"> <i class="fa fa-edit text-warning"></i> </button> ';
                }
                if ($user->delete) {
                    $button .= '<button class="btn-action btn btn-sm btn-outline" data-title="Delete" data-action="delete" data-url="' . $this->url . '" data-id="' . $data->id . '" title="Delete"> <i class="fa fa-trash text-danger"></i> </button>';
                }
                return "<div class='btn-group'>" . $button . "</div>";
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'code' => 'required']);
        if ($this->model::create($request->all())) {
            $response = [
                'status' => TRUE, 'message' => 'Data berhasil disimpan',
            ];
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal disimpan']);
    }

    public function show($id)
    {
        $data = AccessGroup::find($id);
        $data['menu'] = Menu::all();
        return view($this->view . '.show', compact('data'));
    }

    public function edit($id)
    {
        $data = AccessGroup::find($id);
        $data['menu'] = Menu::all();
        return view($this->view . '.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'access_group_id' => 'required|exists:access_groups,id',
            'menu_id' => 'required'
        ]);
        $data = collect($request->menu_id)->map(function ($item) use ($id) {
            return ['access_group_id' => $id, 'menu_id' => $item];
        });
        $this->model::whereAccessGroupId($id)->forceDelete();
        if (AccessGroup::find($id)->access_menu()->createMany($data->toArray())) {
            $response = ['status' => TRUE, 'message' => 'Data berhasil disimpan'];
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal disimpan']);
    }

    public function delete($access_group_id)
    {
        $data = AccessGroup::find($access_group_id);
        return view($this->view . '.delete', compact('data'));
    }

    public function destroy($access_group_id)
    {
        if ($this->model::whereAccessGroupId($access_group_id)->forceDelete()) {
            $response = ['status' => TRUE, 'message' => 'Data berhasil dihapus'];
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal dihapus, silahkan coba lagi nanti !']);
    }
}
