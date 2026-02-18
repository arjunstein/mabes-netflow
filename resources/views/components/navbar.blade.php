<header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">

    <!-- Left -->
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <h2 class="text-lg font-semibold text-gray-700">
            Dashboard Overview
        </h2>
    </div>

    <!-- Right -->
    <div class="flex items-center gap-6">
        <!-- User -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">

                <img class="w-9 h-9 rounded-full object-cover border" src="https://i.pravatar.cc/100" alt="User Avatar">

                <div class="hidden md:block text-left">
                    <p class="text-sm font-medium">Admin</p>
                    <p class="text-xs text-gray-500">Network Engineer</p>
                </div>
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 text-sm z-50">

                <form>
                    @csrf
                    <button class="w-full flex items-center gap-2 px-4 py-2 hover:bg-gray-100 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Log Out
                    </button>
                </form>
            </div>
        </div>

    </div>
</header>
