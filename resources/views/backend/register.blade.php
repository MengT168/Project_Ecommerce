@extends('backend.master-login-register')
@section('title')
    Register
@endsection
@section('content')

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">

            @if (Session::has('message'))
                <p class="text-danger text-center">{{ Session::get('message') }}</p>
            @endif

            @if (Session::has('message_exist_user'))
                <p class="text-warning text-center">{{ Session::get('message_exist_user') }}</p>
            @endif

            <form id="formAuthentication" class="mb-3" action="/signup-submit" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input
                  type="text"
                  class="form-control"
                  id="username"
                  name="name"
                  placeholder="Enter your username"
                  required
                />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" required placeholder="Enter your email" />
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                    required
                  />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Profile</label>
                <input type="file" class="form-control" name="profile" required>
              </div>

              <button class="btn btn-primary d-grid w-100">Sign up</button>
            </form>

            <p class="text-center">
              <span>Already have an account?</span>
              <a href="/signin">
                <span>Sign in instead</span>
              </a>
            </p>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
</div>

@endsection
