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
        $cities = $this->elasticService->getCities();

        return [
            'labels' => collect($cities)->pluck('name')->toArray(),
            'series' => collect($cities)->pluck('total')->toArray(),
        ];
    }

    public function getCountriesChart(): array
    {
        $countries = $this->elasticService->getCountries();

        return [
            'labels' => collect($countries)->pluck('name')->toArray(),
            'series' => collect($countries)->pluck('total')->toArray(),
        ];
    }

    public function getDestinationAutonomousBytesChart(): array
    {
        $data = $this->elasticService->getDestinationAutonomousBytes();

        return [
            'labels' => collect($data)->pluck('name')->toArray(),
            'series' => collect($data)->pluck('total')->toArray(),
        ];
    }

    public function getSourceAutonomousBytesChart(): array
    {
        $data = $this->elasticService->getSourceAutonomousBytes();

        return [
            'labels' => collect($data)->pluck('name')->toArray(),
            'series' => collect($data)->pluck('total')->toArray(),
        ];
    }

    public function getDestinationAutonomousPacketsChart(): array
    {
        $data = $this->elasticService->getDestinationAutonomousPackets();

        return [
            'labels' => collect($data)->pluck('name')->toArray(),
            'series' => collect($data)->pluck('total')->toArray(),
        ];
    }

    public function getSourceAutonomousPacketsChart(): array
    {
        $data = $this->elasticService->getSourceAutonomousPackets();

        return [
            'labels' => collect($data)->pluck('name')->toArray(),
            'series' => collect($data)->pluck('total')->toArray(),
        ];
    }

    public function getDestinationIpChart(): array
    {
        $data = $this->elasticService->getDestinationIp();

        return [
            'labels' => collect($data)->pluck('name')->toArray(),
            'series' => collect($data)->pluck('total')->toArray(),
        ];
    }

    public function getSourceIpChart(): array
    {
        $data = $this->elasticService->getSourceIp();

        return [
            'labels' => collect($data)->pluck('name')->toArray(),
            'series' => collect($data)->pluck('total')->toArray(),
        ];
    }

    public function getDestinationPortsChart(): array
    {
        $data = $this->elasticService->getDestinationPorts();

        return [
            'labels' => collect($data)->pluck('name')->toArray(),
            'series' => collect($data)->pluck('total')->toArray(),
        ];
    }

    public function getSourcePortsChart(): array
    {
        $data = $this->elasticService->getSourcePorts();

        return [
            'labels' => collect($data)->pluck('name')->toArray(),
            'series' => collect($data)->pluck('total')->toArray(),
        ];
    }
}
