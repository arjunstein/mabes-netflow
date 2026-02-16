<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ElasticService
{
    public function getCities()
    {
        $response = Http::get(config('services.elastic.cities_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getCountries()
    {
        $response = Http::get(config('services.elastic.countries_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getDestinationAutonomousBytes()
    {
        $response = Http::get(config('services.elastic.destination_autonomous_bytes_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getSourceAutonomousBytes()
    {
        $response = Http::get(config('services.elastic.source_autonomous_bytes_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getDestinationAutonomousPackets()
    {
        $response = Http::get(config('services.elastic.destination_autonomous_packets_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getSourceAutonomousPackets()
    {
        $response = Http::get(config('services.elastic.source_autonomous_packets_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getDestinationIp()
    {
        $response = Http::get(config('services.elastic.destination_ip_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getSourceIp()
    {
        $response = Http::get(config('services.elastic.source_ip_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getDestinationPorts()
    {
        $response = Http::get(config('services.elastic.destination_ports_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }

    public function getSourcePorts()
    {
        $response = Http::get(config('services.elastic.source_ports_endpoint'));

        if ($response->failed()) {
            return [];
        }

        return $response->json('data') ?? [];
    }
}
