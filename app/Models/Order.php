<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'type',
        'reservation_time',
        'status',
        'table_id',
        'delivery_address_id',
        'notes',
        'subtotal',
        'discount_amount',
        'delivery_fee',
        'total',
        'promo_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => OrderType::class,
            'status' => OrderStatus::class,
            'reservation_time' => 'datetime',
            'subtotal' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    // ── Relationships ──────────────────────────────────────

    /**
     * Get the user that placed the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the table assigned to the order.
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Query Scopes ───────────────────────────────────────

    /**
     * Scope orders to a specific user.
     */
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to only active (in-progress) orders.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status', [
            OrderStatus::Done,
            OrderStatus::Cancelled,
            OrderStatus::Failed,
        ]);
    }

    /**
     * Scope to only completed (terminal) orders.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->whereIn('status', [
            OrderStatus::Done,
            OrderStatus::Cancelled,
            OrderStatus::Failed,
        ]);
    }

    // ── Accessors ──────────────────────────────────────────

    /**
     * Get the current position in the status timeline (0-indexed).
     */
    public function getStatusTimelinePositionAttribute(): int
    {
        $steps = OrderStatus::timelineSteps();

        $index = array_search($this->status, $steps);

        return $index !== false ? $index : -1;
    }
}
