@extends('layouts.backend')
@section('content')

<div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Import sản phẩm
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
            Import sản phẩm
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-content block-content-full">
            <form id="importForm" enctype="multipart/form-data">
                @csrf
                <!-- <div class="mb-4"> -->
                    <!-- <label class="form-label" for="example-file-input">Chọn file import</label> -->
                    <!-- <input class="form-control" type="file" id="excel_file" name="excel_file" accept=".xls,.xlsx,.csv"> -->
                    <div class="mb-4">
                        <label for="excel_file" class="form-label  d-block">Chọn file (Định dạng: XLSX, CSV)</label>
                        <input class="form-control d-none" type="file" id="excel_file" name="excel_file" accept=".xls,.xlsx,.csv">
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('excel_file').click();">
                            <i class="fa fa-upload"></i> Chọn file
                        </button>
                        <span id="file-name" class="ms-2 text-muted">Chưa có file nào được chọn</span>
                    </div>
                <!-- </div> -->
            </form>
            <hr>
            <!-- Chọn cột để import -->
            <div id="columnSelection" style="display: none;">
                <h3>Chọn cột để Import</h3>
                <div id="columnCheckboxes"></div>
            </div>
            <hr>

            <!-- Hiển thị DataTable -->
            <div class="table-responsive">
                <!-- Bảng preview dữ liệu -->
                <table id="previewTable" class="table table-bordered" style="display: none;">
                    <thead>
                        <tr id="previewHeaders"></tr>
                    </thead>
                    <tbody id="previewBody"></tbody>
                </table>
            </div>
            <button class="btn btn-primary" id="importButton" style="display: none;">Nhập dữ liệu</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    let originalData = [];
    let allowedColumns = [];

    document.getElementById("excel_file").addEventListener("change", function () {
        let fileName = this.files.length > 0 ? this.files[0].name : "Chưa có file nào được chọn";
        document.getElementById("file-name").textContent = fileName;
    });

    $("#excel_file").change(function() {
        var formData = new FormData();
        formData.append("excel_file", $("#excel_file")[0].files[0]);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('products.import.preview') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $("#previewTable").show();
                    $("#previewHeaders").empty();
                    $("#previewBody").empty();
                    $("#columnSelection").show();
                    $("#columnCheckboxes").empty();

                    originalData = response.data;
                    allowedColumns = response.allowedColumns;


                    response.headers.forEach((header, index) => {
                        let isAllowed = allowedColumns.includes(header); // Kiểm tra có trong DB không
                        let isCodeField = header.toLowerCase() == "code"; // Kiểm tra nếu là 'code'

                        $("#columnCheckboxes").append(`
                            <label>
                                <input type="checkbox" class="column-checkbox" value="${index}" data-name="${header}"
                                    ${isAllowed ? 'checked' : 'disabled'}
                                    ${isCodeField ? 'checked readonly' : ''}> 
                                ${header} ${isAllowed ? '' : '(Không hợp lệ)'}
                            </label><br>
                        `);
                    });

                    updatePreview();

                    $(".column-checkbox").change(function() {
                        updatePreview();
                    });

                    $("#importButton").show();
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    function updatePreview() {
        let selectedColumns = [];
        $(".column-checkbox:checked:not(:disabled)").each(function() {
            selectedColumns.push($(this).val());
        });

        $("#previewHeaders").empty();
        $("#previewBody").empty();

        if (selectedColumns.length === 0) {
            $("#previewTable").hide();
            return;
        } else {
            $("#previewTable").show();
        }

        $(".column-checkbox:checked").each(function() {
            let index = $(this).val();
            let columnName = $(this).parent().text().trim();
            $("#previewHeaders").append(`<th>${columnName}</th>`);
        });

        originalData.slice(0, 5).forEach(row => {
            let rowHtml = "<tr>";
            selectedColumns.forEach(index => {
                rowHtml += `<td>${row[index] ?? ''}</td>`;
            });
            rowHtml += "</tr>";
            $("#previewBody").append(rowHtml);
        });
    }

    $("#importButton").click(function() {
        let selectedColumns = {};
        $(".column-checkbox:checked:not(:disabled)").each(function() {
            let columnIndex = $(this).val(); 
            let columnName = $(this).data('name');

            selectedColumns[columnName] = parseInt(columnIndex);
        });
        console.log(selectedColumns);

        if (Object.keys(selectedColumns).length === 0) {
            alert("Vui lòng chọn ít nhất một cột hợp lệ để import.");
            return;
        }

        var formData = new FormData();
        formData.append("excel_file", $("#excel_file")[0].files[0]);
        formData.append("selected_columns", JSON.stringify(selectedColumns));
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('products.import.process') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert("Nhập dữ liệu thành công!");
                location.reload();
            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });
});

</script>
  @endsection

