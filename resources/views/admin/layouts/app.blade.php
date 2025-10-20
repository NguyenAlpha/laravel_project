<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  {{-- jquery --}}
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  {{-- Bootstrap JavaScript Bundle --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  {{-- limk css --}}
  <link rel="stylesheet" href="{{ asset('css/admin/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
  {{-- link js --}}
  <script src=" {{ asset('js/admin/global-functions.js') }}"></script>
  @yield('css')
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-header">
      <h3><i class="fas fa-cube"></i> <span>AdminPanel</span></h3>
    </div>
    <div class="sidebar-menu">
      <ul>
        <li><a href="{{ route('admin.dashboard') }}" class="@yield('dashboard-active')"><i class="fas fa-home"></i>
            <span>Dashboard</span></a></li>
        <li><a href="{{ route('admin.product.index') }}" class="@yield('product-active')"><i
              class="fas fa-shopping-bag"></i> <span>Sản phẩm</span></a></li>
        <li><a href="{{ route('admin.user.index') }}" class="@yield('user-active')"><i class="fas fa-users"></i>
            <span>Người dùng</span></a></li>
        <li><a href="{{ route('admin.order.index') }}" class="@yield('order-active')"><i
              class="fas fa-shopping-cart"></i> <span>Đơn hàng</span></a></li>
        <li><a href="{{ route('admin.inventory.index') }}" class="@yield('inventory-active')"><i
              class="fa-solid fa-warehouse"></i> <span>Kho hàng</span></a></li>
        <li><a href="{{ route('admin.receipt.index') }}" class="@yield('receipt-active')"><i class="fas fa-tags"></i>
            <span>Phiếu nhập</span></a></li>
        <li><a href="{{ route('admin.supplier.index') }}" class="@yield('supplier-active')"><i
              class="fas fa-chart-bar"></i> <span>Nhà cùng cấp</span></a></li>
        <li><a href="#"><i class="fas fa-chart-bar"></i> <span>Thống kê</span> </a></li>
        <li><a href="#"><i class="fas fa-tags"></i> <span>Danh mục</span></a></li>
        <li><a href="#"><i class="fas fa-cog"></i> <span>Cài đặt</span></a></li>
        <li><a href="#"><i class="fas fa-question-circle"></i> <span>Trợ giúp</span></a></li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    @yield('content')
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(document).ready(function () {
      // Simple script for sidebar menu active state
      const menuItems = document.querySelectorAll('.sidebar-menu a');

      menuItems.forEach(item => {
        item.addEventListener('click', function () {
          menuItems.forEach(i => i.classList.remove('active'));
          this.classList.add('active');
        });
      });
    })

    // Hiển thị thông báo từ session
    @if(session('success'))
      showAlert('success', '{{ session('success') }}');
    @endif

    @if(session('error'))
      showAlert('error', '{{ session('error') }}');
    @endif

    @if($errors->any())
      @foreach($errors->all() as $error)
        showAlert('error', '{{ $error }}');
      @endforeach
    @endif
  </script>
  @yield('js')
</body>

</html>