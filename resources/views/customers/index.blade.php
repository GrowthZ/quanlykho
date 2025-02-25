@extends('layouts.backend')

@section('css')
  <!-- Page JS Plugins CSS -->
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection

@section('js')
  <!-- jQuery (required for DataTables plugin) -->
  <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

  <!-- Page JS Plugins -->
  <script src="{{ asset('js/plugins/datatables/dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

  <!-- Page JS Code -->
  @vite(['resources/js/pages/datatables.js'])
  @vite(['resources/js/pages/be_comp_dialogs.js'])
@endsection

@section('content')
  <!-- Hero -->
  <div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Quản lý khách hàng
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
              Quản lý khách hàng
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <!-- END Hero -->

  <!-- Page Content -->
  <div class="content">
    <div class="block block-rounded">
      <div class="block-header block-header-default">
        <h3 class="block-title">
          Danh sách
        </h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-customer">
          <i class="fa fa-fw fa-plus me-1"></i> Thêm mới
        </button>
      </div>
      <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
          <thead>
              <tr>
                  <th><a href="?sort=company_name">Công ty</a></th>
                  <th>Địa chỉ</th>
                  <th>Điện thoại</th>
                  <th><a href="?sort=representative">Người đại diện</a></th>
                  <th>Chức vụ</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
          <tbody>
              @foreach($customers as $customer)
                  <tr>
                      <td>{{ $customer->company_name }}</td>
                      <td>{{ $customer->address }}</td>
                      <td>{{ $customer->phone }}</td>
                      <td>{{ $customer->representative }}</td>
                      <td>{{ $customer->position }}</td>
                      <td>
                          <!-- <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Sửa</a> -->
                          <a href="javascript:void(0)" class="edit-customer"  data-bs-toggle="tooltip" title="Chỉnh sửa thông tin"
                            data-id="{{ $customer->id }}" 
                            data-company_name="{{ $customer->company_name }}" 
                            data-address="{{ $customer->address }}" 
                            data-phone="{{ $customer->phone }}" 
                            data-tax_code="{{ $customer->tax_code }}" 
                            data-representative="{{ $customer->representative }}" 
                            data-position="{{ $customer->position }}">
                            <i class="fa fa-fw fa-edit me-1 text-primary"></i>
                          </a>
                          <form action="{{ route('customers.destroy', $customer) }}" method="POST" style="display:inline;">
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
        {{ $customers->links() }}
      </div>
    </div>
    <!-- END Dynamic Table Full -->
     <!-- Vertically Centered Block Modal -->
     <div class="modal" id="add-customer" tabindex="-1" role="dialog" aria-labelledby="add-customer" aria-hidden="true">
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
              <form action="{{ route('customers.store') }}" method="POST">
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
      <div class="modal" id="edit-customer-modal" tabindex="-1" role="dialog" aria-labelledby="edit-customer" aria-hidden="true">
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
                        <form id="edit-customer-form" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="customer_id" id="edit-customer-id">
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
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Xử lý submit form thêm khách hàng
    const form = document.querySelector("#add-customer form");

    form.addEventListener("submit", function (event) {
        let isValid = true;
        let errors = [];

        // Lấy giá trị input
        const company_name = form.querySelector('input[name="customer_company"]').value.trim();
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

    // Xử lý mở modal cập nhật khách hàng
    const editModal = new bootstrap.Modal(document.getElementById("edit-customer-modal"));
    const editForm = document.getElementById("edit-customer-form");

    document.querySelectorAll(".edit-customer").forEach(button => {
        button.addEventListener("click", function () {
            // Lấy dữ liệu từ data-attributes
            const customerId = this.getAttribute("data-id");
            const company_name = this.getAttribute("data-company_name");
            const address = this.getAttribute("data-address");
            const phone = this.getAttribute("data-phone");
            const tax_code = this.getAttribute("data-tax_code");
            const representative = this.getAttribute("data-representative");
            const position = this.getAttribute("data-position");

            // Gán giá trị vào modal
            document.getElementById("edit-customer-id").value = customerId;
            document.getElementById("edit-company-name").value = company_name;
            document.getElementById("edit-address").value = address;
            document.getElementById("edit-phone").value = phone;
            document.getElementById("edit-tax-code").value = tax_code;
            document.getElementById("edit-representative").value = representative;
            document.getElementById("edit-position").value = position;

            // Cập nhật action form
            editForm.setAttribute("action", `/customers/${customerId}`);

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


