<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\ElasticService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }
    public function index()
    {
        return view('dashboard', [
            'title' => 'Netflow Analytics Dashboard',
            'citiesChart' => $this->dashboardService->getCitiesChart(),
            'countriesChart' => $this->dashboardService->getCountriesChart(),
            'destinationAutonomousBytesChart' => $this->dashboardService->getDestinationAutonomousBytesChart(),
            'sourceAutonomousBytesChart' => $this->dashboardService->getSourceAutonomousBytesChart(),
            'destinationAutonomousPacketsChart' => $this->dashboardService->getDestinationAutonomousPacketsChart(),
            'sourceAutonomousPacketsChart' => $this->dashboardService->getSourceAutonomousPacketsChart(),
            'destinationIpChart' => $this->dashboardService->getDestinationIpChart(),
            'sourceIpChart' => $this->dashboardService->getSourceIpChart(),
            'destinationPortsChart' => $this->dashboardService->getDestinationPortsChart(),
            'sourcePortsChart' => $this->dashboardService->getSourcePortsChart(),
        ]);
    }
}
