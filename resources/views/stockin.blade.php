<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Inventory</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#232323] text-white overflow-x-hidden">
    @include('layouts.logout')

    <div class="flex h-screen overflow-hidden"> 
        @include('layouts.sidenav')

        <main class="flex-1 p-8 overflow-y-auto bg-gradient-to-br from-[#232323] to-[#1a2e2e]">
            <h1 class="text-3xl font-bold text-white mb-6">Stock Inventory</h1>

            <!-- ALERT SECTION ADDED HERE[cite: 21, 29] -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-cyan-500/20 border border-cyan-500 text-cyan-400 rounded-xl shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-500/20 border border-red-500 text-red-400 rounded-xl">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="max-w-7xl mx-auto flex gap-6">
                <!-- TABLE SECTION -->
                <div class="w-[50%]">
                    <input type="text" id="searchPart" placeholder="Search inventory..." onkeyup="filterParts()"
                        class="w-full mb-4 bg-[#1f1f1f] border border-gray-700 text-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all" />

                    <div style="scrollbar-width: none;" class="h-[550px] overflow-y-auto rounded-2xl border border-gray-700 bg-[#1f1f1f] shadow-2xl">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead class="bg-[#1f1f1f] sticky top-0 border-b border-gray-700 text-gray-500 uppercase text-[10px] tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Part Name</th>
                                    <th class="px-6 py-4">In Stock</th>
                                    <th class="px-6 py-4">Price</th>
                                </tr>
                            </thead>
                            <tbody id="partTable">
                                @foreach($parts as $p)
                                <tr class="hover:bg-[#2a2a2a] cursor-pointer border-b border-gray-800/50 transition-colors" 
                                    onclick="selectPart({{ $p->part_id }}, '{{ addslashes($p->part_name) }}', '{{ addslashes($p->description) }}', {{ $p->price }})">
                                    <td class="px-6 py-4 text-cyan-300 font-medium">{{ $p->part_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="{{ $p->stock_qty < 5 ? 'text-red-500' : 'text-green-400' }} font-bold">
                                            {{ $p->stock_qty }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400">₱{{ number_format($p->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FORM SECTION -->
                <div class="w-[50%]">
                    <form id="stockForm" method="POST" action="{{ route('stockin.store') }}">
                        @csrf
                        <input type="hidden" id="part_id" name="part_id">
                        
                        <div class="bg-[#1a1a1a] border border-[#333] rounded-2xl p-8 w-full shadow-2xl border-t-4 border-t-cyan-500">
                            <h2 class="text-white text-xl font-bold mb-6">Stock Adjustment</h2>
                            
                            <div class="space-y-5">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Part Name</label>
                                        <input type="text" id="display_name" name="part_name" list="partSuggestions" oninput="syncIdFromType(this.value)"
                                            class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-cyan-400 rounded-lg px-4 py-2.5 text-sm font-bold outline-none focus:border-cyan-500" required/>
                                        <datalist id="partSuggestions">
                                            @foreach($parts as $p)
                                                <option data-id="{{ $p->part_id }}" data-desc="{{ $p->description }}" data-price="{{ $p->price }}" value="{{ $p->part_name }}">
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div>
                                        <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Retail Price</label>
                                        <input type="number" step="0.01" id="form_price" name="price" required
                                            class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-cyan-500"/>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Part Description</label>
                                    <textarea id="form_description" name="description" rows="2"
                                        class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-4 py-2 text-sm outline-none focus:border-cyan-500"></textarea>
                                </div>

                                <hr class="border-[#333]">

                                <div>
                                    <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Supplier</label>
                                    <select name="supplier_id" required class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-cyan-500">
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $s)
                                            <option value="{{ $s->supplier_id }}">{{ $s->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Qty Received</label>
                                        <input type="number" name="quantity_received" required class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-cyan-500"/>
                                    </div>
                                    <div class="flex-1">
                                        <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Cost Per Unit</label>
                                        <input type="number" step="0.01" name="cost_per_unit" required class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-cyan-500"/>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Date Arrived</label>
                                    <input type="datetime-local" name="stock_in_date" value="{{ date('Y-m-d\TH:i') }}" required
                                        class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-4 py-2.5 text-sm outline-none focus:border-cyan-500"/>
                                </div>
                            </div>

                            <div class="mt-8">
                                <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-400 text-black rounded-xl py-4 text-sm font-black uppercase tracking-[0.2em] shadow-lg shadow-cyan-500/20 transition-all active:scale-95">
                                    Complete Stock In
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function syncIdFromType(val) {
            const options = document.querySelectorAll('#partSuggestions option');
            const hiddenIdInput = document.getElementById("part_id");
            const descInput = document.getElementById("form_description");
            const priceInput = document.getElementById("form_price");
            
            hiddenIdInput.value = ""; 
            options.forEach(option => {
                if (option.value === val) {
                    hiddenIdInput.value = option.getAttribute('data-id');
                    descInput.value = option.getAttribute('data-desc');
                    priceInput.value = option.getAttribute('data-price');
                }
            });
        }

        function selectPart(id, name, desc, price) {
            document.getElementById("part_id").value = id;
            document.getElementById("display_name").value = name;
            document.getElementById("form_description").value = desc;
            document.getElementById("form_price").value = price;
            
            const display = document.getElementById("display_name");
            display.classList.add('ring-2', 'ring-cyan-500');
            setTimeout(() => display.classList.remove('ring-2'), 500);
        }

        function filterParts() {
            let input = document.getElementById("searchPart").value.toLowerCase();
            let rows = document.querySelectorAll("#partTable tr");
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
            });
        }
    </script>
</body>
</html>