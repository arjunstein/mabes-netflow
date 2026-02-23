@props(['title', 'type' => 'pie', 'labels' => [], 'series' => []])

<div x-data="chartComponent(
    {{ json_encode($type) }},
    {{ json_encode($labels) }},
    {{ json_encode($series) }}
)" x-init="title = '{{ $title }}'; init()" class="bg-white rounded-xl shadow-sm p-5 relative">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-semibold text-gray-700">
            {{ $title }}
        </h3>

        <!-- Download Button -->
        <div class="relative" x-data="{ open: false }" x-cloak x-transition.origin.top.right>
            <button @click="open = !open" class="p-2 rounded hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </button>

            <div x-show="open" @click.outside="open = false"
                class="absolute right-0 mt-2 w-32 bg-white border-0 shadow-md z-10">
                <button @click="downloadCSV(); open=false" disabled
                    class="block w-full text-left text-xs px-4 py-2 hover:bg-gray-50 cursor-pointer">
                    Download CSV
                </button>
                <button @click="downloadPNG(); open=false"
                    class="block w-full text-left text-xs px-4 py-2 hover:bg-gray-50 cursor-pointer">
                    Download PNG
                </button>
            </div>
        </div>
    </div>

    <div x-ref="chart"></div>
</div>
