<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$html = '';
if (isset($_POST['save'])) {
    $StudentName        =   $_POST['name'];
    $StudentEmail       =   $_POST['email'];
    $StudentPhone       =   $_POST['phone'];
    $StudentAddress     =   $_POST['address'];
    $StudentDOB         =   $_POST['dob'];
    $StudentGender      =   $_POST['gender'];
    $StudentPassword    =   $_POST['password'];
    $StudentDepartment  =   $_POST['depart'];
    $StudentTeacher     =   $_POST['teacher'];
    if (!empty($StudentName) && !empty($StudentEmail) && !empty($StudentPhone) && !empty($StudentAddress) && !empty($StudentDOB) && !empty($StudentGender) && !empty($StudentPassword) && !empty($StudentDepartment) && !empty($StudentTeacher)) {
        $sqlstat = $pdo->prepare('INSERT INTO students VALUES(null,?,?,?,?,?,?,?,?,?)');
        $sqlstat->execute([$StudentName, $StudentEmail, $StudentPhone, $StudentAddress, $StudentDOB, $StudentGender, $StudentPassword, $StudentDepartment, $StudentTeacher]);
        header('Location: students.php');
    } else {
        $html = '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>kayn input khawi!</strong> t2akd bli maamer kolchi?
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
    }
}

// Request
$sqlstate = $pdo->query('SELECT * FROM students');
$students = $sqlstate->fetchAll(PDO::FETCH_ASSOC);

// Delete data
if (isset($_POST['delete_row'])) {
    $deleteId = $_POST['delete_id'];
    $deleteStmt = $pdo->prepare('DELETE FROM students WHERE StudentID = ?');
    $deleteStmt->execute([$deleteId]);
    header('Location: students.php');
    exit;
}

// Update data
if (isset($_POST['update'])) {
    try {
        $StudentID          = $_POST['id'];
        $StudentName        = $_POST['name'];
        $StudentEmail       = $_POST['email'];
        $StudentPhone       = $_POST['phone'];
        $StudentAddress     = $_POST['address'];
        $StudentDOB         = $_POST['dob'];
        $StudentGender      = $_POST['gender'];
        $StudentPassword    = $_POST['pwd'];
        $StudentDepartment  = $_POST['depart'];
        $StudentTeacher     = $_POST['teacher'];

        // Prepare the SQL statement with placeholders for data binding
        $updateStmt = $pdo->prepare('UPDATE students SET StudentName =
    ?, StudentEmail = ?, StudentPhone = ?, StudentAddress = ?, StudentDOB = ?, StudentGender = ?, StudentPassword = ?, StudentDepartment = ?, StudentTeacher = ? WHERE StudentID = ?');

        // Execute the SQL statement with an array of parameters
        $updateStmt->execute([$StudentName, $StudentEmail, $StudentPhone, $StudentAddress, $StudentDOB, $StudentGender, $StudentPassword, $StudentDepartment, $StudentTeacher, $StudentID]);

        // Redirect back to students.php after successful update
        header('Location: students.php');
        exit;
    } catch (PDOException $e) {
        // Handle database errors
        echo "Database Error: " . $e->getMessage();
        exit;
    }
}


// Delete all data
if (isset($_POST['delete_all'])) {
    $deleteAllStmt = $pdo->prepare('DELETE FROM students');
    $deleteAllStmt->execute();
    header('Location: students.php');
    exit;
}

// Filter
if (isset($_POST['filter_submit'])) {
    $filterName = $_POST['filter_name'];
    $sqlstate = $pdo->prepare('SELECT * FROM students WHERE name LIKE ?');
    $sqlstate->execute(["%$filterName%"]);
    $students = $sqlstate->fetchAll(PDO::FETCH_ASSOC);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">

    <style>
        .red-text {
            color: red;
        }

        /* Example of adjusting font size for smaller screens */
        @media (max-width: 768px) {

            /* Adjust font size */
            .sidebar-link {
                font-size: 14px;
            }
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
                        <a href="students.php">Menu</a>
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
                <h1 class="text-center red-text">Students List</h1>
                <div class="table-responsive">
                    <table class="table" style="table-layout: fixed;">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">DOBirth</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Password</th>
                                <th scope="col">Department</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">Update</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($students as $st) {
                            ?>
                                <tr>
                                    <td><?= $st['StudentName'] ?></td>
                                    <td><?= $st['StudentEmail'] ?></td>
                                    <td><?= $st['StudentPhone'] ?></td>
                                    <td><?= $st['StudentAddress'] ?></td>
                                    <td><?= $st['StudentDOB'] ?></td>
                                    <td><?= $st['StudentGender'] ?></td>
                                    <td><?= $st['StudentPassword'] ?></td>
                                    <td><?= $st['StudentDepartment'] ?></td>
                                    <td><?= $st['StudentTeacher'] ?></td>

                                    <td>
                                        <input type="hidden" name="id" value="<?= $st['StudentID'] ?>">
                                        <button type="button" class="btn btn-primary btn-sm btn-block" data-bs-toggle="modal" data-bs-target="#editTeacherModal<?= $st['StudentID'] ?>">
                                            Update
                                        </button>
                                    </td>

                                    <!-- Update Teacher Modal -->
                                    <div class="modal fade" id="editTeacherModal<?= $st['StudentID'] ?>" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTeacherModalLabel">Update Teacher</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">

                                                        <input type="hidden" name="id" value="<?= $st['StudentID'] ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Name</label>
                                                            <input type="text" class="form-control" name="name" value="<?= $st['StudentName'] ?>" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Email</label>
                                                            <input type="email" class="form-control" name="email" value="<?= $st['StudentEmail'] ?>" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Phone</label>
                                                            <input type="text" class="form-control" name="phone" value="<?= $st['StudentPhone'] ?>" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Address</label>
                                                            <input type="text" class="form-control" name="address" value="<?= $st['StudentAddress'] ?>" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Date of Birth</label>
                                                            <input type="date" class="form-control" name="dob" value="<?= $st['StudentDOB'] ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Gender</label>
                                                            <select class="form-select" name="gender">
                                                                <option value="Male" <?= ($st['StudentGender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                                                                <option value="Female" <?= ($st['StudentGender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Password</label>
                                                            <input type="password" class="form-control" name="password" value="<?= $st['StudentPassword'] ?>" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Department</label>
                                                            <input type="text" class="form-control" name="depart" value="<?= $st['StudentDepartment'] ?>" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Student Teacher</label>
                                                            <input type="text" class="form-control" name="teacher" value="<?= $st['StudentTeacher'] ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                                                    </div>
                                                    <form method="post">
                                                        <td>
                                                            <input type="hidden" name="delete_id" value="<?= $st['StudentID'] ?>">
                                                            <button class="btn btn-danger btn-sm btn-block" type="submit" name="delete_row">Delete</button>
                                                        </td>
                                                    </form>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
                <?php
                echo $html;
                ?>
                <form method="post">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Student Name</label>
                                <input type="text" class="form-control" name="name" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Student Email</label>
                                <input type="email" class="form-control" name="email" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Student Phone</label>
                                <input type="text" class="form-control" name="phone" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Student Address</label>
                                <input type="text" class="form-control" name="address" />
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Student Date of Birth</label>
                                <input type="date" class="form-control" name="dob">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Student Gender</label>
                                <select class="form-select" name="gender">
                                    <option hidden>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Student Password</label>
                                <input type="password" class="form-control" name="password" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Student Department</label>
                                <input type="text" class="form-control" name="depart" />
                            </div>
                        </div>
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label">Student Teacher</label>
                        <input type="text" class="form-control" name="teacher" />
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