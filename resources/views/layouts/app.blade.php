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


  {{-- link css --}}
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/header.css')}}">
  <link rel="stylesheet" href="{{asset('css/product/product-card.css')}}">
  <link rel="icon" type="image/png" href="{{asset('images/logo.png')}}">

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
      <div class="container header-container">
        <div class="header__logo">
          <a href="{{route("home")}}"><img src="{{asset('images/logo.png')}}" alt=""></a>
        </div>
        <div class="header__search">
          <form action="{{route("search")}}" method="get">
            @if (isset($textSearch) && $textSearch)
              <input class="header-search__input form-control" type="text" name="search" value="{{ $textSearch }}"
                placeholder="Tìm kiếm sản phẩm">
            @else
              <input class="header-search__input form-control" type="text" name="search" placeholder="Tìm kiếm sản phẩm">
            @endif
            <button class="header-search__submit" type="submit" name='submit' value="search">
              <i class="fa-solid fa-magnifying-glass"></i>
              tìm kiếm
            </button>
          </form>
        </div>
        <div class="header__action">
          <a href="tel:0888999">
            <div class="header__item">
              <i class="fa-solid fa-phone"></i>
              Hotline
            </div>
          </a>

          <a href="./index.php?controller=cart&action=show">
            <div class="header__item">
              <i class="fa-solid fa-cart-shopping"></i>Giỏ hàng
            </div>
          </a>

          @auth
            {{-- Hiển thị khi user đã đăng nhập --}}
            <a href="{{ route('user.show') }}">
              <div class="header__item">
                <i class="fa-solid fa-user"></i>
                {{ Auth::user()->username }}
              </div>
            </a>

            <form method="POST" action="{{ route('logout') }}">
              {{-- Cross-Site Request Forgery (Tấn công giả mạo yêu cầu) --}}
              @csrf
              <button type="submit" class="header__item" style="border: none">
                <i class="fa-solid fa-right-from-bracket"></i>
                Đăng xuất
              </button>
            </form>
          @else
            {{-- Hiển thị khi user chưa đăng nhập --}}
            <a href="{{ route('login') }}">
              <div class="header__item">
                <i class="fa-solid fa-user"></i>
                Đăng Nhập
              </div>
            </a>

            <a href="{{ route('register') }}">
              <div class="header__item">
                <i class="fa-solid fa-user"></i>
                Đăng ký
              </div>
            </a>
          @endauth
        </div>
      </div>
    </div>
    <div class="navbar">
      <div class="container navbar-container">
        <ul class='d-flex'>
          {{--
          <?php foreach ($menus as $menuItem):?>
          <a href="./index.php?controller=category&action=show&id=<?= $menuItem['MaLoai'] ?>">
            <li class="navbar__item">
              <?= $menuItem['TenLoai']?>
            </li>
          </a>
          <?php endforeach; ?> --}}
          <a href="{{ route('product.indexByCategory', ['category' => "Laptop"]) }}">
            <li class="navbar__item">Laptop</li>
          </a>
          <a href="{{ route('product.indexByCategory', ['category' => "LaptopGaming"]) }}">
            <li class="navbar__item">Laptop Gaming</li>
          </a>
          <a href=" {{ route('product.indexByCategory', ['category' => "Screen"]) }}">
            <li class="navbar__item">Màn Hình</li>
          </a>
          <a href=" {{ route('product.indexByCategory', ['category' => "GPU"]) }}">
            <li class="navbar__item">GPU</li>
          </a>
          <a href=" {{ route('product.indexByCategory', ['category' => "Headset"]) }}">
            <li class="navbar__item">Tai Nghe</li>
          </a>
          <a href=" {{ route('product.indexByCategory', ['category' => "Mouse"]) }}">
            <li class="navbar__item">Chuột</li>
          </a>
          <a href=" {{ route('product.indexByCategory', ['category' => "Keyboard"]) }}">
            <li class="navbar__item">Bàn Phím</li>
          </a>
        </ul>
      </div>
    </div>
  </header>
  <main>
    @yield('content')
  </main>

  <footer>
    <div class="container">
      <div class="footer__list">
        <div class="">
          <h3>Về Chúng Tôi</h3>
          <p><a href="">Giới thiệu</a></p>
          <p><a href="">Chi nhánh</a></p>
          <p><a href="">Email: hello12345@gmail.com</a></p>
        </div>
        <div class="">
          <h3>Hỗ Trợ Khách Hàng</h3>
          <p><a href="">Liên hệ</a></p>
          <p><a href="">Góp ý/Khiếu nại</a></p>
          <p><a href="">Thanh Toán</a></p>
        </div>
        <div class="">
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
</body>

</html>