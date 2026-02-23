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

            // Header
            $header = ['Time'];

            foreach ($series as $item) {
                $header[] = $item['name'];
            }

            fputcsv($handle, $header);

            // Rows
            foreach ($labels as $index => $label) {

                $row = [$label];

                foreach ($series as $item) {
                    $row[] = $item['data'][$index] ?? 0;
                }

                fputcsv($handle, $row);
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
