<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Cửa hàng điện tử')</title>

  <!-- font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

  <!-- icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  {{-- jquery --}}
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  {{-- Bootstrap JavaScript Bundle --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- link css --}}
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/header.css')}}">
  <link rel="stylesheet" href="{{asset('css/product/product-card.css')}}">
  <link rel="icon" type="image/png" href="{{asset('images/logo.png')}}">
  @yield('css')

  <script src="{{ asset('js/frontend/global-functions.js') }}"></script>
  {{--
  <script src="./assets/javascript/even.js"></script> --}}
  {{--
  <script src="./assets/javascript/add.js"></script> --}}
  {{--
  <script src="./assets/javascript/edit.js"></script> --}}
</head>

<body>
  <header>
    <div class="header">
      <div class="container-fluid px-3 px-lg-4">
        <div class="row align-items-center header-container">
          <div class="col-6 col-md-2 col-lg-2 header__logo">
            <a href="{{route("home")}}"><img src="{{asset('images/logo.png')}}" alt="Logo" class="img-fluid"></a>
          </div>
          <div class="col-12 col-md-6 col-lg-6 order-md-2 order-lg-2 mt-2 mt-md-0 header__search">
            <form action="{{route("search")}}" method="get">
              @if (isset($textSearch) && $textSearch)
                <input class="header-search__input form-control" type="text" name="search" value="{{ $textSearch }}"
                  placeholder="Tìm kiếm sản phẩm">
              @else
                <input class="header-search__input form-control" type="text" name="search"
                  placeholder="Tìm kiếm sản phẩm">
              @endif
              <button class="header-search__submit" type="submit" name='submit' value="search">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span class="d-none d-sm-inline">tìm kiếm</span>
              </button>
            </form>
          </div>
          <div class="col-6 col-md-4 col-lg-4 order-md-3 order-lg-3 header__action">
            <div class="d-flex justify-content-end align-items-center flex-wrap">
              <a href="tel:0888999" class="d-none d-lg-block">
                <div class="header__item">
                  <i class="fa-solid fa-phone"></i>
                  <span>Hotline</span>
                </div>
              </a>

              <a href="{{route(('cart.index'))}}">
                <div class="header__item">
                  <i class="fa-solid fa-cart-shopping"></i>
                  <span class="d-none d-sm-inline">Giỏ hàng</span>
                </div>
              </a>

              {{-- auth default 'web', @auth('employee') for employee --}}
              @auth
                {{-- Hiển thị khi user đã đăng nhập --}}
                <a href="{{ route('profile.show') }}" class="d-none d-md-block">
                  <div class="header__item">
                    <i class="fa-solid fa-user"></i>
                    <span>Tài khoản</span>
                  </div>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                  {{-- Cross-Site Request Forgery (Tấn công giả mạo yêu cầu) --}}
                  @csrf
                  <button type="submit" class="header__item" style="border: none; background: transparent;">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="d-none d-lg-inline">Đăng xuất</span>
                  </button>
                </form>
              @else
                {{-- Hiển thị khi user chưa đăng nhập --}}
                <a href="{{ route('login') }}">
                  <div class="header__item">
                    <i class="fa-solid fa-user"></i>
                    <span class="d-none d-sm-inline">Đăng Nhập</span>
                  </div>
                </a>

                <a href="{{ route('register') }}" class="d-none d-md-block">
                  <div class="header__item">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Đăng ký</span>
                  </div>
                </a>
              @endauth
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="navbar shadow">
      <div class="container-fluid navbar-container">
        <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <i class="fa-solid fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse d-md-block" id="navbarNav">
          <ul class='d-flex flex-column flex-md-row flex-wrap justify-content-center mb-0'>
            @if(isset($categories))
              @foreach ($categories as $category)
                <a href="{{ route('product.indexByCategory', ['category_id' => $category->category_id]) }}">
                  <li class="navbar__item">{{ $category->category_name }}</li>
                </a>
              @endforeach
            @else
              <a href="{{ route('product.indexByCategory', ['category_id' => " Laptop"]) }}">
                <li class="navbar__item">Laptop</li>
              </a>
              <a href="{{ route('product.indexByCategory', ['category_id' => " LaptopGaming"]) }}">
                <li class="navbar__item">Laptop Gaming</li>
              </a>
              <a href="{{ route('product.indexByCategory', ['category_id' => " GPU"]) }}">
                <li class="navbar__item">GPU</li>
              </a>
            @endif
          </ul>
        </div>
      </div>
    </div>
  </header>
  <main>

    @yield('content')

  </main>

  <footer>
    <div class="container">
      <div class="row footer__list">
        <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
          <h3>Về Chúng Tôi</h3>
          <p><a href="">Giới thiệu</a></p>
          <p><a href="">Chi nhánh</a></p>
          <p><a href="">Email: hello12345@gmail.com</a></p>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
          <h3>Hỗ Trợ Khách Hàng</h3>
          <p><a href="">Liên hệ</a></p>
          <p><a href="">Góp ý/Khiếu nại</a></p>
          <p><a href="">Thanh Toán</a></p>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
          <h3>Chính Sách Chung</h3>
          <p><a href="">Chính sách bảo mật</a></p>
          <p><a href="">Chính sách giải quyết khiếu nại</a></p>
          <p><a href="">Quy chế hoạt động</a></p>
        </div>
      </div>
      <hr>
      <div class="footer__text">
        <p>Copyright © 2025 by CT TTHH 500 Anh Em</p>
        <p>Số Giấy CN ĐKDN mã số 987654321 do Sở Kế hoạch và Đầu tư cấp ngày 23/3/2025</p>
      </div>
    </div>
  </footer>
  <script>
    // Hiển thị thông báo từ session
    @if(session('success'))
      showAlert('success', '{{ session('success') }}');
    @endif

    @if(session('error'))
      showAlert('error', '{{ session('error') }}');
    @endif

    @if(session('warning'))
      showAlert('warning', '{{ session('warning') }}');
    @endif

    @if($errors->any())
      @foreach($errors->all() as $error)
        showAlert('error', '{{ $error }}');
      @endforeach
    @endif

    @if(isset($warning) && $warning)
      showAlert('warning', '{{ $warning }}');
    @endif
  </script>

  @yield('js')

</body>

</html>