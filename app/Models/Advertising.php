<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class Advertising extends Model {

    public static function get(&$data){
        if ($adv = self::inRandomOrder(5)->get()){
            $data['advs'] = $adv->toArray();
        }
    }

}
