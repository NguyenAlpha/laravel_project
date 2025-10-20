@extends('frontend.layouts.app')

@section('title', $product->product_name . ' - Cửa hàng điện tử')

@section('content')
  <div class="container">
    <div class="product__detail">
      <div class="product__detail__box1">
        <!-- phần bên trái -->
        <div class="product__detail--left">
          <!-- hình ảnh sản phẩm-->
          <img src="{{asset('images/' . $product->image_url)}}" alt="">
        </div>

        <!-- phần bên phải -->
        <div class="product__detail--right">
          <!-- tên sản phẩm -->
          <h1 class="product__detail__name">{{$product->product_name}}</h1>

          <!-- giá sản phẩm -->
          <h2 class="product__detail__price">{{ number_format($product->price, 0, ',', '.') }}đ</h2>
          {{-- action="{{route('cart.adds')}}" --}}
          <form method="post">
            @csrf

            <input type="number" name="product_id" value='{{$product->product_id}}' class='d-none'>
            <div class="flex">
              @if($product->stock == -1)
                <p>Hết hàng</p>
              @else
                <p class="product__count">Số Lượng</p>
                <input class="form-control input-number" type="number" name='quantity' value="1" min='1'
                  max='{{$product->stock}}' style="width: 80px">
                <p>còn {{$product->stock}}</p>
              @endif

            </div>

            <!-- các nút mua, giỏ hàng -->
            <div class="product__button__buy__cart">
              <button formaction='{{ route('cart.buyNow')}}' class="product__detail__buy" type="submit" name="buyNow" value="buyNow" @if ($product->stock == 0)
              disabled @endif>
                MUA NGAY
              </button>

              <button formaction='{{ route('cart.addToCart')}}' class="product__detail__cart" type="submit" @if ($product->stock == 0) disabled @endif>
                <i class="fa-solid fa-cart-plus"></i>
                THÊM VÀO GIỎ HÀNG
              </button>
            </div>
          </form>
        </div>
      </div>
      {{-- <div class="product__detail__box2">
        <h2 class="product__detail__title">Thông Số Kỹ Thuật</h2>

        <?php if (!empty($details)):?>
        <table class="product__detail__list">
          <?php  foreach ($attributes as $nameAttributeVN => $nameAttributeInDB):?>
          <?php    if (isset($details[$nameAttributeInDB])):?>
          <tr>
            <td>
              <?=$nameAttributeVN?>
            </td>
            <td>
              <?=$details[$nameAttributeInDB]?>
            </td>
          </tr>
          <?php    endif;?>
          <?php  endforeach;?>
        </table>
        <?php else:?>
        <p class="error">Chưa có thông số</p>
        <?php endif;?>
      </div> --}}

      <!-- Tab thông số kỹ thuật -->
      <div class="product__detail__list tab-pane fade show active" id="specs" role="tabpanel">
        @if($product->getDetail())
          <table class="table table-striped">
            <tbody>
              @foreach($product->getAttributeLabels() as $attribute => $label)
                @if(!empty($product->getDetail()->$attribute))
                  <tr>
                    <td style="width: 30%;"><strong>{{ $label }}:</strong></td>
                    <td>{{ $product->getDetail()->$attribute }}</td>
                  </tr>
                @endif
              @endforeach
            </tbody>
          </table>
        @else
          <p class="text-muted">Chưa có thông tin chi tiết cho sản phẩm này.</p>
        @endif
      </div>

      <!-- Sản phẩm cùng loại -->
      @if($relatedProducts->count() > 0)
        <div class="product__detail__box3">
          <div class="home-page header-product-bar">
            <h2 class="home-page name-product-bar">Sản phầm cùng Loại</h2>
            <div class="home-page line"></div>
            <a href="{{route('product.indexByCategory', ['category_id' => $product->category_id])}}"
              class="home-page see-more">
              xem tất cả
              <i class="fa fa-angle-double-right"></i>
            </a>
          </div>
          <div class="product__item wrap">
            @foreach ($relatedProducts as $product)
              <div class="product__item__card">
                <a href="{{ route('product.show', ['productId' => $product->product_id])}}">
                  <div class="product__item__card__img">
                    <img src="{{ asset('images/' . $product->image_url) }}" alt="">
                  </div>
                  <div class="product__item__card__content">
                    <h3 class="product__item__name">{{ $product->product_name }}</h3>
                    <p class="product__item_price">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                  </div>
                  <div class="flex product-item__quantity">
                    <p class="da-ban-text">Số lượng: {{ $product->stock }}</p>
                  </div>
                </a>
                <div class="button__addcart__box">
                  <a href="{{route('cart.add', ['productId' => $product->product_id, 'quantity' => 1])}}">
                    <button class="button button__addcart" type="submit" name="addcart">
                      Mua ngay
                    </button>
                  </a>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      {{--
      <?php if (!empty($BSP)):?>
      <div class="product__detail__box3">
        <div class="home-page header-product-bar">
          <h2 class="home-page name-product-bar">Sản phầm bán chạy</h2>
          <div class="home-page line"></div>
          <!-- <a href="./index.php" class="home-page see-more">xem tất cả<i class="fa fa-angle-double-right"></i></a> -->
        </div>
        <div class="product__item wrap">
          <?php  foreach ($BSP as $item): ?>
          <div class="product__item__card">
            <a href="./index.php?controller=product&action=show&id=<?=$item[" MaSP"]?>">
              <div class="product__item__card__img">
                <img src="<?=$item['AnhMoTaSP']?>" alt="">
              </div>
              <div class="product__item__card__content">
                <h3 class="product__item__name">
                  <?=$item["TenSP"]?>
                </h3>
                <p class="product__item_price">
                  <?=number_format($item["Gia"], 0, ',', '.') . "đ"?>
                </p>
              </div>
              <div class="flex product-item__quantity">
                <p class="da-ban-text">Số lượng:
                  <?=$item['SoLuong']?>
                </p>
                <p class="da-ban-text">Đã bán:
                  <?=$item['DaBan']?>
                </p>
              </div>
            </a>
            <div class="button__addcart__box">
              <a href="?controller=cart&action=addProduct&MaSP=<?=$item['MaSP']?>&quantity=1"><button
                  class="button button__addcart" type="submit" name="addcart">Mua ngay</button></a>
            </div>
          </div>
          <?php  endforeach; ?>
        </div>
      </div>
      <?php endif;?> --}}
    </div>
  </div>
@endsection

@section('js')
  <script>
    function initQuantityHandlersDetail() {
      const input = document.querySelector('.input-number');
      const min = parseInt(input.min);
      const max = parseInt(input.max);

      input.addEventListener('input', () => {
        console.log('event input-number');
        input.value = input.value.replace(/\D/g, '');
        let value = parseInt(input.value);
        if (value > max) input.value = max;
        if (value < min || isNaN(value)) input.value = min;
      });
    };

    initQuantityHandlersDetail()
  </script>
@endsection