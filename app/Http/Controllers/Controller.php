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

    public string $view, $code, $model, $url;
    public object $help;

    public function __construct(Helper $helper)
    {
        $this->help = $helper;
        $this->code = $helper->menu()->code ?? 'dashboard';
        $this->model = $helper->menu()->model ?? 'dashboard';
        $this->url = $helper->menu()->url ?? 'dashboard';
        $this->view = config('master.app.view.backend') . '.' . $this->code;
    }
}
