<?php

namespace App\Http\Controllers\Bailleur;

use App\Http\Controllers\Controller;

class AideController extends Controller
{
    public function index()
    {
        return view('bailleur.aide');
    }
}
