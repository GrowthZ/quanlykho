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

  <!-- Page Content -->
  <div class="content">
    <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Import</button>
    </form>
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">
          Danh sách
        </h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-product">
          <i class="fa fa-fw fa-plus me-1"></i> Thêm mới
        </button>
        
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
                      <td class="fs-sm">{{ $product->weight }} Kg</td>
                      <td class="fs-sm">{{ $product->origin }}</td>
                      <td class="fs-sm">{{ $product->status }}</td>

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
                              <button type="submit" class="btn" onclick="return confirm('Xác nhận xóa?')" data-bs-toggle="tooltip" title="Xóa khách hàng">
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
     <!-- Vertically Centered Block Modal -->
     <div class="modal" id="add-product" tabindex="-1" role="dialog" aria-labelledby="add-product" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
              <div class="block-header block-header-default">
                <h3 class="block-title">Thêm mới khách hàng</h3>
                <div class="block-options">
                  <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-fw fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="block-content fs-sm">
              <form action="{{ route('products.store') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                      <label class="form-label">Công ty</label>
                      <input type="text" name="company_name" class="form-control">
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Địa chỉ</label>
                      <input type="text" name="address" class="form-control">
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Điện thoại</label>
                      <input type="text" name="phone" class="form-control">
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Mã số thuế</label>
                      <input type="text" name="tax_code" class="form-control">
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Người đại diện</label>
                      <input type="text" name="representative" class="form-control">
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Chức vụ</label>
                      <input type="text" name="position" class="form-control">
                  </div>
                  <div class="block-content block-content-full text-end bg-body">

                    <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
     </div>
          <!-- END Vertically Centered Block Modal -->
      <div class="modal" id="edit-product-modal" tabindex="-1" role="dialog" aria-labelledby="edit-product" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Cập nhật khách hàng</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <form id="edit-product-form" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" id="edit-product-id">
                            <div class="mb-3">
                                <label class="form-label">Công ty</label>
                                <input type="text" name="company_name" id="edit-company-name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" name="address" id="edit-address" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Điện thoại</label>
                                <input type="text" name="phone" id="edit-phone" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mã số thuế</label>
                                <input type="text" name="tax_code" id="edit-tax-code" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Người đại diện</label>
                                <input type="text" name="representative" id="edit-representative" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chức vụ</label>
                                <input type="text" name="position" id="edit-position" class="form-control">
                            </div>
                            <div class="block-content block-content-full text-end bg-body">
                                <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Huỷ</button>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
      </div> 
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
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Xử lý submit form thêm khách hàng
    const form = document.querySelector("#add-product form");

    form.addEventListener("submit", function (event) {
        let isValid = true;
        let errors = [];

        // Lấy giá trị input
        const company_name = form.querySelector('input[name="product_company"]').value.trim();
        const address = form.querySelector('input[name="address"]').value.trim();
        const phone = form.querySelector('input[name="phone"]').value.trim();
        const tax_code = form.querySelector('input[name="tax_code"]').value.trim();
        const representative = form.querySelector('input[name="representative"]').value.trim();
        const position = form.querySelector('input[name="position"]').value.trim();

        // Validate Công ty (có thể để trống nhưng nếu nhập thì phải có ít nhất 3 ký tự)
        if (company_name && company_name.length < 3) {
            isValid = false;
            errors.push("Tên công ty phải có ít nhất 3 ký tự.");
        }

        // Validate Địa chỉ
        if (address.length < 5) {
            isValid = false;
            errors.push("Địa chỉ phải có ít nhất 5 ký tự.");
        }

        // Validate Số điện thoại
        const phoneRegex = /^[0-9]{10,11}$/;
        if (!phoneRegex.test(phone)) {
            isValid = false;
            errors.push("Số điện thoại không hợp lệ (chỉ chấp nhận 10-11 số).");
        }

        // Validate Mã số thuế (có thể để trống nhưng nếu nhập thì phải là số và có độ dài hợp lệ)
        const taxCodeRegex = /^[0-9]{10}$/;
        if (tax_code && !taxCodeRegex.test(tax_code)) {
            isValid = false;
            errors.push("Mã số thuế phải gồm đúng 10 chữ số.");
        }

        // Validate Đại diện (không bắt buộc nhưng nếu nhập phải có ít nhất 3 ký tự)
        if (representative && representative.length < 3) {
            isValid = false;
            errors.push("Tên đại diện phải có ít nhất 3 ký tự.");
        }

        // Validate Chức vụ (không bắt buộc nhưng nếu nhập phải có ít nhất 3 ký tự)
        if (position && position.length < 3) {
            isValid = false;
            errors.push("Chức vụ phải có ít nhất 3 ký tự.");
        }

        // Nếu có lỗi, hiển thị thông báo và chặn submit
        if (!isValid) {
            event.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Lỗi!",
                text: errors.join("\n"),
            });
        } else {
            Swal.fire({
                icon: "success",
                title: "Thành công!",
                text: "Thêm mới khách hàng thành công!",
                timer: 2000,
                showConfirmButton: false
            });
        }
    });

    // Xử lý mở modal
    const editModal = new bootstrap.Modal(document.getElementById("edit-product-modal"));
    const editForm = document.getElementById("edit-product-form");

    document.querySelectorAll(".edit-product").forEach(button => {
        button.addEventListener("click", function () {
            // Lấy dữ liệu từ data-attributes
            const productId = this.getAttribute("data-id");
            const company_name = this.getAttribute("data-company_name");
            const address = this.getAttribute("data-address");
            const phone = this.getAttribute("data-phone");
            const tax_code = this.getAttribute("data-tax_code");
            const representative = this.getAttribute("data-representative");
            const position = this.getAttribute("data-position");

            // Gán giá trị vào modal
            document.getElementById("edit-product-id").value = productId;
            document.getElementById("edit-company-name").value = company_name;
            document.getElementById("edit-address").value = address;
            document.getElementById("edit-phone").value = phone;
            document.getElementById("edit-tax-code").value = tax_code;
            document.getElementById("edit-representative").value = representative;
            document.getElementById("edit-position").value = position;

            // Cập nhật action form
            editForm.setAttribute("action", `/products/${productId}`);

            // Hiển thị modal cập nhật
            editModal.show();
        });
    });

    // Xử lý validate form cập nhật khách hàng
    editForm.addEventListener("submit", function (event) {
        let isValid = true;
        let errors = [];

        // Lấy giá trị input
        const phone = document.getElementById("edit-phone").value.trim();
        const tax_code = document.getElementById("edit-tax-code").value.trim();
        const address = document.getElementById("edit-address").value.trim();

        // Validate Số điện thoại
        const phoneRegex = /^[0-9]{10,11}$/;
        if (!phoneRegex.test(phone)) {
            isValid = false;
            errors.push("Số điện thoại không hợp lệ (chỉ chấp nhận 10-11 số).");
        }

        // Validate Mã số thuế (có thể để trống nhưng nếu nhập thì phải là số và có đúng 10 chữ số)
        const taxCodeRegex = /^[0-9]{10}$/;
        if (tax_code && !taxCodeRegex.test(tax_code)) {
            isValid = false;
            errors.push("Mã số thuế phải gồm đúng 10 chữ số.");
        }

        // Validate Địa chỉ (không bắt buộc nhưng nếu nhập thì phải hợp lệ)
        if (address.length < 5) {
            isValid = false;
            errors.push("Địa chỉ phải có ít nhất 5 ký tự.");
        }

        // Nếu có lỗi, hiển thị và chặn submit
        if (!isValid) {
            event.preventDefault();
            Swal.fire({
                icon: "error",
                title: "Lỗi!",
                text: errors.join("\n"),
            });
        } else {
            editModal.hide();
            Swal.fire({
                icon: "success",
                title: "Thành công!",
                text: "Cập nhật khách hàng thành công!",
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
});
</script>


