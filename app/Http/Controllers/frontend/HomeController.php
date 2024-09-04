<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function Home()
{
    $newProducts = DB::table('product')->orderByDesc('id')->limit(4)->get();
    $promotionProducts = DB::table('product')->where('sale_price', '>', 0)->limit(4)->get();
    $popularProducts = DB::table('product')->orderByDesc('viewer')->limit(4)->get();
    
    $subscribedProductIds = [];

    if (Auth::check()) {
        $userId = Auth::user()->id;
        $dbSubScribe = DB::table('subscribe')->where('user_id', $userId)->first();
        
        if ($dbSubScribe) {
            $subId = $dbSubScribe->id;
            $subscribedProducts = DB::table('subscribe_item')->where('subscribe_id', $subId)->pluck('product_id');
            $subscribedProductIds = $subscribedProducts->toArray();
        }
    }

    return view('frontend.home', [
        'newProducts' => $newProducts,
        'promotionPro' => $promotionProducts,
        'popularProduct' => $popularProducts,
        'subscribedProductIds' => $subscribedProductIds
    ]);
}



public function Product($slug)
{
    $product = DB::table('product')->where('slug', $slug)->get();
    if (count($product) == 0) {
        return redirect('/404');
    }

    $categoryId = $product[0]->category;
    $currentViewer = $product[0]->viewer;
    $increaseViewer = $currentViewer + 1;
    $productId = $product[0]->id;
    DB::table('product')->where('id', $productId)->update([
        'viewer' => $increaseViewer
    ]);

    $relatedProduct = DB::table('product')->where('category', $categoryId)
                        ->where('id', '<>', $productId)
                        ->limit(4)
                        ->orderByDesc('id')
                        ->get();

    $userId = null;
    $isSubscribed = false;

    if (Auth::check()) {
        $userId = Auth::user()->id;
        $dbSubScribe = DB::table('subscribe')->where('user_id', $userId)->first();
        if ($dbSubScribe) {
            $subId = $dbSubScribe->id;
            $subscribedProducts = DB::table('subscribe_item')->where('subscribe_id', $subId)->pluck('product_id');
            $isSubscribed = in_array($productId, $subscribedProducts->toArray());
        }
    }

    return view('frontend.product', [
        'product' => $product,
        'relatedProduct' => $relatedProduct,
        'isSubscribed' => $isSubscribed,
        'userId' => $userId // Pass the userId to the view
    ]);
}


    

    public function AddCart(Request $request)
    {
        if ($request->userId != 0) {
            $userId = $request->userId;
            $productId = $request->proId;

            $exist = DB::table('cart')->where('user_id', $userId)->count();

            if ($exist == 0) {
                $insertCart = DB::table('cart')->insert([
                    'user_id'       => $userId,
                    'total_amount'  => 0,
                    'created_at'    => date('Y-m-d h:i:s')
                ]);
                $cartId = DB::table('cart')->where('user_id', $userId)->get();
            } else {
                $cartId = DB::table('cart')->where('user_id', $userId)->limit(1)->get();
            }
            $productPrice = DB::table('product')->where('id', $productId)->get();
            if ($productPrice[0]->sale_price > 0) {
                $price = $productPrice[0]->sale_price;
            } else {
                $price = $productPrice[0]->regular_price;
            }

            $cartItem = DB::table('cart_items')
                ->where('cart_id', $cartId[0]->id)
                ->where('product_id', $productId)
                ->where('status', 0)
                ->first();

            if ($cartItem) {
                DB::table('cart_items')->where('id', $cartItem->id)->update([
                    'price'         => $price,
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
            } else {
                DB::table('cart_items')->insert([
                    'cart_id'       => $cartId[0]->id,
                    'product_id'    => $productId,
                    'price'         => $price,
                    'status'        => 0,
                    'created_at'    => date('Y-m-d h:i:s'),
                    'updated_at'    => date('Y-m-d h:i:s')
                ]);
            }



            $totalAmount = $cartId[0]->total_amount + $price ;

            DB::table('cart')->where('id', $cartId[0]->id)->update([
                'total_amount'  => $totalAmount,
                'updated_at'    => date('Y-m-d h:i:s')
            ]);

            return redirect('/cart-item');
        } else {
            return redirect('/signin');
        }
    }

    public function CartItem()
    {
        $userId = Auth::user()->id;
        $cartId = DB::table('cart')->where('user_id', $userId)->get();

        $cartId = $cartId[0]->id;

        $cartItems = DB::table('cart_items')
            ->leftJoin('product', 'cart_items.product_id', '=', 'product.id')
            ->leftJoin('cart', 'cart.id', 'cart_items.cart_id')
            ->where('cart_items.cart_id', $cartId)
            ->where('status', 0)
            ->select('cart_items.*', 'product.name', 'product.thumbnail', 'cart.total_amount')
            ->get();

        return view('frontend.cart-item', ['cartItems' => $cartItems]);
    }

    public function checkOut()
    {
        $userId = Auth::user()->id;
        $cartId = DB::table('cart')->where('user_id', $userId)->get();

        $cartId = $cartId[0]->id;

        $cartItems = DB::table('cart_items')
            ->leftJoin('product', 'cart_items.product_id', '=', 'product.id')
            ->leftJoin('cart', 'cart.id', 'cart_items.cart_id')
            ->where('cart_items.cart_id', $cartId)
            ->where('status', 0)
            ->select('cart_items.*', 'product.name', 'product.thumbnail', 'cart.total_amount')
            ->get();
        return view('frontend.check-out', ['cartItems' => $cartItems]);
    }

    public function placeOrder(Request $request)
    {
        $transactionId = date('Ymdhis');
        $userId = Auth::user()->id;
        $visa = $request->visa;
        

        $cart = DB::table('cart')->where('user_id', $userId)->first();


        $cartItems = DB::table('cart_items')->where('cart_id', $cart->id)->where('status', 0)->get();


        $user = DB::table('users')->where('id', $userId)->first();
        $subscribeId = DB::table('subscribe')->insertGetId([
            'transaction_id' => $transactionId,
            'user_id' => $userId,
            'fullname' => $user->name,
            'credit_card' => $visa,
            'total_amount' => $cart->total_amount,
            'status' => "complete",
            'created_at'    => date('Y-m-d h:i:s'),
            'updated_at'    => date('Y-m-d h:i:s')
        ]);


        foreach ($cartItems as $cartItem) {
            DB::table('subscribe_item')->insert([
                'subscribe_id' => $subscribeId,
                'product_id' => $cartItem->product_id,
                'price' => $cartItem->price,
                'created_at'    => date('Y-m-d h:i:s'),
                'updated_at'    => date('Y-m-d h:i:s')
            ]);
        }

        DB::table('cart_items')->where('cart_id', $cart->id)->update([
            'status'    => 1,
            'updated_at'    => date('Y-m-d h:i:s')
        ]);
        DB::table('cart')->where('id', $cart->id)->update([
            'total_amount' => 0,
            'updated_at'    => date('Y-m-d h:i:s')
        ]);
        $subscribeIdCount = DB::table('subscribe_item')
            ->where('subscribe_id', $subscribeId)
            ->count('subscribe_id');

        $dbSubscribeItem = DB::table('subscribe_item')->where('subscribe_id', $subscribeId)
            ->leftJoin('product', 'product.id', 'subscribe_item.product_id')
            ->leftJoin('subscribe', 'subscribe.id', 'subscribe_item.subscribe_id')
            ->select('product.name', 'product.thumbnail', 'subscribe_item.*', DB::raw('subscribe_item.price as total'))
            ->orderByDesc('subscribe.id')
            ->limit($subscribeIdCount)
            ->get();
        $totalAmount = $dbSubscribeItem->sum('total');

        return redirect('/recipt')->with([
            'success' => 'Order placed successfully.',
            'subscribeItems' => $dbSubscribeItem,
            'totalAmount' => $totalAmount
        ]);
    }

    public function myOrder(){
        $dbOrder = DB::table('subscribe')->orderByDesc('id')->get();
        return view('frontend.my-order',['myOrder'=>$dbOrder]);
    }
    public function viewOrder($id){
        $dbSubscribeItems = DB::table('subscribe_item')->where('subscribe_id',$id)
        ->leftJoin('product','product.id','subscribe_item.product_id')
        ->select('product.name','product.thumbnail','subscribe_item.*')
        ->get();
        // return $dbOrderItems;
        $dbSubscribe = DB::table('subscribe')->where('id',$id)->get();

        return view('frontend.my-order-history',['subscribeItems'=>$dbSubscribeItems , 'subscribe'=>$dbSubscribe]);        
    }

    public function recipt()
    {
        return view('frontend.recipt');
    }

    public function Logout($id){
        if(Auth::check()&&Auth::user()->id==$id){
            Auth::logout();
        }
        return redirect('/');
    }
}
