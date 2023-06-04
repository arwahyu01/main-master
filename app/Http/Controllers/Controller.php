<?php

namespace App\Http\Controllers;

use App\support\Helper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public string $view,$code,$model;

    public function __construct()
    {
        $this->view=config('master.app.view.backend').'.'.(Helper::menu()['code'] ?? 'dashboard');
        $this->code= (Helper::menu()['code'] ?? 'dashboard');
        $this->model=(Helper::menu()['model'] ?? 'Dashboard');
        $this->url=(Helper::menu()['url'] ?? 'dashboard');
    }
}
