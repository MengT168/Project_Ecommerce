@extends('frontend.layout')
@section('title')
    Search
@endsection
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');
    body {
        background-color: #eeeeee;
        font-family: 'Open Sans', serif;
        font-size: 14px;
    }
    .container-fluid {
        margin-top: 70px;
    }
    .card-body {
        flex: 1 1 auto;
        padding: 1.40rem;
    }
    .img-sm {
        width: 80px;
        height: 80px;
    }
    .itemside .info {
        padding-left: 15px;
        padding-right: 7px;
    }
    .table-shopping-cart .price-wrap {
        line-height: 1.2;
    }
    .table-shopping-cart .price {
        font-weight: bold;
        margin-right: 5px;
        display: block;
    }
    .text-muted {
        color: #969696 !important;
    }
    a {
        text-decoration: none !important;
    }
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: 0px;
    }
    .itemside {
        position: relative;
        display: flex;
        width: 100%;
    }
    .dlist-align {
        display: flex;
    }
    [class*="dlist-"] {
        margin-bottom: 5px;
    }
    .coupon {
        border-radius: 1px;
    }
    .price {
        font-weight: 600;
        color: #212529;
    }
    .btn.btn-out {
        outline: 1px solid #fff;
        outline-offset: -5px;
    }
    .btn-main {
        border-radius: 2px;
        text-transform: capitalize;
        font-size: 15px;
        padding: 10px 19px;
        cursor: pointer;
        color: #fff;
        width: 100%;
    }
    .btn-light {
        color: #ffffff;
        background-color: #F44336;
        border-color: #f8f9fa;
        font-size: 12px;
    }
    .btn-light:hover {
        color: #ffffff;
        background-color: #F44336;
        border-color: #F44336;
    }
    .btn-apply {
        font-size: 11px;
    }
</style>
<main class="shop">

    <section>
        <div class="container">
            <div class="row">

                @if (Session::has('success'))
                    <h3 style="text-align: center;">{{ Session::get('success') }}</h3>
                @endif
                <aside class="col-lg-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-borderless table-shopping-cart">
                                <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th scope="col">Name</th>
                                        <th scope="col" >Thumbnail</th>
                                        <th scope="col" width="120" >Play</th>
                                        <!-- <th scope="col" width="120">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>
                                                <div class="price-wrap">
                                                    <h5>{{ $product->name }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <img src="/uploads/{{ $product->thumbnail }}" class="img-sm" style="width: 200px;height: 100px;"  alt="Product Thumbnail">
                                            </td>
                                            <td>
                                            <audio controls src="/uploads_audio/{{$product->audio_file}}" type="audio/mpeg"></audio>
                                            </td>
                                            <!-- <td>
                                                <button class="btn btn-light">Action</button>
                                            </td> -->
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

    </section>

</main>
@endsection
