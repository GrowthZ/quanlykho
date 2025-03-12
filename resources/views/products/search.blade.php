@extends('layouts.backend')
@section('css')
  <!-- Page JS Plugins CSS -->
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
@endsection

@section('content')

<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">
                    Tìm kiếm sản phẩm
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
                        Tìm kiếm sản phẩm
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="content">
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-lg-7 col-md-12">
                    <div class="mb-4">
                        <label for="search-codes" class="form-label fw-bold">Tìm kiếm theo danh sách mã hàng</label>
                        <textarea id="search-codes" class="form-control" rows="4" placeholder="Dán danh sách mã hàng vào đây..."></textarea>
                        <button id="btn-search" class="btn btn-primary mt-2"><i class="fa fa-search"></i> Tìm kiếm</button>
                    </div>

                    <!-- Kết quả tìm kiếm -->
                    <div class="mt-4">
                        <h5 class="fw-bold">Kết quả tìm kiếm:</h5>
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
                            <thead>
                                <tr>
                                    <!-- <th class="text-center" style="width: 80px;">#</th> -->
                                    <th>Mã SKU</th>
                                    <th>Mô tả</th>
                                    <th>Số lượng</th>
                                    <th>Giá mua</th>
                                    <th>Giá bán</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="search-results">
                                @foreach($products as $product)
                                <tr>
                                    <!-- <td class="fs-sm">{{ $product->id }}</td> -->
                                    <td class="fw-semibold fs-sm">{{ $product->code }}</td>
                                    <td class="fs-sm">{{ $product->description }}</td>
                                    <td class="fs-sm">{{ $product->quantity }}</td>
                                    <td class="fs-sm">{{ number_format($product->purchase_price, 0) }} đ</td>
                                    <td class="fs-sm">{{ number_format($product->price, 0) }} đ</td>
                                    <td class="fs-sm">
                                        <button class="btn btn-sm btn-primary add-to-cart" 
                                            data-code="{{ $product->code }}" 
                                            data-description="{{ $product->description }}"
                                            data-price="{{ number_format($product->price, 0, '.', '') }}">
                                            <i class="fa fa-cart-plus"></i> Thêm báo giá 
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="mb-4">
                        <h5 class="fw-bold">Tạo báo giá</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="use-common-factor" class="form-check-label">
                                    <input type="checkbox" id="use-common-factor" class="form-check-input"> Sử dụng hệ số chung
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" placeholder="Điền hệ số" id="common-factor" class="form-control" step="0.1" style="display: none;">
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Mã hàng</th>
                                    <th>Đơn giá</th>
                                    <th>Hệ số</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="cart-table">
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Chưa có sản phẩm nào trong báo giá</td>
                                </tr>
                                <!-- Dữ liệu giỏ hàng sẽ được cập nhật bằng JavaScript -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Tổng tiền hàng:</strong></td>
                                    <td colspan="2" id="total-amount">0</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end">
                                        <input type="checkbox" id="apply-vat"> Áp dụng VAT
                                        <input type="number" id="vat-percent" class="form-control w-25 ms-2" placeholder="%" step="0.1" min="0" max="100" style="display:none;">
                                    </td>
                                    <td colspan="2" id="vat-amount">0</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Tổng tiền:</strong></td>
                                    <td colspan="2" id="total-with-vat">0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

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
    $(document).ready(function () {
        $("#btn-search").click(function () {
        let codes = $("#search-codes").val().trim();
        if (!codes) {
            alert("Vui lòng nhập mã hàng!");
            return;
        }

        // Chuyển đổi danh sách mã hàng thành mảng
        let codeList = codes.split(/\r?\n/).map(code => code.trim()).filter(code => code !== "");

        // Gửi yêu cầu AJAX đến server
        $.ajax({
            url: "/products/search",
            method: "POST",
            data: {
                codes: codeList,
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                let tableBody = $("#search-results");
                let table = $("#products-table");
                tableBody.empty(); // Xóa dữ liệu cũ

                if (data.length === 0) {
                    tableBody.append(`<tr><td colspan="6" class="text-center text-muted">Không tìm thấy sản phẩm nào</td></tr>`);
                    return;
                }

                // Hiển thị dữ liệu tìm kiếm
                $.each(data, function (index, product) {
                    tableBody.append(`
                        <tr>
                            <td class="fs-sm">${index + 1}</td>
                            <td class="fs-sm">${product.code}</td>
                            <td class="fs-sm">${product.description}</td>
                            <td class="fs-sm">${product.quantity}</td>
                            <td class="fs-sm">${new Intl.NumberFormat('en-US').format(product.purchase_price)} đ</td>
                            <td class="fs-sm">${new Intl.NumberFormat('en-US').format(product.price)} đ</td>
                        </tr>
                    `);
                });

            },
            error: function (xhr) {
                console.error("Lỗi tìm kiếm:", xhr);
                alert("Có lỗi xảy ra khi tìm kiếm, vui lòng thử lại!");
            }
        });

       
    });

     // 🛒 Giỏ hàng
    let cart = [];
    let useCommonFactor = false;
    let commonFactor = 1;

    $("#use-common-factor").change(function () {
        let isChecked = $(this).is(":checked");

        // Hiển thị hoặc ẩn ô nhập hệ số chung
        $("#common-factor").toggle(isChecked);
        $("#common-factor").val(commonFactor);

        // Vô hiệu hóa ô hệ số của từng sản phẩm nếu checkbox được chọn
        $(".factor").prop("disabled", isChecked);
        useCommonFactor = isChecked;

        // Nếu chọn hệ số chung, cập nhật giá trị cho tất cả các sản phẩm
        if (isChecked) {
            commonFactor = parseFloat($("#common-factor").val()) || 1;
            $(".factor").val(commonFactor).trigger("input");
                cart.forEach(item => {
                item.factor = commonFactor;
            });
            updateCartTable();
        }
    });

    // Khi nhập hệ số chung, cập nhật tất cả hệ số của sản phẩm
    $("#common-factor").on("change", function () {
        commonFactor = parseFloat($(this).val()) || 1;
        $(".factor").val(commonFactor).trigger("input");
        cart.forEach(item => {
            item.factor = commonFactor;
        });
        updateCartTable();
    });

    function updateCartTable() {
        let cartTableBody = $('#cart-table');
        cartTableBody.empty();
        if (cart.length === 0) {
            cartTableBody.append(`
                <tr>
                    <td colspan="6" class="text-center text-muted">Chưa có sản phẩm nào trong báo giá</td>
                </tr>
            `);
            return;
        }   
        cart.forEach((item, index) => {
            item.total = (item.price * item.factor * item.quantity).toFixed(0);
            cartTableBody.append(`
                <tr>
                    <td>${item.code}</td>
                    <td>${new Intl.NumberFormat('en-US').format(item.price)} đ</td>
                    <td>
                        <input type="text"  pattern="[0-9]+([.,][0-9]+)?" step="0.1" class="form-control form-control-sm update-factor factor" data-index="${index}" value="${parseFloat(item.factor) || 0}" lang="en" ${useCommonFactor ? 'disabled' : ''}>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm update-quantity quantity" data-index="${index}" value="${item.quantity}" min="1">
                    </td>
                    <td class="total-price">${new Intl.NumberFormat('en-US').format((item.price * item.factor * item.quantity).toFixed(0))} đ</td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-from-cart" data-index="${index}">
                            <i class="fa fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            `);
        });
        updateTotalAmount();
    }


    $(document).on('click', '.add-to-cart', function () {
        let code = $(this).data('code');
        let description = $(this).data('description');
        let price = $(this).data('price');
        let purchasePrice = $(this).data('purchase-price');
        let factor = useCommonFactor ? commonFactor : 1;
        let total = (price * factor).toFixed(0);

        let existingProduct = cart.find(item => item.code === code);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push({ code, price, quantity: 1, factor: factor, total: total });
        }
        updateCartTable();
    });

    // 🗑 Xóa sản phẩm khỏi giỏ
    $(document).on('click', '.remove-from-cart', function () {
        let index = $(this).data('index');
        cart.splice(index, 1);
        updateCartTable();
    });

    $(document).on("change", ".quantity, .factor", function () {
        let index = $(this).data("index"); // Lấy index của item trong mảng
        let row = $(this).closest("tr");
        
        let quantity = parseInt(row.find(".quantity").val());
        let factor = parseFloat(row.find(".factor").val());
        if(isNaN(factor)) factor = 0;

        // Cập nhật giá trị trong mảng cart
        if (cart[index]) {
            cart[index].quantity = quantity;
            cart[index].factor = factor ?? 0;
            cart[index].total = (cart[index].price * quantity * factor).toFixed(2);
        }
        updateCartTable();
    });

    // 🔄 Cập nhật số lượng
    $(document).on('change', '.update-quantity', function () {
        let index = $(this).data('index');
        let newQuantity = parseInt($(this).val());
        cart[index].quantity = newQuantity;
    });

    function updateTotalAmount() {
        let totalAmount = cart.reduce((sum, item) => sum + (item.price * item.quantity * item.factor), 0);
        $("#total-amount").text(new Intl.NumberFormat('en-US').format(totalAmount.toFixed(0)) + " đ");
        updateVAT(totalAmount);
    }

    function updateVAT(totalAmount) {
        let vatPercent = parseFloat($("#vat-percent").val()) || 0;
        let vatAmount = (totalAmount * vatPercent) / 100;
        let totalWithVAT = totalAmount + vatAmount;
        console.log(totalAmount, vatPercent, vatAmount, totalWithVAT);
        $("#vat-amount").text(new Intl.NumberFormat('en-US').format(vatAmount.toFixed(0)) + " đ");
        $("#total-with-vat").text(new Intl.NumberFormat('en-US').format(totalWithVAT.toFixed(0)) + " đ");
    }

    $("#vat-percent").on("input", function () {
        updateTotalAmount();
    });

    $("#apply-vat").on("change", function () {
        if ($(this).is(":checked")) {
            $("#vat-percent").addClass("d-inline").show();
        } else {
            $("#vat-percent").removeClass("d-inline").hide().val("");
            $("#vat-amount").text("0");
            $("#total-with-vat").text($("#total-amount").text());
        }
        updateTotalAmount();
    });



});

</script>
@endsection
