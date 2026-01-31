<?php

include "../include/db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['account_id'])) {
        echo "<script>alert('You must be logged in to add a patient.'); window.location.href='../login.php';</script>";
        exit;
    }

    $account_id = $_SESSION['account_id'];
    $lrn = $_POST['lrn'];
    $grade_section = $_POST['grade_section'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];
    $email = $_POST['email'];
    $birth_date = $_POST['birth_date'];
    $guardian_name = $_POST['guardian_name'];
    $guardian_contact = $_POST['guardian_contact'];
    $guardian_address = $_POST['guardian_address'];
    $guardian_email = $_POST['guardian_email'];
    $allergies = $_POST['allergies'];
    $medical_conditions = $_POST['medical_conditions'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $picture = $_FILES['profile_picture']['name'];

    // if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
    //     $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
    //     $fileName = $_FILES['profile_picture']['name'];
    //     $fileSize = $_FILES['profile_picture']['size'];
    //     $fileType = $_FILES['profile_picture']['type'];
    //     $fileNameCmps = explode(".", $fileName);
    //     $fileExtension = strtolower(end($fileNameCmps));

    //     $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    //     $uploadFileDir = '../uploads/';
    //     $dest_path = $uploadFileDir . $newFileName;

    //     if (move_uploaded_file($fileTmpPath, $dest_path)) {
    //         $profile_picture_path = $dest_path;
    //     } else {
    //         die('Error moving the uploaded file.');
    //     }
    // } else {
    //     die('No file uploaded or there was an upload error.');
    // }

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);

    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
        echo "Done";
    } else {
        echo "Error";
    }

    $sql = "INSERT INTO user_info (account_id, lrn, grade_section, first_name, middle_name, last_name, address, contact, email, birth_date, gender, age, guardian_name, guardian_no, guardian_address, guardian_email, allergies, med_condition, picture) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssssisssisisssss", $account_id, $lrn, $grade_section, $first_name, $middle_name, $last_name, $address, $contact_no, $email, $birth_date, $gender, $age, $guardian_name, $guardian_contact, $guardian_address, $guardian_email, $allergies, $medical_conditions, $picture);

    if ($stmt->execute()) {
        echo "<script>alert('Record inserted successfully.'); window.location.href='../in/index.php';</script>";
    } else {
        echo "Error inserting record: " . $stmt->error;
        echo "<script>alert('Record inserted successfully.'); window.location.href='../in/index.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
