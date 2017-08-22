<?php

namespace App\Models\Shop;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backup;
use App\Models\Shop\Categorie;
use Session,
    Cart;

class Product extends Model {

    public function rates() {
        return $this->hasMany( 'App\Models\Shop\ProductReview', 'product_id', 'id' )->with( 'user' );
    }


    public static function addProduct( &$request ) {
        DB::beginTransaction();
        try {

            $product = new self;

            $product[ 'categorie_id' ] = $request->category;
            $product[ 'title' ]        = $request[ 'title' ];
            $product[ 'article' ]      = $request[ 'article' ] ? $request[ 'article' ] : '';
            $product[ 'url' ]          = $request[ 'url' ];

            if ( empty( $request[ 'image' ] ) ) {
                $product[ 'image' ]  = $product[ 'images' ] = '';
            } else {
                $product[ 'image' ]  = $request[ 'image' ];
                $product[ 'images' ] = serialize( json_decode( $request[ 'images' ] ) );
            }

            $product[ 'price' ] = $request[ 'price' ];
            $product[ 'sale' ]  = $request[ 'sale' ];
            $product[ 'stock' ] = $request[ 'stock' ];

            $product->save();
//            $backup = [
//                'pages' => [ 'id' => $page[ 'id' ] ],
//            ];
            DB::commit();
//            Backup::set( 'create', 'page', "Create page: {$category[ 'title' ]}", $backup, 'plus' );
            Session::flash( 'sm', "You are update successfull (  {$request[ 'title' ]} ) product." );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t update product now please try after' );
            Session::flash( 'wm', $e->getMessage() );
        }
    }

    public static function getProduct( &$product, &$data ) {
        $data[ 'user_id' ] = Session::get( 'user' );
        if ( !empty( $data[ 'user_id' ][ 'id' ] ) ) {
            $data[ 'user_id' ] = $data[ 'user_id' ][ 'id' ];
        }
        $product = self::where( 'url', $product )->with( 'rates' );
        $product = $product->first();
        if ( $product ) {
            $data[ 'product' ]             = $product->toArray();
            $data[ 'product' ][ 'images' ] = unserialize( $data[ 'product' ][ 'images' ] );
            self::getProductInCart( $data[ 'product' ][ 'id' ], $data[ 'cart' ] );
            $cat                           = Categorie::find( $data[ 'product' ][ 'categorie_id' ] );
            if ( $cat ) {
                $cat                    = $cat->toArray();
                $data[ 'breadcrumb' ][] = [ 'title' => $cat[ 'title' ], 'url' => url( "shop/{$cat[ 'url' ]}" ) ];
            }
            $data[ 'breadcrumb' ][ 'active' ] = $data[ 'product' ][ 'title' ];
        }
    }

    public function category() {
        return $this->hasOne( 'App\Models\Shop\Categorie', 'id', 'categorie_id' );
    }

    public static function getProductList( &$products ) {
        if ( $products = Product::select( 'title' )->get() ) {
            $products = $products->toArray();
            foreach ( $products as $key => $p ) {
                $products[ $key ] = $p[ 'title' ];
            }
        }
    }

    public static function getSearch( &$request, &$data, &$product ) {
        $find = $request[ 'find' ];


        $product       = Product::where( 'title', 'LIKE', "%$find%" )
                ->orWhere( 'article', 'LIKE', "%$find%" );
        $data[ 'cat' ] = [
            'title'   => "Search for $find",
            'article' => "We are found for you {$product->count()} products.",
            'url'     => 'sale',
        ];
    }

    public static function getSale( &$request, &$data, &$product ) {
        $product = Product::where( 'sale', '>', '0' )
                ->with( 'rates' );

        $data[ 'cat' ] = [
            'title'   => 'Sale',
            'article' => 'Sale Sale Sale',
            'url'     => 'sale',
        ];
    }

    public static function getNewProducts( &$data ) {
        $new = self::orderBy( 'created_at', 'DESC' )
                ->where( 'stock', '>', '0' )
                ->limit( 5 )
                ->with( 'category' )
                ->with( 'rates' )
                ->get();
        
        if ( $new ) {
            $data[ 'new_product' ] = $new->toArray();
        }
    }

    public static function getIndexProducts( &$data ) {
        $data[ 'max_discount' ] = self::max( 'sale' );

        self::getNewProducts( $data );

        $sale = self::where( 'sale', '>', '0' )
                ->inRandomOrder()
                ->limit( 4 )
                ->with( 'category' )
                ->with( 'rates' )
                ->get();
        if ( $sale ) {
            $data[ 'sale_product' ] = $sale->toArray();
        }
        self::randomItems( $data );
    }

    public static function randomItems( &$data ) {
        $randomList = self::inRandomOrder()
                ->limit( 8 )
                ->with( 'category' )
                ->with( 'rates' )
                ->get();
        if ( $randomList ) {
            $data[ 'random_list_product' ] = $randomList->toArray();
        }
    }

    public static function getProducts( &$request, &$data ) {
        $data[ 'pagination' ][ 'url' ] = url( "dashboard/shop/product?page=" );

        $limit                            = 5;
        $data[ 'pagination' ][ 'active' ] = !empty( $request[ 'page' ] ) ? $request[ 'page' ] : 1;
        $page                             = $data[ 'pagination' ][ 'active' ] - 1;
        $offset                           = $limit * $page;

        if ( empty( $request[ 'find' ] ) ) {
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( self::count() / $limit );
            $data[ 'products' ]              = self::offset( $offset )->limit( $limit )->get()->toArray();
        } else {
            $data[ 'products' ]              = self::where( 'title', 'LIKE', "%{$request[ 'find' ]}%" );
            $data[ 'pagination' ][ 'count' ] = ( int ) ceil( $data[ 'products' ]->count() / $limit );
            $data[ 'products' ]              = $data[ 'products' ]->offset( $offset )->limit( $limit )->get()->toArray();
        }
    }

    public static function getCxontentsById( &$id, &$data ) {
        if ( $product = self::find( $id ) ) {
            $data[ 'product' ]             = $product->toArray();
            $data[ 'product' ][ 'images' ] = unserialize( $data[ 'product' ][ 'images' ] );

            $images   = [];
            $meny_img = old( 'images' ) ? json_decode( old( 'images' ) ) : $data[ 'product' ][ 'images' ];
            self::imageForDropZone( $meny_img, $images );

            $data[ 'images_json' ] = json_encode( $images );
        }
    }

    public static function getImagesAndCat( &$data ) {
        $files  = \File::allFiles( public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'up' );
        $images = [];
        foreach ( $files as $file ) {
            $images[] = $file->getFilename();
        }
        $data[ 'uploaded_images' ] = &$images;
        $cat                       = Categorie::orderBy( 'title' )->get();
        if ( $cat ) {
            $data[ 'cats' ] = $cat->toArray();
        }
    }

    public static function updateProduct( &$request ) {
        DB::beginTransaction();
        try {

            $product = self::find( $request[ 'id' ] );

            $product[ 'categorie_id' ] = $request->category;
            $product[ 'title' ]        = $request[ 'title' ];
            $product[ 'article' ]      = $request[ 'article' ] ? $request[ 'article' ] : '';
            $product[ 'url' ]          = $request[ 'url' ];

            if ( empty( $request[ 'image' ] ) ) {
                $product[ 'image' ]  = $product[ 'images' ] = '';
            } else {
                $product[ 'image' ]  = $request[ 'image' ];
                $product[ 'images' ] = serialize( json_decode( $request[ 'images' ] ) );
            }

            $product[ 'price' ] = $request[ 'price' ];
            $product[ 'sale' ]  = $request[ 'sale' ];
            $product[ 'stock' ] = $request[ 'stock' ];

            $product->save();
//            $backup = [
//                'pages' => [ 'id' => $page[ 'id' ] ],
//            ];
            DB::commit();
//            Backup::set( 'create', 'page', "Create page: {$category[ 'title' ]}", $backup, 'plus' );
            Session::flash( 'sm', "You are update successfull (  {$request[ 'title' ]} ) product." );
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t update product now please try after' );
            Session::flash( 'wm', $e->getMessage() );
        }
    }

    private static function imageForDropZone( $meny_img, &$images ) {
        if ( !empty( $meny_img ) ) {
            foreach ( $meny_img as $image ) {
                $current                                = count( $images );
                $images[ $current ][ 'name' ]           = $image;
                $images[ $current ][ 'serverFileName' ] = $image;
            }
        }
    }

    public static function getOldImages( &$data ) {
        $images                = [];
        self::imageForDropZone( old( 'images' ), $images );
        $data[ 'images_json' ] = json_encode( $images );
    }

    public static function deleteProduct( $id ) {
        DB::beginTransaction();
        try {

            $product = self::find( $id );
            $title   = $product[ 'title' ];
            if ( $product ) {
//                self::pageBackup( 'delete', $category, 'trash-o' );
                $product->delete();

                DB::commit();
                Session::flash( 'sm', "You are successfull delete product ($title)" );
            } else {
                
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            Session::flash( 'wm', 'Can\'t delete product now please try after' );
        }
    }

    public static function addToCart( $productId, $count ) {
        if ( $product = self::where( 'id', $productId )->with( 'category' )->first() ) {
            $product       = $product->toArray();
            $productToCart = [
                'id'      => $productId,
                'name'    => $product[ 'title' ],
                'qty'     => $count,
                'price'   => $product[ 'price' ] * (1 - $product[ 'sale' ] / 100),
                'options' => [
                    'url'   => url( "shop/{$product[ 'category' ][ 'url' ]}/{$product[ 'url' ]}" ),
                    'image' => $product[ 'image' ],
                ],
            ];
            $cart          = Cart::add( $productToCart );
            if ( $cart->qty > $product[ 'stock' ] ) {
                Cart::update( $cart->rowId, $product[ 'stock' ] );
                if ( $product[ 'stock' ] == 0 ) {
                    Session::flash( 'wm', 'Product\'s ' . $product[ 'title' ] . ' Out of stock.' );
                } else {
                    Session::flash( 'wm', 'In product ' . $product[ 'title' ] . ' max stock is ' . $product[ 'stock' ] . '.' );
                }
            } else {
                Session::flash( 'sm', 'You added successfull ' . $product[ 'title' ] . ' to cart.' );
            }
        }
    }

    private static function getProductInCart( $id, &$product ) {
        $cart = Cart::content()->groupBy( 'id' )->toArray();
        if ( !empty( $cart[ $id ] ) ) {
            $product = $cart[ $id ][ 0 ];
        }
    }

    public static function removeFromCart( $rowId ) {
        Cart::remove( $rowId );
    }

    public static function updateCart( $rowId, $count ) {
        Cart::update( $rowId, $count );
    }

}
