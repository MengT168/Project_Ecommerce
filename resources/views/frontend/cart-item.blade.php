@extends('frontend.layout')
@section('title')
    Search
@endsection
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');body{background-color: #eeeeee;font-family: 'Open Sans',serif;font-size: 14px}.container-fluid{margin-top:70px}.card-body{-ms-flex: 1 1 auto;flex: 1 1 auto;padding: 1.40rem}.img-sm{width: 80px;height: 80px}.itemside .info{padding-left: 15px;padding-right: 7px}.table-shopping-cart .price-wrap{line-height: 1.2}.table-shopping-cart .price{font-weight: bold;margin-right: 5px;display: block}.text-muted{color: #969696 !important}a{text-decoration: none !important}.card{position: relative;display: -ms-flexbox;display: flex;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid rgba(0,0,0,.125);border-radius: 0px}.itemside{position: relative;display: -webkit-box;display: -ms-flexbox;display: flex;width: 100%}.dlist-align{display: -webkit-box;display: -ms-flexbox;display: flex}[class*="dlist-"]{margin-bottom: 5px}.coupon{border-radius: 1px}.price{font-weight: 600;color: #212529}.btn.btn-out{outline: 1px solid #fff;outline-offset: -5px}.btn-main{border-radius: 2px;text-transform: capitalize;font-size: 15px;padding: 10px 19px;cursor: pointer;color: #fff;width: 100%}.btn-light{color: #ffffff;background-color: #F44336;border-color: #f8f9fa;font-size: 12px}.btn-light:hover{color: #ffffff;background-color: #F44336;border-color: #F44336}.btn-apply{font-size: 11px}
</style>
<main class="shop">
@if (Request::get('cart_id'))
    <input type="hidden" value="{{Request::get('cart_id')}}" name="cartId" >
    @endif
    <section>
    <div class="container">
        <div class="row">
           
            
           @if (Session::has('success'))
            <h3 style="text-align: center;" >{{Session::get('success')}}</h3>
           @endif
            <aside class="col-lg-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-borderless table-shopping-cart">
                            <thead class="text-muted">
                                <tr class="small text-uppercase">
                                    <th scope="col">Cart Items Id</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Thumbnail</th>
                                    <th scope="col" width="120">Price</th>
                                    <th scope="col" width="120">Action</th>
                                    <!-- <th scope="col" class="text-right d-none d-md-block" width="200"></th> -->
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($cartItems as $cartVal )
                                <tr>
                                <td>
                                    <div class="price-wrap"> <h5>{{$cartVal->id}}</h5></div>
                                    </td>
                                    <td>
                                    <div class="price-wrap"> <h5>{{$cartVal->name}}</h5></div>
                                    </td>
                                    <td>
                                    <img src="/uploads/{{$cartVal->thumbnail}}" width="80px" alt="">
                                    </td>
                                    <td>
                                        <div class="price-wrap"> <h5>{{$cartVal->price}} $</h5></div>
                                    </td>
                                    <td class="text-right d-none d-md-block"> 
                                        <a href="/remove-cartitem/{{$cartVal->id}}" class="btn btn-light" data-abc="true"> Remove</a> </td>
                                </tr>
            @endforeach
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </aside>
            <div class="card" style="width: 300px; margin-left: 12px; " >
            <div class="price-wrap"> <h4>Total Amount : {{$cartItems[0]->total_amount}} $</h4></div>
            </div>
            
            
        </div>
        <a href="/check-out" class="btn btn-primary" style="margin-top: 5px; width: 200px; float: right; " >Check Out</a>
    </div>
       
    </section>

</main>
@endsection