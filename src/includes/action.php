<?php

include "../config.php";

if (isset($_POST['addEmployee'])) {
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
    $fired = 0;

    $query = "INSERT INTO employees (full_name, birth_date, passport, phone_number, email, address, department, position, salary, hire_date, fired) 
              VALUES ('$fullname', '$birthdate', '$passport', '$phonenumber', '$email', '$address', '$department', '$position', '$salary', '$hiredate', $fired)";
    if (mysqli_query($conn, $query)) {
        // Успешно - перенаправляем на главную с параметром успеха
        header("Location: ../index.php?success=1");
        exit();
    } else {
        // Ошибка - перенаправляем на главную с параметром ошибки
        header("Location: ../index.php?error=" . urlencode(mysqli_error($conn)));
        exit();
    }
} else {
    // Если кто-то зашел напрямую без POST данных
    header("Location: ../index.php");
    exit();
}

