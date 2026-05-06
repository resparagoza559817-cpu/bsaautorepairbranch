<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Garage</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#232323] text-white">
    @include('layouts.logout')
    <div class="flex"> 
        @include('layouts.sidenav')

        <main class="flex-1 p-6 min-h-screen">
            <h1 class="text-3xl font-bold text-white">Garage Management</h1>

            <div class="max-w-7xl mx-auto pt-5 flex gap-6">
                <!-- VEHICLE TABLE -->
                <div class="w-[60%]">
                    <div style="scrollbar-width: none;" class="h-[500px] overflow-y-auto rounded-2xl border border-gray-700 bg-[#1f1f1f]">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead class="sticky top-0 bg-[#1f1f1f] border-b border-gray-700 text-[10px] uppercase text-gray-500">
                                <tr>
                                    <th class="px-4 py-3">Plate Number</th>
                                    <th class="px-4 py-3">Make / Engine Model</th>
                                    <th class="px-4 py-3">Owner</th>
                                </tr>
                            </thead>
                            <tbody id="vehicleTable">
                                @foreach($vehicles as $v)
                                <tr class="hover:bg-[#2a2a2a] cursor-pointer border-b border-gray-800/50" 
                                    onclick="selectVehicle('{{ $v->vehicle_id }}', '{{ $v->plate_number }}', '{{ $v->make }}', '{{ $v->engine_model }}', '{{ $v->customer_id }}')">
                                    <!-- Changed text-orange-500 to text-cyan-300 (Pastel) -->
                                    <td class="px-4 py-3 text-cyan-300 font-bold">{{ $v->plate_number }}</td>
                                    <td class="px-4 py-3">
                                        {{ $v->make }} 
                                        <span class="text-gray-500">({{ $v->engine_model ?? 'N/A' }})</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $v->customer->cust_name ?? 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FORM SECTION -->
                <div class="w-[40%]">
                    <form id="vehicleForm" method="POST" action="{{ route('vehicles.store') }}">
                        @csrf
                        <input type="hidden" id="vehicle_id" name="vehicle_id" value="">
                        
                        <div class="bg-[#1a1a1a] border border-[#333] rounded-xl p-7 w-full shadow-xl">
                            <h2 class="text-white text-lg font-medium mb-6">Vehicle Registration</h2>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-[10px] text-gray-500 uppercase">Plate Number</label>
                                    <input type="text" id="plate_number" name="plate_number" required class="w-full mt-1 bg-[#2a2a2a] border border-[#444] rounded-lg px-3 py-2 text-sm outline-none focus:border-cyan-300 transition-all"/>
                                </div>
                                <div class="flex gap-2">
                                    <div class="flex-1">
                                        <label class="text-[10px] text-gray-500 uppercase">Make</label>
                                        <input type="text" id="make" name="make" class="w-full mt-1 bg-[#2a2a2a] border border-[#444] rounded-lg px-3 py-2 text-sm outline-none focus:border-cyan-300"/>
                                    </div>
                                    <div class="flex-1">
                                        <label class="text-[10px] text-gray-500 uppercase">Engine Model</label>
                                        <input type="text" id="engine_model" name="engine_model" class="w-full mt-1 bg-[#2a2a2a] border border-[#444] rounded-lg px-3 py-2 text-sm outline-none focus:border-cyan-300"/>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-500 uppercase">Assign Owner</label>
                                    <select id="customer_id" name="customer_id" class="w-full mt-1 bg-[#2a2a2a] border border-[#444] rounded-lg px-3 py-2 text-sm outline-none focus:border-cyan-300">
                                        <option value="">Select Owner</option>
                                        @foreach($customers as $c)
                                            <option value="{{ $c->id }}">{{ $c->cust_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 mt-6">
                                <div class="flex gap-3">
                                    <!-- Changed bg-orange-600 to bg-cyan-500 (Pastel Cyan) -->
                                    <button type="button" onclick="submitVehicleForm('store')" class="flex-1 bg-cyan-500 hover:bg-cyan-600 text-black rounded-lg py-2.5 text-sm font-bold transition-all">Register</button>
                                    <button type="button" id="updateBtn" onclick="submitVehicleForm('update')" class="flex-1 bg-[#333] text-white rounded-lg py-2.5 text-sm font-bold transition-all">Update</button>
                                </div>
                                <button type="button" id="deleteBtn" onclick="confirmVehicleDelete()" class="w-full bg-red-600/10 border border-red-600/20 text-red-500 hover:bg-red-600 hover:text-white rounded-lg py-2 text-xs font-bold transition-all opacity-50 cursor-not-allowed" disabled>Delete Vehicle</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
function selectVehicle(id, plate, make, engModel, ownerId) {
    document.getElementById("vehicle_id").value = id;
    document.getElementById("plate_number").value = plate;
    document.getElementById("make").value = make;
    document.getElementById("engine_model").value = engModel;
    document.getElementById("customer_id").value = ownerId;

    // Selection now activates a Cyan-700 (Darker Cyan) button state
    document.getElementById("updateBtn").classList.replace('bg-[#333]', 'bg-cyan-700');
    const delBtn = document.getElementById("deleteBtn");
    delBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    delBtn.disabled = false;
}

function submitVehicleForm(type) {
    const form = document.getElementById('vehicleForm');
    const idValue = document.getElementById('vehicle_id').value;
    form.method = "POST";

    if (type === 'update') {
        if (!idValue) return alert('Please select a vehicle first!');
        form.action = "/vehicles/update/" + idValue;
    } else if (type === 'delete') {
        if (!idValue) return;
        form.action = "/vehicles/delete/" + idValue;
    } else {
        form.action = "/vehicles/store";
    }
    form.submit();
}

function confirmVehicleDelete() {
    if(confirm("Are you sure you want to remove this vehicle?")) {
        submitVehicleForm('delete');
    }
}
    </script>
</body>
</html>