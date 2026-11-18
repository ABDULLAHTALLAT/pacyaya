<?php

namespace App\Http\Controllers;

use App\Models\Printer;

class PrinterController extends Controller
{
    public function index()
    {
        return view('printers.index', [
            'printers' => Printer::where('is_active', true)->orderByDesc('rating')->get(),
        ]);
    }
}
