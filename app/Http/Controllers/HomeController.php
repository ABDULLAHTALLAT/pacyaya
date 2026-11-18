<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Printer;
use App\Models\Template;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'categories' => Category::withCount('templates')->get(),
            'featured' => Template::with('category')->where('is_featured', true)->take(8)->get(),
            'printers' => Printer::where('is_active', true)->orderByDesc('rating')->take(3)->get(),
        ]);
    }
}
