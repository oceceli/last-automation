<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BaseExport implements ShouldAutoSize, WithStyles, WithProperties, Responsable
{
    use Exportable;

    protected $injectedQuery;


    public function toPdf($fileName = null)
    {
        return $this->download($fileName ?? $this->fileName . '.pdf', \Maatwebsite\Excel\Excel::MPDF);
    }

    public function toExcel($fileName = null)
    {
        return $this->download($fileName ?? $this->fileName . '.xlsx');
    }

    public function properties(): array
    {
        return [
            'creator'        => auth()->user()->name,
            'lastModifiedBy' => auth()->user()->name,
            'title' => method_exists($this, 'title') ? $this->title() : 'Belge',
        ];
    }


    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}