<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        p {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4047fd;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #2e35d9;
        }
        .error {
            margin-top: 15px;
            color: red;
            font-size: 13px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <p>Hanya pemimpin yang dapat membuat akun baru dengan cara menugaskan nama baru maka akun otomatis dibuat</p>
        <p>Password default semua akun: 12345</p>
        <p>Setiap akun pemimpin hanya menampilkan unit yang ada di bawahnya, jadi login sebagai pimpinan tertinggi untuk melihat semua unit</p>
        <p>Nama pimpinan tertinggi: Volodymyr Zelenskyy</p>

        <form method="POST" action="/login">
            @csrf
            <div>
                <label>Name</label>
                <input type="text" name="name" required>
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div>
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>

            <button type="submit">Login</button>
        </form>

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif
    </div>
</body>
</html>
