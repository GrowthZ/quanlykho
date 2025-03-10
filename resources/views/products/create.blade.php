@extends('layouts.backend')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
        <div class="flex-grow-1">
          <h1 class="h3 fw-bold mb-1">
            Thêm mới sản phẩm
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
                Thêm mới sản phẩm
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading">Thông tin sản phẩm</h2>
            <form id="product-form" class="js-validation" method="POST" action="{{ route('products.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label" for="code">Mã sản phẩm <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="code" name="code" required>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="description">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="price">Giá sản phẩm <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="quantity">Số lượng <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                </div>
                <!-- <div class="mb-4">
                    <label class="form-label" for="category_id">Danh mục <span class="text-danger">*</span></label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Chọn danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div> -->
                <!-- Xuất xứ -->
                <div class="mb-4">
                    <label class="form-label" for="origin">Xuất xứ</label>
                    <input type="text" class="form-control" id="origin" name="origin">
                </div>
                <!-- Trạng thái -->
                <div class="mb-4">
                    <label class="form-label" for="status">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="1">Hoạt động</option>
                        <option value="0">Ngưng sản xuất</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="image">Ảnh sản phẩm</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                

                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
