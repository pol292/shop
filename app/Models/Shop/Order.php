<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use App\Models\Shop\Product;
use Session,
    Cart;

class Order extends Model {

    public function user() {
        return $this->hasOne( 'App\Models\User', 'id', 'user_id' );
    }

    public static function checkout( &$cart ) {
        $user = Session::get( 'user' )[ 'id' ];
        if ( !empty( $user ) ) {
            Product::removeQty( $cart );
            $order          = new self;
            $order->user_id = $user;
            $order->orders  = serialize( $cart );
            $order->total   = $cart[ 'price' ];
            $order->save();
        }
    }

    public static function checkoutCart( &$redirect ) {
        $user = Session::get( 'user' )[ 'id' ];
        $cart = Cart::content();
        if ( !empty( $user ) && !empty( $cart ) ) {
            $cart = $cart->toArray();
            foreach ( $cart as $item ) {
                Product::removeQty( $item );
            }
            $order          = new self;
            $order->user_id = $user;
            $order->orders  = serialize( $cart );
            $order->total   = Cart::total();
            $order->save();
            Cart::destroy();
            $redirect       = 'user/order-history';
        } else {
            $redirect = '/';
        }
    }

    public static function getOrderById( $id, &$data ) {
        if ( $orders = self::where( 'user_id', $id )->get() ) {
            $data[ 'orders' ] = $orders->toArray();
            foreach ( $data[ 'orders' ] as $key => $order ) {
                $data[ 'orders' ][ $key ][ 'orders' ] = unserialize( $order[ 'orders' ] );
                $data[ 'orders' ][ $key ][ 'count' ]  = count( $data[ 'orders' ][ $key ][ 'orders' ] );
            }
        }
    }

    public static function getOrderByOrderId( $id, &$data ) {
        if ( $orders = self::find( $id ) ) {
            $data[ 'order' ]             = $orders->toArray();
            $data[ 'order' ][ 'orders' ] = unserialize( $data[ 'order' ][ 'orders' ] );
            $data[ 'order' ][ 'count' ]  = count( $data[ 'order' ][ 'orders' ] );
            if ( !empty( $data[ 'order' ][ 'orders' ][ 'id' ] ) ) {
                $temp                          = $data[ 'order' ][ 'orders' ];
                unset( $data[ 'order' ][ 'orders' ] );
                $data[ 'order' ][ 'orders' ][] = $temp;
            }
        }
    }

}
