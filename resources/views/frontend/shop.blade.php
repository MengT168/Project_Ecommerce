@extends('frontend.layout')
@section('title')
    Shop
@endsection
@section('content')
<main class="shop">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <div class="row">
                       
                    @foreach ($product as $productVal )
                        
                            <div class="col-4">
                                <figure>
                                    <div class="thumbnail">
                                    @if ($productVal->sale_price >0)
                                        <div class="status">
                                            Promotion
                                        </div>
                                    @endif
                                    
                                        <a href="/product/{{$productVal->slug}}">
                                        <img src="/uploads/{{$productVal->thumbnail}}" alt="">
                                        </a>
                                     

                                    </div>
                                    <div class="detail">
                                       
                                        
                                    <div class="price-list">
                                    @if ($productVal->sale_price >0)
                                        <div class="regular-price "><strike> US {{$productVal->regular_price}}</strike></div>
                                        <div class="sale-price ">US {{$productVal->sale_price}}</div>
                                    @else
                                     <div class="price">US {{$productVal->regular_price}}</div>
                                    @endif 
                                    </div>
                                    <h5 class="title">{{$productVal->name}}</h5>
                                    
                                </div>
                                </figure>
                            </div>
                            @endforeach
                        <div class="col-12">
                            <ul class="pagination">
                            @if (Request::get('category'))
                                @for ($i = 1; $i <= $totalPage; $i++)
                                    <li>
                                        <a href="/shop?category={{Request::get('category')}}&page={{$i}}">{{$i}}</a>
                                    </li>
                                @endfor
                            @elseif(Request::get('promotion'))
                                @for ($i = 1; $i <= $totalPage; $i++)
                                    <li>
                                        <a href="/shop?promotion={{Request::get('promotion')}}&page={{$i}}">{{$i}}</a>
                                    </li>
                                @endfor
                            @else
                                @for ($i = 1; $i <= $totalPage; $i++)
                                    <li>
                                        <a href="/shop?page={{$i}}">{{$i}}</a>
                                    </li>
                                @endfor
                            @endif
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-3 filter">
                    <h4 class="title">Category</h4>
                    <ul>
                        <li>
                            <a href="/shop">All</a>
                        </li>
                        @foreach ($category as $cateVal )
                        <li>
                            <a href="/shop?category={{$cateVal->slug}}">{{$cateVal->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                    
                    <h4 class="title mt-4">Price</h4>
                    <div class="block-price mt-4">
                        <a href="/shop?price=max">High</a>
                        <a href="/shop?price=min">Low</a>
                    </div>

                    <h4 class="title mt-4">Promotion</h4>
                    <div class="block-price mt-4">
                        <a href="/shop?promotion=true">Promotion Product</a>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main>
@endsection