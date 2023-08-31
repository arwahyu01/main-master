<?php

namespace App\Http\Controllers\Backend\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
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
        $user = $request->user();
        $data = $this->model::filterByUser();
        return datatables()->of($data)
            ->addColumn('title', function ($data) {
                return $data->data['title'];
            })
            ->addColumn('content', function ($data) {
                return $data->data['content'];
            })
            ->addColumn('status', function ($data) {
                return config('template.notification.' . ($data->status ? 'read' : 'unread'));
            })
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
            ->rawColumns(['action', 'content', 'status', 'title'])
            ->make(TRUE);
    }

    public function store(Request $request)
    {
        // store data
    }

    public function show($id)
    {
        $data = $this->model::find($id);
        $data->update(['status' => TRUE]);
        return view($this->view . '.show', compact('data'));
    }

    public function edit($id)
    {
        $data = $this->model::find($id);
        return view($this->view . '.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // update data
    }

    public function delete($id)
    {
        $data = $this->model::find($id);
        return view($this->view . '.delete', compact('data'));
    }

    public function destroy($id)
    {
        $data = $this->model::find($id);
        if ($data->delete()) {
            $response = ['status' => TRUE, 'message' => 'Data berhasil dihapus'];
        }
        return response()->json($response ?? ['status' => FALSE, 'message' => 'Data gagal dihapus']);
    }

    public function getNotification(Notification $notification)
    {
        return response()->json($notification->fetchNotification());
    }

    public function markAsRead(Request $request, Notification $notification)
    {
        $notification->markAsRead($request->user()->id);
        return response()->json(['status' => true]);
    }

    public function getSideBarNotification()
    {
        try {
            // code menu
            $response['sidebar_notification'] = [
                'announcement' => 0,
                'user' => 0,
                'level' => 0
            ];

            foreach ($response['sidebar_notification'] as $code => $total) {
                $response = $this->menuRecursive($response, $this->help->menu($code)->parent, $total);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
        return response()->json($response);
    }

    private function menuRecursive(mixed $response, $menu = null, $total = 0)
    {
        if (!is_null($menu)) {
            if (array_key_exists($menu->code, $response['sidebar_notification'])) {
                $response['sidebar_notification'][$menu->code] += $total;
            } else {
                $response['sidebar_notification'] += [$menu->code => $total];
            }
            $this->menuRecursive($response, $menu->parent, $total);
        }
        return $response;
    }
}
