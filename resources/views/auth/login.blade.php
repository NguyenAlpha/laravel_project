@extends('layouts.app')

@section('title', 'Đăng nhập - Cửa hàng điện tử')

@section('content')
  <div class="container">
    @include('components.auth.login-form')
  </div>
@endsection