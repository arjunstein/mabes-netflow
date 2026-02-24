<?php

namespace App\Services;

use Carbon\Carbon;

class PeriodService
{
    protected string $timezone;

    public function __construct()
    {
        $this->timezone = config('app.timezone');
    }

    public function resolveRange(String $period): array
    {
        $now = Carbon::now($this->timezone);

        return match ($period) {
            '24h' => [
                'start' => $now->copy()->subDay(),
                'end'   => $now
            ],

            '7d' => [
                'start' => $now->copy()->subDays(6)->startOfDay(),
                'end'   => $now->copy()->subDay()->endOfDay()
            ],

            default => [
                'start' => $now->copy()->subHour(),
                'end'   => $now->subMinute()
            ],
        };
    }

    public function resolveFormat(string $period): string
    {
        return match ($period) {
            '24h' => 'H:i',
            '7d' => 'd-M',
            default => 'H:i',
        };
    }

    public function toUtcISO(Carbon $date): string
    {
        return $date->copy()
            ->setTimezone('UTC')
            ->toIso8601String();
    }
}
