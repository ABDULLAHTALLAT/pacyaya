<?php

namespace App\Http\Controllers;

class ToolController extends Controller
{
    public function index()
    {
        return view('tools.index');
    }

    public function pricing()
    {
        return view('pricing');
    }

    public function dieline()
    {
        return view('tools.dieline');
    }
}
