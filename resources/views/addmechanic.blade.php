<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanics & Staff</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-[#232323] text-white">
    <!-- Main Flex Container for Sidebar + Content -->
    <div class="flex min-h-screen">
        
        <!-- 1. Left Sidebar Section -->
        <aside class="w-64 fixed inset-y-0 left-0 bg-[#1a1a1a] border-r border-gray-800">
            @include('layouts.sidenav')
            <div class="absolute bottom-5 left-5">
                @include('layouts.logout')
            </div>
        </aside>

        <!-- 2. Main Content Area (ml-64 pushes it past the sidebar) -->
        <main class="flex-1 ml-64 p-10">
            <div class="max-w-6xl mx-auto">
                <h1 class="text-3xl font-black text-white mb-8 tracking-tight uppercase">Mechanics/Staff</h1>

                <div class="flex flex-row gap-10 items-start">
                    
                    <!-- 📦 LEFT SIDE: SEARCH & TABLE -->
                    <div class="w-[60%]">
                        <div class="mb-5">
                            <input type="text" id="searchStaff" placeholder="Search staff names..." onkeyup="filterStaff()" 
                                   class="w-full bg-[#121212] border border-gray-700 text-gray-200 rounded-xl px-5 py-3 focus:ring-2 focus:ring-orange-500 outline-none transition-all shadow-inner"/>
                        </div>
                        
                        <div class="overflow-hidden rounded-2xl border border-gray-800 bg-[#1a1a1a] shadow-xl">
                            <div class="max-h-[550px] overflow-y-auto custom-scrollbar">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-[#212121] text-gray-500 uppercase text-xs sticky top-0">
                                        <tr>
                                            <th class="px-6 py-4">ID</th>
                                            <th class="px-6 py-4">Name</th>
                                            <th class="px-6 py-4">Role</th>
                                            <th class="px-6 py-4">Contact</th>
                                        </tr>
                                    </thead>
                                    <tbody id="staffTable" class="divide-y divide-gray-800">
                                        @foreach($staff as $s)
                                        <tr class="hover:bg-[#252525] cursor-pointer transition-colors group" 
                                            onclick="selectStaff({{ $s->id }}, '{{ $s->name }}', '{{ $s->role }}', '{{ $s->contact_number }}')">
                                            <td class="px-6 py-4 text-gray-500 group-hover:text-gray-300">{{ $s->id }}</td>
                                            <td class="px-6 py-4 font-bold text-[#00ffff] staff-name">{{ $s->name }}</td>
                                            <td class="px-6 py-4 text-gray-300">{{ $s->role }}</td>
                                            <td class="px-6 py-4 text-gray-400 staff-contact">{{ $s->contact_number }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- 📝 RIGHT SIDE: STAFF DETAILS FORM -->
                    <div class="w-[40%]">
                        <form action="{{ route('staff.store') }}" method="POST" id="staffForm">
                            @csrf
                            <input type="hidden" id="staff_id" name="id">
                            <div class="bg-[#121212] border border-gray-800 rounded-3xl p-8 shadow-2xl">
                                <div class="flex items-center gap-3 mb-8">
                                    <div class="w-2.5 h-2.5 bg-orange-500 rounded-full shadow-[0_0_10px_rgba(249,115,22,0.5)]"></div>
                                    <h2 class="text-white text-lg font-bold tracking-wide">Staff Details</h2>
                                </div>
                                
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Full Name</label>
                                        <input type="text" id="name" name="name" required 
                                               class="w-full bg-[#1f1f1f] border border-gray-700 text-gray-100 rounded-xl px-4 py-3 text-sm focus:border-orange-500 outline-none transition-all"/>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Role / Position</label>
                                        <input type="text" id="role" name="role" 
                                               class="w-full bg-[#1f1f1f] border border-gray-700 text-gray-100 rounded-xl px-4 py-3 text-sm focus:border-orange-500 outline-none transition-all"/>
                                    </div>

                                    <div>
                                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Contact Number</label>
                                        <input type="text" id="contact_number" name="contact_number" 
                                               class="w-full bg-[#1f1f1f] border border-gray-700 text-gray-100 rounded-xl px-4 py-3 text-sm focus:border-orange-500 outline-none transition-all"/>
                                    </div>
                                </div>

                                <div class="mt-10 space-y-3">
                                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-500 text-white rounded-xl py-4 text-xs font-black transition-all shadow-lg active:scale-95 uppercase tracking-widest">
                                        Save New Member
                                    </button>
                                    <div class="flex gap-3">
                                        <button type="submit" formaction="{{ route('staff.update') }}" 
                                                class="flex-1 bg-blue-700 hover:bg-blue-600 text-white rounded-xl py-3 text-xs font-bold transition-all active:scale-95 uppercase">
                                            Update
                                        </button>
                                        <button type="submit" formaction="{{ route('staff.delete') }}" 
                                                class="flex-1 bg-red-700 hover:bg-red-600 text-white rounded-xl py-3 text-xs font-bold transition-all active:scale-95 uppercase"
                                                onclick="return confirm('Delete this staff member?')">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function selectStaff(id, name, role, contact) {
        document.getElementById('staff_id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('role').value = role;
        document.getElementById('contact_number').value = contact;
    }

    function filterStaff() {
        let input = document.getElementById("searchStaff").value.toLowerCase();
        let rows = document.querySelectorAll("#staffTable tr");
        rows.forEach(row => {
            let name = row.querySelector(".staff-name").textContent.toLowerCase();
            let contact = row.querySelector(".staff-contact").textContent.toLowerCase();
            row.style.display = (name.includes(input) || contact.includes(input)) ? "" : "none";
        });
    }
    </script>
</body>
</html>