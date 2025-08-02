<style>
    /* Reset dasar */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(to right, #74ebd5, #ACB6E5);
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        min-height: 100vh;
    }

    .register-container {
        background: #fff;
        padding: 40px 50px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        max-width: 400px;
        width: 100%;
        text-align: center;
        box-sizing: border-box;
    }

    .register-container h2 {
        margin-bottom: 35px;
        color: #333;
        font-weight: 700;
        font-size: 28px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
        padding: 14px 15px;
        border: 1.8px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
        width: 100%;
        background-color: white;
        appearance: none;
        /* hilangkan style default select */
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%23777777' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 10px 6px;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    select:focus {
        border-color: #007BFF;
        outline: none;
        box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
    }

    button {
        padding: 14px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    button:hover {
        background-color: #0056b3;
    }

    /* Responsive untuk layar kecil */
    @media (max-width: 480px) {
        .register-container {
            padding: 30px 20px;
        }

        .register-container h2 {
            font-size: 24px;
        }

        button,
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            font-size: 16px;
        }
    }

    .login-link {
        margin-top: 20px;
        font-size: 15px;
        color: #555;
        text-align: center;
    }

    .login-link a {
        color: #007BFF;
        font-weight: 600;
        text-decoration: none;
        transition: text-decoration 0.3s ease, color 0.3s ease;
    }

    .login-link a:hover {
        text-decoration: underline;
        color: #0056b3;
    }
</style>

<div class="register-container">
    <h2>Register</h2>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error'); ?></p>
    <?php endif; ?>
    <form method="post" action="/register">
        <?= csrf_field() ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>


    <p class="login-link">
        Sudah punya akun? <a href="/login">Login di sini</a>
    </p>
</div>