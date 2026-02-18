<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\StreamedResponse;

class ChartExportService
{
    public function exportCSV(string $title, array $labels, array $series): StreamedResponse
    {
        $filename = str()->slug($title) . '.csv';

        return response()->streamDownload(function () use ($labels, $series) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Label', 'Value']);

            foreach ($labels as $index => $label) {
                fputcsv($handle, [
                    $label,
                    $series[$index] ?? 0
                ]);
            }

            fclose($handle);
        }, $filename);
    }

    public function exportPNG(string $title, string $base64Image)
    {
        $filename = str()->slug($title) . '.png';

        $image = str_replace('data:image/png;base64,', '', $base64Image);
        $image = str_replace(' ', '+', $image);

        return response(base64_decode($image))
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
