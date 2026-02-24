<?php

namespace App\Services;

class DashboardService
{
    protected ElasticService $elasticService;
    protected PeriodService $periodService;

    public function __construct(ElasticService $elasticService, PeriodService $periodService)
    {
        $this->elasticService = $elasticService;
        $this->periodService = $periodService;
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

        $format = $this->periodService->resolveFormat($period);
        foreach ($timeSeries as $row) {

            $categories[] = toLocalTime($row['time'], $format);

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
        $range = $this->periodService->resolveRange($period);

        if (in_array($period, ['7d', '24h'])) {

            $start = $range['start']->toDateString();
            $end   = $range['end']->toDateString();

            $response = $callback($start, $end);
        } else {
            $response = $callback();
        }

        return $this->transformTimeSeriesToLine($response, $period);
    }
}
