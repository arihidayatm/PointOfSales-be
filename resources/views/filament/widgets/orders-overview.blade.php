<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-sm text-gray-500">Total Revenue</div>
        <div class="text-xl font-bold">Rp {{ number_format($this->totalRevenue, 0, ',', '.') }}</div>
    </div>

    <div class="p-4 bg-white rounded shadow">
        <div class="text-sm text-gray-500">Total Transactions</div>
        <div class="text-xl font-bold">{{ $this->totalOrders }}</div>
    </div>

    <div class="p-4 bg-white rounded shadow">
        <div class="text-sm text-gray-500">Daily Average</div>
        <div class="text-xl font-bold">Rp {{ number_format($this->dailyAverage, 0, ',', '.') }}</div>
    </div>

    <div class="p-4 bg-white rounded shadow">
        <div class="text-sm text-gray-500">Growth</div>
        <div class="text-xl font-bold">-</div>
    </div>
</div>
