<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Order;
use Carbon\Carbon;

class OrdersChartWidget extends Widget
{
    protected static string $view = 'filament.widgets.orders-chart';

    public array $labels = [];
    public array $data = [];

    public function mount(): void
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        // Sum actual column `total_price` and alias it as `total` for compatibility
        $rows = Order::selectRaw("DATE(created_at) as day, COALESCE(SUM(total_price), 0) as total")
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day')
            ->map(fn($r) => (float) $r->total)
            ->toArray();

        $period = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $period[] = $d->toDateString();
        }

        $this->labels = array_map(fn($d) => (int) date('j', strtotime($d)), $period);
        $this->data = array_map(fn($d) => $rows[$d] ?? 0, $period);
    }
}
