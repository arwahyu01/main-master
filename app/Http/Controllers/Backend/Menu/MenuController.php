<?php

namespace App\Http\Controllers\Backend\Menu;

use App\Http\Controllers\Controller;
use App\Models\AccessGroup;
use App\support\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    public function index()
    {
        return view($this->view.'.index');
    }

    public function data()
    {
        $menu=$this->model::with(['children'])->whereNull('parent_id')->sort()->get();
        return view($this->view.'.list-menu.list-menu', compact('menu'));
    }

    public function create()
    {
        $data=[
            'model'=>Helper::listFile(app_path('/Models'), ['php']),
            'access_group'=>AccessGroup::pluck('name', 'id'),
        ];
        return view($this->view.'.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => 'nullable',
            'title' => 'required|unique:menus',
            'subtitle' => 'nullable',
            'code' => 'required|unique:menus',
            'url' => 'required|unique:menus',
            'model' => 'nullable',
            'icon' => 'required',
            'type' => 'required',
            'show' => 'nullable',
            'active' => 'nullable',
            'access_group_id' => 'required|array|exists:access_groups,id',
        ]);

        if ($data = $this->model::create($request->all())) {
            foreach ($request->access_group_id as $access_group_id) {
                $access_menu[]=['menu_id'=>$data->id, 'access_group_id'=>$access_group_id, 'access'=>$request->input('access_crud_'.$access_group_id)];
            }
            if($data->access_menu()->createMany($access_menu)) {
                $response = ['status' => TRUE, 'message' => 'Data berhasil disimpan'];
            }else{
                $data->forceDelete();
            }
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal disimpan']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $result=[
            'model'=>Helper::listFile(app_path('/Models'), ['php']),
            'data'=>$this->model::find($id),
            'access_group'=>AccessGroup::pluck('name', 'id'),
        ];
        return view($this->view.'.edit', $result);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'parent_id' => 'nullable',
            'title' => 'required',
            'subtitle' => 'nullable',
            'code' => 'required|unique:menus,code,' . $id,
            'url' => 'required|unique:menus,url,' . $id,
            'model' => 'nullable',
            'icon' => 'required',
            'type' => 'required',
            'show' => 'nullable',
            'active' => 'nullable',
            'access_group_id' => 'required|array|exists:access_groups,id',
        ]);

        if ($data = $this->model::find($id)) {
            if($data->update($request->all())) {
                $data->access_menu()->delete();
                foreach ($request->access_group_id as $access_group_id) {
                    $access_menu[]=['menu_id'=>$data->id, 'access_group_id'=>$access_group_id, 'access'=>$request->input('access_crud_'.$access_group_id)];
                }
                if($data->access_menu()->createMany($access_menu)) {
                    $response = ['status' => TRUE, 'message' => 'Data berhasil disimpan'];
                }
            }
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
        $data->access_menu()->delete();
        if ($data->forceDelete()) {
            return response()->json(['status'=>TRUE, 'message'=>'Data berhasil dihapus']);
        }
        return response()->json(['status'=>FALSE, 'message'=>'Data gagal dihapus']);
    }

    public function sorted(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->loopUpdateMenu(json_decode($request->input('sort')));
        }
        return response()->json(['status'=>TRUE, 'message'=>'Menu berhasil diurutkan']);
    }

    function loopUpdateMenu($menu, $parentMenu=NULL)
    {
        if ($menu) {
            foreach ($menu as $key=>$dt) {
                if ($this->model::find($dt->id)->update(['parent_id'=>$parentMenu, 'sort'=>$key + 1])) {
                    if (isset($dt->children) && count($dt->children) > 0) {
                        $this->loopUpdateMenu($dt->children, $dt->id);
                    }
                }
            }
        }
    }

    public function listMenu()
    {
        $menu=$this->model::with(['accessChildren'])->whereHas('access_menu', function ($query) {
            $query->where('access_group_id', Auth::user()->access_group_id);
        })->whereNull('parent_id')->show()->sort()->get();
        return response()->json(['menu'=>$menu], 200)->header('Content-Type', 'application/json');
    }

    public function convertMenuToJson()
    {
        // export menu
        $menu = $this->model::with(['children'])->whereNull('parent_id')->orderBy('created_at','asc')->get();
        $menu = $this->convertMenu($menu);
        File::makeDirectory(config_path('seeders'), 0777, true, true);
        File::put(config_path('seeders/menu.json'), json_encode($menu, JSON_PRETTY_PRINT));

        // export access group
        $accessGroup = AccessGroup::all();
        foreach ($accessGroup as $group){
            $data[] = [$group->code => $group->access_menu->pluck('menu.code')->toArray()];
        }
        File::put(config_path('seeders/access-group.json'), json_encode($data ?? [], JSON_PRETTY_PRINT));

        $response = ['status'=>TRUE, 'message'=>'Menu berhasil diexport', 'files'=>collect(File::files(config_path('seeders')))->map(function ($item) {
            return $item->getPathname();
        })];

        return response()->json($response)->header('Content-Type', 'application/json');
    }

    private function convertMenu($menu)
    {
        foreach ($menu as $dt) {
            $data[]=[
                'title'=>$dt->title,
                'subtitle'=>$dt->subtitle,
                'code'=>$dt->code,
                'model'=>collect(explode('\\', $dt->model))->last(),
                'url'=>$dt->url,
                'icon'=>$dt->icon,
                'type'=>$dt->type,
                'show'=>$dt->show,
                'active'=>$dt->active,
                'sort'=>$dt->sort,
                'children'=>$this->convertMenu($dt->children),
            ];
        }
        return $data ?? [];
    }
}

