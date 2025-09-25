@extends('layouts.app')

@section('title', $category->category_name . ' - Cửa hàng điện tử')

@section('content')
  <div class="main">
    <div class="container category">
      <div class="category__left">
        <div class="category-filter__box">
          <h2 class="category-filter__header">Lọc sản phẩm</h2>

          <!-- Nếu danh mục có filter -->
          @if (!empty($filters))
            <form action="{{ route('product.indexByCategory', ['category' => $category->category_id]) }}" method="get"
              id="filterForm" class="category-filter__form">
              <!-- FILTER SẮP XẾP -->
              <div class="category-filter__box__attribute">
                <h3 class="filter__name-attribute">Sắp xếp theo</h3>
                <select name="sapXep" class="form-select">
                  <option value="mac-dinh" {{ request('sapXep') == 'mac-dinh' ? 'selected' : '' }}>Mặc
                    định</option>
                  {{-- <option value="moi-nhat" {{ request('sapXep')=='moi-nhat' ? 'selected' : '' }}>Mới nhất</option> --}}
                  <option value="gia-thap-den-cao" {{ request('sapXep') == 'gia-thap-den-cao' ? 'selected' : '' }}>Giá thấp
                    đến cao
                  </option>
                  <option value="gia-cao-den-thap" {{ request('sapXep') == 'gia-cao-den-thap' ? 'selected' : '' }}>Giá cao đến
                    thấp
                  </option>
                  {{-- <option value="ban-chay" {{ request('sapXep')=='ban-chay' ? 'selected' : '' }}>Bán chạy</option> --}}
                </select>
              </div>
              <!-- Duyệt qua từng thuộc tính trong filter -->
              @foreach ($filters as $attribute => $filter)
                <div class="category-filter__box__attribute">
                  <h3 class="filter__name-attribute">{{ $filter['label'] }}</h3>

                  @foreach ($filter['values'] as $value)
                    @php
                      $safeId = strtolower(str_replace(' ', '_', $value));
                      // Kiểm tra giá trị đã được chọn chưa
                      $isChecked = in_array($value, (array) request($attribute, []));
                    @endphp

                    <label for="{{ $safeId }}" class="category-filter__label-checkbox">
                      <input type="checkbox" id="{{ $safeId }}" name="{{ $attribute }}[]" value="{{ $value }}" {{ $isChecked ? 'checked' : '' }} class="filter-checkbox">
                      {{ $value }}
                    </label>
                  @endforeach
                </div>
              @endforeach

              <!-- Filter khoảng giá -->
              <div class="category-filter__box__attribute">
                <p class="filter__name-attribute">Khoảng Giá</p>
                <div class="category-price-inputs">
                  <input type="number" name="giaThap" placeholder="₫ từ" value="{{ request('giaThap') }}" min="0">
                  <div class="category-price-inputs__bar"></div>
                  <input type="number" name="giaCao" placeholder="₫ đến" value="{{ request('giaCao') }}" min="0">
                </div>
              </div>


              <!-- Các filter ẩn khác (giữ lại category_id) -->
              <input type="hidden" name="category_id" value="{{ $category->category_id }}">

              <div class="filter__button__box">
                <button type="submit" class="filter__button" name="submit" value="filter" id="filterButton">
                  Tìm kiếm
                </button>

                <!-- Nút xóa filter -->
                <a href="{{ route('product.indexByCategory', ['category' => $category->category_id]) }}"
                  class="filter__button filter__button--clear">
                  Xóa bộ lọc
                </a>
              </div>
            </form>
          @else
            <p class="error">Chưa có bộ lọc</p>
          @endif
        </div>
      </div>

      <div class="category__right">
        @if ($products->count() > 0)
          <div class="product__item wrap">
            @foreach ($products as $product)
              <div class="product__item__card">
                <a href="">
                  <div class="product__item__card__img">
                    <img src="{{ asset('images/' . $product->image_url) }}" alt="">
                  </div>
                  <div class="product__item__card__content">
                    <h3 class="product__item__name">{{ $product->product_name }}</h3>
                    <p class="product__item_price">{{ number_format($product->price, 0, ',', '.') }}đ
                    </p>
                  </div>
                  <div class="flex product-item__quantity">
                    <p class="da-ban-text">Số lượng: {{ $product->stock }}</p>
                  </div>
                </a>
                <div class="button__addcart__box">
                  <a href="">
                    <button class="button button__addcart" type="submit" name="addcart">Mua
                      ngay</button></a>
                </div>
              </div>
            @endforeach
          </div>
          {{ $products->links('pagination::bootstrap-4') }}
        @else
          <p class="error">không có sản phẩm nào</p>
        @endif
      </div>
    </div>
  </div>
@endsection