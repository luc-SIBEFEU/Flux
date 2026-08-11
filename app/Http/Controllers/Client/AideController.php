<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class AideController extends Controller
{
    public function index()
    {
        return view('client.aide');
    }
}
