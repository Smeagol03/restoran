<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->order_number }}</title>
    <style>
        /* Reset & Receipt Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            background: #fff;
            width: 80mm;
            margin: 0 auto;
            padding: 8mm 4mm;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mt-2 { margin-top: 8px; }
        .mt-1 { margin-top: 4px; }
        .mb-1 { margin-bottom: 4px; }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .double-divider {
            border-top: 2px double #000;
            margin: 8px 0;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 10px;
            color: #555;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }

        .item-row {
            margin-bottom: 4px;
        }

        .item-name {
            font-size: 12px;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            padding-left: 8px;
            color: #444;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #888;
            margin-top: 12px;
        }

        /* Print-specific styles */
        @media print {
            body {
                width: auto;
                padding: 0;
            }

            .no-print { display: none !important; }

            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header text-center">
        <h1>{{ config('app.name', 'Restoran') }}</h1>
        <p class="mt-1">Bukti Transaksi</p>
    </div>

    <div class="double-divider"></div>

    {{-- Order Info --}}
    <div>
        <div class="info-row">
            <span>No. Order</span>
            <span class="font-bold">{{ $order->order_number }}</span>
        </div>
        <div class="info-row">
            <span>Tanggal</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="info-row">
            <span>Tipe</span>
            <span>{{ $order->type->label() }}</span>
        </div>
        @if($order->table)
            <div class="info-row">
                <span>Meja</span>
                <span>{{ $order->table->number }}</span>
            </div>
        @endif
        @if($order->user)
            <div class="info-row">
                <span>Pelanggan</span>
                <span>{{ $order->user->name }}</span>
            </div>
        @endif
        <div class="info-row">
            <span>Status</span>
            <span class="font-bold">{{ $order->status->label() }}</span>
        </div>
    </div>

    <div class="divider"></div>

    {{-- Items --}}
    <div>
        @foreach($order->items as $item)
            <div class="item-row">
                <div class="item-name">{{ $item->menuItem->name ?? 'Item Dihapus' }}</div>
                <div class="item-detail">
                    <span>{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="divider"></div>

    {{-- Totals --}}
    <div>
        <div class="info-row">
            <span>Subtotal</span>
            <span>Rp {{ number_format($order->items->sum('subtotal'), 0, ',', '.') }}</span>
        </div>
        @if($order->delivery_fee > 0)
            <div class="info-row">
                <span>Biaya Pengiriman</span>
                <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
            </div>
        @endif
    </div>

    <div class="double-divider"></div>

    <div class="total-row">
        <span>TOTAL</span>
        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
    </div>

    <div class="double-divider"></div>

    {{-- Notes --}}
    @if($order->notes)
        <div class="mt-1" style="font-size: 11px;">
            <span class="font-bold">Catatan:</span> {{ $order->notes }}
        </div>
        <div class="divider"></div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <p>Terima kasih telah memesan!</p>
        <p class="mt-1">{{ config('app.name', 'Restoran') }}</p>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    {{-- Print Button (hidden on print) --}}
    <div class="no-print text-center mt-2" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 8px 24px; font-size: 14px; background: #18181b; color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: bold;">
            🖨️ Cetak Struk
        </button>
    </div>

    <script>
        // Auto-trigger print dialog
        window.addEventListener('load', function() {
            setTimeout(function() { window.print(); }, 500);
        });
    </script>
</body>
</html>
