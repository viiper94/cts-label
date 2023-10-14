<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmailingChannelExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    WithColumnWidths{

    use Exportable;

    public function __construct(public $collection){}

    public function headings(): array
    {
        return [
            'Name',
            'E-Mail',
            'Full Name',
            'Country',
            'Company',
            'Company',
            'Position',
            'Phone',
            'Website',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 15,
            'D' => 10,
            'E' => 35,
            'F' => 35,
            'G' => 35,
            'H' => 20,
            'I' => 20,
        ];
    }

    public function map($collection): array
    {
        return [
            $collection->name,
            $collection->email,
            $collection->full_name,
            $collection->country,
            $collection->company,
            $collection->company_foa,
            $collection->position,
            $collection->phone,
            $collection->website,
        ];
    }

    public function collection(){
        return $this->collection;
    }

}
