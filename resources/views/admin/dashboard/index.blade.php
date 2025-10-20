@extends('admin.layouts.app')

@section('title', 'Admin Dashboard - Hệ thống quản trị')
@section('dashboard-active', 'active')
@section('content')
  <!-- Top Bar -->
  <div class="top-bar">
    <div class="search-box">
      {{-- <i class="fas fa-search"></i>
      <input type="text" placeholder="Tìm kiếm..."> --}}
    </div>
    <div class="user-menu">
      {{-- <div class="notification-bell">
        <i class="fas fa-bell"></i>
        <span class="notification-badge">3</span>
      </div> --}}
      <div class="user-info">
        <div class="user-avatar">AD</div>
        <div>
          <div class="fw-bold">Admin User</div>
          <div class="small text-muted">Quản trị viên</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="row">
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-icon primary">
          <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stats-number">1,248</div>
        <div class="stats-label">Tổng đơn hàng</div>
        <div class="stats-change positive">
          <i class="fas fa-arrow-up"></i> 12.5% so với tháng trước
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-icon success">
          <i class="fas fa-users"></i>
        </div>
        <div class="stats-number">5,678</div>
        <div class="stats-label">Người dùng</div>
        <div class="stats-change positive">
          <i class="fas fa-arrow-up"></i> 8.3% so với tháng trước
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-icon warning">
          <i class="fas fa-box"></i>
        </div>
        <div class="stats-number">324</div>
        <div class="stats-label">Sản phẩm</div>
        <div class="stats-change positive">
          <i class="fas fa-arrow-up"></i> 5.2% so với tháng trước
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="stats-card">
        <div class="stats-icon info">
          <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stats-number">$24,580</div>
        <div class="stats-label">Doanh thu</div>
        <div class="stats-change positive">
          <i class="fas fa-arrow-up"></i> 15.7% so với tháng trước
        </div>
      </div>
    </div>
  </div>

  <!-- Charts and Tables -->
  <div class="row">
    <div class="col-md-8">
      <div class="chart-container">
        <div class="chart-header">
          <div class="chart-title">Doanh thu theo tháng</div>
          <div class="btn-group">
            <button class="btn btn-sm btn-outline-primary active">Tháng</button>
            <button class="btn btn-sm btn-outline-primary">Quý</button>
            <button class="btn btn-sm btn-outline-primary">Năm</button>
          </div>
        </div>
        <div
          style="height: 300px; background-color: #f8fafc; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
          <div class="text-center">
            <i class="fas fa-chart-line fa-3x mb-3"></i>
            <p>Biểu đồ doanh thu sẽ được hiển thị tại đây</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="chart-container">
        <div class="chart-header">
          <div class="chart-title">Phân loại sản phẩm</div>
        </div>
        <div
          style="height: 300px; background-color: #f8fafc; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
          <div class="text-center">
            <i class="fas fa-chart-pie fa-3x mb-3"></i>
            <p>Biểu đồ phân loại sẽ được hiển thị tại đây</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Orders -->
  <div class="recent-orders">
    <div class="chart-header">
      <div class="chart-title">Đơn hàng gần đây</div>
      <a href="#" class="btn btn-sm btn-primary">Xem tất cả</a>
    </div>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Mã đơn hàng</th>
            <th>Khách hàng</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>#ORD-7842</td>
            <td>Nguyễn Văn A</td>
            <td>15/01/2024</td>
            <td>2,450,000đ</td>
            <td><span class="status-badge completed">Hoàn thành</span></td>
            <td>
              <button class="btn btn-sm btn-outline-primary">Chi tiết</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection