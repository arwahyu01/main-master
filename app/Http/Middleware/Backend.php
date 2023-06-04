<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class Backend
{
    public function handle(Request $request, $next)
    {
        $route = collect(explode(".",Route::currentRouteName()))->first();
        View::share([
            'user' => Auth::user(),
            'page' => Menu::whereCode($route)->first() ?? NULL,
            'backend' => config('master.app.view.backend'),
            'template' => config('master.app.web.template'),
        ]);
        return $next($request);
    }
}
