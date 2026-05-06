<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Order Form</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center p-8 bg-[#0f172a]">

<!-- Ensure method is POST and action points to the store route -->
<form action="{{ route('job-order.store') }}" method="POST" id="jobOrderForm">
@csrf
<input type="hidden" name="customer_id" id="customer_id">
<input type="hidden" name="vehicle_id" id="vehicle_id">
<input type="hidden" name="staff_id" id="staff_id">
<input type="hidden" name="total_cost" id="total_cost" value="0">

<div class="bg-[#1e293b] border border-slate-700 rounded-xl p-7 w-full max-w-3xl shadow-2xl">
  <h2 class="text-white text-xl font-bold mb-6 border-b border-slate-700 pb-4">Job Order / Repair Estimate</h2>

  <!-- Selection Section[cite: 11] -->
  <div class="grid grid-cols-2 gap-8 mb-6">
    <div>
      <label class="block text-xs font-bold text-slate-400 mb-2 uppercase">Customer</label>
      <div class="h-40 overflow-y-auto rounded-lg border border-slate-700 bg-[#0f172a] custom-scrollbar">
        <table class="w-full text-sm">
          <tbody id="customerTableBody">
            @foreach($customers as $customer)
            <tr class="border-b border-slate-800 hover:bg-slate-800 cursor-pointer transition" onclick="selectCustomer('{{ $customer->id }}', this)">
              <td class="px-4 py-2 text-white">{{ $customer->cust_name }}</td>
              <td class="px-4 py-2 text-right"><span class="text-blue-500 text-xs uppercase font-bold">Select</span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <div>
      <label class="block text-xs font-bold text-slate-400 mb-2 uppercase">Vehicle</label>
      <div class="h-40 overflow-y-auto rounded-lg border border-slate-700 bg-[#0f172a] custom-scrollbar">
        <table class="w-full text-sm">
          <tbody id="vehicleTableBody">
            @foreach($vehicles as $vehicle)
            <tr class="border-b border-slate-800 hover:bg-slate-800 cursor-pointer transition vehicle-row hidden" data-customer="{{ $vehicle->customer_id }}" onclick="selectVehicle('{{ $vehicle->vehicle_id }}', this)">
              <td class="px-4 py-2 text-white font-mono">{{ $vehicle->plate_number }}</td>
              <td class="px-4 py-2 text-slate-500 text-right">{{ $vehicle->make }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Mechanic Selector[cite: 11] -->
  <div class="mb-6">
    <label class="block text-xs font-bold text-slate-400 mb-2 uppercase">Assigned Mechanic</label>
    <div class="relative">
      <input type="text" id="mechanic_display" readonly onclick="toggleDropdown('mechanicDropdown')" placeholder="Click to select mechanic..." class="w-full bg-[#0f172a] border border-slate-600 text-white rounded-lg px-4 py-2 cursor-pointer focus:border-blue-500 outline-none">
      <ul id="mechanicDropdown" class="absolute z-50 w-full mt-1 bg-slate-800 border border-slate-600 rounded-lg shadow-2xl hidden max-h-40 overflow-y-auto">  
        @foreach($mechanics as $mechanic)
          <li class="px-4 py-2 hover:bg-blue-600 text-white cursor-pointer border-b border-slate-700 last:border-0" onclick="selectMechanic('{{ $mechanic->name }}', '{{ $mechanic->id }}')">
            {{ $mechanic->name }}
          </li>
        @endforeach
      </ul>
    </div>
  </div>

  <!-- Services Calculator Section[cite: 11] -->
  <div class="space-y-4">
    <div class="bg-slate-800/40 p-4 rounded-lg border border-slate-700">
      <div class="flex justify-between items-center mb-2">
        <span class="text-xs font-bold text-blue-400 uppercase">Labor / Services</span>
        <span class="text-xs text-slate-400">Subtotal: ₱<span id="serviceSubtotal">0.00</span></span>
      </div>
      <div id="activeServices" class="space-y-2 mb-3"></div>
      <div class="flex gap-2">
        <select id="serviceSelect" class="flex-1 bg-[#0f172a] border border-slate-600 text-white rounded px-3 py-2 text-sm">
          <option value="">Choose Service...</option>
          @foreach($services as $s) 
            <option value="{{ $s->service_id }}" data-price="{{ $s->price }}">{{ $s->job_desc }}</option> 
          @endforeach
        </select>
        <button type="button" onclick="addService()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded font-bold text-lg">+</button>
      </div>
    </div>

    <!-- Parts Calculator Section[cite: 11] -->
    <div class="bg-slate-800/40 p-4 rounded-lg border border-slate-700">
      <div class="flex justify-between items-center mb-2">
        <span class="text-xs font-bold text-emerald-400 uppercase">Parts / Materials</span>
        <span class="text-xs text-slate-400">Subtotal: ₱<span id="partSubtotal">0.00</span></span>
      </div>
      <div id="activeParts" class="space-y-2 mb-3"></div>
      <div class="flex gap-2">
        <select id="partSelect" class="flex-1 bg-[#0f172a] border border-slate-600 text-white rounded px-3 py-2 text-sm">
          <option value="">Choose Part...</option>
          @foreach($parts as $p) 
            <option value="{{ $p->part_id }}" data-price="{{ $p->price }}"> {{ $p->part_name }}</option> 
          @endforeach
        </select>
        <input type="number" id="partQty" value="1" min="1" class="w-16 bg-[#0f172a] border border-slate-600 text-white rounded px-2 text-sm">
        <button type="button" onclick="addPart()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 rounded font-bold text-lg">+</button>
      </div>
    </div>
  </div>

  <!-- Bottom Section[cite: 11] -->
  <div class="mt-6 pt-4 border-t border-slate-700 flex justify-between items-end">
    <div>
      <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Date Issued</label>
      <input type="date" name="date_issued" value="{{ date('Y-m-d') }}" class="bg-[#0f172a] border border-slate-600 text-white rounded px-3 py-1 text-sm">
    </div>
    <div class="text-right">
      <span class="text-xs font-bold text-slate-500 uppercase block">Total Estimate</span>
      <span class="text-2xl font-black text-emerald-500">₱<span id="displayTotal">0.00</span></span>
    </div>
  </div>

  <div class="flex justify-end gap-3 mt-6">
    <button type="button" onclick="window.history.back()" class="px-6 py-2 text-slate-400 hover:text-white text-sm font-bold">Cancel</button>
    <button type="submit" class="bg-orange-600 hover:bg-orange-500 text-white px-8 py-2 rounded-lg font-bold shadow-lg shadow-orange-900/20">Add Order</button>
  </div>
</div>
</form>

<script>
// JS logic to handle row selection and calculations[cite: 11]
function selectCustomer(id, el) {
  document.getElementById('customer_id').value = id;
  document.querySelectorAll('#customerTableBody tr').forEach(r => r.classList.remove('bg-blue-900/30'));
  el.classList.add('bg-blue-900/30');
  
  document.querySelectorAll('.vehicle-row').forEach(row => {
    row.classList.toggle('hidden', row.dataset.customer !== id);
  });
}

function selectVehicle(id, el) {
  document.getElementById('vehicle_id').value = id;
  document.querySelectorAll('#vehicleTableBody tr').forEach(r => r.classList.remove('bg-blue-900/30'));
  el.classList.add('bg-blue-900/30');
}

function selectMechanic(name, id) {
  document.getElementById('mechanic_display').value = name;
  document.getElementById('staff_id').value = id;
  document.getElementById('mechanicDropdown').classList.add('hidden');
}

function toggleDropdown(id) {
  document.getElementById(id).classList.toggle('hidden');
}

function addService() {
  const sel = document.getElementById('serviceSelect');
  if(!sel.value) return;
  const price = parseFloat(sel.options[sel.selectedIndex].dataset.price);
  const name = sel.options[sel.selectedIndex].text;
  
  const html = `<div class="flex justify-between items-center text-sm text-white bg-slate-700/30 p-2 rounded">
    <span>${name}</span>
    <div class="flex items-center gap-4">
      <span>₱${price.toFixed(2)}</span>
      <button type="button" onclick="this.parentElement.parentElement.remove(); calc();" class="text-red-500">✕</button>
      <input type="hidden" name="services[]" value="${sel.value}">
    </div>
  </div>`;
  document.getElementById('activeServices').insertAdjacentHTML('beforeend', html);
  calc();
}

function addPart() {
  const sel = document.getElementById('partSelect');
  const qty = parseInt(document.getElementById('partQty').value);
  if(!sel.value || qty < 1) return;
  const price = parseFloat(sel.options[sel.selectedIndex].dataset.price) * qty;
  
  const html = `<div class="flex justify-between items-center text-sm text-white bg-slate-700/30 p-2 rounded">
    <span>${sel.options[sel.selectedIndex].text} (x${qty})</span>
    <div class="flex items-center gap-4">
      <span>₱${price.toFixed(2)}</span>
      <button type="button" onclick="this.parentElement.parentElement.remove(); calc();" class="text-red-500">✕</button>
      <input type="hidden" name="parts[]" value="${sel.value}">
      <input type="hidden" name="qty[]" value="${qty}">
    </div>
  </div>`;
  document.getElementById('activeParts').insertAdjacentHTML('beforeend', html);
  calc();
}

// Replace your existing calc() function with this one:
function calc() {
  let sSub = 0;
  // Sum Services
  document.querySelectorAll('#activeServices input[name="services[]"]').forEach(i => {
    const serviceOpt = document.querySelector(`#serviceSelect option[value="${i.value}"]`);
    if(serviceOpt) sSub += parseFloat(serviceOpt.dataset.price);
  });
  
  let pSub = 0;
  // Sum Parts: Price * Quantity
  document.querySelectorAll('#activeParts > div').forEach(row => {
    const pId = row.querySelector('input[name="parts[]"]').value;
    const q = parseInt(row.querySelector('input[name="qty[]"]').value);
    const partOpt = document.querySelector(`#partSelect option[value="${pId}"]`);
    
    if(partOpt) {
      const unitPrice = parseFloat(partOpt.dataset.price);
      pSub += unitPrice * q; // Multiply by quantity here
    }
  });

  document.getElementById('serviceSubtotal').innerText = sSub.toFixed(2);
  document.getElementById('partSubtotal').innerText = pSub.toFixed(2);
  
  const total = sSub + pSub;
  document.getElementById('displayTotal').innerText = total.toLocaleString(undefined, {minimumFractionDigits: 2});
  document.getElementById('total_cost').value = total;
}
</script>

</body>
</html>