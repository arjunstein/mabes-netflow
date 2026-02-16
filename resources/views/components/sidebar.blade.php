<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed z-30 inset-y-0 left-0 w-64 bg-white shadow-lg transform lg:translate-x-0 transition duration-200 ease-in-out">

    <!-- Logo -->
    <div class="h-16 flex items-center justify-center">
        <h1 class="text-xl font-bold text-indigo-600 tracking-wide">
            NETFLOW
        </h1>
    </div>

    <nav class="mt-6 px-4 space-y-2">

        <!-- Dashboard -->
        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg bg-indigo-50 text-indigo-600 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
        </a>
    </nav>
</aside>
