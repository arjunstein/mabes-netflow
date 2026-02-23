<?php

namespace App\Services;

class DashboardService
{
    protected ElasticService $elasticService;

    public function __construct(ElasticService $elasticService)
    {
        $this->elasticService = $elasticService;
    }

    public function getCitiesChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getCities($start, $end),
            $period
        );
    }

    public function getCountriesChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getCountries($start, $end),
            $period
        );
    }

    public function getDestinationAutonomousBytesChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getDestinationAutonomousBytes($start, $end),
            $period
        );
    }

    public function getSourceAutonomousBytesChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getSourceAutonomousBytes($start, $end),
            $period
        );
    }

    public function getDestinationAutonomousPacketsChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getDestinationAutonomousPackets($start, $end),
            $period
        );
    }

    public function getSourceAutonomousPacketsChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getSourceAutonomousPackets($start, $end),
            $period
        );
    }

    public function getDestinationIpChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getDestinationIp($start, $end),
            $period
        );
    }

    public function getSourceIpChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getSourceIp($start, $end),
            $period
        );
    }

    public function getDestinationPortsChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getDestinationPorts($start, $end),
            $period
        );
    }

    public function getSourcePortsChart(string $period = '1h'): array
    {
        return $this->getChart(
            fn($start = null, $end = null) => $this->elasticService->getSourcePorts($start, $end),
            $period
        );
    }

    private function transformTimeSeriesToLine(array $response, string $period = '1h'): array
    {
        if (
            empty($response['legends']) ||
            empty($response['data'])
        ) {
            return [
                'categories' => [],
                'series' => []
            ];
        }

        $legends = $response['legends'];
        $timeSeries = $response['data'];

        $categories = [];
        $series = [];

        // Init series per legend
        foreach ($legends as $name) {
            $series[$name] = [];
        }

        foreach ($timeSeries as $row) {

            if ($period === '7d') {
                $categories[] = toLocalTime($row['time'], 'Y-m-d');
            } else {
                $categories[] = toLocalTime($row['time'], 'H:i');
            }

            foreach ($legends as $name) {
                $value = collect($row['dimensions'] ?? [])
                    ->firstWhere('key', $name)['value'] ?? 0;

                $series[$name][] = $value;
            }
        }

        $formattedSeries = [];

        foreach ($series as $name => $values) {
            $formattedSeries[] = [
                'name' => $name,
                'data' => $values
            ];
        }

        return [
            'categories' => $categories,
            'series' => $formattedSeries,
        ];
    }

    private function getChart(callable $callback, string $period = '1h'): array
    {
        if ($period === '7d') {

            $range = resolvePeriodRange('7d');

            $start = $range['start']->toDateString();
            $end   = $range['end']->subDay()->toDateString();

            $response = $callback($start, $end);
        } else {
            $response = $callback();
        }

        return $this->transformTimeSeriesToLine($response, $period);
    }
}
