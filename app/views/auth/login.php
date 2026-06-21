<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Habit Tracker</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial,sans-serif;
        }

        body{
            background:#f5f7fb;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
        }

        .card{
            width:100%;
            max-width:450px;
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 4px 20px rgba(0,0,0,.1);
        }

        h1{
            text-align:center;
            margin-bottom:20px;
        }

        .form-group{
            margin-bottom:15px;
        }

        label{
            display:block;
            margin-bottom:5px;
        }

        input{
            width:100%;
            padding:12px;
            border:1px solid #ddd;
            border-radius:8px;
        }

        button{
            width:100%;
            padding:12px;
            border:none;
            background:#4f46e5;
            color:white;
            border-radius:8px;
            cursor:pointer;
        }
    </style>
</head>
<body>

<div class="card">

    <h1>Login</h1>

    <form action="/habittracker/public/login" method="POST">

        <input
            type="hidden"
            name="csrf_token"
            value="<?= $_SESSION['csrf_token']; ?>"
        >

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">
            Login
        </button>

    </form>

</div>

</body>
</html>