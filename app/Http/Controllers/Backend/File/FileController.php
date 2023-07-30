<?php

namespace App\Http\Controllers\Backend\File;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FileController extends Controller
{
    public function getFile($id, $filename)
    {
        if ($file=File::find($id)) {
            if ($file->exists) {
                return response()->make($file->take, 200, [
                    'Content-Type'=>$file->mime, 'Content-Disposition'=>'inline; filename="'.$filename.'.'.$file->extension.'"'
                ]);
            }
        }
        return view('errors.404', [
            'data'=>[
                'code'=>410, 'status'=>'GONE', 'title'=>'File Not Found', 'message'=>'im sorry, the file you are looking for is not found',
            ],
        ]);
    }

    public function downloadFile($id, $filename)
    {
        if ($file=File::find($id)) {
            if ($file->exists) {
                return response()->make($file->take, 200, [
                    'Content-Type'=>$file->mime, 'Content-Disposition'=>'attachment; filename="'.$filename.'.'.$file->extension.'"',
                ]);
            }
        }
        return view('errors.404', [
            'data'=>[
                'code'=>410, 'status'=>'GONE', 'title'=>'File Not Found', 'message'=>'im sorry, the file you are looking for is not found',
            ],
        ]);
    }

    public function deleteFile($id, $filename)
    {
        if ($file=File::find($id)) {
            if ($file->exists()) {
                $file->delete();
                return response()->json(['status'=>TRUE, 'message'=>"File $filename has been deleted"]);
            }
        }
        throw new ModelNotFoundException("File $filename not found", 404);
    }
}
