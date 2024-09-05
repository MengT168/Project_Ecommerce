@extends('backend.master')

@section('content')
<div class="content-wrapper">
    @section('site-title')
      Admin | List Post
    @endsection
    @section('page-main-title')
      List Product
    @endsection
    
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                    <th>Name</th>
                    <th>Thumbnail</th>
                    <th>Audio</th>
                    <th>Regular Price</th>
                    <th>Sale Price</th>
                    <th>Category</th>
                    <th>Viewer</th>
                    <th>Author</th>
                    <th>Detail</th>
                    <th>Create Date</th>
                    <th>Action</th>

                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($product as $proVal)
                    <tr>
                        <td><span class="badge bg-label-primary me-1">{{ $proVal->name }}</span></td>
                        <td>
                            <img src="/uploads/{{ $proVal->thumbnail }}" width="70px">
                        </td>
                        <td>
                        <audio controls style="margin-top: 10px;" >
                                    <source src="/uploads_audio/{{ $proVal->audio_file }}"  type="audio/mpeg">
                                    </audio>
                        </td>
                        <td>{{ $proVal->regular_price}} $</td>
                        <td>{{ $proVal->sale_price }} $</td>
                        <td><span class="badge bg-label-warning me-1">{{ $proVal->cateName }}</span></td>
                        <td><i>{{ $proVal->viewer }}</i></td>
                        <td><span class="badge bg-label-primary me-1">{{ $proVal->authorname }}</span></td>
                        <td><span class="badge bg-label-primary me-1">{{ $proVal->description }}</span></td>
                        <td><i>{{ $proVal->created_at }}</i></td>
                        <td>
                            <div class="dropdown">
                              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="/admin/list-product"><i class="bx bx-edit-alt me-1"></i> Back</a>
                              </div>
                            </div>
                          </td>
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
