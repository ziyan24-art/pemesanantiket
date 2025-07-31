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

    .login-container {
        background: #fff;
        padding: 40px 50px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        max-width: 400px;
        width: 100%;
        text-align: center;
        box-sizing: border-box;
    }

    .login-container h2 {
        margin-bottom: 35px;
        color: #333;
        font-weight: 700;
        font-size: 28px;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        /* lebih rapi dari margin bottom */
    }

    input[type="email"],
    input[type="password"] {
        padding: 14px 15px;
        border: 1.8px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
        width: 100%;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
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

    .register-link {
        margin-top: 25px;
        font-size: 15px;
        color: #555;
    }

    .register-link a {
        color: #007BFF;
        text-decoration: none;
        font-weight: 600;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    /* Responsive untuk layar kecil */
    @media (max-width: 480px) {
        .login-container {
            padding: 30px 20px;
        }

        .login-container h2 {
            font-size: 24px;
        }

        button,
        input[type="email"],
        input[type="password"] {
            font-size: 16px;
        }
    }

    .home-link {
        margin-top: 20px;
    }

    .btn-home {
        display: inline-block;
        text-decoration: none;
        color: #007BFF;
        font-weight: 600;
        font-size: 15px;
        transition: color 0.3s ease;
    }

    .btn-home:hover {
        color: #0056b3;
        text-decoration: underline;
    }
</style>
<div class="login-container">
    <h2>Login</h2>
    <form method="post" action="/login">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <p class="register-link">
        Belum punya akun? <a href="/register">Daftar di sini</a>
    </p>

    <p class="home-link">
        <a href="/" class="btn-home">← Kembali ke Home</a>
    </p>
</div>