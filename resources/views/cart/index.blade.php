@extends('layouts.app')

@section('title', 'Giỏ Hàng - Cửa hàng điện tử')

@section('css')
  <style>
    .cart-item {
      border-bottom: 1px solid #eee;
      padding: 1rem 0;
    }

    .product-image {
      max-width: 100px;
      height: auto;
    }

    .quantity-input {
      width: 80px;
      text-align: center;
    }

    .cart-summary {
      background: #f8f9fa;
      padding: 1.5rem;
      border-radius: 0.5rem;
    }

    small.text-muted {}
  </style>
@endsection

@section('content')
  <div class="container py-4">
    <div class="row">
      <div class="col-12">
        <h1 class="h3 mb-4">
          <i class="fas fa-shopping-cart me-2"></i>Giỏ Hàng
        </h1>
      </div>
    </div>

    @if($cart->cartItems->count() > 0)
      {{-- <div class="row"> --}}
        <!-- Danh sách sản phẩm -->
        <div class="card">
          <div class="card-body">
            @foreach($cart->cartItems as $item)
              <div class="cart-item row align-items-center">
                <div class="col-md-2">
                  <img src="{{ asset('images/' . $item->product->image_url) ?? '' }}" alt="{{ $item->product->name }}"
                    class="img-fluid product-image">
                </div>
                <div class="col-md-4">
                  <h5 class="mb-1">{{ $item->product->product_name }}</h5>
                  <p class="text-muted mb-0">{{ number_format($item->product->price, 0, ',', '.') }}đ</p>
                </div>
                <div class="col-md-3 text-center">
                  <div class="input-group input-group-sm">
                    <button class="btn btn-update-quantity" type="button" data-product-id="{{ $item->product_id }}"
                      data-action="decrease">
                      <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" class="form-control quantity-input" value="{{ $item->quantity }}" min="1"
                      max="{{ $item->product->stock }}" data-product-id="{{ $item->product_id }}">
                    <button class="btn btn-update-quantity" type="button" data-product-id="{{ $item->product_id }}"
                      data-action="increase">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                  <small class="text-muted">Còn: {{ $item->product->stock }} sản phẩm</small>
                </div>
                <div class="col-md-2 text-center">
                  <strong class="text-danger item-total" data-product-id="{{ $item->product_id }}">
                    {{ $item->thanh_tien_formatted }}
                  </strong>
                </div>
                <div class="col-md-1 text-end">
                  <button class="btn btn-outline-danger btn-sm btn-remove" data-product-id="{{ $item->product_id }}"
                    title="Xóa sản phẩm">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Nút xóa toàn bộ -->
        <div class="mt-3 text-end">
          <button class="btn btn-outline-danger" id="btn-clear-cart">
            <i class="fas fa-trash me-1"></i>Xóa Toàn Bộ Giỏ Hàng
          </button>
        </div>

        <!-- Tổng kết giỏ hàng -->
        <div class="col-lg-4">
          <div class="cart-summary">
            <h5 class="mb-3">Tổng Kết Giỏ Hàng</h5>

            <div class="d-flex justify-content-between mb-2">
              <span>Tổng số lượng:</span>
              <strong id="cart-total-quantity">{{ $cart->tong_so_luong }}</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
              <span>Tổng tiền:</span>
              <strong class="text-danger h5" id="cart-total-amount">
                {{ number_format($cart->tong_tien, 0, ',', '.') }}đ
              </strong>
            </div>

            <button class="btn btn-primary w-100 mb-2">
              <i class="fas fa-credit-card me-1"></i>Tiến Hành Thanh Toán
            </button>

            <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100">
              <i class="fas fa-shopping-bag me-1"></i>Tiếp Tục Mua Hàng
            </a>
          </div>
        </div>
        {{--
      </div> --}}
    @else
      <!-- Giỏ hàng trống -->
      <div class="text-center py-5">
        <div class="mb-4">
          <i class="fas fa-shopping-cart fa-4x text-muted"></i>
        </div>
        <h3 class="text-muted">Giỏ hàng của bạn đang trống</h3>
        <p class="text-muted mb-4">Hãy thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm</p>
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
          <i class="fas fa-shopping-bag me-2"></i>Mua Sắm Ngay
        </a>
      </div>
    @endif
  </div>

  <!-- Loading Spinner -->
  <div class="modal fade" id="loadingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <div class="spinner-border text-primary mb-2" role="status"></div>
          <p class="mb-0">Đang xử lý...</p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection

@section('js')
  <script>
    $(document).ready(function () {
      // Hiển thị loading
      function showLoading() {
        // $('#loadingModal').modal('show');
      }

      // Ẩn loading
      function hideLoading() {
        // $('#loadingModal').modal('hide');
      }

      // Hiển thị thông báo
      function showAlert(message, type = 'success') {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
                                                    <div class="alert ${alertClass} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" role="alert">
                                                        ${message}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                                    </div>
                                                `;
        $('body').append(alertHtml);
        setTimeout(() => $('.alert').alert('close'), 3000);
      }

      // Cập nhật số lượng
      $('.btn-update-quantity').on('click', function () {
        const productId = $(this).data('product-id');
        const action = $(this).data('action');
        const input = $(`.quantity-input[data-product-id="${productId}"]`);
        let quantity = parseInt(input.val());

        if (action === 'increase') {
          quantity++;
        } else if (action === 'decrease' && quantity > 1) {
          quantity--;
        }

        input.val(quantity);
        updateQuantity(productId, quantity);
      });

      // Cập nhật khi thay đổi trực tiếp trong input
      $('.quantity-input').on('change', function () {
        const productId = $(this).data('product-id');
        const quantity = parseInt($(this).val());
        const maxStock = parseInt($(this).attr('max'));

        if (quantity > maxStock) {
          $(this).val(maxStock);
          showAlert('Số lượng vượt quá tồn kho', 'danger');
          updateQuantity(productId, maxStock);
        } else if (quantity < 1) {
          $(this).val(1);
          updateQuantity(productId, 1);
        } else {
          updateQuantity(productId, quantity);
        }
      });

      // Gọi API cập nhật số lượng
      function updateQuantity(productId, quantity) {
        showLoading();
        console.log('1. Bắt đầu updateQuantity');
        $.ajax({
          url: '{{ route("cart.update") }}',
          method: 'PUT',
          data: {
            product_id: productId,
            quantity: quantity,
            _token: '{{ csrf_token() }}'
          },
          success: function (response) {
            console.log('2. Vào success');
            if (response.success) {
              console.log('3. Response success');
              // Cập nhật tổng tiền item
              $(`.item-total[data-product-id="${productId}"]`).text(response.item_total_formatted);

              // Cập nhật tổng giỏ hàng
              $('#cart-total-quantity').text(response.cart_total);
              $('#cart-total-amount').text(response.cart_amount_formatted ||
                new Intl.NumberFormat('vi-VN').format(response.cart_amount) + 'đ');

              showAlert(response.message);
            } else {
              console.log('4. Response không success');
              showAlert(response.message, 'danger');
            }
            console.log('5. Kết thúc success');
          },
          error: function (xhr) {
            console.log('6. Vào error');
            const response = xhr.responseJSON;
            showAlert(response?.message || 'Có lỗi xảy ra', 'danger');
          },
          complete: function () {
            console.log('7. Vào complete');
            hideLoading();
            // setTimeout(hideLoading, 100);
          }
        });
        console.log('8. Sau khi gọi AJAX');
      }

      // Xóa sản phẩm
      $('.btn-remove').on('click', function () {
        if (!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
          return;
        }

        const productId = $(this).data('product-id');
        showLoading();

        $.ajax({
          url: '{{ route("cart.remove") }}',
          method: 'DELETE',
          data: {
            product_id: productId,
            _token: '{{ csrf_token() }}'
          },
          success: function (response) {
            if (response.success) {
              // Xóa item khỏi DOM
              $(`.cart-item:has(button[data-product-id="${productId}"])`).remove();

              // Cập nhật tổng giỏ hàng
              $('#cart-total-quantity').text(response.cart_total);
              $('#cart-total-amount').text(
                new Intl.NumberFormat('vi-VN').format(response.cart_amount) + 'đ'
              );

              // Nếu giỏ hàng trống, reload trang
              if (response.cart_total === 0) {
                location.reload();
              }

              showAlert(response.message);
            } else {
              showAlert(response.message, 'danger');
            }
          },
          error: function (xhr) {
            const response = xhr.responseJSON;
            showAlert(response?.message || 'Có lỗi xảy ra', 'danger');
          },
          complete: function () {
            hideLoading();
          }
        });
      });

      // Xóa toàn bộ giỏ hàng
      $('#btn-clear-cart').on('click', function () {
        if (!confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')) {
          return;
        }

        showLoading();

        $.ajax({
          url: '{{ route("cart.clear") }}',
          method: 'DELETE',
          data: {
            _token: '{{ csrf_token() }}'
          },
          success: function (response) {
            if (response.success) {
              location.reload();
            } else {
              showAlert(response.message, 'danger');
            }
          },
          error: function (xhr) {
            const response = xhr.responseJSON;
            showAlert(response?.message || 'Có lỗi xảy ra', 'danger');
          },
          complete: function () {
            hideLoading();
          }
        });
      });
    });
  </script>
@endsection