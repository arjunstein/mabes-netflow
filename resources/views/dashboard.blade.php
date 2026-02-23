<x-app :title="$title">

    <div class="grid grid-cols-1 gap-6">
        <x-chart-card title="Cities" type="line" :labels="$citiesChart['categories']" :series="$citiesChart['series']" />
        <x-chart-card title="Countries" type="line" :labels="$countriesChart['categories']" :series="$countriesChart['series']" />
        <x-chart-card title="Destination Bytes" type="line" :labels="$destinationAutonomousBytesChart['categories']" :series="$destinationAutonomousBytesChart['series']" />
        <x-chart-card title="Source Bytes" type="line" :labels="$sourceAutonomousBytesChart['categories']" :series="$sourceAutonomousBytesChart['series']" />
        <x-chart-card title="Destination Packets" type="line" :labels="$destinationAutonomousPacketsChart['categories']" :series="$destinationAutonomousPacketsChart['series']" />
        <x-chart-card title="Source Packets" type="line" :labels="$sourceAutonomousPacketsChart['categories']" :series="$sourceAutonomousPacketsChart['series']" />
        <x-chart-card title="Destination IP" type="line" :labels="$destinationIpChart['categories']" :series="$destinationIpChart['series']" />
        <x-chart-card title="Source IP" type="line" :labels="$sourceIpChart['categories']" :series="$sourceIpChart['series']" />
        <x-chart-card title="Destination Ports" type="line" :labels="$destinationPortsChart['categories']" :series="$destinationPortsChart['series']" />
        <x-chart-card title="Source Ports" type="line" :labels="$sourcePortsChart['categories']" :series="$sourcePortsChart['series']" />
    </div>

</x-app>
