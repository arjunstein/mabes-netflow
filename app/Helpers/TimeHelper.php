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
