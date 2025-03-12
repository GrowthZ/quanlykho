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
            Quản lý sản phẩm
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
              Quản lý sản phẩm
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- END Hero -->
  @if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
  @endif
  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">
          Danh sách
        </h3>
        <a type="button" class="btn btn-primary" href="{{ route('products.create') }}">
          <i class="fa fa-fw fa-plus me-1"></i> Thêm mới
        </a>
        
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
                  <th>Giá mua</th>
                  <th>Giá bán</th>
                  <th>Trọng lượng</th>
                  <th>Xuất xứ</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
          <tbody>
              @foreach($products as $product)
                  <tr>
                      <td class="fs-sm">{{ $product->id }}</td>
                      <td class="fw-semibold fs-sm">{{ $product->code }}</td>
                      <td class="fs-sm">{{ $product->description }}</td>
                      <td class="fs-sm">{{ $product->quantity }}</td>
                      <td class="fs-sm">{{ number_format($product->purchase_price, 0) }} VNĐ</td>
                      <td class="fs-sm">{{ number_format($product->price, 0) }} VNĐ</td>
                      <td class="fs-sm">{{ $product->weight }}</td>
                      <td class="fs-sm">{{ $product->origin }}</td>
                      <td class="fs-sm">
                          @php
                              if ($product->status == 0) {
                                  echo '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">Ngừng sản xuất</span>';
                              } elseif ($product->status == 1) {
                                  echo $product->quantity > 0 
                                      ? '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">Còn hàng</span>' 
                                      : '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning">Hết hàng</span>';
                              }
                          @endphp
                      </td>

                      <td class="fs-sm">
                          <!-- <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Sửa</a> -->
                          <button href="javascript:void(0)" class="btn edit-product"  data-bs-toggle="tooltip" title="Chỉnh sửa thông tin"
                            data-id="{{ $product->id }}" 
                            data-company_name="{{ $product->company_name }}" 
                            data-address="{{ $product->address }}" 
                            data-phone="{{ $product->phone }}" 
                            data-tax_code="{{ $product->tax_code }}" 
                            data-representative="{{ $product->representative }}" 
                            data-position="{{ $product->position }}">
                            <i class="fa fa-fw fa-edit me-1 text-primary"></i>
                          </button>
                          <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn" onclick="return confirm('Xác nhận xóa?')" data-bs-toggle="tooltip" title="Xóa sản phẩm ">
                                <i class="fa fa-fw fa-trash me-1 text-danger"></i>
                              </button>
                          </form>
                      </td>
                     
                  </tr>
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



