<x-app :title="$title">

    <div class="grid grid-cols-1 gap-6">
        <x-chart-card title="Cities" type="line" :labels="$citiesChart['categories']" :series="$citiesChart['series']" endpoint="/api/v1/cities" />
        <x-chart-card title="Countries" type="line" :labels="$countriesChart['categories']" :series="$countriesChart['series']" endpoint="/api/v1/countries" />
        <x-chart-card title="Destination Bytes" type="line" :labels="$destinationAutonomousBytesChart['categories']" :series="$destinationAutonomousBytesChart['series']" endpoint="/api/v1/destination-autonomous-bytes" />
        <x-chart-card title="Source Bytes" type="line" :labels="$sourceAutonomousBytesChart['categories']" :series="$sourceAutonomousBytesChart['series']" endpoint="/api/v1/source-autonomous-bytes" />
        <x-chart-card title="Destination Packets" type="line" :labels="$destinationAutonomousPacketsChart['categories']" :series="$destinationAutonomousPacketsChart['series']" endpoint="/api/v1/destination-autonomous-packets" />
        <x-chart-card title="Source Packets" type="line" :labels="$sourceAutonomousPacketsChart['categories']" :series="$sourceAutonomousPacketsChart['series']" endpoint="/api/v1/source-autonomous-packets" />
        <x-chart-card title="Destination IP" type="line" :labels="$destinationIpChart['categories']" :series="$destinationIpChart['series']" endpoint="/api/v1/destination-ip" />
        <x-chart-card title="Source IP" type="line" :labels="$sourceIpChart['categories']" :series="$sourceIpChart['series']" endpoint="/api/v1/source-ip" />
        <x-chart-card title="Destination Ports" type="line" :labels="$destinationPortsChart['categories']" :series="$destinationPortsChart['series']" endpoint="/api/v1/destination-ports" />
        <x-chart-card title="Source Ports" type="line" :labels="$sourcePortsChart['categories']" :series="$sourcePortsChart['series']" endpoint="/api/v1/destination-autonomous-bytes" />
    </div>

</x-app>
