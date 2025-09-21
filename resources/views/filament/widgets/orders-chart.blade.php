<div class="bg-white p-4 rounded shadow">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold">Sales Revenue - {{ now()->format('F Y') }}</h3>
    </div>
    <canvas id="ordersChart" height="120"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($this->labels),
                datasets: [{
                    label: 'Revenue',
                    data: @json($this->data),
                    borderColor: '#1e40af',
                    backgroundColor: 'rgba(30,64,175,0.08)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) { return 'Rp ' + value.toLocaleString(); }
                        }
                    }
                }
            }
        });
    });
</script>
