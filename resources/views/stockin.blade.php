<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock In - BSA Auto Repair</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#1a1a1a] text-white flex min-h-screen">

    <!-- Sidebar Navigation -->
    <aside class="w-64 fixed inset-y-0 left-0 bg-[#121212] border-r border-gray-800">
        @include('layouts.sidenav')
        <div class="absolute bottom-5 left-5">
            @include('layouts.logout')
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-64 p-10">
        <div class="max-w-7xl mx-auto">
            
            <div class="flex flex-row gap-10 items-start">
                
                <!-- 📦 LEFT SIDE: STOCK HISTORY TABLE -->
                <div class="w-[60%]">
                    <h1 class="text-3xl font-black mb-8 tracking-tight uppercase">Inventory / Stock In</h1>
                    
                    <div class="overflow-hidden rounded-2xl border border-gray-800 bg-[#121212] shadow-2xl">
                        <div class="max-h-[600px] overflow-y-auto custom-scrollbar">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-[#1a1a1a] text-gray-500 uppercase text-xs sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-4 border-b border-gray-800">Part Name</th>
                                        <th class="px-6 py-4 border-b border-gray-800 text-center">Qty</th>
                                        <th class="px-6 py-4 border-b border-gray-800">Cost/Unit</th>
                                        <th class="px-6 py-4 border-b border-gray-800">Date</th>
                                        <th class="px-6 py-4 border-b border-gray-800 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800">
                                    @foreach($history as $item)
                                    <tr class="hover:bg-[#1f1f1f] transition-colors group">
                                        <td class="px-6 py-4 font-bold text-[#00ffff]">
                                            {{ $item->part->part_name ?? 'Unknown Part' }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-[#00ff88]">
                                            {{ $item->quantity_received }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-400">
                                            ₱{{ number_format($item->cost_per_unit, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($item->stock_in_arrived)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <!-- DELETE ACTION -->
                                            <form action="{{ route('stockin.delete', $item->id) }}" method="POST" 
                                                  onsubmit="return confirm('Permanently remove this stock record?')">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-400 font-black text-[10px] tracking-widest uppercase transition-all">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- 📝 RIGHT SIDE: STOCK IN FORM -->
                <div class="w-[40%] sticky top-10">
                    <form action="{{ route('stockin.store') }}" method="POST">
                        @csrf
                        <div class="bg-[#121212] border border-gray-800 rounded-3xl p-8 shadow-2xl">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-3 h-3 bg-[#00ffff] rounded-full shadow-[0_0_10px_rgba(0,255,255,0.5)]"></div>
                                <h2 class="text-white text-lg font-bold uppercase tracking-widest">New Stock Entry</h2>
                            </div>

                            <div class="space-y-4">
                                <!-- Part Selection/Input -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Part Name</label>
                                    <input type="text" name="part_name" required list="part-list"
                                           class="w-full bg-[#1a1a1a] border border-gray-700 text-gray-100 rounded-xl px-4 py-3 text-sm focus:border-[#00ffff] outline-none transition-all">
                                    <datalist id="part-list">
                                        @foreach($parts as $part)
                                            <option value="{{ $part->part_name }}">
                                        @endforeach
                                    </datalist>
                                </div>

                                <!-- Supplier -->
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Supplier</label>
                                    <select name="supplier_id" required 
                                            class="w-full bg-[#1a1a1a] border border-gray-700 text-gray-100 rounded-xl px-4 py-3 text-sm focus:border-[#00ffff] outline-none appearance-none">
                                        <option value="" disabled selected>Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Retail Price</label>
                                        <input type="number" step="0.01" name="price" required 
                                               class="w-full bg-[#1a1a1a] border border-gray-700 text-gray-100 rounded-xl px-4 py-3 text-sm focus:border-[#00ffff] outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Qty Received</label>
                                        <input type="number" name="quantity_received" required 
                                               class="w-full bg-[#1a1a1a] border border-gray-700 text-gray-100 rounded-xl px-4 py-3 text-sm focus:border-[#00ffff] outline-none">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Cost Per Unit (Supply Price)</label>
                                    <input type="number" step="0.01" name="cost_per_unit" required 
                                           class="w-full bg-[#1a1a1a] border border-gray-700 text-gray-100 rounded-xl px-4 py-3 text-sm focus:border-[#00ffff] outline-none">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">Date Arrived</label>
                                    <input type="datetime-local" name="stock_in_date" value="{{ now()->format('Y-m-d\TH:i') }}" required 
                                           class="w-full bg-[#1a1a1a] border border-gray-700 text-gray-100 rounded-xl px-4 py-3 text-sm focus:border-[#00ffff] outline-none">
                                </div>
                            </div>

                            <button type="submit" class="w-full mt-8 bg-[#00ffff] hover:bg-[#00dada] text-black rounded-xl py-4 text-xs font-black transition-all shadow-lg uppercase tracking-widest active:scale-95">
                                Complete Stock In
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #121212; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #444; }
    </style>
</body>
</html>