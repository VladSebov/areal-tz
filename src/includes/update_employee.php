<?php
include "../config.php";

if (isset($_POST['updateEmployee'])) {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $birthdate = $_POST['birthdate'];
    $passport = $_POST['passport'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $hiredate = $_POST['hiredate'];

    $query = "UPDATE employees SET 
              full_name = '$fullname',
              birth_date = '$birthdate',
              passport = '$passport',
              phone_number = '$phonenumber',
              email = '$email',
              address = '$address',
              department = '$department',
              position = '$position',
              salary = '$salary',
              hire_date = '$hiredate'
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: ../index.php?success=updated");
        exit();
    } else {
        header("Location: ../index.php?error=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}