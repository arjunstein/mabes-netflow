@props([
    'title',
    'type' => 'pie',
    'labels' => [],
    'series' => []
])

<div
    x-data="chartComponent(
        {{ json_encode($type) }},
        {{ json_encode($labels) }},
        {{ json_encode($series) }}
    )"
    x-init="init()"
    class="bg-white rounded-xl shadow-sm p-5"
>
    <h3 class="text-sm font-semibold text-gray-700 mb-4">
        {{ $title }}
    </h3>

    <div x-ref="chart"></div>
</div>
