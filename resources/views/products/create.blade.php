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
  @if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
  @endif
  <div class="content">
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <h2 class="content-heading">Thông tin sản phẩm</h2>
              <form id="product-form" class="js-validation" method="POST" action="{{ route('products.store') }}">
                  @csrf
                  <div class="mb-4">
                      <label class="form-label" for="code">Mã sản phẩm <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required>
                      @error('code')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-4">
                      <label class="form-label" for="description">Mô tả</label>
                      <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                      @error('description')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-4">
                      <label class="form-label" for="purchase_price">Giá nhập</label>
                      <input type="number" class="form-control @error('purchase_price') is-invalid @enderror" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}">
                      @error('purchase_price')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-4">
                      <label class="form-label" for="price">Giá bán</label>
                      <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}">
                      @error('price')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-4">
                      <label class="form-label" for="quantity">Số lượng <span class="text-danger">*</span></label>
                      <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required min="0">
                      @error('quantity')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-4">
                      <label class="form-label" for="weight">Trọng lượng</label>
                      <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}">
                      @error('weight')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-4">
                      <label class="form-label" for="category_id">Danh mục <span class="text-danger">*</span></label>
                      <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                          <option value="">Chọn danh mục</option>
                          @foreach ($categories as $category)
                              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                  {{ $category->name }}
                              </option>
                          @endforeach
                      </select>
                      @error('category_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-4">
                      <label class="form-label" for="origin">Xuất xứ</label>
                      <input type="text" class="form-control @error('origin') is-invalid @enderror" id="origin" name="origin" value="{{ old('origin') }}">
                      @error('origin')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-4">
                      <label class="form-label" for="status">Trạng thái</label>
                      <select class="form-select" id="status" name="status">
                          <option value="1">Hoạt động</option>
                          <option value="0">Ngưng sản xuất</option>
                      </select>
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
