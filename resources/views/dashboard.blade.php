@extends('layouts.backend')

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Dashboard
          </h1>
          <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Xin chào {{Auth::user()->name}}, đây là trang tổng quan.
          </h2>
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">App</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              Dashboard
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- END Hero -->

  <!-- Page Content -->
  <div class="content">
    <h2 class="content-heading">Original</h2>
          <div class="row">
            <div class="col-md-6 col-xxl-4">
              <!-- Sign In -->
              <a class="block block-rounded block-link-shadow" href="#">
                <div class="block-content text-center">
                  <div class="py-5">
                    <div class="mb-3">
                      <i class="fa fa-user-group fa-2x text-default"></i>
                    </div>
                    <p class="fw-medium text-muted">
                      Quản lý khách hàng
                    </p>
                  </div>
                </div>
              </a>
              <!-- END Sign In -->
            </div>
            <div class="col-md-6 col-xxl-4">
              <!-- Sign Up -->
              <a class="block block-rounded block-link-shadow" href="{{ route('users.index') }}">
                <div class="block-content text-center">
                  <div class="py-5">
                    <div class="mb-3">
                      <i class="fa fa-user-gear fa-2x text-secondary"></i>
                    </div>
                    <p class="fw-medium text-muted">
                      Quản lý người dùng
                    </p>
                  </div>
                </div>
              </a>
              <!-- END Sign Up -->
            </div>
          </div>
  </div>
  <!-- END Page Content -->
@endsection
