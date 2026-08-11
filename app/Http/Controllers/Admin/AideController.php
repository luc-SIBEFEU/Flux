<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AideController extends Controller
{
    public function index()
    {
        return view('admin.aide');
    }
}
