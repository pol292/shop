<?php

namespace App\Http\Controllers\Dashboard\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseDashboardController;
use App\Models\Shop\Order;
use Session;

class ManageOrderController extends BaseDashboardController {

    public function __construct( Request $request ) {
        parent::__construct( $request );
        self::$data[ 'page' ] = 'Order Manager';
    }

    public function showOrders() {
        Order::getOrders( self::$data );
        return view( 'dashboard.shop.order.view', self::$data );
    }

    public function viewOrder( $orderId ) {
        Order::getOrderByOrderId( $orderId, self::$data );
        if ( empty( self::$data[ 'order' ] ) ) {
            return redirect( 'user/order-history' );
        }
        return view( 'dashboard.shop.order.items', self::$data );
    }

}
