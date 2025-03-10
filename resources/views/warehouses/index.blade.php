@extends('layouts.backend')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Danh sách kho
          </h1>
          <!-- <h2 class="fs-base lh-base fw-medium text-muted mb-0">
            Plugin Integration
          </h2> -->
        </div>
        <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item">
              <a class="link-fx" href="javascript:void(0)">Trang chủ</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                Danh sách kho
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="row">
    @foreach ($warehouses as $warehouse)
      <div class="col-xl-6">
        <a href="{{ route('warehouses.show', $warehouse->id) }}">

        <div class="block block-rounded text-center">
          <div class="block-content bg-primary">
            <p class="text-white text-uppercase fs-sm fw-bold">
              {{$warehouse->name}}
            </p>
          </div>
          <div class="block-content block-content-full">
            <div class="row">
              <div class="col-4">
                <div class="fw-bold" data-percent="20" data-line-width="3" data-size="70" data-bar-color="#82b54b" data-track-color="#e9e9e9">
                  <span>{{ $warehouse->countDistinctProducts() }}</span>
                </div>
                <p class="fs-sm fw-medium text-muted mt-2 mb-0">
                  Sản phẩm
                </p>
              </div>
              <div class="col-4">
                <div class="fw-bold">
                  <span>{{ number_format($warehouse->totalQuantity(),0) }}</span>
                </div>
                <p class="fs-sm fw-medium text-muted mt-2 mb-0">
                  Tổng số lượng
                </p>
              </div>
              <div class="col-4">
                <!-- Pie Chart Container -->
                <div class="fw-bold">
                  <span>{{ number_format($warehouse->totalValue(),0) }} đ</span>
                </div>
                <p class="fs-sm fw-medium text-muted mt-2 mb-0">
                  Tổng giá trị
                </p>
              </div>
            </div>
          </div>
        </div>
        </a>
      </div>
  @endforeach
    </div>
</div>
@endsection
