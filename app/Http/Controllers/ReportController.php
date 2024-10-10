<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response as FacadesResponse;

class ReportController extends Controller
{
    public static function downloadCSV($fileName, $headers, $data){
        $file = fopen('php://memory', 'w');

        if (!empty($data)) {
            fputcsv($file, $headers);
        }

        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fseek($file, 0);

        return FacadesResponse::stream(function () use ($file) {
            fpassthru($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
