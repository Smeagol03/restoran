<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        if ($request->has('table_id')) {
            session(['table_id' => $request->query('table_id')]);
        }

        $categories = Category::where('is_active', true)
            ->with(['menuItems' => function ($query) {
                $query->where('is_available', true);
            }])
            ->orderBy('sort_order')
            ->get();

        return view('public.menu.index', compact('categories'));
    }
}
