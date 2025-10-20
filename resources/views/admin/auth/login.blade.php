<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Đăng nhập quản trị viên</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      width: 350px;
    }

    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #555;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #45a049;
    }

    .error {
      color: red;
      margin-bottom: 15px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h1>Đăng Nhập Hệ Thống</h1>

    <form method="post" action="{{ route('admin.login') }}">
      @csrf
      <div class="form-group">
        <label for="email">Email đăng nhập</label>
        <input type="email" id="email" name="email" required>
      </div>
      @error('email')
        <div class="text-danger p-2">{{ $message }}</div>
      @enderror

      <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" required>
      </div>
      @error('password')
        <div class="text-danger p-2">{{ $message }}</div>
      @enderror

      <button type="submit">Đăng Nhập</button>
    </form>
  </div>
</body>

</html>