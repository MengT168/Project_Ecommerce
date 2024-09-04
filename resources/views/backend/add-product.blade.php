@extends('backend.master')
@section('content')

@section('site-title')
Admin | Add Post
@endsection
@section('page-main-title')
Add Post
@endsection

<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-12">
            <!-- File input -->
            <form action="/admin/add-product-submit" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    @if (Session::has('message'))
                    <p class="text-danger text-center">{{ Session::get('message') }}</p>
                    @endif
                    <div class="card-body">

                        <div class="row">
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Name</label>
                                <input class="form-control" type="text" name="name" />
                            </div>
                            <!-- <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Quantity</label>
                                    <input class="form-control" type="text" name="qty" />
                                </div> -->
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Regular Price</label>
                                <input class="form-control" type="number" name="regular_price" />
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Sale Price</label>
                                <input class="form-control" type="number" name="sale_price" />
                            </div>

                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Category</label>
                                <select name="category" class="form-control">
                                    @foreach ($cate as $value )
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label text-danger">Recommend image size ..x.. pixels.</label>
                                <input class="form-control" type="file" name="thumbnail" />
                            </div>
                            <div class="mb-3 col-6">
                                <label for="formFile" class="form-label">Audio File</label>
                                <input class="form-control" type="file" name="audio_file" accept="audio/*" />
                            </div>

                            <div class="mb-3 col-12">
                                <label for="formFile" class="form-label text-danger">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-primary" value="Add Post">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection