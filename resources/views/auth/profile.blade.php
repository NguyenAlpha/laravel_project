@extends('layouts.app')

@section('content')
  {{-- <p>Tên: {{$user->username}}</p>
  <p>Mật khẩu: {{$user->password}}</p>
  <p>Email: {{$user->email}}</p>
  <p>Số điện thoại: {{$user->phone_number}}</p>
  <p>Vai trò: {{$user->role}}</p>
  <p>Giới tính: {{$user->sex}}</p>
  <p>Ngày sinh: {{$user->dob}}</p>
  <p>Trạng thái tài khoản: {{$user->status}}</p>
  <p>Đường dẫn ảnh đại diện: {{$user->avatar_url}}</p> --}}

  <div class='container' style='margin-top: 40px;'>
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('success') }}</strong>
      </div>
    @endif

    <div class="d-flex">
      <div class="card shadow-sm border-0 w-25">
        <div class="card-body text-center p-4 bg-light">
          <img src="{{ $user->avatar_url ? asset('images/' . $user->avatar_url) : asset('images/avatar.jpg') }}"
            alt="avatar" class="rounded-circle mb-3 border border-3 border-white shadow" width="80" height="80">
          <h5 class="card-title mb-0 fw-bold text-primary">{{ $user->username }}</h5>
          <small class="text-muted">Thành viên</small>
        </div>

        <ul class="list-group list-group-flush">
          <a href="{{ route('profile.show') }}"
            class="text-decoration-none text-dark d-flex align-items-center hover-effect">
            <li class="list-group-item py-3 w-100">
              <i class="fas fa-user-circle me-3 text-primary"></i>
              <span>Thông tin tài khoản</span>
            </li>
          </a>
          <a href="#" class="text-decoration-none text-dark d-flex align-items-center hover-effect">
            <li class="list-group-item py-3 w-100">
              <i class="fas fa-address-book me-3 text-success"></i>
              <span>Sổ địa chỉ</span>
            </li>
          </a>
          <a href="#" class="text-decoration-none text-dark d-flex align-items-center hover-effect">
            <li class="list-group-item py-3 w-100">
              <i class="fas fa-shopping-bag me-3 text-warning"></i>
              <span>Đơn hàng đã mua</span>
            </li>
          </a>
          <form method="POST" action="{{ route('logout') }}" class="mb-0 w-100 hover-effect">
            <li class="list-group-item py-3">
              @csrf
              <button type="submit"
                class="btn btn-link text-decoration-none text-dark p-0 border-0 w-100 text-start d-flex align-items-center hover-effect">
                <i class="fas fa-sign-out-alt me-3 text-danger"></i>
                <span>Đăng xuất</span>
              </button>
            </li>
          </form>
        </ul>
      </div>

      <style>
        .hover-effect:hover {
          border-radius: 5px;
          padding-left: 10px;
        }

        .hover-effect {
          transition: all 0.3s ease;
        }

        .btn-link:hover {
          background-color: transparent !important;
        }
      </style>

      <div class="card w-75">
        <div class="card-header bg-white">
          <h5 class="mb-0">Thông tin tài khoản</h5>
        </div>
        <form action="{{ route('profile.update', ['user_id' => $user->user_id]) }}" method="POST" id="myForm">
          @csrf
          @method('PUT')

          <div class="card-body">
            <!-- Tên tài khoản -->
            <div class="mb-3">
              <label for="username" class="form-label">Tên tài khoản <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                name="username" value="{{ old('username', $user->username) }}" required>
              @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email', $user->email) }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Số điện thoại -->
            <div class="mb-3">
              <label for="phone_number" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>
              @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Giới tính -->
            <div class="mb-3">
              <label class="form-label">Giới tính <span class="text-danger">*</span></label>
              <div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" name="sex" id="sexMale"
                    value="nam" {{ old('sex', $user->sex) == 'nam' ? 'checked' : '' }}>
                  <label class="form-check-label" for="sexMale">Nam</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" name="sex"
                    id="sexFemale" value="nữ" {{ old('sex', $user->sex) == 'nữ' ? 'checked' : '' }}>
                  <label class="form-check-label" for="sexFemale">Nữ</label>
                </div>
              </div>
              @error('sex')
                <div class="text-danger small">{{ $message }}</div>
              @enderror
            </div>

            <!-- Ngày sinh -->
            <div class="mb-3">
              <label for="dob" class="form-label">Ngày sinh <span class="text-danger">*</span></label>
              <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob"
                value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}">
              @error('dob')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Nút submit -->
            <div class="mt-4 text-center">
              <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtnUser">
                <i class="fas fa-save me-2"></i>LƯU THAY ĐỔI
              </button>
              <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-lg px-5 ms-2">
                <i class="fas fa-undo me-2"></i>HỦY BỎ
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
@endsection