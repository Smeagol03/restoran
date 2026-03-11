@php
    use App\Models\Order;
    use App\Models\MenuItem;
    use App\Models\Category;
    use Carbon\Carbon;

    $totalOrders = Order::count();
    $pendingOrders = Order::where('status', 'pending')->count();
    $totalRevenue = Order::where('status', 'done')->sum('total');
    $totalMenu = MenuItem::count();
    $recentOrders = Order::with(['user', 'table'])->latest()->take(5)->get();

    // Data Penjualan 7 Hari Terakhir
    $salesLabels = [];
    $salesData = [];
    
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $salesLabels[] = $date->translatedFormat('d M');
        
        $dailyTotal = Order::where('status', 'done')
            ->whereDate('created_at', $date)
            ->sum('total');
            
        $salesData[] = $dailyTotal;
    }
@endphp

<x-layouts.admin>
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Dashboard Overview</h1>
            <p class="text-zinc-500 dark:text-zinc-400">Ringkasan aktivitas restoran hari ini.</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Pesanan</p>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $totalOrders }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pesanan Pending</p>
                <p class="text-3xl font-bold text-orange-600 mt-2">{{ $pendingOrders }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Pendapatan</p>
                <p class="text-3xl font-bold text-emerald-600 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Menu Tersedia</p>
                <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $totalMenu }}</p>
            </div>
        </div>

        {{-- Sales Chart --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Tren Penjualan (7 Hari Terakhir)</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Total pendapatan harian dari pesanan selesai.</p>
            </div>
            <div class="relative h-[300px] w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 uppercase text-[10px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Order #</th>
                            <th class="px-6 py-3">Pelanggan</th>
                            <th class="px-6 py-3">Tipe</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($recentOrders as $order)
                            <tr class="text-zinc-900 dark:text-zinc-300">
                                <td class="px-6 py-4 font-mono font-medium">{{ $order->order_number }}</td>
                                <td class="px-6 py-4">{{ $order->user->name ?? 'Guest' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->type->value === 'dine_in' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' }}">
                                        {{ $order->type->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold text-emerald-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase bg-{{ $order->status->color() }}-100 text-{{ $order->status->color() }}-700 dark:bg-{{ $order->status->color() }}-900/30 dark:text-{{ $order->status->color() }}-400">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-zinc-500">{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-zinc-500">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($salesLabels),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: @json($salesData),
                        borderColor: '#ea580c', // orange-600
                        backgroundColor: 'rgba(234, 88, 12, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#ea580c',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return formatter.format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000) + 'k';
                                }
                            },
                            grid: {
                                color: 'rgba(161, 161, 170, 0.1)' // zinc-400 with opacity
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-layouts.admin>
