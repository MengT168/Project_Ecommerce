@extends('backend.master')

@section('content')
<div class="content-wrapper">
    @section('site-title')
      Admin | Log Detail
    @endsection
    @section('page-main-title')
        Log Detail
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
          @foreach ($log as $value )
          {{$value->id}},
          {{$value->title}},
          {{$value->post_type}},
          {{$value->post_id}},
          {{$value->action}},
          {{$value->name}},
          {{$value->created_at}},
          {{$value->updated_at}}
          <br>
          @endforeach
        </div>        
      <hr class="my-5" />
    </div>
  </div>
</div>

@endsection
