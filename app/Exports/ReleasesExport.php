<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Track;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReleasesExport implements 
    FromCollection,
    WithMapping,
    WithColumnWidths,
    WithColumnFormatting,
    // ShouldAutoSize,
    WithHeadings
    {

    use Exportable;

    public $metadata;

    public function __construct(public $collection){}

    public function collection(){

        $metadata = array();
        foreach($this->collection as $release){
            $i = 1;
            foreach($release->tracks as $track){
                $array = $track->toArray();
                $array['order'] = $i;
                $array['release'] = $release->toArray();
                $array['first_release'] = $track->releases[0]->release_date;

                $metadata[] = $array;
                $i++;
            }
        }
        // dd(collect($metadata));
        return $this->metadata = collect($metadata);
    }

    public function columnFormats(): array{
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function headings(): array
    {
        return [
            'Album title',
            'Album version',
            'Album display artist',
            'UPC',
            'Catalog number',
            'Primary artists',
            'Featuring Artists',
            'Release date',
            'Original release date',
            'Main genre',
            'Main subgenre',
            'Alternate genre',
            'Alternate subgenre',
            'Label',
            'CLine year',
            'CLine name',
            'PLine year',
            'Pline name',
            'Parental advisory',
            'Recording year',
            'Recording location',
            'Album format',
            'Number of volumes',
            'Territories',
            'Excluded territories',
            'Language(Metadata)',
            'Catalog Tier',

            'Track title',
            'Track version(OR Version title)',
            'ISRC',
            'Track primary artists',
            'Track featuring Artists',
            'Track display artist',
            'Volume number',
            'Track Main genre',
            'Track Main subgenre',
            'Track alternate genre',
            'Track alternate subgenre',
            'Track Language (Metadata)',
            'Audio Language',
            'Lyrics',
            'Available separately',
            'Track Parental advisory',
            'Preview start',
            'Preview length',
            'Track recording year',
            'Track recording location',
            'Composer',
            'Lyricist',
            'Mastering Engineer',
            'Producer',
            'Programmer',
            'Remixer',
            'Vocals', 
            'Writer',
            'Publisher',
            'Track Sequence',
            'Track Catalog Tier',
            'Original file name',
        ];
    }

    public function columnWidths(): array{
        return [
            'C' => 20
        ];
    }

    public function map($metadata): array{
        return [
            $this->getAlbumTitle($metadata['release']['title']),                                            // Album title
            '',                                                                                             // Album version
            $metadata['release']['main_artists'],                                                           // Album display artist
            $metadata['release']['upc'],                                                                    // UPC
            $metadata['release']['release_number'],                                                         // Catalog number
            $this->getPrimaryArtists($metadata['release']['main_artists']),                                 // Primary artists
            $this->getFeaturingArtists($metadata['release']['title']),                                      // Featuring Artists
            $metadata['release']['non_exclusive_release_date'] ? 
                Carbon::parse($metadata['release']['non_exclusive_release_date'])->format('Y-m-d') : '',    // Release date
            $metadata['release']['non_exclusive_release_date'] ? 
                Carbon::parse($metadata['release']['non_exclusive_release_date'])->format('Y-m-d') : '',    // Original release date                                                                                
            'Dance',                                                                                        // Main genre                  
            $this->getSubGenre($metadata['release']['genre']),                                              // Main subgenre
            '',                                                                                             // Alternate genre
            '',                                                                                             // Alternate subgenre
            'CTS Records',                                                                                  // Label
            $metadata['release']['release_date'] ? 
                Carbon::parse($metadata['release']['release_date'])->format('Y') : '',                      // CLine year
            'CTS Records',                                                                                  // CLine name
            $metadata['release']['release_date'] ?                                                          
                Carbon::parse($metadata['release']['release_date'])->format('Y') : '',                      // Pline year
            'CTS Records',                                                                                  // Pline name
            'No',                                                                                           // Parental advisory
            $this->getAlbumFormat($metadata['release']),                                                    // Album format
            '1',                                                                                            // Number of volumes                     
            'World',                                                                                        // Territories
            'RU',                                                                                           // Excluded territories
            'EN',                                                                                           // Language(Metadata)
            'Front',                                                                                        // Catalog Tier

            $metadata['name'],                                                                              // Track title
        $metadata['mix_name'],                                                                              // Track version(OR Version title)
            $this->getISRCWithNoDashes($metadata['isrc']),                                                  // ISRC
            $this->getPrimaryArtists($metadata['artists']),                                                 // Track primary artists
            $this->getFeaturingArtists($metadata['artists']),                                               // Track featuring Artists
            $metadata['artists'],                                                                           // Track display artist
            '1',                                                                                            // Volume number
            'Dance',                                                                                        // Track Main genre
            $this->getSubGenre($metadata['genre']),                                                         // Track Main subgenre
            '',                                                                                             // Track alternate genre
            '',                                                                                             // Track alternate subgenre
            'EN',                                                                                           // Track Language (Metadata)
            'ZXX',                                                                                          // Audio Language
            '',                                                                                             // Lyrics
            'Y',                                                                                            // Available separately
            'N',                                                                                            // Track Parental advisory
            '',                                                                                             // Preview start
            '',                                                                                             // Preview length
            '',                                                                                             // Track recording year
            '',                                                                                             // Track recording location
            str_replace(' ,', ' | ', $metadata['composer']),                                                // Composer
            '',                                                                                             // Lyricist
            '',                                                                                             // Mastering Engineer
            '',                                                                                             // Producer
            '',                                                                                             // Programmer
            implode(' | ', (array) $metadata['remixers']),                                                  // Remixer
            '',                                                                                             // Vocals
            str_replace(' ,', ' | ', $metadata['composer']),                                                // Writer
            'Atal Music',                                                                                   // Publisher
            $metadata['order'],                                                                             // Track Sequence
            'Front',                                                                                        // Track Catalog Tier
            '',                                                                                             // Original file name
        ];
    }

    private function getAlbumTitle($title){
        // if title contains " - " and the part before it is not empty, return the part after it, otherwise return the whole title
        if(str_contains($title, ' - ')){
            $parts = explode(' - ', $title);
            if(!empty($parts[0])){
                return $parts[1];
            }
        }
        return $title;
    }

    private function getPrimaryArtists($title){
        // if main artists contains comma separated values, replace comma with | and return the result, otherwise return the whole main artists
        $title = explode(' feat. ', $title)[0];
        $title = str_replace(' & ', ' | ', $title);
        $title = str_replace(', ', ' | ', $title);
        return $title;
    }

    private function getFeaturingArtists($string){
        // if title contains "feat." and the part after it is not empty, return the part after "feat." and before " - ", otherwise return empty string  
        if(str_contains($string, 'feat.')){
            $parts = explode('feat.', $string);
            if(!empty($parts[1])){
                $featuring = explode(' - ', $parts[1])[0];
                return trim($featuring);
            }
        }
        return '';
    }

    private function getSubGenre($genre){
        // trim values in "()" and trim text after " / " if it exists, otherwise return the whole genre
        //  	Techno (Peak Time / Driving) => Techno
        if(str_contains($genre, ' (')){
            $parts = explode(' (', $genre);
            return trim($parts[0]);
        }
        if(str_contains($genre, ' / ')){
            $parts = explode(' / ', $genre);
            return trim($parts[0]);
        }
        if(str_contains($genre, ',')){
            $parts = explode(',', $genre);
            return trim($parts[0]);
        }
        return $genre;
    }

    private function getAlbumFormat($release){
        // // if title contains "EP" return "EP"
        // if(str_contains($release['title'], ' EP')){
        //     return 'EP';
        // }
        // // if release has more than 5 track, return "Album", 3-4 tracks - EP, otherwise return "Single"
        // $tracks_count = count($release['tracks']);
        // if($tracks_count > 5){
        //     return 'Album';
        // }elseif($tracks_count >= 3){
        //     return 'EP';
        // }else{
        //     return 'Single';
        // }


        $tracks = $release['tracks'] ?? [];

        $trackCount = count($tracks);

        // convert all durations once
        $durations = array_map(function ($track) {
            return (int) Track::minutesToMilliseconds($track['length']);
        }, $tracks);

        $totalDurationMs = array_sum($durations);

        // thresholds
        $tenMinutesMs = 10 * 60 * 1000;
        $thirtyMinutesMs = 30 * 60 * 1000;

        $hasLongTrack = collect($durations)->contains(fn($d) => $d >= $tenMinutesMs);

        // Album
        if ($trackCount >= 7 || $totalDurationMs > $thirtyMinutesMs) {
            return 'Album';
        }

        // EP
        if (
            ($trackCount >= 4 && $trackCount <= 6 && $totalDurationMs < $thirtyMinutesMs) ||
            ($trackCount >= 1 && $trackCount <= 3 && $hasLongTrack)
        ) {
            return 'EP';
        }

        // Single
        if ($trackCount >= 1 && $trackCount <= 3 && !$hasLongTrack) {
            return 'Single';
        }

        return '';
    }

    private function getYearFromDate($string){
        // parse plain string date and return year, if it fails, return empty string
        return Carbon::parse($string)->format('Y');
    }

    private function getISRCWithNoDashes($isrc) : string {
        return str_replace('-', '', $isrc);
    }

}
