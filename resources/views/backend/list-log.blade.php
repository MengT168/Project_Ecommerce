@extends('backend.master')

@section('content')
<div class="content-wrapper">
    @section('site-title')
      Admin | List Post
    @endsection
    @section('page-main-title')
      List Log
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Post Type</th>
                  <th>Author</th>
                  <th>Actions</th>
                  <th>Detail</th>
                  <th>Created At</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($log as $value)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $value->title }}</strong></td>
                        <td>{{ $value->post_type }}</td>
                        <td><span class="badge bg-label-primary me-1">{{ $value->name }}</span>
                        </td><td><span class="badge bg-label-warning me-1">{{ $value->action }}</span></td>
                        <input type="hidden" value="{{$value->id}}" >
                        <td><a href="/admin/log-detail/{{$value->post_type}}/{{ $value->post_id }}/{{$value->id}}">Detail</a></td>
                        <td>{{ $value->created_at }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>        
      <hr class="my-5" />
    </div>
    <!-- / Content -->
  </div>
</div>

@endsection
