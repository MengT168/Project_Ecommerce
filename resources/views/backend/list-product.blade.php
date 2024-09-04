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
              <th>Audio Here</th>
              <th>Regular Price</th>
              <th>Sale Price</th>
              <th>Category</th>
              <th>Viewer</th>
              <th>Author</th>
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
                @if($proVal->audio_file)
                <audio controls>
                  <source src="/uploads_audio/{{ $proVal->audio_file }}" type="audio/mpeg">
                  Your browser does not support the audio element.
                </audio>
                @else
                <span>No audio available</span>
                @endif
              </td>
              <td>{{ $proVal->regular_price}} $</td>
              <td>{{ $proVal->sale_price }} $</td>
              <td><span class="badge bg-label-warning me-1">{{ $proVal->cateName }}</span></td>
              <td><i>{{ $proVal->viewer }}</i></td>
              <td><span class="badge bg-label-primary me-1">{{ $proVal->authorname }}</span></td>
              <td><i>{{ $proVal->created_at }}</i></td>
              <td>
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="/admin/update-product/{{$proVal->id}}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                    <a class="dropdown-item" href="/admin/detail-product/{{$proVal->id}}"><i class="bx bx-edit-alt me-1"></i> Detail</a>
                    <a class="dropdown-item remove-post-key" data-value="{{$proVal->id}}" data-bs-toggle="modal" data-bs-target="#basicModal" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                  </div>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
    <div class="pagination_rounded">
      <ul>


        @if ($currentPage > 1)
        <li>
          <a href="/admin/list-product?page={{ $currentPage - 1 }}" class="prev"> <i class="fa fa-angle-left" aria-hidden="true"></i> Prev </a>
        </li>
        @endif
        @for ($i=0 ; $i<$totalPage ; $i++)
          <li>
          <a href="/admin/list-product?page={{$i+1}}">{{$i+1}}</a>
          </li>
          @endfor
          @if ($currentPage < $totalPage)
            <li><a href="/admin/list-product?page={{ $currentPage + 1 }}" class="next"> Next <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </li>
            @endif
      </ul>
    </div>

    <div class="mt-3">
      <form action="/admin/remove-product-submit" method="post">
        @csrf
        <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Are you sure to remove this post?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-footer">
                <input type="hidden" id="remove-val" name="remove_id">
                <button type="submit" class="btn btn-danger">Confirm</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
      </form>
    </div>

    <hr class="my-5" />
  </div>
  <!-- / Content -->
</div>
<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-post-key').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = button.getAttribute('data-value');
            document.getElementById('remove-val').value = id;
        });
    });
});
</script> -->
</div>

@endsection