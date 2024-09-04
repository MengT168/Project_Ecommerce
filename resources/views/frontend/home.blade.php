@extends('frontend.layout')
@section('title')
    Home
@endsection
@section('content')
    <main class="home">
        <section>
            <div class="container">
                @if (Session::has('message'))
                    <h3 style="text-align: center;" >{{Session::get('message')}}</h3>
                @endif
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            NEW 
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($newProducts as $newProductValue )
                    
                    
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                @if (Auth::check() && in_array($newProductValue->id, $subscribedProductIds))
                                <div class="status">
                                    Subscribe
                                </div>
                                    @elseif($newProductValue->sale_price >0)
                                    <div class="status">
                                            Promotion
                                        </div>
                                    @endif
                                    <a href="/product/{{$newProductValue->slug}}">
                                        <img src="/uploads/{{$newProductValue->thumbnail}}" alt="">
                                    </a>
                                </div>
                                <div class="detail">
                                    <div class="price-list">
                                    @if ($newProductValue->sale_price >0)
                                        <div class="regular-price "><strike> US {{$newProductValue->regular_price}}</strike></div>
                                        <div class="sale-price ">US {{$newProductValue->sale_price}}</div>
                                    @else
                                     <div class="price">US {{$newProductValue->regular_price}}</div>
                                    @endif 
                                    </div>
                                    <h5 class="title">{{$newProductValue->name}}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            PROMOTION 
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($promotionPro as $promotionProductValue )
                    
                    
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                @if (Auth::check() &&  in_array($promotionProductValue->id, $subscribedProductIds))
                                <div class="status">
                                    Subscribe
                                </div>
                                    @elseif($promotionProductValue->sale_price >0)
                                    <div class="status">
                                            Promotion
                                        </div>
                                    @endif
                                    <a href="/product/{{$promotionProductValue->slug}}">
                                        <img src="/uploads/{{$promotionProductValue->thumbnail}}" alt="">
                                    </a>
                                </div>
                                <div class="detail">
                                    <div class="price-list">
                                    @if ($promotionProductValue->sale_price >0)
                                        <div class="regular-price "><strike> US {{$promotionProductValue->regular_price}}</strike></div>
                                        <div class="sale-price ">US {{$promotionProductValue->sale_price}}</div>
                                    @else
                                     <div class="price">US {{$promotionProductValue->regular_price}}</div>
                                    @endif 
                                    </div>
                                    <h5 class="title">{{$promotionProductValue->name}}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>  

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            POPULAR 
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($popularProduct as $popularProductValue )
                    
                    
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                @if (Auth::check() &&  in_array($popularProductValue->id, $subscribedProductIds))
                                <div class="status">
                                    Subscribe
                                </div>
                                    @elseif($popularProductValue->sale_price >0)
                                    <div class="status">
                                            Promotion
                                        </div>
                                    @endif
                                    <a href="/product/{{$popularProductValue->slug}}">
                                        <img src="/uploads/{{$popularProductValue->thumbnail}}" alt="">
                                    </a>
                                </div>
                                <div class="detail">
                                    <div class="price-list">
                                    @if ($popularProductValue->sale_price >0)
                                        <div class="regular-price "><strike> US {{$popularProductValue->regular_price}}</strike></div>
                                        <div class="sale-price ">US {{$popularProductValue->sale_price}}</div>
                                    @else
                                     <div class="price">US {{$popularProductValue->regular_price}}</div>
                                    @endif 
                                    </div>
                                    <h5 class="title">{{$popularProductValue->name}}</h5>
                                </div>
                            </figure>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </main>  
@endsection
