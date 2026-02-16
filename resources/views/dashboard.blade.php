<x-app :title="$title">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-chart-card title="Cities" type="pie" :labels="$citiesChart['labels']" :series="$citiesChart['series']" />
        <x-chart-card title="Countries" type="donut" :labels="$countriesChart['labels']" :series="$countriesChart['series']" />
        <x-chart-card title="Destination Bytes" type="bar" :labels="$destinationAutonomousBytesChart['labels']" :series="$destinationAutonomousBytesChart['series']" />
        <x-chart-card title="Source Bytes" type="bar" :labels="$sourceAutonomousBytesChart['labels']" :series="$sourceAutonomousBytesChart['series']" />
        <x-chart-card title="Destination Packets" type="bar" :labels="$destinationAutonomousPacketsChart['labels']" :series="$destinationAutonomousPacketsChart['series']" />
        <x-chart-card title="Source Packets" type="bar" :labels="$sourceAutonomousPacketsChart['labels']" :series="$sourceAutonomousPacketsChart['series']" />
        <x-chart-card title="Destination IP" type="bar" :labels="$destinationIpChart['labels']" :series="$destinationIpChart['series']" />
        <x-chart-card title="Source IP" type="bar" :labels="$sourceIpChart['labels']" :series="$sourceIpChart['series']" />
        <x-chart-card title="Destination Ports" type="bar" :labels="$destinationPortsChart['labels']" :series="$destinationPortsChart['series']" />
        <x-chart-card title="Source Ports" type="bar" :labels="$sourcePortsChart['labels']" :series="$sourcePortsChart['series']" />
    </div>

</x-app>
