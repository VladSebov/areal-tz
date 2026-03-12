<?php
include "config.php";

// Обработка параметров из URL
$view_id = isset($_GET['view_id']) ? (int) $_GET['view_id'] : null;
$edit_id = isset($_GET['edit_id']) ? (int) $_GET['edit_id'] : null;
$confirm_fire_id = isset($_GET['confirm_fire_id']) ? (int) $_GET['confirm_fire_id'] : null;
$fire_id = isset($_GET['fire_id']) ? (int) $_GET['fire_id'] : null;

// Фильтры
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$department_filter = isset($_GET['department']) ? trim($_GET['department']) : '';
$position_filter = isset($_GET['position']) ? trim($_GET['position']) : '';

// Увольнение
if ($fire_id) {
    mysqli_query($conn, "UPDATE employees SET fired = 1 WHERE id = $fire_id");
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Получаем уникальные значения для выпадающих списков
$departments = mysqli_query($conn, "SELECT DISTINCT department FROM employees WHERE department IS NOT NULL AND department != '' ORDER BY department");
$positions = mysqli_query($conn, "SELECT DISTINCT position FROM employees WHERE position IS NOT NULL AND position != '' ORDER BY position");

// Построение SQL запроса с фильтрами
$sql = "SELECT * FROM employees WHERE 1=1";

if (!empty($search)) {
    $search_escaped = mysqli_real_escape_string($conn, $search);
    $sql .= " AND full_name LIKE '%$search_escaped%'";
}

if (!empty($department_filter)) {
    $department_escaped = mysqli_real_escape_string($conn, $department_filter);
    $sql .= " AND department = '$department_escaped'";
}

if (!empty($position_filter)) {
    $position_escaped = mysqli_real_escape_string($conn, $position_filter);
    $sql .= " AND position = '$position_escaped'";
}

$sql .= " ORDER BY id DESC";
$all_employees = mysqli_query($conn, $sql);

// Просмотр
$view_employee = null;
if ($view_id) {
    $view_result = mysqli_query($conn, "SELECT * FROM employees WHERE id = $view_id");
    $view_employee = mysqli_fetch_assoc($view_result);
}

// Редактирование
$edit_employee = null;
if ($edit_id) {
    $edit_result = mysqli_query($conn, "SELECT * FROM employees WHERE id = $edit_id");
    $edit_employee = mysqli_fetch_assoc($edit_result);
}

// Подтверждение увольнения
$confirm_fire_employee = null;
if ($confirm_fire_id) {
    $fire_result = mysqli_query($conn, "SELECT * FROM employees WHERE id = $confirm_fire_id");
    $confirm_fire_employee = mysqli_fetch_assoc($fire_result);
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
                    <!-- Фильтры -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="bi bi-funnel"></i> Фильтры</h5>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="" class="row g-3">
                                        <!-- Поиск по ФИО -->
                                        <div class="col-md-4">
                                            <label class="form-label">Поиск по ФИО</label>
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Введите ФИО..." value="<?= htmlspecialchars($search) ?>">
                                        </div>

                                        <!-- Фильтр по отделу -->
                                        <div class="col-md-3">
                                            <label class="form-label">Отдел</label>
                                            <select name="department" class="form-select">
                                                <option value="">Все отделы</option>
                                                <?php while ($dept = mysqli_fetch_assoc($departments)): ?>
                                                    <option value="<?= htmlspecialchars($dept['department']) ?>"
                                                        <?= $department_filter == $dept['department'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($dept['department']) ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <!-- Фильтр по должности -->
                                        <div class="col-md-3">
                                            <label class="form-label">Должность</label>
                                            <select name="position" class="form-select">
                                                <option value="">Все должности</option>
                                                <?php while ($pos = mysqli_fetch_assoc($positions)): ?>
                                                    <option value="<?= htmlspecialchars($pos['position']) ?>"
                                                        <?= $position_filter == $pos['position'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($pos['position']) ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <!-- Кнопки -->
                                        <div class="col-md-2 d-flex align-items-end">
                                            <div class="d-grid gap-2 w-100">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-search"></i> Применить
                                                </button>
                                                <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>" class="btn
                                                    btn-outline-secondary">
                                                    <i class="bi bi-eraser"></i> Сбросить
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Информация о фильтрах -->
                    <?php if (!empty($search) || !empty($department_filter) || !empty($position_filter)): ?>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i>
                                    Применены фильтры:
                                    <?php if (!empty($search)): ?>
                                        <span class="badge bg-primary">Поиск:
                                            <?= htmlspecialchars($search) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($department_filter)): ?>
                                        <span class="badge bg-success">Отдел:
                                            <?= htmlspecialchars($department_filter) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($position_filter)): ?>
                                        <span class="badge bg-warning text-dark">Должность:
                                            <?= htmlspecialchars($position_filter) ?>
                                        </span>
                                    <?php endif; ?>
                                    (найдено:
                                    <?= mysqli_num_rows($all_employees) ?>)
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Employees Table -->
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

                        <?php if (mysqli_num_rows($all_employees) > 0): ?>
                            <?php while ($employee = mysqli_fetch_assoc($all_employees)): ?>

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

                                        <?php
                                        // Параметры фильтров для сохранения в ссылках
                                        $filter_params = '';
                                        if (!empty($search))
                                            $filter_params .= '&search=' . urlencode($search);
                                        if (!empty($department_filter))
                                            $filter_params .= '&department=' . urlencode($department_filter);
                                        if (!empty($position_filter))
                                            $filter_params .= '&position=' . urlencode($position_filter);
                                        ?>


                                        <?php if ($employee["fired"] == 1): ?>
                                            <button class="btn btn-secondary" disabled>
                                                <i class="bi bi-person-x"></i> Уволен
                                            </button>
                                        <?php else: ?>
                                            <a href="?view_id=<?= $employee['id'] ?><?= $filter_params ?>"
                                                class="btn btn-success view-btn">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="?edit_id=<?= $employee['id'] ?><?= $filter_params ?>"
                                                class="btn btn-primary edit-btn">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <a href="?confirm_fire_id=<?= $employee['id'] ?><?= $filter_params ?>"
                                                class="btn btn-warning fire-btn">
                                                <i class="bi bi-person-x"></i> Уволить
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="12" class="text-center py-4">
                                    <i class="bi bi-exclamation-circle fs-1 d-block mb-3 text-muted"></i>
                                    <h5>Сотрудники не найдены</h5>
                                    <?php if (!empty($search)): ?>
                                        <p>По запросу "<?= htmlspecialchars($search) ?>" ничего не найдено</p>
                                        <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>"
                                            class="btn btn-outline-primary mt-2">
                                            <i class="bi bi-arrow-left"></i> Вернуться ко всем сотрудникам
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
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
                                    <input type="date" name="birthdate" required min="1900-01-01" max="2009-12-31">
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
                                    <input type="number" name="salary" required min="1000" step="0.01">
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
                                        value="<?= $edit_employee['birth_date'] ?? '' ?>" required min="1900-01-01"
                                        max="2009-12-31">
                                </div>
                                <div>
                                    <label>Серия/номер паспорта:</label>
                                    <input type="text" name="passport" class="form-control"
                                        value="<?= htmlspecialchars($edit_employee['passport'] ?? '') ?>" required
                                        minlength="10" maxlength="10">
                                </div>
                                <div>
                                    <label>Номер телефона:</label>
                                    <input type="text" name="phonenumber" class="form-control"
                                        value="<?= htmlspecialchars($edit_employee['phone_number'] ?? '') ?>" required
                                        minlength="11" maxlength="11">>
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
                                        value="<?= $edit_employee['salary'] ?? '' ?>" required min="1000" step="0.01">
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

        <!-- Confirm Fire Modal Form -->
        <div class="modal fade <?= $confirm_fire_id ? 'show' : '' ?>" id="confirmFireModalForm" <?= $confirm_fire_id ? 'style="display:block"' : '' ?>>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h4 class="modal-title">Подтверждение увольнения</h4>
                        <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>" class="btn-close"
                            aria-label="Закрыть"></a>
                    </div>
                    <div class="modal-body">
                        <p class="fs-5">Вы действительно хотите уволить сотрудника:</p>
                        <p class="fw-bold text-center fs-4">
                            <?= htmlspecialchars($confirm_fire_employee['full_name'] ?? '') ?>
                        </p>
                        <p class="text-muted text-center">Действие нельзя отменить</p>
                    </div>
                    <div class="modal-footer">
                        <a href="<?= strtok($_SERVER["REQUEST_URI"], '?') ?>" class="btn btn-secondary">Отмена</a>
                        <a href="?fire_id=<?= $confirm_fire_id ?>" class="btn btn-warning">Подтвердить увольнение</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Confirm Fire Modal Form -->

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

            <?php if ($confirm_fire_id && $confirm_fire_employee): ?>
                var fireModal = new bootstrap.Modal(document.getElementById('confirmFireModalForm'));
                fireModal.show();
            <?php endif; ?>

            document.querySelector('input[name="search"]')?.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.form.submit();
                }
            });
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