@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm: ' . $textSearch . ' - Cửa hàng điện tử')

@section('content')
  <div class="main">
    <div class="container search">
      <h2 class="search title">Nội dung tìm kiếm: "{{$textSearch}}"</h2>
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
@endsection