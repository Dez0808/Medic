<?php
include '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['register'])) {
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $employee_id = $_POST['employee_id'];
        $mobile_num = $_POST['mobile_num'];
        $account_pass = $_POST['account_pass'];
    
        $checkAccount_ifExist = "SELECT * FROM registered_accounts WHERE employee_id='$employee_id'";
        $accountIfExist_result = $conn->query($checkAccount_ifExist);
    
        if ($accountIfExist_result->num_rows > 0) {
            echo "<script>
                    alert('An account was already registered with the same employee ID.');
                    window.location.href='register.php';
                  </script>";
            die();
        }

        if (!isset($_FILES['registrant_img']) || $_FILES['registrant_img']['error'] !== 0) {
            echo "<script>
                    alert('An unexpected error has occured in uploading registrant image. Please try again later.');
                    window.location.href='../register.php';
                  </script>";
            die();
        }

        $registrant_img = file_get_contents($_FILES['registrant_img']['tmp_name']);

        $sql = "INSERT INTO registered_accounts (registrant_img, first_name, middle_name, last_name, employee_id, mobile_num, account_pass)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssis", $registrant_img, $first_name, $middle_name, $last_name, $employee_id, $mobile_num, $account_pass);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Account registered successfully!');
                    window.location.href='../login.php';
                  </script>";
        } else {
            echo "Error" . $stmt->error;
        }
    }
}