@extends('frontend.layout')
@section('title')
    Product Detail
@endsection
@section('content')
<main class="product-detail">

    <section class="review">
        <div class="container">
            <div class="row">
                <div class="col-5">
                    <div class="thumbnail">
                        <img src="/uploads/{{$product->thumbnail}}" width="100%" alt="">
                    </div>
                </div>
                <div class="col-7">
                    <div class="detail">
                        @if (!$isSubscribed)
                            <div class="price-list">
                                @if ($product->sale_price > 0)
                                    <div class="regular-price"><strike> US {{$product->regular_price}}</strike></div>
                                    <div class="sale-price">US {{$product->sale_price}}</div>
                                @else
                                    <div class="price">US {{$product->regular_price}}</div>
                                @endif
                            </div>
                        @endif

                        @if($product->audio_file)
                            <audio id="productAudio" controls src="/uploads_audio/{{ $product->audio_file }}"></audio>
                        @endif

                        <h5 class="title">{{$product->name}}</h5>

                        <div class="group-size">
                            <form method="post" action="/add-cart" style="width: 250px; display: flex; gap: 10px;">
                                @csrf
                                <input type="hidden" value="{{$product->id}}" name="proId">
                                <input type="hidden" value="{{ $userId ?? 0 }}" name="userId">
                                
                                @if ($isSubscribed)
                                    <button id="unsubscribeBtn" class="btn btn-secondary mt-2" style="width: 150px;">Unsubscribe</button>
                                @else
                                    <button id="addToCartBtn" class="btn btn-primary mt-2" style="width: 150px;">Add to cart</button>
                                @endif
                            </form>
                        </div>

                        <div class="group-size">
                            <span class="title">Description</span>
                            <div class="description">
                                {{$product->description}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="main-title">
                        RELATED PRODUCTS
                    </h3>
                </div>
            </div>
            <div class="row">
                @foreach ($relatedProduct as $relatedProductValue)
                    <div class="col-3">
                        <figure>
                            <div class="thumbnail">
                                @if (Auth::check() &&  in_array($relatedProductValue->id, $dbSubScribe))
                                <div class="status">
                                        Subscribe
                                    </div>
                                @elseif ($relatedProductValue->sale_price > 0)
                                    <div class="status">
                                        Promotion
                                    </div>
                                @endif
                                <a href="/product/{{$relatedProductValue->slug}}">
                                    <img src="/uploads/{{$relatedProductValue->thumbnail}}" alt="">
                                </a>
                            </div>
                            <div class="detail">
                                <div class="price-list">
                                    @if (Auth::check() &&  in_array($relatedProductValue->id, $dbSubScribe))

                                    @elseif ($relatedProductValue->sale_price > 0)
                                        <div class="regular-price"><strike> US {{$relatedProductValue->regular_price}}</strike></div>
                                        <div class="sale-price">US {{$relatedProductValue->sale_price}}</div>
                                    @else
                                        <div class="price">US {{$relatedProductValue->regular_price}}</div>
                                    @endif
                                </div>
                                <h5 class="title">{{$relatedProductValue->name}}</h5>
                            </div>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const productAudio = document.getElementById('productAudio');
        let playCount = 0;
        const isSubscribed = @json($isSubscribed);

        productAudio.addEventListener('play', function() {
            if (!isSubscribed) {
                setTimeout(function() {
                    productAudio.pause();
                    playCount++;

                    if (playCount >= 1) {
                        Swal.fire({
                            title: 'Subscribe Now!',
                            text: 'Subscribe now to continue listening!',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }

                    productAudio.currentTime = 0; // Reset audio to the beginning
                }, 40000); // 40,000 ms = 40 seconds
            }
        });
    });
</script>
@endsection
