@extends('backend.master')
@section('content')

    @section('site-title')
        Admin | Update Category
    @endsection
    @section('page-main-title')
        Update Category
    @endsection

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <form action="/admin/update-category-submit" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        @if (Session::has('message'))
                            <p class="text-primary text-center">{{ Session::get('message') }}</p>
                        @endif
                        <div class="card-body">

                            <div class="row">
                                <div class="mb-3 col-6">
                                    <input type="hidden" value="{{$cate->id}}" name="id" >
                                    <label for="formFile" class="form-label">Name</label>
                                    <input class="form-control" type="text" value="{{$cate->name}}" name="name" />
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
