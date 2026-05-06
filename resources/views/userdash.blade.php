<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Maintenance - Dashboard</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-black text-white">

    @include('layouts.logout')

    <div class="flex">
        @include('layouts.sidenav')

        <main class="flex-1 p-6 min-h-screen">
            <h1 class="text-3xl font-bold text-white mb-[9px]">Dashboard</h1>
           
            <!-- Main Card with Toggle -->
            <div class="bg-zinc-900 rounded-2xl p-4 md:p-6 shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="chartTitle" class="text-white text-lg md:text-xl font-semibold">
                      Job Orders Growth (Weekly)
                    </h2>
                    <div class="flex bg-zinc-800 rounded-lg p-1">
                        <button onclick="updateChart('weekly')" id="btnWeekly" 
                            class="px-4 py-1 rounded-md bg-cyan-500 text-black text-xs font-bold transition">
                            Weekly
                        </button>
                        <button onclick="updateChart('daily')" id="btnDaily" 
                            class="px-4 py-1 rounded-md text-white text-xs transition">
                            Daily
                        </button>
                    </div>
                </div>

                <div class="h-64">
                    <canvas id="jobOrdersChart"></canvas>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                <button onclick="window.location.href='/viewcustomervehicles'"
                  class="bg-zinc-900 text-white rounded-xl p-4 flex items-center gap-3 shadow-md hover:bg-zinc-800 transition w-full text-left">
                  <img src="{{ asset('icons/mdi_car.png') }}" alt="Car">
                    <div>
                      <p class="text-xs text-gray-400">Total Vehicles</p>
                      <p class="text-lg font-semibold">{{ $totalVehicles }}</p>
                      <p class="text-xs text-gray-500">Active in System</p>
                    </div>
                </button>

                <button class="bg-zinc-900 text-white rounded-xl p-4 flex items-center gap-3 shadow-md hover:bg-zinc-800 transition w-full text-left">
                    <img src="{{ asset('icons/mdi_calendar.png') }}" alt="Calendar">
                    <div>
                        <p class="text-xs text-gray-400">Job Orders</p>
                        <p class="text-lg font-semibold">{{ $totalJobOrders }}</p>
                        <p class="text-xs text-gray-500">On The System</p>
                    </div>
                </button>

                <button onclick="window.location.href='/reminders'" 
                  class="bg-zinc-900 text-white rounded-xl p-4 flex items-center gap-3 shadow-md hover:bg-zinc-800 transition w-full text-left">
                  <img src="{{ asset('icons/material-symbols_warning.png') }}" alt="Warning">
                  <div>
                    <p class="text-xs text-gray-400">Alerts / Reminders</p>
                    <p class="text-lg font-semibold text-white">{{ $totalAlerts }}</p>
                    <p class="text-xs text-gray-500">
                      {{ $overdueCount }} Need to Maintain • {{ $pendingCount }} Active
                    </p>
                  </div>
                </button>
            </div>

            <!-- Quick Actions -->
            <h2 class="text-white text-lg font-semibold mt-6 mb-3">Quick Actions</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <button onclick="window.location.href='/joborderform'" class="bg-zinc-900 rounded-xl p-6 hover:bg-zinc-800 transition">Add Job Order</button>
                <button onclick="window.location.href='/addsupplier'" class="bg-zinc-900 rounded-xl p-6 hover:bg-zinc-800 transition">Add Supplier</button>
                <button onclick="window.location.href='/addmechanic'" class="bg-zinc-900 rounded-xl p-6 hover:bg-zinc-800 transition">Add Mechanic</button>
                <button onclick="window.location.href='/addservices'" class="bg-zinc-900 rounded-xl p-6 hover:bg-zinc-800 transition">Add Services</button>
            </div>
        </main>
    </div>

    <script>
let jobChart;
// Ensure these variables are being passed correctly from the controller
const chartData = {
    weekly: {
        labels: @json($weeklyLabels),
        data: @json($weeklyCounts),
        title: "Job Orders Growth (Weekly)"
    },
    daily: {
        labels: @json($dailyLabels),
        data: @json($dailyCounts),
        title: "Job Orders Growth (Daily)"
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('jobOrdersChart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    jobChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.weekly.labels,
            datasets: [{
                label: 'Job Orders',
                data: chartData.weekly.data,
                borderColor: '#00fbff',
                backgroundColor: 'rgba(0, 251, 255, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#00fbff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: '#ccc' }, grid: { display: false } },
                y: { 
                    beginAtZero: true, 
                    ticks: { color: '#ccc', stepSize: 1 },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' }
                }
            }
        }
    });
});

function updateChart(view) {
    if (!jobChart) return;

    // Update Chart Data
    jobChart.data.labels = chartData[view].labels;
    jobChart.data.datasets[0].data = chartData[view].data;
    jobChart.update();

    // Update Title text
    document.getElementById('chartTitle').innerText = chartData[view].title;
    
    // Update Button Styles
    const isWeekly = view === 'weekly';
    const btnWeekly = document.getElementById('btnWeekly');
    const btnDaily = document.getElementById('btnDaily');
    
    if (isWeekly) {
        btnWeekly.classList.add('bg-cyan-500', 'text-black', 'font-bold');
        btnWeekly.classList.remove('text-white');
        btnDaily.classList.remove('bg-cyan-500', 'text-black', 'font-bold');
        btnDaily.classList.add('text-white');
    } else {
        btnDaily.classList.add('bg-cyan-500', 'text-black', 'font-bold');
        btnDaily.classList.remove('text-white');
        btnWeekly.classList.remove('bg-cyan-500', 'text-black', 'font-bold');
        btnWeekly.classList.add('text-white');
    }
}
</script>
</body>
</html>