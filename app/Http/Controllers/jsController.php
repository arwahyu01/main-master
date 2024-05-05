<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class jsController extends Controller
{
    public function javaScript(Request $request, $layout, $page, $file)
    {
        $data = json_decode($request->getContent(), true) ?? [];
        $data['url'] = $page;
        $layout = config('master.app.view.' . $layout);
        $viewPath = "$layout.$page." . Str::before($file, '.js');
        return response()->view($viewPath, $data)->header('Content-Type', 'application/javascript');
    }
}
