<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class News extends Model{

    public static function releases(){
        $release_list = News::where('category', 'releases')->get();
//        $release_list = News::where('id', '1091')->get();

        foreach($release_list as $item){

           /* $row = 'content_ru';
            $row = 'data';

            dump($item->title);
            dump($item->{$row});
            dd(!preg_match('/[°‹±ЃЎµ]/u', $item->{$row}) ?
                $item->{$row} : mb_convert_encoding($item->{$row}, 'Windows-1251'));*/

            $release = new Release();
            $release->id = $item->id;
            $release->sort_id = $item->sort_id;
            $release->title = !preg_match('/[°‹±ЃЎµ]/u', $item->title) ? $item->title : mb_convert_encoding($item->title, 'Windows-1251');
            $release->release_number = $item->title_ru;
            $release->release_date = date('Y-m-d', strtotime($item->description_ru));
            $release->beatport = $item->beatport;
            $release->youtube = $item->listen;
            $release->description_en = $item->content;
            $release->description_ru = !preg_match('/[°‹±ЃЎµ]/u', $item->data) ? $item->data : mb_convert_encoding($item->data, 'Windows-1251');
            $release->description_ua = !preg_match('/[°‹±ЃЎµ]/u', $item->data_ua) ? $item->data_ua : mb_convert_encoding($item->data_ua, 'Windows-1251');
            $release->tracklist = !preg_match('/[°‹±ЃЎµ]/u', $item->content_ru) ? $item->content_ru : mb_convert_encoding($item->content_ru, 'Windows-1251');
            $release->image = preg_replace('%\.\/\.\.\/images\/%', '', $item->picture);
            $release->created_at = $item->updated;
            $release->updated_at = $item->updated;

            try{
                $release->save();

            }catch (QueryException $e){
                dump($e);
            }
        }

        return 'Done!';
    }

    public static function artists(){
        $artist_list = News::where('category', 'artists')->get();

        foreach($artist_list as $item){
            $artist = new Artist();
            $artist->id = $item->id;
            $artist->sort_id = $item->sort_id;
            $artist->name = !preg_match('/[°‹±ЃЎµ]/u', $item->title) ? $item->title : mb_convert_encoding($item->title, 'Windows-1251');
            $artist->description = $item->content;
            $description_ru = preg_match('/(пїЅ)/u', $item->content_ru) ? '' : $item->content_ru;
            $artist->description_ru = !preg_match('/[°‹±ЃЎµ]/u', $description_ru) ? $description_ru : mb_convert_encoding($description_ru, 'Windows-1251');
            $artist->link = $item->description_ru;
            $artist->image = preg_replace('%\.\/\.\.\/images\/%', '', $item->picture);
            $artist->created_at = $item->updated;
            $artist->updated_at = $item->updated;

            $artist->save();
        }

        return 'Done!';
    }

    public static function feedback(){
        $new_list = Feebdack1::all();

        foreach($new_list as $item){
            $new = new Feedback();
            $new->id = $item->id;
            $new->sort_id = $item->sort_id;
            $new->release_id = $item->release_id;
            $new->feedback_title = $item->feedback_title;
            $new->archive_name = $item->archive_name;
            $new->tracks = $item->tracks;

            $new->save();
        }

        return 'Done!';
    }

}