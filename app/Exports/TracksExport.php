<?php

namespace App\Exports;

use App\Track;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TracksExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    WithColumnWidths{

    use Exportable;

    public function __construct(public $collection){}

    public function headings(): array
    {
        return [
            'Release(s)',
            'Artist(s)',
            'Title',
            'Mix',
            'ISRC'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 100,
            'B' => 40,
            'C' => 30,
            'D' => 35,
            'E' => 20
        ];
    }

    public function map($collection): array
    {
        return [
            Track::getReleasesPlainText($collection),
            $collection->artists,
            $collection->name,
            $collection->mix_name,
            $collection->isrc
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->collection;
    }

}
