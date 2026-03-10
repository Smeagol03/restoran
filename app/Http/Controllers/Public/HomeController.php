<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredItems = MenuItem::where('is_featured', true)
            ->where('is_available', true)
            ->with('category')
            ->limit(6)
            ->get();

        return view('public.home', compact('featuredItems'));
    }

    public function about(): View
    {
        return view('public.about');
    }
}
