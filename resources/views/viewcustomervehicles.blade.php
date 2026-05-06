<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#232323] text-white">

<main class="flex-1 p-6 min-h-screen">
        <h1 class="text-3xl font-bold text-white">Vehicles and their Owners</h1>

<input 
  type="text" 
  id="searchMaster"
  placeholder="Search name, contact, or make..."
  onkeyup="filterMaster()"
  class="mt-3 mb-3 w-full bg-[#1f1f1f] border border-gray-700 text-gray-200 
         rounded-xl px-4 py-2.5 text-sm 
         focus:outline-none focus:ring-2 focus:ring-orange-500"
/>

<div class="overflow-hidden rounded-2xl border border-gray-700 bg-[#1f1f1f] shadow-inner">

  <div class="max-h-[420px] overflow-y-auto no-scrollbar">
    <table class="w-full text-sm text-left text-gray-300">

      <!-- Header -->
      <thead class="bg-[#262626] text-gray-400 uppercase text-xs sticky top-0">
        <tr>
          <th class="px-4 py-3">Customer ID</th>
          <th class="px-4 py-3">Name</th>
          <th class="px-4 py-3">Contact</th>
          <th class="px-4 py-3">Vehicle ID</th>
          <th class="px-4 py-3">Plate</th>
          <th class="px-4 py-3">Make</th>
          <th class="px-4 py-3">Engine</th>
        </tr>
      </thead>

      <!-- Body -->
      <tbody id="masterTable" class="divide-y divide-gray-700">
        @foreach($vehicles as $v)
        <tr class="hover:bg-[#2e2e2e] transition duration-150">

          <td class="px-4 py-3 text-gray-400 customer-id">
            {{ $v->customer_id }}
          </td>

          <td class="px-4 py-3 font-medium text-white customer-name">
            {{ $v->cust_name }}
          </td>

          <td class="px-4 py-3 text-gray-300 customer-contact">
            {{ $v->contact_number }}
          </td>

          <td class="px-4 py-3 text-gray-400">
            {{ $v->vehicle_id }}
          </td>

          <td class="px-4 py-3 text-gray-300">
            {{ $v->plate_number }}
          </td>

          <td class="px-4 py-3 text-gray-300 make">
            {{ $v->make }}
          </td>

          <td class="px-4 py-3 text-gray-300">
            {{ $v->engine_model }}
          </td>

        </tr>
        @endforeach
      </tbody>

    </table>
  </div>

</div>

<div class="flex justify-end mt-6 me-10">
    <button type="button" onclick="window.location.href='/userdash'" class="border border-gray-400 text-gray-300 rounded-lg px-7 py-2 text-sm">
        Cancel
    </button>
</div>

</main>

</body>
</html>

<script>
function filterMaster() {
  let input = document.getElementById("searchMaster").value.toLowerCase();
  let rows = document.querySelectorAll("#masterTable tr");

  rows.forEach(row => {
    let name = row.querySelector(".customer-name")?.textContent.toLowerCase() || "";
    let contact = row.querySelector(".customer-contact")?.textContent.toLowerCase() || "";
    let make = row.querySelector(".make")?.textContent.toLowerCase() || "";

    if (
      name.includes(input) ||
      contact.includes(input) ||
      make.includes(input)
    ) {
      row.style.display = "";
    } else {
      row.style.display = "none";
    }
  });
}
</script>