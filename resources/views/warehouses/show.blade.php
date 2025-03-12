@extends('layouts.backend')

@section('css')
  <!-- Page JS Plugins CSS -->
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
@endsection



@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            {{ $warehouse->name }}
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
              {{ $warehouse->name }}
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- END Hero -->

  <!-- Page Content -->
  <div class="content">
    <div class="row">
      <div class="col-md-6 col-xl-4">
        <a class="block block-rounded block-link-pop" href="javascript:void(0)">
          <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div>
              <i class="fa fa-2x fa-boxes-packing text-muted"></i>
            </div>
            <dl class="ms-3 text-end mb-0">
              <dt class="h3 fw-extrabold mb-0">
              {{ $warehouse->countDistinctProducts() }}
              </dt>
              <dd class="fs-sm fw-medium text-muted mb-0">
                Sản phẩm
              </dd>
            </dl>
          </div>
        </a>
      </div>
      <!--  -->
      <div class="col-md-6 col-xl-4">
        <a class="block block-rounded block-link-pop" href="javascript:void(0)">
          <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div>
              <i class="fa fa-2x fa-boxes text-muted"></i>
            </div>
            <dl class="ms-3 text-end mb-0">
              <dt class="h3 fw-extrabold mb-0">
              {{ number_format($warehouse->totalQuantity(),0) }}
              </dt>
              <dd class="fs-sm fw-medium text-muted mb-0">
                Tổng số lượng
              </dd>
            </dl>
          </div>
        </a>
      </div>
      <!--  -->
      <div class="col-md-6 col-xl-4">
        <a class="block block-rounded block-link-pop" href="javascript:void(0)">
          <div class="block-content block-content-full d-flex align-items-center justify-content-between">
            <div>
              <i class="fa fa-2x fa-dollar-sign
 text-muted"></i>
            </div>
            <dl class="ms-3 text-end mb-0">
              <dt class="h3 fw-extrabold mb-0">
              {{ number_format($warehouse->totalValue(),0) }}
              </dt>
              <dd class="fs-sm fw-medium text-muted mb-0">
                Tổng giá trị
              </dd>
            </dl>
          </div>
        </a>
      </div>
    </div>
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">
          Danh sách
        </h3>
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
          <i class="fa fa-fw fa-plus me-1"></i> Thêm mới
        </button> -->
      </div>
      <div class="block-content block-content-full overflow-x-auto">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
          <thead>
              <tr>
                  <th class="text-center" style="width: 80px;">#</th>
                  <th>Mã SKU</th>
                  <th>Mô tả</th>
                  <th>Số lượng</th>
                  <th>Giá nhập</th>
                  <th>Tổng giá trị</th>
              </tr>
          </thead>
          <tbody>
            @php $stt = 1; @endphp

            @foreach($warehouse->productWarehouses as $productWarehouse)
              @if ($productWarehouse->quantity > 0)
              <tr>
                  <td class="fs-sm">{{ $stt++ }}</td>
                  <td class="fw-semibold fs-sm">{{ $productWarehouse->product->code }}</td>
                  <td class="fs-sm">{{ $productWarehouse->product->description }}</td>
                  <td class="fs-sm">{{ $productWarehouse->quantity }}</td>
                  <td class="fs-sm">{{ number_format($productWarehouse->purchase_price, 0) }} đ</td>
                  <td class="fs-sm">{{ number_format($productWarehouse->quantity * $productWarehouse->purchase_price, 0) }} đ</td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- END Dynamic Table Full -->
  </div>
  <!-- END Page Content -->
@endsection
@section('js')
  <!-- jQuery (required for DataTables plugin) -->
  <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

  <!-- Page JS Plugins -->
  <script src="{{ asset('js/plugins/datatables/dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

  <!-- Page JS Code -->
  @vite(['resources/js/pages/datatables.js'])
  @vite(['resources/js/pages/be_tables_datatables.js'])
  @vite(['resources/js/pages/be_comp_dialogs.js'])
@endsection

