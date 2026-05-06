<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Management</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#232323] text-white">
    @include('layouts.logout')
    
    <div class="flex"> 
        @include('layouts.sidenav')

        <main class="flex-1 p-6 min-h-screen">
            <h1 class="text-3xl font-bold text-white">Services</h1>

            <div class="max-w-7xl mx-auto pt-5 flex gap-6">

                <!-- 📦 LEFT SIDE: TABLE -->
                <div class="w-[60%]">
                    <div class="overflow-hidden rounded-2xl border border-gray-700 bg-[#1f1f1f] shadow-inner">
                        <div style="scrollbar-width: none; -ms-overflow-style: none;" class="max-h-[420px] overflow-y-auto no-scrollbar">
                            <table class="w-full text-sm text-left text-gray-300">
                                <thead class="bg-[#262626] text-gray-400 uppercase text-xs sticky top-0">
                                    <tr>
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">Description</th>
                                        <th class="px-4 py-3">Price</th>
                                        <th class="px-4 py-3">Interval</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceTable" class="divide-y divide-gray-700">
                                    @foreach($services as $s)
                                    <tr class="hover:bg-[#2e2e2e] transition duration-150 cursor-pointer"
                                        onclick="selectRow({{ $s->service_id }}, '{{ $s->job_desc }}', '{{ $s->price }}', '{{ $s->interval_value }}', '{{ $s->interval_unit }}')">
                                        <td class="px-4 py-3 text-gray-400">{{ $s->service_id }}</td>
                                        <td class="px-4 py-3 font-medium text-white">{{ $s->job_desc }}</td>
                                        <td class="px-4 py-3 text-gray-300">₱{{ number_format($s->price, 2) }}</td>
                                        <td class="px-4 py-3 text-gray-300">{{ $s->interval_value }} {{ $s->interval_unit }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 📝 RIGHT SIDE: FORM -->
                <div class="w-[40%]">
                    <form id="serviceForm" action="{{ route('services.store') }}" method="POST">
                        @csrf
                        <!-- Hidden ID input for Update/Delete -->
                        <input type="hidden" id="service_id" name="service_id">

                        <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-7 w-full max-w-md">
                            <h2 class="text-white text-lg font-medium mb-6">Service Form</h2>

                            <div class="mb-4">
                                <label class="block text-sm text-gray-400 mb-1">Job Description</label>
                                <input type="text" id="desc" name="job_desc" required class="w-full bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-3 py-2 text-sm"/>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm text-gray-400 mb-1">Price</label>
                                <input type="number" step="0.01" id="price" name="price" required class="w-full bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-3 py-2 text-sm"/>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm text-gray-400 mb-1">Interval Value</label>
                                <input type="number" id="interval_value" name="interval_value" class="w-full bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-3 py-2 text-sm"/>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm text-gray-400 mb-1">Interval Unit</label>
                                <select id="interval_unit" name="interval_unit" class="w-full bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-3 py-2 text-sm">
                                    <option value="">None</option>
                                    <option value="days">Days</option>
                                    <option value="months">Months</option>
                                    <option value="years">Years</option>
                                </select>
                            </div>

                            <!-- Cyan Buttons -->
                            <div class="flex flex-col gap-2 mt-5">
                                <button type="submit" class="bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg px-6 py-2 text-sm font-bold transition">
                                    Save New
                                </button>
                                <div class="flex gap-2">
                                    <button type="submit" formaction="{{ route('services.update') }}" class="flex-1 bg-cyan-700 hover:bg-cyan-600 text-white rounded-lg px-6 py-2 text-sm transition">
                                        Update
                                    </button>
                                    <button type="submit" formaction="{{ route('services.delete') }}" class="flex-1 bg-red-600 hover:bg-red-500 text-white rounded-lg px-6 py-2 text-sm transition">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <script>
    function selectRow(id, desc, price, interval_value, interval_unit) {
        document.getElementById("service_id").value = id;
        document.getElementById("desc").value = desc;
        document.getElementById("price").value = price;
        document.getElementById("interval_value").value = interval_value || '';
        document.getElementById("interval_unit").value = interval_unit || '';
    }
    </script>
</body>
</html>