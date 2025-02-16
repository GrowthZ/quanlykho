@extends('layouts.simple')

@section('content')
<div id="page-container">
    <!-- Main Container -->
    <main id="main-container">
    <!-- Page Content -->
    <div class="hero-static d-flex align-items-center">
        <div class="content">
        <div class="row justify-content-center push">
            <div class="col-md-8 col-lg-6 col-xl-4">
            <!-- Sign In Block -->
            <div class="block block-rounded mb-0">
                <div class="block-header block-header-default">
                <h3 class="block-title">Đăng nhập</h3>
                <!-- <div class="block-options">
                    <a class="btn-block-option fs-sm" href="op_auth_reminder.html">Forgot Password?</a>
                    <a class="btn-block-option" href="op_auth_signup.html" data-bs-toggle="tooltip" data-bs-placement="left" title="New Account">
                    <i class="fa fa-user-plus"></i>
                    </a>
                </div> -->
                </div>
                <div class="block-content">
                <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                    <h1 class="h2 mb-1">Quản lý kho</h1>
                    <p class="fw-medium text-muted">
                    Xin chào, hãy đăng nhập để sử dụng.
                    </p>

                    <!-- Sign In Form -->
                    <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-signin" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="py-3">
                        <div class="mb-4">
                        <input type="text" class="form-control form-control-alt form-control-lg" id="login-username" name="email" placeholder="Email">
                        </div>
                        <div class="mb-4">
                        <input type="password" class="form-control form-control-alt form-control-lg" id="login-password" name="password" placeholder="Mật khẩu">
                        </div>
                        <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="login-remember" name="remember">
                            <label class="form-check-label" for="login-remember">Remember Me</label>
                        </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6 col-xl-6">
                        <button type="submit" class="btn w-100 btn-alt-primary">
                            <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Đăng nhập
                        </button>
                        </div>
                    </div>
                    </form>
                    <!-- END Sign In Form -->
                </div>
                </div>
            </div>
            <!-- END Sign In Block -->
            </div>
        </div>
        <div class="fs-sm text-muted text-center">
            <strong>Dương Hiếu JSC</strong> &copy; <span data-toggle="year-copy"></span>
        </div>
        </div>
    </div>
    <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
</div>

@endsection
@section('js')
  <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- <script src="{{ asset('js/plugins/jquery-validation/additional-methods.min.js') }}"></script> -->

  <!-- Page JS Code -->
  @vite(['resources/js/pages/op_auth_signin.js'])
  @vite(['resources/js/oneui/app.js'])
@endsection
