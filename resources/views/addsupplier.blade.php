<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suppliers</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#232323] text-white overflow-hidden">
    @include('layouts.logout')

    <div class="flex h-screen"> 
        <!-- SIDENAV -->
        @include('layouts.sidenav')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-8 overflow-y-auto bg-gradient-to-br from-[#232323] to-[#1a2e2e]">
            <h1 class="text-3xl font-bold text-white mb-6">Suppliers</h1>

            <div class="max-w-7xl mx-auto flex gap-6">
                <!-- TABLE SECTION -->
                <div class="w-[60%]">
                    <input 
                        type="text"
                        id="searchSupplier"
                        placeholder="Search supplier..."
                        onkeyup="filterSuppliers()"
                        class="w-full mb-4 bg-[#1f1f1f] border border-gray-700 text-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 transition-all"
                    />

                    <div style="scrollbar-width: none;" class="h-[550px] overflow-y-auto rounded-2xl border border-gray-700 bg-[#1f1f1f] shadow-2xl">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead class="bg-[#1f1f1f] sticky top-0 border-b border-gray-700 text-gray-500 uppercase text-[10px] tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Name</th>
                                    <th class="px-6 py-4">Contact</th>
                                    <th class="px-6 py-4">Address</th>
                                </tr>
                            </thead>
                            <tbody id="supplierTable">
                                @foreach($suppliers as $s)
                                <tr class="hover:bg-[#2a2a2a] cursor-pointer border-b border-gray-800/50 transition-colors" 
                                    onclick="selectRow({{ $s->supplier_id }}, '{{ $s->supplier_name }}', '{{ $s->contact_number }}', '{{ $s->address }}')">
                                    <td class="px-6 py-4 text-gray-500">{{ $s->supplier_id }}</td>
                                    <td class="px-6 py-4 text-cyan-300 font-medium">{{ $s->supplier_name }}</td>
                                    <td class="px-6 py-4 text-gray-400">{{ $s->contact_number }}</td>
                                    <td class="px-6 py-4 text-gray-400">{{ $s->address }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FORM SECTION -->
                <div class="w-[40%]">
                    <form id="supplierForm" method="POST">
                        @csrf
                        <input type="hidden" id="supplier_id">
                        <div class="bg-[#1a1a1a] border border-[#333] rounded-2xl p-8 w-full shadow-2xl border-t-4 border-t-cyan-500">
                            <h2 class="text-white text-xl font-bold mb-6">Add/Edit Suppliers</h2>

                            <div class="space-y-5">
                                <div>
                                    <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Supplier Name</label>
                                    <input type="text" id="name" name="supplier_name" required
                                        class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500"/>
                                </div>

                                <div>
                                    <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Contact Number</label>
                                    <input type="text" id="contact" name="contact_number"
                                        class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500"/>
                                </div>

                                <div>
                                    <label class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Address</label>
                                    <input type="text" id="address" name="address"
                                        class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-cyan-500"/>
                                </div>
                            </div>

                            <!-- CYAN BUTTONS[cite: 19] -->
                            <div class="grid grid-cols-2 gap-3 mt-8">
                                <button type="button" onclick="addSupplier()"
                                    class="col-span-2 bg-cyan-500 hover:bg-cyan-400 text-black font-black uppercase tracking-widest py-3 rounded-xl transition-all shadow-lg shadow-cyan-500/20">
                                    Add New Supplier
                                </button>
                                <button type="button" onclick="updateSupplier()"
                                    class="bg-gray-700 hover:bg-cyan-600 text-white font-bold py-2.5 rounded-lg transition-all">
                                    Update
                                </button>
                                <button type="button" onclick="deleteSupplier()"
                                    class="bg-red-900/30 hover:bg-red-600 text-red-200 font-bold py-2.5 rounded-lg transition-all border border-red-900/50">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        let selectedId = null;

        function selectRow(id, name, contact, address) {
            selectedId = id;
            document.getElementById("supplier_id").value = id;
            document.getElementById("name").value = name;
            document.getElementById("contact").value = contact;
            document.getElementById("address").value = address;
            
            // Visual feedback
            const form = document.querySelector('form > div');
            form.classList.add('ring-2', 'ring-cyan-500');
            setTimeout(() => form.classList.remove('ring-2'), 400);
        }

        function addSupplier() {
            let form = document.getElementById("supplierForm");
            form.action = "{{ route('suppliers.store') }}";
            form.submit();
        }

        function updateSupplier() {
            if (!selectedId) return alert("Select a supplier first");
            let form = document.getElementById("supplierForm");
            form.action = "/suppliers/update/" + selectedId;
            form.submit();
        }

        function deleteSupplier() {
            if (!selectedId || !confirm("Are you sure?")) return;
            let form = document.getElementById("supplierForm");
            form.action = "/suppliers/delete/" + selectedId;
            form.submit();
        }

        function filterSuppliers() {
            let input = document.getElementById("searchSupplier").value.toLowerCase();
            let rows = document.querySelectorAll("#supplierTable tr");
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
            });
        }
    </script>
</body>
</html>