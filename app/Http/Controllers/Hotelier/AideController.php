<?php

namespace App\Http\Controllers\Hotelier;

use App\Http\Controllers\Controller;

class AideController extends Controller
{
    public function index()
    {
        return view('hotelier.aide');
    }
}
