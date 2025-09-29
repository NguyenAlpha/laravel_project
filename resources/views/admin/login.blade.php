<main>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f2f5f9;
        margin: 0;
        padding: 0;
    }

    main {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .container {
        background: #fff;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        max-width: 420px;
        width: 100%;
    }

    .login-register__title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    .login-register__inform .block {
        margin-bottom: 15px;
    }

    .login-register__inform label {
        display: block;
        font-weight: bold;
        margin-bottom: 6px;
        color: #444;
    }

    .login-register__inform input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        outline: none;
        transition: all 0.3s ease;
    }

    .login-register__inform input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 6px rgba(78, 115, 223, 0.4);
    }

    .error {
        color: red;
        font-size: 14px;
        text-align: center;
    }

    .login-register__submit {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        background: #4e73df;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .login-register__submit:hover {
        background: #3751c6;
    }

    .register__link {
        color: #4e73df;
        font-weight: bold;
        text-decoration: none;
        margin-left: 5px;
    }

    .register__link:hover {
        text-decoration: underline;
    }

    .cart-alert {
        background: #f8d7da;
        color: #721c24;
        padding: 10px;
        text-align: center;
        border-radius: 6px;
        margin-bottom: 15px;
        font-size: 14px;
    }
</style>

    <div class="container">
        <?php if(isset($cartAlert)):?>
            <h1 class="alert cart-alert"><?=$cartAlert?></h1>
        <?php endif;?>
        <div class="login-register">
            <h1 class="login-register__title">ĐĂNG NHẬP</h1>
            <form action="./index.php?controller=user&action=login" method="post">
                <div class="login-register__inform">
                    <div class="block">
                        <label for="username">Tên đăng nhập:</label>
                        <input type="text" name="username" placeholder="Tên đăng nhập">
                    </div>
                    <div class="block">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" name="password" placeholder="Mật khẩu">
                    </div>
                    <div class="block">
                        <p class="error"><?=$erroLogin ?? ''?></p>  
                    </div>
                    <div class="block submit">
                        <button class="login-register__submit">Đăng nhập</button>
                    </div>
                    <div class="block">
                        <span>Chưa có tài khoản?</span>
                        <a href="" class="register__link">Đăng ký</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>