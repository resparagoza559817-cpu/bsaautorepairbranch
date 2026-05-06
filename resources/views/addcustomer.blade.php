<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#232323] text-white">
    @include('layouts.logout')
    <div class="flex"> 
        @include('layouts.sidenav')

        <main class="flex-1 p-6 min-h-screen">
            <h1 class="text-3xl font-bold text-white">Customers</h1>

            <div class="max-w-7xl mx-auto pt-5 flex gap-6">
                <!-- TABLE SECTION -->
                <div class="w-[60%]">
                    <input 
                        type="text"
                        id="searchCustomer"
                        placeholder="Search customer..."
                        onkeyup="filterTable()"
                        class="w-full mb-3 bg-[#1f1f1f] border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                    />

                    <div style="scrollbar-width: none; -ms-overflow-style: none;" class="h-[420px] overflow-y-auto no-scrollbar rounded-2xl border border-gray-700 bg-[#1f1f1f] shadow-inner">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead>
                                <tr class="border-b border-gray-700 text-gray-400 uppercase text-[10px] tracking-wider">
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Full Name</th>
                                    <th class="px-4 py-3">Contact</th>
                                </tr>
                            </thead>
                            <tbody id="dataTable">
                                @foreach($customers as $c)
                                <tr class="hover:bg-[#2a2a2a] cursor-pointer border-b border-gray-800/50 transition-colors" 
                                    onclick="selectCustomer('{{ $c->id }}', '{{ addslashes($c->cust_name) }}', '{{ $c->contact_number }}')">
                                    <td class="px-4 py-3">{{ $c->id }}</td>
                                    <td class="px-4 py-3 font-medium text-white">{{ $c->cust_name }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $c->contact_number }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FORM SECTION -->
                <div class="w-[40%]">
                    <form id="customerForm" method="POST">
                        @csrf
                        <input type="hidden" id="customer_id" name="id">
                        <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-7 w-full max-w-md shadow-xl">
                            <h2 class="text-white text-lg font-medium mb-6">Add/Edit Customer</h2>
                            
                            <div class="mb-4">
                                <label class="text-[10px] text-gray-500 uppercase tracking-widest">Customer Name</label>
                                <input type="text" id="cust_name" name="name" required 
                                    class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-3 py-2 text-sm focus:border-orange-500 outline-none transition-all"/>
                            </div>

                            <div class="mb-6">
                                <label class="text-[10px] text-gray-500 uppercase tracking-widest">Contact Number</label>
                                <input type="text" id="cust_phone" name="phone" 
                                    class="w-full mt-1 bg-[#2a2a2a] border border-[#444] text-gray-100 rounded-lg px-3 py-2 text-sm focus:border-orange-500 outline-none transition-all"/>
                            </div>

                            <div class="flex flex-col gap-3 mt-5">
                                <div class="flex gap-3">
                                    <button type="button" onclick="submitForm('store')" 
                                        class="flex-1 bg-[#ff8800] hover:bg-orange-600 text-white rounded-lg py-2.5 text-sm font-bold transition-all shadow-lg shadow-orange-900/20">
                                        Add
                                    </button>
                                    <button type="button" id="updateBtn" onclick="submitForm('update')" 
                                        class="flex-1 bg-[#333] hover:bg-[#444] text-white rounded-lg py-2.5 text-sm font-bold transition-all">
                                        Update
                                    </button>
                                </div>
                                <button type="button" id="deleteBtn" onclick="confirmDelete()" 
                                    class="w-full bg-red-600/10 border border-red-600/20 text-red-500 hover:bg-red-600 hover:text-white rounded-lg py-2 text-xs font-bold transition-all opacity-50 cursor-not-allowed" disabled>
                                    Delete Customer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Fills the form when you click a row in the table[cite: 8]
        function selectCustomer(id, name, phone) {
            document.getElementById("customer_id").value = id;
            document.getElementById("cust_name").value = name;
            document.getElementById("cust_phone").value = phone;

            // Enable Update/Delete buttons visually[cite: 8]
            const upBtn = document.getElementById("updateBtn");
            const delBtn = document.getElementById("deleteBtn");
            
            upBtn.classList.replace('bg-[#333]', 'bg-blue-600');
            delBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            delBtn.disabled = false;
        }

        // Asks for confirmation before deleting[cite: 9]
        function confirmDelete() {
            const name = document.getElementById("cust_name").value;
            if (confirm(`Are you sure you want to delete ${name}?`)) {
                submitForm('delete');
            }
        }

        // Dynamically changes the form "action" based on which button you click[cite: 5, 8]
        function submitForm(type) {
            const form = document.getElementById('customerForm');
            const id = document.getElementById('customer_id').value;
            
            if (type === 'update') {
                form.action = '/customer/update/' + id;
            } else if (type === 'delete') {
                form.action = '/customer/delete/' + id;
            } else {
                form.action = '/customer/store';
            }
            form.submit();
        }

        // Simple search filter[cite: 8]
        function filterTable() {
            let input = document.getElementById("searchCustomer").value.toLowerCase();
            let rows = document.querySelectorAll("#dataTable tr");
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
            });
        }
    </script>
</body>
</html>