<?php

namespace App\Http\Controllers\Backend\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function index()
    {
        return view($this->view.'.index');
    }

    public function create()
    {
        return view($this->view.'.create');
    }

    public function data()
    {
        $data=$this->model::filterByUser();
        return datatables()->of($data)
            ->addColumn('title', function ($data) {
                return $data->data['title'];
            })
            ->addColumn('content', function ($data) {
                return $data->data['content'];
            })
            ->addColumn('status', function ($data) {
                return config('template.notification.'.($data->status ? 'read' : 'unread'));
            })
            ->addColumn('action', function ($data) {
                $button ='';
                if(Auth::user()->level->canAccess('read')){
                    $button .= '<button type="button" class="btn-action btn btn-sm btn-outline" data-title="Detail" data-action="show" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Tampilkan"><i class="fa fa-eye text-info"></i></button>';
                }
                if(Auth::user()->level->canAccess('update')){
                    $button.='<button class="btn-action btn btn-sm btn-outline" data-title="Edit" data-action="edit" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Edit"> <i class="fa fa-edit text-warning"></i> </button> ';
                }
                if(Auth::user()->level->canAccess('delete')){
                    $button.='<button class="btn-action btn btn-sm btn-outline" data-title="Delete" data-action="delete" data-url="'.$this->url.'" data-id="'.$data->id.'" title="Delete"> <i class="fa fa-trash text-danger"></i> </button>';
                }
                return "<div class='btn-group'>".$button."</div>";
            })
            ->addIndexColumn()
            ->rawColumns(['action','content','status','title'])
            ->make(TRUE);
    }

    public function store(Request $request)
    {
        // store data
    }

    public function show($id)
    {
        $data = $this->model::find($id);
        $data->update(['status'=>TRUE]);
        return view($this->view.'.show', compact('data'));
    }

    public function edit($id)
    {
        $data = $this->model::find($id);
        return view($this->view.'.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // update data
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

    public function getNotification(Notification $notification)
    {
        return response()->json($notification->fetchNotification(),200);
    }

    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead(Auth::id());
        return response()->json(['status'=>true],200);
    }
}
