<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service History</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#232323] text-white">
    @include('layouts.logout')
    <div class="flex"> 
        @include('layouts.sidenav')

        <main class="flex-1 p-6 min-h-screen">
            <h1 class="text-3xl font-bold text-white">Service Records</h1>

            <div class="max-w-7xl mx-auto pt-5">
                <div class="mb-6">
                    <!-- Search Input -->
                    <input 
                        type="text"
                        id="searchRecords"
                        placeholder="Search by Job ID or Customer..."
                        onkeyup="filterRecords()"
                        class="w-full mb-3 bg-[#1f1f1f] border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                    />

                    <!-- Table Container -->
                    <div style="scrollbar-width: none; -ms-overflow-style: none;" class="h-[500px] overflow-y-auto no-scrollbar rounded-2xl border border-gray-700 bg-[#1f1f1f] shadow-inner">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead>
                                <tr class="text-gray-500 uppercase text-[10px] tracking-widest border-b border-gray-800">
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Job ID</th>
                                    <th class="px-6 py-4">Customer</th>
                                    <th class="px-6 py-4">Total Amount</th>
                                    <th class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody id="recordsTable">
                                @forelse($history as $jo)
                                <tr class="hover:bg-[#2a2a2a] border-b border-gray-800/50 transition-colors">
                                    <td class="px-6 py-4 text-gray-400">
                                        {{ \Carbon\Carbon::parse($jo->date_issued)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-white">#JO-{{ $jo->job_order_id }}</td>
                                    <td class="px-6 py-4">{{ $jo->customer_name }}</td>
                                    <td class="px-6 py-4 text-orange-400 font-mono font-bold">
                                        ₱{{ number_format($jo->total_cost, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('job-order.pdf', $jo->job_order_id) }}" class="bg-orange-500/10 text-orange-500 hover:bg-orange-500 hover:text-white px-4 py-1.5 rounded-lg text-xs font-bold transition-all">
                                            View PDF
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                        No service records found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function filterRecords() {
            let input = document.getElementById("searchRecords").value.toLowerCase();
            let rows = document.querySelectorAll("#recordsTable tr");
            rows.forEach(row => {
                if (row.cells.length > 1) {
                    row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
                }
            });
        }
    </script>
</body>
</html>