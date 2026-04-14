<?php
session_start();
include "koneksi.php";

if (isset($_POST['register'])) {

    $nama     = mysqli_real_escape_string($conn, $_POST['nama'] ?? '');
    $email    = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
    $password = md5($_POST['password'] ?? '');

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$email'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username / Email sudah dipakai!');</script>";
    } else {

        $query = "INSERT INTO users (username, nama, email, password, role_id) 
                  VALUES ('$username', '$nama', '$email', '$password', 2)";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Register berhasil!');</script>";
        } else {
            die("Gagal: " . mysqli_error($conn));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #0f172a;
        }

        /* CONTAINER */
        .container {
            width: 850px;
            height: 520px;
            /* Sedikit dinaikkan untuk akomodasi ikon */
            background: #111827;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        /* FORM BOX UMUM */
        .form-box {
            width: 50%;
            height: 100%;
            padding: 50px 40px;
            color: white;
            position: absolute;
            top: 0;
            transition: all 0.6s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* LOGIN */
        .login {
            left: 0;
            z-index: 2;
            opacity: 1;
        }

        /* REGISTER */
        .register {
            left: 0;
            z-index: 1;
            opacity: 0;
            pointer-events: none;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 25px;
            font-weight: 600;
            color: #f1f5f9;
        }

        /* INPUT GROUPS - Penting untuk menempatkan ikon */
        .input-group {
            position: relative;
            margin-bottom: 15px;
            width: 100%;
        }

        /* Ikon Sisi Kiri (Orang, Amplop, dll) */
        .input-group i.left-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            /* Warna abu-abu redup */
            font-size: 18px;
            pointer-events: none;
            /* Jangan biarkan ikon mengklik */
        }

        /* Ikon Sisi Kanan (Mata) */
        .input-group i.toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 18px;
            cursor: pointer;
            /* Bisa diklik */
            transition: color 0.3s;
        }

        .input-group i.toggle-password:hover {
            color: #22c55e;
            /* Warna hijau saat di-hover */
        }

        /* GAYA INPUT */
        input {
            width: 100%;
            padding: 13px 13px 13px 45px;
            /* Beri ruang ekstra di kiri untuk ikon */
            border-radius: 10px;
            border: 1px solid #1f2937;
            background: #0f172a;
            color: white;
            font-size: 15px;
            transition: 0.3s;
        }

        /* Penyesuaian padding untuk input yang ada ikon mata */
        input.with-toggle {
            padding-right: 45px;
            /* Beri ruang di kanan juga */
        }

        input:focus {
            outline: none;
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
        }

        /* BUTTON */
        button.btn-main {
            width: 100%;
            padding: 13px;
            background: #22c55e;
            border: none;
            border-radius: 10px;
            color: #000;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
            transition: 0.3s;
        }

        button.btn-main:hover {
            background: #16a34a;
        }

        /* PANEL HIJAU */
        .panel {
            width: 50%;
            height: 100%;
            background: #22c55e;
            color: black;
            position: absolute;
            right: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: all 0.6s ease-in-out;
            padding: 40px;
            z-index: 10;
            text-align: center;
        }

        .panel h2 {
            margin-bottom: 10px;
            color: black;
        }

        .panel p {
            font-size: 15px;
            line-height: 1.5;
            color: rgba(0, 0, 0, 0.8);
        }

        .panel button {
            background: transparent;
            border: 2px solid black;
            padding: 10px 30px;
            border-radius: 10px;
            margin-top: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 15px;
        }

        .panel button:hover {
            background: black;
            color: #22c55e;
        }

        /* ANIMASI SAAT AKTIF */
        .container.active .panel {
            transform: translateX(-100%);
        }

        .container.active .login {
            transform: translateX(100%);
            opacity: 0;
            z-index: 1;
        }

        .container.active .register {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            pointer-events: all;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #0f172a inset !important;
            box-shadow: 0 0 0 1000px #0f172a inset !important;
            -webkit-text-fill-color: #ffffff !important;
            caret-color: #ffffff;
            border: 1px solid #1f2937 !important;
        }
    </style>
</head>

<body>

    <div class="container" id="container">

        <div class="form-box login">
            <h2>Login</h2>
            <form action="proses_login.php" method="POST">
                <div class="input-group">
                    <i class="fa-solid fa-user left-icon"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock left-icon"></i>
                    <input type="password" name="password" id="login-password" class="with-toggle" placeholder="Password" required>
                    <i class="fa-solid fa-eye-slash toggle-password" data-target="login-password"></i>
                </div>

                <button type="submit" name="login" class="btn-main">Masuk</button>
            </form>
        </div>

        <div class="form-box register">
            <h2>Register</h2>
            <form method="POST">

                <div class="input-group">
                    <i class="fa-solid fa-id-card left-icon"></i>
                    <input type="text" name="nama" placeholder="Nama Lengkap" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-envelope left-icon"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-user left-icon"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock left-icon"></i>
                    <input type="password" name="password" id="register-password" class="with-toggle" placeholder="Password" required>
                    <i class="fa-solid fa-eye-slash toggle-password" data-target="register-password"></i>
                </div>

                <button type="submit" name="register" class="btn-main">Daftar</button>

            </form>

        </div>

        <div class="panel">
            <h2 id="title">Welcome</h2>
            <p id="desc">Belum punya akun? Yuk daftar dulu supaya bisa akses semua fitur!</p>
            <button id="toggleBtn" type="button">Daftar</button>
        </div>

    </div>

    <script>
        // 1. Logika untuk Toggle Form Login/Register
        const container = document.getElementById("container");
        const toggleBtn = document.getElementById("toggleBtn");
        const title = document.getElementById("title");
        const desc = document.getElementById("desc");

        toggleBtn.addEventListener("click", () => {
            container.classList.toggle("active");

            if (container.classList.contains("active")) {
                title.innerText = "Welcome Back";
                desc.innerText = "Sudah punya akun? Login di sini untuk melanjutkan.";
                toggleBtn.innerText = "Login";
            } else {
                title.innerText = "Welcome";
                desc.innerText = "Belum punya akun? Yuk daftar dulu supaya bisa akses semua fitur!";
                toggleBtn.innerText = "Daftar";
            }
        });

        // 2. Logika untuk Show/Hide Password
        // Kita ambil semua ikon yang punya class 'toggle-password'
        const togglePasswordIcons = document.querySelectorAll('.toggle-password');

        togglePasswordIcons.forEach(icon => {
            icon.addEventListener('click', function() {
                // Ambil ID target input dari atribut data-target
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);

                // Cek tipe input saat ini
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text'; // Ubah jadi text
                    this.classList.remove('fa-eye-slash'); // Ganti ikon
                    this.classList.add('fa-eye');
                } else {
                    passwordInput.type = 'password'; // Ubah balik jadi password
                    this.classList.remove('fa-eye'); // Ganti ikon balik
                    this.classList.add('fa-eye-slash');
                }
            });
        });
    </script>

</body>

</html>