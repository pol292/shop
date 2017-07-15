<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use Session;

class Product extends Model {

    public function sale() {
        return $this->hasOne( 'App\Models\Shop\Sale' );
    }

}
