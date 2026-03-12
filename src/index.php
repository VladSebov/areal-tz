<?php

include "config.php";
$query = mysqli_query($conn, "Select * from employees");

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовое задание Ареал: Учет сотрудников</title>

    <link rel="stylesheet" href="assets/styles/style.css">

    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Bootstrap 5 Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
    <header>
        <h1 class="display-3 text-center">Тестовое задание Ареал: Учет сотрудников</h1>
    </header>



    <main>
        <section class="p-3">
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-hover mt-3 text-center table-bordered">
                        <tr>
                            <th>№</th>
                            <th>ФИО</th>
                            <th>Дата рождения</th>
                            <th>Серия/номер паспорта</th>
                            <th>Номер телефона</th>
                            <th>Email</th>
                            <th>Адрес</th>
                            <th>Отдел</th>
                            <th>Должность</th>
                            <th>Размер зарплаты</th>
                            <th>Дата принятия на работу</th>
                            <th>Действия</th>
                        </tr>

                        <?php
                        while ($employee = mysqli_fetch_assoc($query)): ?>

                            <tr>
                                <td><?= $employee["id"] ?></td>
                                <td><?= $employee["full_name"] ?></td>
                                <td><?= $employee["birth_date"] ?></td>
                                <td><?= $employee["passport"] ?></td>
                                <td><?= $employee["phone_number"] ?></td>
                                <td><?= $employee["email"] ?></td>
                                <td><?= $employee["address"] ?></td>
                                <td><?= $employee["department"] ?></td>
                                <td><?= $employee["position"] ?></td>
                                <td><?= $employee["salary"] ?></td>
                                <td><?= $employee["hire_date"] ?></td>
                                <td>
                                    <button class="btn btn-success"><i class="bi bi-eye"></i></button>
                                    <button class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalForm">Добавить
                        сотрудника <i class="bi bi-people"></i></button>
                </div>
            </div>
        </section>

        <!-- Modal Form -->
        <div class="modal fade" id="modalForm">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Добавление сотрудника</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <form method="POST" action="includes/action.php" id="employeeForm">
                        <div class="modal-body">

                            <div class="inputField">
                                <div>
                                    <label for="fullname">ФИО:</label>
                                    <input type="text" name="fullname">
                                </div>
                                <div>
                                    <label for="birthdate">Дата рождения:</label>
                                    <input type="date" name="birthdate">
                                </div>
                                <div>
                                    <label for="passport">Серия/номер паспорта:</label>
                                    <input type="text" name="passport">
                                </div>
                                <div>
                                    <label for="phonenumber">Номер телефона:</label>
                                    <input type="text" name="phonenumber">
                                </div>
                                <div>
                                    <label for="email">Email:</label>
                                    <input type="email" name="email">
                                </div>
                                <div>
                                    <label for="address">Адрес:</label>
                                    <input type="text" name="address">
                                </div>
                                <div>
                                    <label for="department">Отдел:</label>
                                    <input type="text" name="department">
                                </div>
                                <div>
                                    <label for="position">Должность:</label>
                                    <input type="text" name="position">
                                </div>
                                <div>
                                    <label for="salary">Размер зарплаты:</label>
                                    <input type="number" name="salary">
                                </div>
                                <div>
                                    <label for="hiredate">Дата принятия на работу:</label>
                                    <input type="date" name="hiredate">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button name="addEmployee" type="submit" form="employeeForm"
                                class="btn btn-primary submit">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>