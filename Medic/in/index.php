<!DOCTYPE html>
<html lang="">
<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | LHS Clinic</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="..\js\bootstrap.bundle.min.js" />
    <link rel="icon" type="image/x-icon" href="../Pics/Logos/Lagro_High_School_logo.png">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: green;
            --secondary-color: blue;
            --font-color: white;
            --gradient-color: linear-gradient(90deg, rgb(10, 89, 52) 50%, rgb(55, 123, 77) 100%);
            --input-color: #f1f1f1;
            --shadow: 0 2px 5px rgba(0, 0, 0, 0.4)
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
        }

        .sidebar-container {
            margin-bottom: -10px;
        }

        main {
            display: grid;
            grid-template-columns: minmax(250px, 2fr);
            gap: 50px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
            border-radius: 16px;
            width: 70%;
            margin: auto;
            padding: 10px;
            background-color: white;
            margin-top: 20px;

        }

        .container {
            margin: auto;
            padding: 10px;
            width: 100%;
            margin-bottom: 18px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            padding: 7px 10px 7px 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="file"],
        input[type="date"],
        select {
            width: 100%;
            height: 35px;
            padding: 3px;
            box-sizing: border-box;
            border-radius: 8px;
            border: none;
            background-color: var(--input-color);
            box-shadow: var(--shadow);
        }

        input[type="file"] {
            border-bottom: 1px solid black;
            width: 100%;
            box-sizing: border-box;
            background-color: var(--input-color);
            box-shadow: var(--shadow);
        }

        textarea {
            width: 100%;
            height: 80px;
            padding: 3px;
            box-sizing: border-box;
            border-radius: 8px;
            border:none;
            resize: vertical;
            background-color: var(--input-color);
            box-shadow: var(--shadow);
        }

        .register-label {
            text-align: center;
            position: relative;
            background: var(--gradient-color);
            color: var(--font-color);
            font-weight: bold;
            padding: 10px;
            height: 60px;
            line-height: 40px;
            margin: -30px;
            margin-bottom: 30px;
            box-shadow: 0px 5px 3px 0px rgba(0, 0, 0, 0.2);
        }

        #home::after {
            width: 100%;
        }

        #clearBtn {
            background-color: rgb(161, 59, 60);
            border-color: rgb(161, 59, 60);
        }

        #clearBtn:hover {
            background-color: rgb(126, 43, 45);
            border-color: rgb(126, 43, 45);
        }

        .btn{
            float: right;
            margin: 5px 6px 15px 6px;
            width: 10rem;
        }

    </style>
</head>

<body>

    <div class="flex-container">

        <div class="sidebar-container">
            <?php include '../include/sidebar.php'; ?>
        </div>

        <main class="mb-5">
            <form action="../process/insert.php" method="post" enctype="multipart/form-data">

                <div class="container">
                    <table border="0" style="table-layout: fixed;">
                        <tr>
                            <th colspan="2" style="text-align: center;">
                                <h4 class="register-label">STUDENT INFORMATION</h4>
                            </th>
                        </tr>
                        <tr>
                            <td>LRN: </td>
                            <td>GRADE & SECTION: </td>
                        </tr>
                        <tr>
                            <td><input type="number" name="lrn" oninput="if(this.value.length > 12) this.value = this.value.slice(0, 12);" required autocomplete="off"> </td>
                            <td>
                                <input type="text" name="grade_section" placeholder="e.g., Grade 7 - A" required autocomplete="off">
                            </td>
                        </tr>
                        <tr>
                            <td>FIRST NAME: </td>
                            <td>ADDRESS: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="first_name" required autocomplete="off"> </td>
                            <td><input type="text" name="address" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <td>MIDDLE NAME: </td>
                            <td>CONTACT NO.: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="middle_name" autocomplete="off"> </td>
                            <td><input type="number" name="contact_no" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11);" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <td>LAST NAME: </td>
                            <td>EMAIL: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="last_name" required autocomplete="off"> </td>
                            <td><input type="email" name="email" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <td>PROFILE PICTURE: </td>
                            <td>BIRTH DATE: </td>
                        </tr>
                        <tr>
                            <td><input type="file" name="profile_picture"> </td>
                            <td><input type="date" name="birth_date" id="birth" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <td>GENDER: </td>
                            <td>AGE: </td>
                        </tr>
                        <tr>
                            <td><select name="gender" id="" required>
                                    <option value=""></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select> </td>
                            <td><input type="number" name="age" id="age" readonly> </td>
                        </tr>
                    </table>
                </div>
                <div class="container">
                    <table>
                        <tr>
                            <th colspan="2">
                                <h4 style="text-align: center;" class="register-label">GUARDIAN INFORMATION</h4>
                            </th>
                        </tr>
                        <tr>
                            <td>GUARDIAN NAME: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="guardian_name" required> </td>
                        </tr>
                        <tr>
                            <td>CONTACT NO.: </td>
                        </tr>
                        <tr>
                            <td><input type="number" name="guardian_contact" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11);" required> </td>
                        </tr>
                        <tr>
                            <td>ADDRESS: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="guardian_address"> </td>
                        </tr>
                        <tr>
                            <td>EMAIL: </td>
                        </tr>
                        <tr>
                            <td><input type="email" name="guardian_email"> </td>
                        </tr>
                    </table>
                </div>
                <div class="container">
                    <table>
                        <tr>
                            <th colspan="2">
                                <h4 style="text-align: center;" class="register-label">MEDICAL INFORMATION</h4>
                            </th>
                        </tr>
                        <tr>
                            <td>KNOWN ALLERGIES: </td>
                        </tr>
                        <tr>
                            <td><textarea name="allergies" id=""></textarea> </td>
                        </tr>
                        <tr>
                            <td>EXISTING MEDICAL CONDITIONS: </td>
                        </tr>
                        <tr>
                            <td><textarea name="medical_conditions" id=""></textarea> </td>
                        </tr>
                    </table>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-success" id="clearBtn">Clear</button>
            </form>
        </main>
    </div>


    <script>
        const birthInput = document.getElementById('birth');
        const ageInput = document.getElementById('age');
        const gradeSection = document.querySelector('input[name="grade_section"]');

        // Age calculation
        if (birthInput && ageInput) {
            birthInput.addEventListener('change', function() {
                if (this.value) {
                    const birthDate = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    ageInput.value = age;
                } else {
                    ageInput.value = '';
                }
            });
        }

        // Grade & Section normalization
        if (gradeSection) {
            gradeSection.addEventListener('blur', function() {
                let normalized = this.value.trim().replace(/\s*-\s*/g, ' - ');
                this.value = normalized;
            });
        }
    </script>

    <?php include '../include/footer.php'; ?>
</body>

</html>
