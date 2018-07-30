<?php

namespace App\Http\Controllers\Web\Manager;


use App\Http\Controllers\Web\Base\BaseController;

class ManagerController extends BaseController
{
    //

    public function index()
    {
        return view('manager.list');
    }

    public function store()
    {
        return view('manager.form');
    }
}
