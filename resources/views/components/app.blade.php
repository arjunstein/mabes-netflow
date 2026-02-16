<!DOCTYPE html>
<html lang="en">

<head>
    <x-head :title=$title />
</head>

<body>

    <div x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false"
        class="min-h-screen flex bg-gray-100 text-gray-800">

        <!-- ===== Overlay (Mobile Only) ===== -->
        <div x-show="sidebarOpen" x-transition.opacity.duration.300ms @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/30 backdrop-blur-sm z-30 lg:hidden"></div>

        <!-- Sidebar -->
        <x-sidebar />


        <!-- Main -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <x-navbar />

            <main class="p-6 space-y-6">
                {{ $slot }}
            </main>
        </div>

    </div>

</body>

</html>
