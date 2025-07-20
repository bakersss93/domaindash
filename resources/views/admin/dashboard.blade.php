@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">System Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <canvas id="storageChart"></canvas>
    </div>
    <div>
        <canvas id="cpuChart"></canvas>
    </div>
    <div>
        <canvas id="memoryChart"></canvas>
    </div>
    <div>
        <canvas id="dbChart"></canvas>
    </div>
</div>
<div class="mt-6">
    <p><strong>Last Sync:</strong> {{ optional($status)->last_sync_at?->toDateTimeString() ?? 'N/A' }}</p>
    <p><strong>Last Backup:</strong> {{ optional($status)->last_backup_at?->toDateTimeString() ?? 'N/A' }}</p>
    <p><strong>Synergy Balance:</strong> {{ $balance ?? 'N/A' }}</p>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const metrics = @json($metrics);
function makeChart(id, data) {
    new Chart(document.getElementById(id), {
        type: 'line',
        data: {
            labels: data.map(m => m.recorded_at),
            datasets: [{
                label: id,
                data: data.map(m => m.value),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        }
    });
}
makeChart('storageChart', metrics.storage);
makeChart('cpuChart', metrics.cpu);
makeChart('memoryChart', metrics.memory);
makeChart('dbChart', metrics.database);
</script>
@endsection
