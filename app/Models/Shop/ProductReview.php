<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;

class ProductReview extends Model {

    public function user() {
        return $this->hasOne( 'App\Models\User', 'id', 'user_id' );
    }

    public static function addRate( &$request ) {
        $rate = new self;
        $rate->user_id = $request['user_id'];
        $rate->product_id = $request['product_id'];
        $rate->rate = $request['score'];
        $rate->review = $request['review']?$request['review']:'';
        $rate->save();
    }

}
