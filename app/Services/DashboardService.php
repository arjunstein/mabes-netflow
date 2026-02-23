<?php

namespace App\Services;

class DashboardService
{
    protected ElasticService $elasticService;

    public function __construct(ElasticService $elasticService)
    {
        $this->elasticService = $elasticService;
    }

    public function getCitiesChart(): array
    {
        $response = $this->elasticService->getCities();
        return $this->transformTimeSeriesToLine($response);
    }

    public function getCountriesChart(): array
    {
        $response = $this->elasticService->getCountries();
        return $this->transformTimeSeriesToLine($response);
    }

    public function getDestinationAutonomousBytesChart(): array
    {
        $response = $this->elasticService->getDestinationAutonomousBytes();

        return $this->transformTimeSeriesToLine($response);
    }

    public function getSourceAutonomousBytesChart(): array
    {
        $response = $this->elasticService->getSourceAutonomousBytes();

        return $this->transformTimeSeriesToLine($response);
    }

    public function getDestinationAutonomousPacketsChart(): array
    {
        $response = $this->elasticService->getDestinationAutonomousPackets();

        return $this->transformTimeSeriesToLine($response);
    }

    public function getSourceAutonomousPacketsChart(): array
    {
        $response = $this->elasticService->getSourceAutonomousPackets();

        return $this->transformTimeSeriesToLine($response);
    }

    public function getDestinationIpChart(): array
    {
        $response = $this->elasticService->getDestinationIp();

        return $this->transformTimeSeriesToLine($response);
    }

    public function getSourceIpChart(): array
    {
        $response = $this->elasticService->getSourceIp();

        return $this->transformTimeSeriesToLine($response);
    }

    public function getDestinationPortsChart(): array
    {
        $response = $this->elasticService->getDestinationPorts();

        return $this->transformTimeSeriesToLine($response);
    }

    public function getSourcePortsChart(): array
    {
        $response = $this->elasticService->getSourcePorts();

        return $this->transformTimeSeriesToLine($response);
    }

    private function transformTimeSeriesToLine(array $response): array
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

            // Format time HH:mm
            $categories[] = toLocalTime($row['time']);

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
}
