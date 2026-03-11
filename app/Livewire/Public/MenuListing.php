<?php

namespace App\Livewire\Public;

use App\Models\Category;
use App\Models\MenuItem;
use Livewire\Component;

class MenuListing extends Component
{
    public string $search = '';

    public string $activeCategory = 'all';

    public function updatingSearch(): void
    {
        $this->activeCategory = 'all';
    }

    public function setCategory(string $slug): void
    {
        $this->activeCategory = $slug;
        $this->search = '';
    }

    public function render(): \Illuminate\View\View
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $query = MenuItem::where('is_available', true)->with('category');

        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('description', 'like', '%'.$this->search.'%');
        } elseif ($this->activeCategory !== 'all') {
            $query->whereHas('category', function ($q) {
                $querySlug = $this->activeCategory;
                $q->where('slug', $querySlug);
            });
        }

        return view('livewire.public.menu-listing', [
            'categories' => $categories,
            'menuItems' => $query->get(),
        ]);
    }
}
