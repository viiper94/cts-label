<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharedModel extends Model{

    public function getLatestSortId($class){
        $item = $class::select('sort_id')->orderBy('sort_id', 'desc')->first();
        if($item){
            $item->toArray();
            return $item['sort_id'];
        }
        return false;
    }

}
