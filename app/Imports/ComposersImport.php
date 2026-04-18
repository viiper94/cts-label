<?php

namespace App\Imports;

use App\Track;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ComposersImport implements ToModel, WithHeadingRow
{
    public array $notFound = [];

    public function model(array $row)
    {
        $title = $row['track'] ?? null;
        $composers = $row['composers'] ?? null;

        if (!$title || !$composers) return null;

        $composers = str_replace(' | ', ', ', $composers);

        $tracks = $this->findTracks($title);

        if ($tracks->isEmpty()) {
            $this->notFound[] = $title;
            return null;
        }

        $tracks->each->update(['composer' => $composers]);

        return null;
    }

    private function findTracks(string $excelTitle): Collection
    {
        // 1. Exact match (case-insensitive)
        $tracks = Track::whereRaw('LOWER(name) = ?', [strtolower($excelTitle)])->get();
        if ($tracks->isNotEmpty()) return $tracks;

        // 2. Strip parentheses suffix — "TITLE (ORIGINAL MIX)" → "TITLE"
        $stripped = trim(preg_replace('/\s*\(.*?\)\s*$/', '', $excelTitle));
        if ($stripped !== $excelTitle) {
            $tracks = Track::whereRaw('LOWER(name) = ?', [strtolower($stripped)])->get();
            if ($tracks->isNotEmpty()) return $tracks;
        }

        // 3. DB title contained anywhere in the excel title (case-insensitive)
        $tracks = Track::whereRaw('LOWER(?) LIKE CONCAT("%", LOWER(name), "%")', [$excelTitle])->get();
        if ($tracks->isNotEmpty()) return $tracks;

        return collect();
    }
}