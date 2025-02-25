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
            Quản lý người dùng
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
              Quản lý người dùng
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-user">
          <i class="fa fa-fw fa-plus me-1"></i> Thêm mới
        </button>
      </div>
      <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full fs-sm">
          <thead>
            <tr>
                <th class="text-center" style="width: 80px;">#</th>
                <th>Tên</th>
                <th class="d-none d-sm-table-cell" >Email</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
            </tr>
          </thead>
          <tbody>
              @foreach ($users as $index => $user)
                  <tr>
                      <td class="text-center">{{ $index + 1 }}</td>
                      <td class="fw-semibold">
                          <a href="javascript:void(0)" class="edit-user" 
                            data-id="{{ $user->id }}" 
                            data-name="{{ $user->name }}" 
                            data-email="{{ $user->email }}" 
                            data-role="{{ $user->role }}" 
                            data-status="{{ $user->status }}">
                              {{ $user->name }}
                          </a>
                      </td>
                      <td class="d-none d-sm-table-cell">{{ $user->email }}</td>
                      <td class="text-muted">
                        @switch($user->role)
                            @case('user')
                                Người dùng
                                @break
                            @case('manager')
                                Quản lý
                                @break
                            @case('admin')
                                Admin
                                @break
                            @default
                                Không xác định
                        @endswitch
                    </td>                      
                    <td class="{{ $user->status == 'active' ? 'text-success' : 'text-danger' }}">{{ $user->status == 'active' ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</td>
                  </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- END Dynamic Table Full -->
     <!-- Vertically Centered Block Modal -->
     <div class="modal" id="add-user" tabindex="-1" role="dialog" aria-labelledby="add-user" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
              <div class="block-header block-header-default">
                <h3 class="block-title">Thêm mới người dùng</h3>
                <div class="block-options">
                  <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-fw fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="block-content fs-sm">
              <form action="{{ route('users.store') }}" method="POST">
                  @csrf
                  <div class="mb-3">
                      <label class="form-label">Tên</label>
                      <input type="text" name="name" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Mật khẩu</label>
                      <input type="password" name="password" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Xác nhận mật khẩu</label>
                      <input type="password" name="password_confirmation" class="form-control" required>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Vai trò</label>
                      <select name="role" class="form-control" required>
                          <option value="user">Người dùng</option>
                          <option value="manager">Quản lý</option>
                          <option value="admin">Admin</option>
                      </select>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Trạng thái</label>
                      <select name="status" class="form-control" required>
                          <option value="active">Hoạt động</option>
                          <option value="inactive">Không hoạt động</option>
                      </select>
                  </div>
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
          <!-- END Vertically Centered Block Modal -->
      <div class="modal" id="edit-user-modal" tabindex="-1" role="dialog" aria-labelledby="edit-user" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Cập nhật người dùng</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <form id="edit-user-form" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" id="edit-user-id">

                            <div class="mb-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" id="edit-name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="edit-email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                            <label class="form-label">Mật khẩu mới (bỏ trống nếu không đổi)</label>
                                <input type="password" name="new_password" id="edit-password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" name="new_password_confirmation" id="edit-password-confirm" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Vai trò</label>
                                <select name="role" id="edit-role" class="form-control" required>
                                    <option value="user">Người dùng</option>
                                    <option value="manager">Quản lý</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" id="edit-status" class="form-control" required>
                                    <option value="active">Hoạt động</option>
                                    <option value="inactive">Không hoạt động</option>
                                </select>
                            </div>
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
    // Xử lý submit form thêm user
    const form = document.querySelector("#add-user form");

    form.addEventListener("submit", function (event) {
        let isValid = true;
        let errors = [];

        // Lấy giá trị input
        const name = form.querySelector('input[name="name"]').value.trim();
        const email = form.querySelector('input[name="email"]').value.trim();
        const password = form.querySelector('input[name="password"]').value.trim();
        const confirmPassword = form.querySelector('input[name="password_confirmation"]').value.trim();
        const role = form.querySelector('select[name="role"]').value;
        const status = form.querySelector('select[name="status"]').value;

        // Validate Tên
        if (name.length < 3) {
            isValid = false;
            errors.push("Tên phải có ít nhất 3 ký tự.");
        }

        // Validate Email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            isValid = false;
            errors.push("Email không hợp lệ.");
        }

        // Validate Mật khẩu
        if (password.length < 6) {
            isValid = false;
            errors.push("Mật khẩu phải có ít nhất 6 ký tự.");
        }

        if (password !== confirmPassword) {
            isValid = false;
            errors.push("Mật khẩu xác nhận không khớp.");
        }

        // Nếu có lỗi, hiển thị và chặn submit
        if (!isValid) {
            event.preventDefault();
            alert(errors.join("\n")); // Hoặc có thể hiển thị ở phần riêng trong modal
        }
    });

    // Xử lý mở modal cập nhật user
    const editModal = new bootstrap.Modal(document.getElementById("edit-user-modal"));
    const editForm = document.getElementById("edit-user-form");

    document.querySelectorAll(".edit-user").forEach(user => {
        user.addEventListener("click", function () {
            // Lấy dữ liệu từ data-attributes
            const userId = this.getAttribute("data-id");
            const userName = this.getAttribute("data-name");
            const userEmail = this.getAttribute("data-email");
            const userRole = this.getAttribute("data-role");
            const userStatus = this.getAttribute("data-status");

            // Gán giá trị vào modal
            document.getElementById("edit-user-id").value = userId;
            document.getElementById("edit-name").value = userName;
            document.getElementById("edit-email").value = userEmail;
            document.getElementById("edit-role").value = userRole;
            document.getElementById("edit-status").value = userStatus;
            document.getElementById("edit-password").value = "";
            document.getElementById("edit-password-confirm").value = "";

            // Cập nhật action form
            editForm.setAttribute("action", `/users/${userId}`);

            // Hiển thị modal cập nhật
            editModal.show();
        });
    });

    // Xử lý validate form cập nhật user
    editForm.addEventListener("submit", function (event) {
        let isValid = true;
        let errors = [];

        // Lấy giá trị input
        const password = document.getElementById("edit-password").value.trim();
        const confirmPassword = document.getElementById("edit-password-confirm").value.trim();

        // Nếu nhập mật khẩu mới thì kiểm tra
        if (password.length > 0) {
            if (password.length < 6) {
                isValid = false;
                errors.push("Mật khẩu mới phải có ít nhất 6 ký tự.");
            }
            if (password !== confirmPassword) {
                isValid = false;
                errors.push("Mật khẩu xác nhận không khớp.");
            }
        }

        // Nếu có lỗi, hiển thị và chặn submit
        if (!isValid) {
            event.preventDefault();
            alert(errors.join("\n"));
        }else{
            editModal.hide();
            Swal.fire({
                    icon: "success",
                    title: "Thành công!",
                    text: "Cập nhật người dùng thành công!",
                    timer: 2000,
                    showConfirmButton: false
                });
        }
    });
});
</script>

