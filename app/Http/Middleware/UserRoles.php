<?php

namespace App\Http\Middleware;

use App\Models\AccessMenu;
use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserRoles
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $route = collect(explode(".",Route::currentRouteName()))->first();
        $menu = Menu::whereCode($route)->first();
        if(!is_null($menu)){
            if(AccessMenu::where(['access_group_id'=>$user->access_group_id,'menu_id'=>$menu->id])->first()) {
                return $next($request);
            }
        }
        return abort(403,'Page Not Found');
    }
}
