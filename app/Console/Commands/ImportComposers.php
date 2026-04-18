<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\ComposersImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportComposers extends Command
{
    protected $signature = 'import:composers';
    protected $description = 'Import composers from xlsx into tracks table';

    public function handle()
    {
        $import = new ComposersImport();
        Excel::import($import, public_path('compiled_composers.xlsx'));

        $notFound = $import->notFound;
        $this->info("Done. Not matched: " . count($notFound));

        foreach ($notFound as $title) {
            $this->warn("  - $title");
        }

        return 0;
    }
}