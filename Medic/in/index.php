<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        main {
            display: grid;
            grid-template-columns: minmax(250px, 2fr);
            gap: 50px;
            border: 2px solid black;
            border-radius: 16px;
            width: 70%;
            margin: auto;
            padding: 40px;
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
            padding: 3px 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="date"],
        select {
            width: 100%;
            padding: 3px;
            box-sizing: border-box;
            border-radius: 8px;
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
            resize: vertical;
            background-color: var(--input-color);
            box-shadow: var(--shadow);
        }

        .register-label {
            text-align: center;
            margin-bottom: 12px;
            position: relative;
            background: var(--gradient-color);
            color: var(--font-color);
            height: 40px;
            line-height: 40px;
            border-radius: 10px 10px 0px 0px;
        }

        #home::after {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include '../include/header.php'; ?>
    <main class="mt-5 mb-5">
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
                        <td><input type="number" name="lrn"> </td>
                        <td><input type="text" name="grade_section"> </td>
                    </tr>
                    <tr>
                        <td>FIRST NAME: </td>
                        <td>ADDRESS: </td>
                    </tr>
                    <tr>
                        <td><input type="text" name="first_name"> </td>
                        <td><input type="text" name="address"> </td>
                    </tr>
                    <tr>
                        <td>MIDDLE NAME: </td>
                        <td>CONTACT NO.: </td>
                    </tr>
                    <tr>
                        <td><input type="text" name="middle_name"> </td>
                        <td><input type="number" name="contact_no"> </td>
                    </tr>
                    <tr>
                        <td>LAST NAME: </td>
                        <td>EMAIL: </td>
                    </tr>
                    <tr>
                        <td><input type="text" name="last_name"> </td>
                        <td><input type="email" name="email"> </td>
                    </tr>
                    <tr>
                        <td>PROFILE PICTURE: </td>
                        <td>BIRTH DATE: </td>
                    </tr>
                    <tr>
                        <td><input type="file" name="profile_picture"> </td>
                        <td><input type="date" name="birth_date"> </td>
                    </tr>
                    <tr>
                        <td>GENDER: </td>
                        <td>AGE: </td>
                    </tr>
                    <tr>
                        <td><select name="gender" id="">
                                <option value=""></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select> </td>
                        <td><input type="number" name="age"> </td>
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
                        <td><input type="text" name="guardian_name"> </td>
                    </tr>
                    <tr>
                        <td>CONTACT NO.: </td>
                    </tr>
                    <tr>
                        <td><input type="number" name="guardian_contact"> </td>
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
        </form>
    </main>
    <?php include '../include/footer.php'; ?>
</body>

</html>