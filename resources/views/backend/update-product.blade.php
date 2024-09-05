@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Add Post
    @endsection
    @section('page-main-title')
        Add Post
    @endsection

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <form action="/admin/update-product-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        @if (Session::has('message'))
                            <p class="text-danger text-center">{{ Session::get('message') }}</p>
                        @endif
                        <div class="card-body">
                            
                            
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <input type="hidden" name="id" value="{{$product->id}}" >
                                    <label for="formFile" class="form-label">Name</label>
                                    <input class="form-control" value="{{$product->name}}" type="text" name="name" />
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Regular Price</label>
                                    <input class="form-control" value="{{$product->regular_price}}" type="number" name="regular_price" />
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Sale Price</label>
                                    <input class="form-control" value="{{$product->sale_price}}" type="number" name="sale_price" />
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Category</label>
                                    <select name="category" class="form-control">
                                        @foreach ($cate as $cateVal )
                                            @if ($cateVal->id == $product->category)
                                                <option selected value="{{$cateVal->id}}">{{$cateVal->name}}</option>
                                            @else
                                                <option value="{{$cateVal->id}}">{{$cateVal->name}}</option>
                                            @endif
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label text-danger">Recommend image size ..x.. pixels.</label>
                                    <input class="form-control" type="file" name="thumbnail" />
                                    <img src="/uploads/{{$product->thumbnail}}" style="margin-top: 5px;" width="100" height="100" alt="">
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label text-danger">Recommend image size ..x.. pixels.</label>
                                    <input class="form-control" type="file" name="audio_file" />
                                    <audio controls style="margin-top: 10px;" >
                                    <source src="/uploads_audio/{{ $product->audio_file }}"  type="audio/mpeg">
                                    </audio>
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="formFile" class="form-label text-danger">Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="10">{{$product->description}}</textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" value="Update Post">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
