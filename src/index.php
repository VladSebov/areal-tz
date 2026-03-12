<?php

include "config.php";
$all_employees = mysqli_query($conn, "Select * from employees");

// Обработка параметров из URL
$view_id = isset($_GET['view_id']) ? (int) $_GET['view_id'] : null;
$edit_id = isset($_GET['edit_id']) ? (int) $_GET['edit_id'] : null;

$view_employee = null;
if ($view_id) {
    $view_result = mysqli_query($conn, "SELECT * FROM employees WHERE id = $view_id");
    $view_employee = mysqli_fetch_assoc($view_result);
}

$edit_employee = null;
if ($edit_id) {
    $edit_result = mysqli_query($conn, "SELECT * FROM employees WHERE id = $edit_id");
    $edit_employee = mysqli_fetch_assoc($edit_result);
}

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
                        while ($employee = mysqli_fetch_assoc($all_employees)): ?>

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
                                    <a href="?view_id=<?= $employee['id'] ?>" class="btn btn-success view-btn">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="?edit_id=<?= $employee['id'] ?>" class="btn btn-primary edit-btn">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>

                        <?php endwhile; ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModalForm">Добавить
                        сотрудника <i class="bi bi-people"></i></button>
                </div>
            </div>
        </section>

        <!-- View Modal Form -->
        <div class="modal fade <?= $view_id ? 'show' : '' ?>" id="viewModalForm" <?= $view_id ? 'style="display:block"' : '' ?>>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Данные сотрудника</h4>
                        <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>" class="btn-close"
                            aria-label="Закрыть"></a>
                    </div>
                    <div class="modal-body">
                        <div class="inputField">
                            <div>
                                <label>ФИО:</label>
                                <input type="text" class="form-control" value="<?= $view_employee['full_name'] ?? '' ?>"
                                    disabled>
                            </div>
                            <div>
                                <label>Дата рождения:</label>
                                <input type="date" class="form-control"
                                    value="<?= $view_employee['birth_date'] ?? '' ?>" disabled>
                            </div>
                            <div>
                                <label>Серия/номер паспорта:</label>
                                <input type="text" class="form-control" value="<?= $view_employee['passport'] ?? '' ?>"
                                    disabled>
                            </div>
                            <div>
                                <label>Номер телефона:</label>
                                <input type="text" class="form-control"
                                    value="<?= $view_employee['phone_number'] ?? '' ?>" disabled>
                            </div>
                            <div>
                                <label>Email:</label>
                                <input type="email" class="form-control" value="<?= $view_employee['email'] ?? '' ?>"
                                    disabled>
                            </div>
                            <div>
                                <label>Адрес:</label>
                                <input type="text" class="form-control" value="<?= $view_employee['address'] ?? '' ?>"
                                    disabled>
                            </div>
                            <div>
                                <label>Отдел:</label>
                                <input type="text" class="form-control"
                                    value="<?= $view_employee['department'] ?? '' ?>" disabled>
                            </div>
                            <div>
                                <label>Должность:</label>
                                <input type="text" class="form-control" value="<?= $view_employee['position'] ?? '' ?>"
                                    disabled>
                            </div>
                            <div>
                                <label>Размер зарплаты:</label>
                                <input type="number" class="form-control" value="<?= $view_employee['salary'] ?? '' ?>"
                                    disabled>
                            </div>
                            <div>
                                <label>Дата принятия:</label>
                                <input type="date" class="form-control" value="<?= $view_employee['hire_date'] ?? '' ?>"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- View Modal Form -->

        <!-- Add Modal Form -->
        <div class="modal fade" id="addModalForm">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Добавление сотрудника</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <form method="POST" action="includes/add_employee.php" id="employeeForm">
                        <div class="modal-body">

                            <div class="inputField">
                                <div>
                                    <label for="fullname">ФИО:</label>
                                    <input type="text" name="fullname" required>
                                </div>
                                <div>
                                    <label for="birthdate">Дата рождения:</label>
                                    <input type="date" name="birthdate" required>
                                </div>
                                <div>
                                    <label for="passport">Серия/номер паспорта:</label>
                                    <input type="text" name="passport" id="passport" required minlength="10"
                                        maxlength="10">
                                </div>
                                <div>
                                    <label for="phonenumber">Номер телефона:</label>
                                    <input type="text" name="phonenumber" id="phone" required minlength="11"
                                        maxlength="11">
                                </div>
                                <div>
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" required>
                                </div>
                                <div>
                                    <label for="address">Адрес:</label>
                                    <input type="text" name="address" required>
                                </div>
                                <div>
                                    <label for="department">Отдел:</label>
                                    <input type="text" name="department" required>
                                </div>
                                <div>
                                    <label for="position">Должность:</label>
                                    <input type="text" name="position" required>
                                </div>
                                <div>
                                    <label for="salary">Размер зарплаты:</label>
                                    <input type="number" name="salary" required>
                                </div>
                                <div>
                                    <label for="hiredate">Дата принятия на работу:</label>
                                    <input type="date" name="hiredate" required>
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
        <!-- Add Modal Form -->

        <!-- Edit Modal Form -->
        <div class="modal fade <?= $edit_id ? 'show' : '' ?>" id="editModalForm" <?= $edit_id ? 'style="display:block"' : '' ?>>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Редактирование сотрудника</h4>
                        <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>" class="btn-close"
                            aria-label="Закрыть"></a>
                    </div>
                    <form action="includes/update_employee.php" method="POST">
                        <input type="hidden" name="id" value="<?= $edit_employee['id'] ?? '' ?>">
                        <div class="modal-body">
                            <div class="inputField">
                                <div>
                                    <label>ФИО:</label>
                                    <input type="text" name="fullname" class="form-control"
                                        value="<?= htmlspecialchars($edit_employee['full_name'] ?? '') ?>" required>
                                </div>
                                <div>
                                    <label>Дата рождения:</label>
                                    <input type="date" name="birthdate" class="form-control"
                                        value="<?= $edit_employee['birth_date'] ?? '' ?>" required>
                                </div>
                                <div>
                                    <label>Серия/номер паспорта:</label>
                                    <input type="text" name="passport" class="form-control"
                                        value="<?= htmlspecialchars($edit_employee['passport'] ?? '') ?>" required>
                                </div>
                                <div>
                                    <label>Номер телефона:</label>
                                    <input type="text" name="phonenumber" class="form-control"
                                        value="<?= htmlspecialchars($edit_employee['phone_number'] ?? '') ?>" required>
                                </div>
                                <div>
                                    <label>Email:</label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?= htmlspecialchars($edit_employee['email'] ?? '') ?>" required>
                                </div>
                                <div>
                                    <label>Адрес:</label>
                                    <input type="text" name="address" class="form-control"
                                        value="<?= htmlspecialchars($edit_employee['address'] ?? '') ?>" required>
                                </div>
                                <div>
                                    <label>Отдел:</label>
                                    <input type="text" name="department" class="form-control"
                                        value="<?= htmlspecialchars($edit_employee['department'] ?? '') ?>" required>
                                </div>
                                <div>
                                    <label>Должность:</label>
                                    <input type="text" name="position" class="form-control"
                                        value="<?= htmlspecialchars($edit_employee['position'] ?? '') ?>" required>
                                </div>
                                <div>
                                    <label>Размер зарплаты:</label>
                                    <input type="number" name="salary" class="form-control"
                                        value="<?= $edit_employee['salary'] ?? '' ?>" required>
                                </div>
                                <div>
                                    <label>Дата принятия:</label>
                                    <input type="date" name="hiredate" class="form-control"
                                        value="<?= $edit_employee['hire_date'] ?? '' ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>" class="btn btn-secondary">Отмена</a>
                            <button type="submit" name="updateEmployee" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Modal Form -->

    </main>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <!-- Для отображения модальных окон -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if ($view_id): ?>
                var viewModal = new bootstrap.Modal(document.getElementById('viewModalForm'));
                viewModal.show();
            <?php endif; ?>

            <?php if ($edit_id): ?>
                var editModal = new bootstrap.Modal(document.getElementById('editModalForm'));
                editModal.show();
            <?php endif; ?>
        });
    </script>
    <!-- jQuery и плагин маски -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#phone').mask('+7 (999) 999-99-99', { placeholder: '+7 (___) ___-__-__' });
            $('#passport').mask('9999 999999', { placeholder: '____ ______' });
        });
    </script>

</body>

</html>