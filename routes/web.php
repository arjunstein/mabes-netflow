<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Services\DashboardService;

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/chart/export', [DashboardController::class, 'export'])->name('chart.export');

Route::prefix('api/v1')->group(function () {
    Route::get('cities', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getCitiesChart($period));
    });

    Route::get('countries', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getCountriesChart($period));
    });

    Route::get('destination-autonomous-bytes', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getDestinationAutonomousBytesChart($period));
    });

    Route::get('source-autonomous-bytes', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getSourceAutonomousBytesChart($period));
    });

    Route::get('destination-autonomous-packets', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getDestinationAutonomousPacketsChart($period));
    });

    Route::get('source-autonomous-packets', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getSourceAutonomousPacketsChart($period));
    });

    Route::get('destination-ip', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getDestinationIpChart($period));
    });

    Route::get('source-ip', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getSourceIpChart($period));
    });

    Route::get('destination-ports', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getDestinationPortsChart($period));
    });

    Route::get('source-ports', function (Request $request, DashboardService $service) {
        $period = $request->input('period', '1h');
        return response()->json($service->getSourcePortsChart($period));
    });
});
