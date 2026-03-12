<?php

namespace App\Livewire\Admin;

use App\Models\Table;
use App\Models\Order;
use App\Enums\OrderStatus;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Tables extends Component
{
    use WithPagination;

    public $tableId;
    public $number;
    public $capacity = 4;
    public $status = 'available';
    
    public $isCreating = false;
    public $isEditing = false;
    public $showQrCode = false;
    public $selectedTableQrCode = null;
    public $selectedTableUrl = null;
    public $selectedTableNumber = null;

    public string $search = '';
    public ?int $viewingTableId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tables', 'number')->ignore($this->tableId),
            ],
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,occupied',
        ];
    }

    public function create()
    {
        $this->resetForm();
        $this->isCreating = true;
    }

    public function edit(int $id)
    {
        $this->resetForm();
        $table = Table::findOrFail($id);
        $this->tableId = $table->id;
        $this->number = $table->number;
        $this->capacity = $table->capacity;
        $this->status = $table->status;
        $this->isEditing = true;
    }

    public function showDetails(int $id)
    {
        $this->viewingTableId = $id;
    }

    public function closeDetails()
    {
        $this->viewingTableId = null;
    }

    public function cancel()
    {
        $this->resetForm();
    }

    public function store()
    {
        $this->validate();
        Table::create([
            'number' => $this->number,
            'capacity' => $this->capacity,
            'status' => $this->status,
        ]);
        session()->flash('message', 'Meja berhasil ditambahkan.');
        $this->resetForm();
    }

    public function update()
    {
        $this->validate();
        $table = Table::findOrFail($this->tableId);
        $table->update([
            'number' => $this->number,
            'capacity' => $this->capacity,
            'status' => $this->status,
        ]);
        session()->flash('message', 'Meja berhasil diperbarui.');
        $this->resetForm();
    }

    public function delete(int $id)
    {
        $table = Table::findOrFail($id);
        if ($table->orders()->where('status', '!=', 'done')->exists()) {
            session()->flash('error', 'Meja sedang digunakan dan tidak dapat dihapus.');
            return;
        }
        $table->delete();
        session()->flash('message', 'Meja berhasil dihapus.');
    }

    public function toggleStatus(int $id)
    {
        $table = Table::findOrFail($id);
        $table->status = $table->status === 'available' ? 'occupied' : 'available';
        $table->save();
        session()->flash('message', 'Status meja berhasil diubah.');
    }

    public function generateQrCode(int $id)
    {
        $table = Table::findOrFail($id);
        $this->selectedTableNumber = $table->number;
        $this->selectedTableUrl = route('menu.index', ['table_id' => $table->id]);
        $svg = (new Writer(new ImageRenderer(new RendererStyle(300, 0, null, null, Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(24, 24, 27))), new SvgImageBackEnd)))->writeString($this->selectedTableUrl);
        $this->selectedTableQrCode = trim(substr($svg, strpos($svg, "\n") + 1));
        $this->showQrCode = true;
    }

    public function closeQrCode()
    {
        $this->showQrCode = false;
        $this->selectedTableQrCode = null;
        $this->selectedTableUrl = null;
        $this->selectedTableNumber = null;
    }

    private function resetForm()
    {
        $this->reset(['tableId', 'number', 'capacity', 'status', 'isCreating', 'isEditing', 'viewingTableId']);
        $this->resetValidation();
    }

    public function render()
    {
        $tables = Table::where('number', 'like', '%'.$this->search.'%')
            ->with(['orders' => function($query) {
                $query->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready', 'delivered'])
                      ->with('user')
                      ->latest();
            }])
            ->get();

        return view('livewire.admin.tables', [
            'tables' => $tables,
            'totalTables' => Table::count(),
            'availableCount' => Table::where('status', 'available')->count(),
            'occupiedCount' => Table::where('status', 'occupied')->count(),
            'viewingTable' => $this->viewingTableId ? Table::with(['orders' => function($q) {
                $q->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready', 'delivered'])->with('items.menuItem', 'user');
            }])->find($this->viewingTableId) : null,
        ]);
    }
}
