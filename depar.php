<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$html = '';
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $remarks = $_POST['remarks'];
    if (!empty($name) && !empty($remarks)) {
        $sqlstat = $pdo->prepare('INSERT INTO departments VALUES(null,?,?)');
        $sqlstat->execute([$name, $remarks]);
        header('Location: depar.php');
    } else {
        $html = '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>
                kayn input khawi!
            </strong> t2akd bli maamer kolchi?
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
}

// Request
$sqlstate = $pdo->query('SELECT * FROM departments');
$departments = $sqlstate->fetchAll(PDO::FETCH_ASSOC);

// Delete data
if (isset($_POST['delete_row'])) {
    $deleteId = $_POST['delete_id'];
    $deleteStmt = $pdo->prepare('DELETE FROM departments WHERE id = ?');
    $deleteStmt->execute([$deleteId]);
    header('Location: depar.php');
    exit;
}

// Update data
if (isset($_POST['update'])) {
    try {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $remarks = $_POST['remarks'];
        $updateStmt = $pdo->prepare('UPDATE departments SET name = ?, remarks = ? WHERE id = ?');
        $updateStmt->execute([$name, $remarks, $id]);
        header('Location: depar.php');
        exit;
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        exit;
    }
}

// Delete all data
if (isset($_POST['delete_all'])) {
    $deleteAllStmt = $pdo->prepare('DELETE FROM departments');
    $deleteAllStmt->execute();
    header('Location: depar.php');
    exit;
}

// Filter
if (isset($_POST['filter_submit'])) {
    $filterName = $_POST['filter_name'];
    $sqlstate = $pdo->prepare('SELECT * FROM departments WHERE name LIKE ?');
    $sqlstate->execute(["%$filterName%"]);
    $departments = $sqlstate->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">

    <style>
        .red-text {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container-fluid">

        <div class="wrapper d-flex">

            <aside id="sidebar">
                <div class="d-flex">
                    <button class="toggle-btn" type="button">
                        <i class="fa-sharp fa-solid fa-bars"></i>
                    </button>
                    <div class="sidebar-logo">
                        <a href="depar.php">Menu</a>
                    </div>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="teachers.php" class="sidebar-link">
                            <i class="fa-solid fa-person-chalkboard"></i>
                            <span>Teachers</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="students.php" class="sidebar-link">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span>Students</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="marks.php" class="sidebar-link">
                            <i class="fa-solid fa-square-check"></i>
                            <span>Marks</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="schedules.php" class="sidebar-link">
                            <i class="fa-solid fa-calendar-days"></i>
                            <span>schedules</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="depar.php" class="sidebar-link">
                            <i class="fa-solid fa-hotel"></i>
                            <span>Departements</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dash.php" class="sidebar-link">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="setting.php" class="sidebar-link">
                            <i class="fa-solid fa-gears"></i>
                            <span>Setting</span>
                        </a>
                    </li>
                </ul>
                <div class="sidebar-footer">
                    <a href="logout.php" class="sidebar-link">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </aside>

            <div class="main p-3 width8hu">
                <h1 class="text-center red-text">departments List</h1>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Update</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($departments as $st) {
                            ?>
                                <tr>
                                    <td><?= $st['name'] ?></td>
                                    <td><?= $st['remarks'] ?></td>
                                    <td>
                                        <input type="hidden" name="id" value="<?= $st['id'] ?>">
                                        <button type="button" class="btn btn-primary btn-sm btn-block" data-bs-toggle="modal" data-bs-target="#editTeacherModal<?= $st['id'] ?>">
                                            Update
                                        </button>
                                    </td>

                                    <!-- Update Teacher Modal -->
                                    <div class="modal fade" id="editTeacherModal<?= $st['id'] ?>" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTeacherModalLabel">Update Teacher</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <!-- Populate the input fields with teacher's data -->
                                                        <input type="hidden" name="id" value="<?= $st['id'] ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Department Name</label>
                                                            <input type="text" class="form-control" name="name" value="<?= $st['name'] ?>" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Remarks</label>
                                                            <input type="text" class="form-control" name="remarks" value="<?= $st['remarks'] ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post">
                                        <td>
                                            <input type="hidden" name="delete_id" value="<?= $st['id'] ?>">
                                            <button class="btn btn-danger btn-sm btn-block" type="submit" name="delete_row">Delete</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php

                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="main p-3 width">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center">
                        <img src="image/5.png" class="wd img-fluid d-block mx-auto" alt="Centered Image" style="width: 200px;">
                    </div>
                </div>

                <form method="post">

                    <?php
                    echo $html;
                    ?>

                    <div class="row mb-4">
                        <div class="col">
                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label">Department Name</label>
                                <input type="text" class="form-control" name="name" />
                            </div>
                        </div>

                        <div class="col">
                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label">Remarks</label>
                                <input type="text" class="form-control" name="remarks" />
                            </div>
                        </div>
                    </div>

                    <!-- Submit buttons -->
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success mx-2" name="save">Save</button>
                        <button type="submit" class="btn btn-primary mx-2" name="filter_submit">Filter</button>
                        <button type="submit" class="btn btn-danger mx-2" name="delete_all">Delete All</button>
                    </div>


                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script/sidebar.js"></script>
    <script src="https://kit.fontawesome.com/384cdfd76e.js" crossorigin="anonymous"></script>
</body>

</html>