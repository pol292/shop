<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use Session;

class Sale extends Model {

    public static function getMaxDiscount(&$max){
        $max = self::max('discount');
    }
    
}
