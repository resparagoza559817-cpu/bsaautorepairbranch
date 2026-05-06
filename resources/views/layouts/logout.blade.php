<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">

    <div class="bg-[#232323] text-white w-[90%] max-w-md rounded-2xl shadow-xl p-6">
        
        <!-- Title -->
        <h2 class="text-xl font-semibold mb-2 text-[#00ffff]">
            Confirm Logout
        </h2>

        <!-- Message -->
        <p class="text-gray-300 mb-6">
            Are you sure you want to log out?
        </p>

        <!-- Buttons -->
        <div class="flex justify-end gap-3">
            
            <!-- Cancel -->
            <button onclick="closeLogoutModal()"
                class="px-4 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 transition">
                Cancel
            </button>

            <!-- Confirm Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-[#00ffff] text-black hover:bg-cyan-400 font-bold transition">
                    Logout
                </button>
            </form>

        </div>
    </div>
</div>

<!-- Script -->
<script>
    function openLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
        document.getElementById('logoutModal').classList.add('flex');
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
        document.getElementById('logoutModal').classList.remove('flex');
    }
</script>