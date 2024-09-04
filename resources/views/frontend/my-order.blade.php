@extends('frontend.layout')
@section('title')
    Search
@endsection
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');body{background-color: #eeeeee;font-family: 'Open Sans',serif;font-size: 14px}.container-fluid{margin-top:70px}.card-body{-ms-flex: 1 1 auto;flex: 1 1 auto;padding: 1.40rem}.img-sm{width: 80px;height: 80px}.itemside .info{padding-left: 15px;padding-right: 7px}.table-shopping-cart .price-wrap{line-height: 1.2}.table-shopping-cart .price{font-weight: bold;margin-right: 5px;display: block}.text-muted{color: #969696 !important}a{text-decoration: none !important}.card{position: relative;display: -ms-flexbox;display: flex;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid rgba(0,0,0,.125);border-radius: 0px}.itemside{position: relative;display: -webkit-box;display: -ms-flexbox;display: flex;width: 100%}.dlist-align{display: -webkit-box;display: -ms-flexbox;display: flex}[class*="dlist-"]{margin-bottom: 5px}.coupon{border-radius: 1px}.price{font-weight: 600;color: #212529}.btn.btn-out{outline: 1px solid #fff;outline-offset: -5px}.btn-main{border-radius: 2px;text-transform: capitalize;font-size: 15px;padding: 10px 19px;cursor: pointer;color: #fff;width: 100%}.btn-light{color: #ffffff;background-color: #F44336;border-color: #f8f9fa;font-size: 12px}.btn-light:hover{color: #ffffff;background-color: #F44336;border-color: #F44336}.btn-apply{font-size: 11px}
</style>
<main class="shop">

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
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Credit Card ID</th>
                                    <th scope="col" width="120">Transaction ID</th>
                                    <th scope="col" width="120">Total Amount</th>
                                    <th scope="col" width="120">Status</th>
                                    <th scope="col" width="120">Date</th>
                                    <th scope="col" width="120">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($myOrder as $orderVal )
                                <tr>
                                <td>
                                    <div class="price-wrap"> <h5>{{$orderVal->id}}</h5></div>
                                    </td>
                                    <td>
                                    <div class="price-wrap"> <h5>{{$orderVal->fullname}}</h5></div>
                                    </td>
                                    
                                    <td>
                                    <div class="price-wrap"> <h5>{{$orderVal->credit_card}}</h5></div>
                                    </td>
                                    <td>
                                        <div class="price-wrap"> <h5>{{$orderVal->transaction_id}}</h5></div>
                                    </td>
                                    <td>
                                        <div class="price"> <h6>{{$orderVal->total_amount}} $ </h6></div>
                                    </td>
                                    <td>
                                        <div class="price"> <h6>{{$orderVal->status}}</h6></div>
                                    </td>
                                    <td>
                                        <div class="price"> <h6>{{$orderVal->created_at}}</h6></div>
                                    </td>
                                    <td class="text-right d-none d-md-block"> 
                                        <a href="/view-order/{{$orderVal->id}}" class="btn btn-light" data-abc="true">View</a> </td>
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