<div class="flex h-screen">
    <aside class="w-64 flex flex-col" style="background-color: #232323">
        
        <img class="mt-5 mx-11" style="width: 160px; height: 85px;" src="{{ asset('images/HEAD-LOGO-LIGHT.png') }}" alt="Logo">

        <!-- Navigation text updated to Cyan via BSAPri variable -->
        <nav style="font-size: 20px;" class="text-BSAPri flex-grow text-center space-y-2 font-extrabold">
            <a href="{{ route('userdash') }}" class="mt-25 block py-2.5 px-4 rounded transition duration-200 hover:bg-cyan-900/30 hover:text-white bg-olive-50/0">
                Home
            </a>
            <a href="{{ route('usermygarage') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-cyan-900/30 hover:text-white">
                My Garage
            </a>

            <a href="{{ route('addcustomer') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-cyan-900/30 hover:text-white">
                Add Customer
            </a>
            
            <a href="{{ route('serviceshistory') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-cyan-900/30 hover:text-white">
                Records
            </a>

             <a href="{{ route('stockin') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-cyan-900/30 hover:text-white">
                Stock in
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800">
            <a href="#" onclick="openLogoutModal()" class="block py-2.5 px-4 rounded transition duration-200 text-gray-400 hover:bg-red-600 hover:text-white">
                Logout
            </a>
        </div>
    </aside>
</div>