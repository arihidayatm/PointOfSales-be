<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Order;

class OrdersOverviewWidget extends Widget
{
    protected static string $view = 'filament.widgets.orders-overview';

    public int $totalOrders = 0;
    public float $totalRevenue = 0.0;
    public float $dailyAverage = 0.0;

    public function mount(): void
    {
        $this->totalOrders = Order::count();
        // Use `total_price` column from orders table
        $this->totalRevenue = (float) Order::sum('total_price');

        $daysWithOrders = Order::selectRaw('DATE(created_at) as day')
            ->distinct()
            ->count();

        $this->dailyAverage = $daysWithOrders > 0 ? round($this->totalRevenue / $daysWithOrders) : 0;
    }
}
