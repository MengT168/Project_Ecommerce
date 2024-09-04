@extends('backend.master')

@section('content')
<div class="content-wrapper">
    @section('site-title')
      Admin | List Post
    @endsection
    @section('page-main-title')
      List Logo
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr>
                  <th>Thumbnail</th>
                  <th>Author</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($logo as $value)
                    <tr>
                        <td>
                            <img src="/uploads/{{ $value->thumbnail }}" width="120px">
                        </td>
                        <td><span class="badge bg-label-primary me-1">{{ $value->name }}</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/admin/update-logo/{{ $value->id }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item remove-post-key" data-value="{{ $value->id }}" data-bs-toggle="modal" data-bs-target="#basicModal" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-3">
          <form action="/admin/remove-logo-submit" method="post">
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Are you sure to remove this post?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" id="remove-val" name="id">
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
  <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-post-key').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = button.getAttribute('data-value');
            document.getElementById('remove-val').value = id;
        });
    });
});
</script>
</div>

@endsection
