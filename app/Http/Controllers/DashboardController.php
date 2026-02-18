<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\ChartExportService;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    protected $dashboardService;
    protected $chartExportService;

    public function __construct(DashboardService $dashboardService, ChartExportService $chartExportService)
    {
        $this->dashboardService = $dashboardService;
        $this->chartExportService = $chartExportService;
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

    public function export(Request $request)
    {
        $request->validate([
            'type' => 'required|in:csv,png',
            'title' => 'required|string',
        ]);

        if ($request->type === 'csv') {
            return $this->chartExportService->exportCSV(
                $request->title,
                $request->labels ?? [],
                $request->series ?? []
            );
        }

        if ($request->type === 'png') {
            return $this->chartExportService->exportPNG(
                $request->title,
                $request->image
            );
        }

        abort(400);
    }
}
