<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $name;

    public $description;

    public $categoryId;

    public bool $isEditing = false;

    public bool $isCreating = false;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable|max:500',
    ];

    public function create(): void
    {
        $this->resetInputFields();
        $this->isCreating = true;
    }

    public function store(): void
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'is_active' => true,
        ]);

        $this->resetInputFields();
        $this->isCreating = false;
        session()->flash('message', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id): void
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->isEditing = true;
    }

    public function update(): void
    {
        $this->validate();

        $category = Category::find($this->categoryId);
        $category->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
        ]);

        $this->resetInputFields();
        $this->isEditing = false;
        session()->flash('message', 'Kategori berhasil diperbarui.');
    }

    public function delete(int $id): void
    {
        Category::find($id)->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
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
        $this->description = '';
        $this->categoryId = null;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.categories', [
            'categories' => Category::latest()->paginate(10),
        ]);
    }
}
