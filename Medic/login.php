<?php

include "include/db.php";
session_start();

if (isset($_POST["login"])) {
    $id = $_POST["account_num"];
    $password = $_POST["account_pass"];

    $stmt = $conn->prepare("SELECT account_id, employee_id, account_pass FROM registered_accounts WHERE employee_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check if password is hashed (starts with $2y$) or plain text
        if (password_verify($password, $user['account_pass']) || $password === $user['account_pass']) {
            $_SESSION['account_id'] = $user['account_id'];
            $_SESSION['employee_id'] = $user['employee_id'];
            echo "<script>alert('Successfully Login.'); window.location.href='in/index.php'</script>";
            exit();
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password.');</script>";
    }
    $stmt->close();
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LHS | Login</title>
    <link rel="icon" type="image/x-icon" href="Pics/Logos/Lagro_High_School_logo.png">
    <style>
        body {
            background-image: url(Pics/bg1.png);
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        * {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        /* Main */
        main {
            display: flex;
            align-items: center;
            justify-content: right;
            line-height: 1.6;
            height: 100vh;
            padding: 0 30px;
        }

        /* div:header */
        .header {
            background-color: #1b5e20;
            text-align: center;
            padding: 20px;
            border-radius: 20px 20px 0px 0px;
        }

        .header h1,
        .header h3 {
            color: white;
        }

        .logo img {
            width: 70px;
            height: 70px;
            margin-right: 15px;
            color: white;
        }

        /* Section:login-form */
        .login-form {
            width: 500px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-right: 40px;
        }

        .form-container {
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 0 0 20px 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #1b5e20;
        }

        input[type=number],
        input[type=password] {
            padding: 8px 10px;
            width: 100%;
            border: 3px solid rgba(201, 201, 201, 0.7);
            border-radius: 8px;
            box-sizing: border-box;
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            text-align: center;
            background-color: #1b5e20;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .submit-btn:active {
            background-color: #36a73d;
        }

        .reg {
            text-align: center;
            margin-top: 20px;
        }

        p a {
            text-decoration: none;
            color: blue;
        }

        p a:active {
            color: red;
        }
    </style>
</head>

<body>
    <main>
        <section class="login-form">
            <div class="header">
                <div class="logo">
                    <img src="Pics/Logos/Lagro_High_School_logo.png" alt="LHS">
                </div>
                <h1>Lagro High School</h1>
                <h3>Log-in</h3>
            </div>

            <div class="form-container">
                <form action="login.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="account_num">Employee ID</label>
                        <input type="number" name="account_num" id="account_num" required>
                    </div>

                    <div class="form-group">
                        <label for="account_pass">Password</label>
                        <input type="password" name="account_pass" id="account_pass" required>
                    </div>
                    <button type="submit" class="submit-btn" name="login">Log-in</button>

                    <div class="reg">
                        <p class="reg-msg">Don't have an account? <a href="register.php">Register</a></p>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

</html>
