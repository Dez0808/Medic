<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="..\js\bootstrap.bundle.min.js" />
    <style>
        :root {
            --primary-color: green;
            --secondary-color: blue;
            --font-color: white;
            --gradient-color: linear-gradient(90deg, rgb(10, 89, 52) 50%, rgb(55, 123, 77) 100%);
            --input-color: #f1f1f1;
            --shadow: 0 2px 5px rgba(0, 0, 0, 0.2)
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: arial;
        }

        header {
            position: sticky;
            top: 0;
            display: flex;
            gap: 280px;
            justify-content: center;
            align-items: center;
            background: var(--gradient-color);
            z-index: 1000;
        }

        .logo {
            display: flex;
            padding: 4px;
            gap: 10px;
            color: var(--font-color);
        }


        .logo img {
            margin-top: 4px;
        }

        nav {
            display: flex;
            gap: 28px;
            margin-right: 80px;
            font-size: 20px;
        }

        nav a {
            text-decoration: none;
            color: var(--font-color);
        }

        .actions {
            margin-right: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .actions button {
            padding: 8px;
            width: 80px;
            border: none;
            color: var(--font-color);
            margin-right: 35px;
            border-radius: 8px;
            font-size: 18px;
            margin-left: -11px;
            background-color: #ffffff00;
        }

        nav a:hover {
            cursor: pointer;
        }

        .bi-person {
            color: var(--font-color);
            margin-right: 8px;
        }

        .navbtn {
            position: relative;
        }

        .navbtn::after {
            content: '';
            display: block;
            width: 0%;
            border-bottom: 3px solid white;
            left: 50%;
            transform: translateX(-50%);
            position: absolute;
            bottom: 0;
            transition: width 0.3s ease-in-out;
        }

        .navbtn:hover::after {
            width: 100%;
            transition: width 0.3s ease-in-out;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../include/Lagro_High_School_logo.png" alt="Logo" width="80px" height="80px">
            <div class="">
                <h2 style="font-size: 36px; margin-top: 6px;">Lagro Clinic</h2>
                <p style="font-size: 15px; margin-top: -6px;">Sa lagro lalala ka!</p>
            </div>
        </div>
        <nav>
            <a href="index.php" class="navbtn" id="home">Home</a>
            <a href="studentlist.php" class="navbtn" id="student">Student Record</a>
            <a href="anecdotal.php" class="navbtn" id="anecdotal">Anecdotal Record</a>
        </nav>
        <div class="actions">

            <button><a href="../process/logout.php" class="btn btn-danger">Logout</a></button>
        </div>
    </header>
</body>

</html>