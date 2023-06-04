<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class jsController extends Controller
{
    public function javaScript(Request $request, $layout,$page,$file)
    {
        foreach (json_decode($request->getContent(),true) ?? [] as  $key => $value){
            $data[$key] = $value;
        }
        $data['url'] = $page;
        $layout = config('master.app.view.'.$layout);
        $file=str_replace('.js','',$file);
        return response()->view("$layout.$page.$file",$data)->header('Content-Type','application/javascript');
    }
}
