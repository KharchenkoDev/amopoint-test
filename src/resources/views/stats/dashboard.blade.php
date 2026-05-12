<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика посещений</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <h1 class="text-lg font-semibold text-gray-800">Статистика посещений</h1>
        <form method="POST" action="{{ route('stats.logout') }}">
            @csrf
            <button class="text-sm text-gray-500 hover:text-gray-800 transition">Выйти</button>
        </form>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8 space-y-8">

        {{-- Сводка --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 max-w-sm">
            <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                <div class="text-3xl font-bold text-blue-600">{{ $totalVisits }}</div>
                <div class="text-sm text-gray-500 mt-1">Всего визитов</div>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                <div class="text-3xl font-bold text-blue-600">{{ $uniqueVisitors }}</div>
                <div class="text-sm text-gray-500 mt-1">Уникальных IP</div>
            </div>
        </div>

        {{-- Графики --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-sm font-semibold text-gray-600 mb-4">Уникальные визиты по часам (последние 24 ч)</h2>
                <canvas id="hourlyChart"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-sm font-semibold text-gray-600 mb-4">Визиты по городам</h2>
                @if ($cityCounts->sum() > 0)
                    <canvas id="cityChart"></canvas>
                @else
                    <p class="text-sm text-gray-400 text-center py-12">Нет данных</p>
                @endif
            </div>

        </div>

    </main>

    <script>
        const hourlyLabels = @json($hourlyLabels);
        const hourlyCounts = @json($hourlyCounts);
        const cityLabels   = @json($cityLabels);
        const cityCounts   = @json($cityCounts);

        new Chart(document.getElementById('hourlyChart'), {
            type: 'bar',
            data: {
                labels: hourlyLabels,
                datasets: [{
                    label: 'Уникальных визитов',
                    data: hourlyCounts,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderRadius: 4,
                }],
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, ticks: { precision: 0 } },
                },
            },
        });

        if (cityCounts.length > 0) {
            const palette = [
                '#3B82F6','#10B981','#F59E0B','#EF4444','#8B5CF6',
                '#06B6D4','#F97316','#84CC16','#EC4899','#6366F1',
            ];

            new Chart(document.getElementById('cityChart'), {
                type: 'doughnut',
                data: {
                    labels: cityLabels,
                    datasets: [{
                        data: cityCounts,
                        backgroundColor: palette.slice(0, cityLabels.length),
                    }],
                },
                options: {
                    plugins: {
                        legend: { position: 'right', labels: { boxWidth: 12 } },
                    },
                },
            });
        }
    </script>

</body>
</html>
