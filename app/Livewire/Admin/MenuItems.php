<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class MenuItems extends Component
{
    use WithPagination;

    public $name;

    public $category_id;

    public $price;

    public $description;

    public $preparation_time;

    public $menuId;

    public bool $is_available = true;

    public bool $is_featured = false;

    public bool $isEditing = false;

    public bool $isCreating = false;

    public string $search = '';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|max:1000',
        'preparation_time' => 'nullable|integer|min:0',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function create(): void
    {
        $this->resetInputFields();
        $this->isCreating = true;
    }

    public function store(): void
    {
        $this->validate();

        MenuItem::create([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'price' => $this->price,
            'is_available' => $this->is_available,
            'is_featured' => $this->is_featured,
            'preparation_time' => $this->preparation_time,
        ]);

        $this->resetInputFields();
        $this->isCreating = false;
        session()->flash('message', 'Menu berhasil ditambahkan.');
    }

    public function edit(int $id): void
    {
        $menu = MenuItem::findOrFail($id);
        $this->menuId = $id;
        $this->name = $menu->name;
        $this->category_id = $menu->category_id;
        $this->price = $menu->price;
        $this->description = $menu->description;
        $this->preparation_time = $menu->preparation_time;
        $this->is_available = $menu->is_available;
        $this->is_featured = $menu->is_featured;
        $this->isEditing = true;
    }

    public function update(): void
    {
        $this->validate();

        $menu = MenuItem::find($this->menuId);
        $menu->update([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'price' => $this->price,
            'is_available' => $this->is_available,
            'is_featured' => $this->is_featured,
            'preparation_time' => $this->preparation_time,
        ]);

        $this->resetInputFields();
        $this->isEditing = false;
        session()->flash('message', 'Menu berhasil diperbarui.');
    }

    public function toggleAvailability(int $id): void
    {
        $menu = MenuItem::find($id);
        $menu->update(['is_available' => ! $menu->is_available]);
    }

    public function delete(int $id): void
    {
        MenuItem::find($id)->delete();
        session()->flash('message', 'Menu berhasil dihapus.');
    }

    public function cancel(): void
    {
        $this->resetInputFields();
        $this->isEditing = false;
        $this->isCreating = false;
    }

    private function resetInputFields(): void
    {
        $this->name = '';
        $this->category_id = '';
        $this->price = '';
        $this->description = '';
        $this->preparation_time = '';
        $this->is_available = true;
        $this->is_featured = false;
        $this->menuId = null;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.menu-items', [
            'menuItems' => MenuItem::where('name', 'like', '%'.$this->search.'%')
                ->with('category')
                ->latest()
                ->paginate(10),
            'categories' => Category::all(),
        ]);
    }
}
