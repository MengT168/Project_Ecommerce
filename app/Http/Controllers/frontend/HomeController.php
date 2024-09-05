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
    
            $subIds = DB::table('subscribe')->where('user_id', $userId)->pluck('id')->toArray();
    
            if (!empty($subIds)) {
                $subscribedProductIds = DB::table('subscribe_item')
                                          ->whereIn('subscribe_id', $subIds)
                                          ->pluck('product_id')
                                          ->toArray();
            }
        }
    
        return view('frontend.home', [
            'newProducts' => $newProducts,
            'promotionPro' => $promotionProducts,
            'popularProduct' => $popularProducts,
            'subscribedProductIds' => $subscribedProductIds
        ]);
    }

    public function Shop(Request $request)
    {
        $limitPage = 3;
        $currentPage = $request->input('page', 1);

        $offset = ($currentPage - 1) * $limitPage;

        $productObj = DB::table('product');

        if ($request->category) {
            $categorySlug = $request->category;
            $categoryId = DB::table('category')->where('slug', $categorySlug)->get();
            $product = $productObj->where('category', $categoryId[0]->id)->limit($limitPage)->offset($offset);
            $productCount = DB::table('product')->where('category', $categoryId[0]->id)->count();
        } elseif ($request->price) {
            if ($request->price == 'max') {
                $product = $productObj->orderByDesc('regular_price')->limit($limitPage)->offset($offset);
            } else {
                $product = $productObj->orderBy('regular_price', 'ASC')->limit($limitPage)->offset($offset);
            }
            $productCount = DB::table('product')->count();
        } elseif ($request->promotion) {
            $product = $productObj->where('sale_price', '>', 0)->limit($limitPage)->offset($offset);
            $productCount = DB::table('product')->where('sale_price', '>', 0)->count();
        } else {
            $product = $productObj->limit($limitPage)->offset($offset);
            $productCount = DB::table('product')->count();
        }
        $product = $productObj->orderByDesc('id')->get();

        $category = DB::table('category')->orderByDesc('id')->get();
        $totalPage = ceil($productCount / $limitPage);

        return view('frontend.shop', ['product' => $product, 'totalPage' => $totalPage, 'category' => $category]);
    }

    public function mySub()
    {
        $userId = Auth::user()->id;
    
        $subIds = DB::table('subscribe')->where('user_id', $userId)->pluck('id')->toArray();
        $products = [];
    
        if (!empty($subIds)) {
            $products = DB::table('product')
                            ->whereIn('id', function($query) use ($subIds) {
                                $query->select('product_id')
                                      ->from('subscribe_item')
                                      ->whereIn('subscribe_id', $subIds);
                            })
                            ->get();
        }
    
        return view('frontend.my-audio', ['products' => $products]);
    }
    



    public function Product($slug)
    {
        $product = DB::table('product')->where('slug', $slug)->first();
        if (!$product) {
            return redirect('/404');
        }
    
        $productId = $product->id;
        $currentViewer = $product->viewer;
        $increaseViewer = $currentViewer + 1;
        DB::table('product')->where('id', $productId)->update(['viewer' => $increaseViewer]);
    
        $categoryId = $product->category;
        $relatedProduct = DB::table('product')
                            ->where('category', $categoryId)
                            ->where('id', '<>', $productId)
                            ->limit(4)
                            ->orderByDesc('id')
                            ->get();
    
        $userId = null;
        $isSubscribed = false;
        $dbSubScribe = [];
    
        if (Auth::check()) {
            $userId = Auth::user()->id;
    
            $subscriptionIds = DB::table('subscribe')
                                 ->where('user_id', $userId)
                                 ->pluck('id');
    
            if ($subscriptionIds->isNotEmpty()) {
                $subscribedProducts = DB::table('subscribe_item')
                                        ->whereIn('subscribe_id', $subscriptionIds)
                                        ->pluck('product_id')
                                        ->toArray();
    
                $isSubscribed = in_array($productId, $subscribedProducts);
    
                $dbSubScribe = $subscribedProducts;
            }
        }
    
        return view('frontend.product', [
            'product' => $product,
            'relatedProduct' => $relatedProduct,
            'isSubscribed' => $isSubscribed,
            'userId' => $userId,
            'dbSubScribe' => $dbSubScribe
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
    $cart = DB::table('cart')->where('user_id', $userId)->first();

    if (!$cart) {
        abort(404, 'Cart not found');
    }

    $cartItems = DB::table('cart_items')
        ->leftJoin('product', 'cart_items.product_id', '=', 'product.id')
        ->leftJoin('cart', 'cart.id', 'cart_items.cart_id')
        ->where('cart_items.cart_id', $cart->id)
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
        if(Auth::check()>0){
            $id = Auth::user()->id;
            $dbOrder = DB::table('subscribe')->where('user_id',$id)->orderByDesc('id')->get();
        }
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


    public function myProfile()
{
    if (Auth::check()) {
        $id = Auth::user()->id;
        $dbUser = DB::table('users')->where('id', $id)->get();
        $subIds = DB::table('subscribe')->where('user_id', $id)->pluck('id');

        // Initialize productSubScribe
        $productSubScribe = 0;

        if (!$subIds->isEmpty()) {
            $productSubScribe = DB::table('subscribe_item')
                                  ->whereIn('subscribe_id', $subIds)
                                  ->count('product_id');
        }

        return view('frontend.my-profile', ['user' => $dbUser, 'product' => $productSubScribe]);
    }

    return redirect('/signin');
}

public function editMyProfile(){
    if(Auth::check()>0){
        $userId = Auth::user()->id;
        $dbUser = DB::table('users')->where('id', $userId)->get();

    }
    return view('frontend.edit-myPro',['User'=>$dbUser]);
}

public function editMyProfileSubmit(Request $request){
    $userId = Auth::user()->id;
    $dbUser = DB::table('users')->where('id',$userId)->get();
    $name = $request->name;
    $email = $request->email;
    if($request->file('img')){
        $file = $request->file('img');
        $img = $this->uploadFile($file);
    }else{
        $img = $dbUser[0]->image;
    }
    $update = DB::table('users')->where('id',$userId)->update(
        [
            'name'  => $name,
            'email' => $email,
            'image' => $img
        ]
    );
    if($update){
        return redirect('/my-profile');
    }
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
