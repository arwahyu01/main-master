<?php

namespace App\Http\Controllers\Backend\File;

use App\Http\Controllers\Controller;
use App\Models\File;

class FileController extends Controller
{
    public function getFile($id, $filename)
    {
        if ($file=File::find($id)) {
            if ($file->exists()) {
                return response()->make($file->take, 200, [
                    'Content-Type'=>$file->mime, 'Content-Disposition'=>'inline; filename="'.$filename.'.'.$file->extension.'"',
                ]);
            }
        }
        return view(config('master.app.view.backend').'.errors.404', [
            'data'=>[
                'code'=>410, 'status'=>'GONE', 'file'=>$file->name, 'title'=>'File Not Found', 'message'=>'im sorry, the file you are looking for is not found',
            ],
        ]);
    }

    public function downloadFile($id, $filename)
    {
        if ($file=File::find($id)) {
            if ($file->exists()) {
                return response()->make($file->take, 200, [
                    'Content-Type'=>$file->mime, 'Content-Disposition'=>'attachment; filename="'.$filename.'.'.$file->extension.'"',
                ]);
            }
        }
        return view(config('master.app.view.backend').'.errors.404', [
            'data'=>[
                'code'=>410, 'status'=>'GONE', 'file'=>$file->name, 'title'=>'File Not Found', 'message'=>'im sorry, the file you are looking for is not found',
            ],
        ]);
    }

    public function delete($id, $filename)
    {
        if ($file=File::find($id)) {
            if ($file->exists()) {
                $file->delete();
                $response=['status'=>TRUE, 'message'=>"File $filename has been deleted"];
            }
        }
        return response()->json($response ?? ['status'=>FALSE, 'message'=>'file not found or already deleted']);
    }
}
