<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | LHS Clinic</title>
    <link rel="icon" type="image/x-icon" href="Pics/Logos/Lagro_High_School_logo.png">
    <style>
        body {
            background-image: url(Pics/bg1-nodoc.png);
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
            justify-content: center;
            line-height: 1.6;
            height: 100vh;
        }

        /* div:header */
        .header {
            background-color: #1b5e20;
            text-align: center;
            padding: 20px;
            border-radius: 20px 20px 0px 0px;
        }

        .header h1, .header h3 {
            color: white;
        }   

        .logo img {
            width: 70px;
            height: 70px;
            margin-right: 15px;
            color: white;
        }

        /* Image preview */
        .preview-image {
            width: 130px;
            height: 130px;
            border: 3px solid black;
            border-radius: 100%;
            object-fit: cover;
        }

        #registrant_img::file-selector-button {
            padding: 8px;
            text-align: center;
            background-color: #1b5e20;
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        } #registrant_img::file-selector-button:active {
            background-color: #36a73d;
        }

        /* Section:login-form */
        .login-form {
            width: 650px;
            height: 520px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-right: 40px;
            overflow: scroll;
            overflow-x: hidden;
            scrollbar-width: thin;
        }

        .form-container {
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 0 0 20px 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group-names {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        } .name-field {
            width: 100%;
        } 

        .form-group-img1 {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        } .form-group-img2 {
            display: flex;
            flex-direction: column;
            margin-left: 30px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #1b5e20;
        }

        input[type=number], input[type=password], input[type=text] {
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
        } .submit-btn:active {
            background-color: #36a73d;
        }

        .reg {
            text-align: center;
            margin-top: 20px;
        }

        p a {
            text-decoration: none;
            color: blue;
        } p a:active {
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
                <h3>Registration</h3>
            </div>

            <div class="form-container">
                <form action="process/register-action.php" method="post" enctype="multipart/form-data" id="form">
                    <div class="form-group-img1">
                        <img id="preview-image" class="preview-image">
                        <div class="form-group-img2">
                            <label for="registrant-img">Registrant Image</label>
                            <input type="file" name="registrant_img" id="registrant_img" accept="image/*" onchange="previewImage(event);">
                        </div>
                    </div>

                    <div class="form-group-names">
                        <div class="name-field">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" id="first_name" required>
                        </div>

                        <div class="name-field" style="margin-left: 8px; margin-right: 8px;">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name">
                        </div>

                        <div class="name-field">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="employee_id">Employee ID</label>
                        <input type="number" name="employee_id" id="employee_id" required>
                    </div>

                    <div class="form-group">
                        <label for="mobile_num">Mobile Number</label>
                        <input type="number" name="mobile_num" id="mobile_num" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="home_address">Current Home Address</label>
                        <input type="text" name="home_address" id="home_address" required>
                    </div>

                    <div class="form-group">
                        <label for="account_pass">Password</label>
                        <input type="password" name="account_pass" id="account_pass" required>
                    </div>

                    <button type="submit" class="submit-btn" name="register">Register Account</button>

                    <div class="reg">
                        <p class="reg-msg">Already have an account? <a href="login.php">Login</a></p>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

<script>
    const previewImage = (event) => {
        const files = event.target.files;
        if (files.length > 0) {
            const imageUrl = URL.createObjectURL(files[0]);
            const imageElement = document.getElementById("preview-image");
            imageElement.src = imageUrl;
        }
    } 
</script>

</html>