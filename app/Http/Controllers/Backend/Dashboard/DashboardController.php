<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view($this->view . '.index');
    }
}

