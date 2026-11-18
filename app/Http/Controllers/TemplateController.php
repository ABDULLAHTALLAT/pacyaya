<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = Template::with('category')
            ->when($request->category, fn ($q, $slug) => $q->whereHas('category', fn ($c) => $c->where('slug', $slug)))
            ->when($request->q, fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->when($request->sort === 'name', fn ($q) => $q->orderBy('name'))
            ->when($request->sort === 'new', fn ($q) => $q->orderByDesc('id'))
            ->when(! in_array($request->sort, ['name', 'new'], true), fn ($q) => $q->orderByDesc('is_featured')->orderBy('name'))
            ->get();

        return view('templates.index', [
            'templates' => $templates,
            'categories' => Category::all(),
            'active' => $request->category,
        ]);
    }
}
