<?php

use Carbon\Carbon;

if (! function_exists('toLocalTime')) {

    function toLocalTime(
        string $utcTime,
        string $format = 'H:i',
        ?string $timezone = null
    ): string {
        try {
            $timezone = $timezone ?? config('app.timezone');

            return Carbon::parse($utcTime)
                ->setTimezone($timezone)
                ->format($format);
        } catch (\Exception $e) {
            return '';
        }
    }
}

if (! function_exists('toUtcRange')) {

    function toUtcRange(
        string $date,
        string $position = 'start',
        ?string $timezone = null
    ): string {
        $timezone = $timezone ?? config('app.timezone');

        $carbon = Carbon::parse($date, $timezone);

        if ($position === 'start') {
            $carbon->startOfDay();
        } else {
            $carbon->endOfDay();
        }

        return $carbon->utc()->toIso8601String();
    }
}

if (! function_exists('resolvePeriodRange')) {

    function resolvePeriodRange(string $period): array
    {
        $now = now(); // config('app.timezone')

        switch ($period) {
            case '7d':
                return [
                    'start' => $now->copy()->subDays(7)->startOfDay(),
                    'end'   => $now->copy()->endOfDay()
                ];

            default:
                return [
                    'start' => $now->copy()->subHour(),
                    'end'   => $now
                ];
        }
    }
}

if (! function_exists('toUtcIso')) {

    function toUtcIso(Carbon $date): string
    {
        return $date->copy()
            ->setTimezone('UTC')
            ->toIso8601String();
    }
}

if (! function_exists('resolveFormatByPeriod')) {

    function resolveFormatByPeriod(string $period): string
    {
        return match ($period) {
            '7d' => 'd M',
            default => 'H:i',
        };
    }
}
