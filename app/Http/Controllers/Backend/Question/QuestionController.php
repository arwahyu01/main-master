<?php

namespace App\Http\Controllers\Backend\Question;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function index()
    {
        $data = Faq::orderBy('visitors','desc')->paginate(10);
        return view($this->view.'.index',['data'=>$data]);
    }

    public function page($page)
    {
        $faq = Faq::whereHas('menu', fn($query) => $query->where('code', $page))->select('faqs.title','faqs.id')->wherePublish(true)->paginate(10);
        if(!$faq->isNotEmpty()) {
            $faq = Faq::orderBy('visitors', 'desc')->select('faqs.title', 'faqs.id')->wherePublish(true)->paginate(10);
        }
        return response()->json($faq);
    }

    public function show($id)
    {
        if($data = Faq::find($id)){
            $data->increment('visitors');
            $response = $data;
        }
        return view($this->view.'.show',['data'=>$response ?? []]);
    }

    public function data()
    {
        $data = Faq::with('menu')->latest('visitors');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<a href="'.url(config('master.app.url.backend').'/question/'.$row->id).'" class="edit btn btn-primary btn-xs"><i class="fa fa-search"></i> Show</a>';
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function response(Request $request)
    {
        if ($data=Faq::find($request->id)) {
            if ($log=$data->log()->where('ip', $request->ip())->first()) {
                if ($log->data['code'] == 'yes' && $request->code == 'no') {
                    $data->decrement('like');
                    $data->increment('dislike');
                } else {
                    if ($log->data['code'] == 'no' && $request->code == 'yes') {
                        $data->decrement('dislike');
                        $data->increment('like');
                    }
                }
                $log->update(['data'=>['code'=>$request->code]]);
            } else {
                if ($request->code == 'yes') {
                    $data->increment('like');
                } else {
                    $data->increment('dislike');
                }
                $data->log()->create([
                    'ip'=>$request->ip(), 'data'=>['code'=>$request->code], 'user_agent'=>$request->userAgent(),
                ]);

            }
            $response=['status'=>true, 'message'=>'Terima kasih atas respon anda'];
        }
        return response()->json($response ?? ['status'=>false, 'message'=>'Terjadi kesalahan, silahkan coba lagi'], 200);
    }

    public function updateViewer(Request $request)
    {
        if($request->ajax()){
            if($data = Faq::find($request->id)){
                $data->increment('visitors');
                $response = $data;
            }
            return response()->json($response ?? ['status'=>false, 'message'=>'Terjadi kesalahan, silahkan coba lagi'], 200);
        }
        abort(404);
    }
}
