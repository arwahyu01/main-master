<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class Backend
{
    public function handle(Request $request, $next)
    {
        $page = Menu::whereCode(explode(".",$request->route()->getName())[0])->first();
        View::share([
            'user' => $request->user(),
            'page' => $page,
            'backend' => config('master.app.view.backend'),
            'template' => config('master.app.web.template'),
        ]);
        $request->merge(['page_menu_id' => $page->id ?? null]);
        return $next($request);
    }
}
