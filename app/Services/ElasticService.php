<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ElasticService
{
    public function getCities(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.cities_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getCountries(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.countries_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getDestinationAutonomousBytes(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.destination_autonomous_bytes_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getSourceAutonomousBytes(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.source_autonomous_bytes_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getDestinationAutonomousPackets(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.destination_autonomous_packets_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getSourceAutonomousPackets(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.source_autonomous_packets_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getDestinationIp(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.destination_ip_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getSourceIp(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.source_ip_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getDestinationPorts(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.destination_ports_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getSourcePorts(?string $startDate = null, ?string $endDate = null)
    {
        $url = config('services.elastic.source_ports_endpoint');

        if ($startDate && $endDate) {
            $url .= "?start_date={$startDate}&end_date={$endDate}";
        }

        $response = Http::get($url);

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }
}
