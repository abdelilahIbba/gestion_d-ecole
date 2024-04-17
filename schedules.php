<?php
require_once 'config.php';

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$html = '';
if (isset($_POST['save'])) {
    $DepartmentName = $_POST['Department'];
    $Day = $_POST['day'];
    $FirstSlot = $_POST['first'];
    $SecondSlot = $_POST['second'];
    $ThirdSlot = $_POST['third'];
    $FourthSlot = $_POST['fourth'];
    $FifthSlot = $_POST['fifth'];
    if (!empty($DepartmentName) && !empty($Day) && !empty($FirstSlot) && !empty($SecondSlot) && !empty($ThirdSlot) && !empty($FourthSlot) && !empty($FifthSlot)) {
        $sqlstat = $pdo->prepare('INSERT INTO schedules VALUES(null,?,?,?,?,?,?,?)');
        $sqlstat->execute([$DepartmentName, $Day, $FirstSlot, $SecondSlot, $ThirdSlot, $FourthSlot, $FifthSlot]);
        header('Location: schedules.php');
        exit();
    } else {
        $html = '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>
                                kayn input khawi!
                            </strong> t2akd bli maamer kolchi?
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
    }
}

// Request
$sqlstate = $pdo->query('SELECT * FROM Schedules');
$schedules = $sqlstate->fetchAll(PDO::FETCH_ASSOC);

// delete
if (isset($_POST['delete_row'])) {
    $deleteId = $_POST['delete_id'];
    $deleteStmt = $pdo->prepare('DELETE FROM Schedules WHERE ScheduleID = ?');
    $deleteStmt->execute([$deleteId]);
    header('Location: schedules.php');
    exit;
}

// Update
if (isset($_POST['update'])) {
    $ScheduleID = $_POST['ScheduleID'];
    $DepartmentName = $_POST['Department'];
    $Day = $_POST['day'];
    $FirstSlot = $_POST['first'];
    $SecondSlot = $_POST['second'];
    $ThirdSlot = $_POST['third'];
    $FourthSlot = $_POST['fourth'];
    $FifthSlot = $_POST['fifth'];

    $updateStmt = $pdo->prepare('UPDATE Schedules SET
    DepartmentName = ?, Day = ?, FirstSlot = ?, SecondSlot = ?, ThirdSlot = ?, FourthSlot = ?, FifthSlot = ? WHERE ScheduleID = ?');

    $updateStmt->execute([$DepartmentName, $Day, $FirstSlot, $SecondSlot, $ThirdSlot, $FourthSlot, $FifthSlot, $ScheduleID]);
    header('Location: schedules.php');
    exit;
}

// ha9
if (isset($_POST['delete_all'])) {
    $deleteAllStmt = $pdo->prepare('DELETE FROM Schedules');
    $deleteAllStmt->execute();
    header('Location: schedules.php');
    exit;
}

// filter
if (isset($_POST['filter_submit'])) {
    $filterName = $_POST['filter_name'];
    $sqlstate = $pdo->prepare('SELECT * FROM Schedules WHERE name LIKE ?');
    $sqlstate->execute(["%$filterName%"]);
    $schedules = $sqlstate->fetchAll(PDO::FETCH_ASSOC);
}
?>

?>

<!DOCTYPE html>
<html lang="en">`

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules</title>
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
                        <a href="schedules.php">Menu</a>
                    </div>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-item">
                        <a href="teachers.php" class="sidebar-link">
                            <i class="fa-solid fa-person-chalkboard"></i>
                            <span>teachers</span>
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
                <h1 class="text-center red-text">Schedules List</h1>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Department</th>
                                <th scope="col">Day</th>
                                <th scope="col">First</th>
                                <th scope="col">Second</th>
                                <th scope="col">Third</th>
                                <th scope="col">Fourth</th>
                                <th scope="col">Fifth</th>
                                <th scope="col">Update</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($schedules as $st) {
                            ?>
                                <tr>
                                    <td><?= $st['ScheduleID'] ?></td>
                                    <td><?= $st['DepartmentName'] ?></td>
                                    <td><?= $st['Day'] ?></td>
                                    <td><?= $st['FirstSlot'] ?></td>
                                    <td><?= $st['SecondSlot'] ?></td>
                                    <td><?= $st['ThirdSlot'] ?></td>
                                    <td><?= $st['FourthSlot'] ?></td>
                                    <td><?= $st['FifthSlot'] ?></td>
                                    <td>
                                        <input type="hidden" name="id" value="<?= $st['ScheduleID'] ?>">
                                        <button type="button" class="btn btn-primary btn-sm btn-block" data-bs-toggle="modal" data-bs-target="#editTeacherModal<?= $st['ScheduleID'] ?>">
                                            Update
                                        </button>
                                    </td>

                                    <!-- Update Teacher Modal -->
                                    <div class="modal fade" id="editTeacherModal<?= $st['ScheduleID'] ?>" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTeacherModalLabel">Update Teacher</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="post">
                                                    <div class="modal-body">
                                                        <!-- Populate the input fields with teacher's data -->
                                                        <input type="hidden" name="id" value="<?= $st['ScheduleID'] ?>">
                                                        <div class="mb-3">
                                                            <label class="form-label">Department Name</label>
                                                            <select class="form-select" name="Department" value="<?= $st['DepartmentName'] ?>">
                                                                <option hidden>Select department </option>
                                                                <option value="Sciences">Sciences</option>
                                                                <option value="Arts">Arts</option>
                                                                <option value="Sport">Sport</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Day</label>
                                                            <select class="form-select" name="day" value="<?= $st['Day'] ?>">
                                                                <option hidden>Select Day </option>
                                                                <option value="Monday">Monday</option>
                                                                <option value="Tuesday">Tuesday</option>
                                                                <option value="Wednesday">Wednesday</option>
                                                                <option value="Thursday">Thursday</option>
                                                                <option value="Friday">Friday</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">8AM - 9AM</label>
                                                            <select class="form-select" name="first" value="<? $st['FirstSlot'] ?>">
                                                                <option hidden>Select Course </option>
                                                                <option value="Math">Math</option>
                                                                <option value="English">English</option>
                                                                <option value="Hinidi">Arabic</option>
                                                                <option value="Geography">Geography</option>
                                                                <option value="History">History</option>
                                                                <option value="Cumputer">Cumputer</option>
                                                                <option value="Networking">Networking</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">8AM - 9AM</label>
                                                            <select class="form-select" name="second" value="<? $st['SecondSlot'] ?>">
                                                                <option hidden>Select Course </option>
                                                                <option value="Math">Math</option>
                                                                <option value="English">English</option>
                                                                <option value="Hinidi">Arabic</option>
                                                                <option value="Geography">Geography</option>
                                                                <option value="History">History</option>
                                                                <option value="Cumputer">Cumputer</option>
                                                                <option value="Networking">Networking</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">8AM - 9AM</label>
                                                            <select class="form-select" name="third" value="<? $st['ThirdSlot'] ?>">
                                                                <option hidden>Select Course </option>
                                                                <option value="Math">Math</option>
                                                                <option value="English">English</option>
                                                                <option value="Hinidi">Arabic</option>
                                                                <option value="Geography">Geography</option>
                                                                <option value="History">History</option>
                                                                <option value="Cumputer">Cumputer</option>
                                                                <option value="Networking">Networking</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">8AM - 9AM</label>
                                                            <select class="form-select" name="fourth" value="<? $st['FourthSlot'] ?>">
                                                                <option hidden>Select Course </option>
                                                                <option value="Math">Math</option>
                                                                <option value="English">English</option>
                                                                <option value="Hinidi">Arabic</option>
                                                                <option value="Geography">Geography</option>
                                                                <option value="History">History</option>
                                                                <option value="Cumputer">Cumputer</option>
                                                                <option value="Networking">Networking</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">8AM - 9AM</label>
                                                            <select class="form-select" name="fifth" value="<? $st['FifthSlot'] ?>">
                                                                <option hidden>Select Course </option>
                                                                <option value="Math">Math</option>
                                                                <option value="English">English</option>
                                                                <option value="Hinidi">Arabic</option>
                                                                <option value="Geography">Geography</option>
                                                                <option value="History">History</option>
                                                                <option value="Cumputer">Cumputer</option>
                                                                <option value="Networking">Networking</option>
                                                            </select>
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
                                            <input type="hidden" name="delete_id" value="<?= $st['ScheduleID'] ?>">
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
                    <!-- 2 column grid layout with text inputs for the first and last names -->
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Department Name</label>
                                <select class="form-select" name="Department">
                                    <option value="" hidden>Select department </option>
                                    <option value="Sciences">Sciences</option>
                                    <option value="Arts">Arts</option>
                                    <option value="Sport">Sport</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline">
                                <label class="form-label">Day</label>
                                <select class="form-select" name="day">
                                    <option value="" hidden>Select Day </option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label">8AM - 9AM</label>
                        <select class="form-select" name="first">
                            <option value="" hidden>Select Course </option>
                            <option value="Math">Math</option>
                            <option value="English">English</option>
                            <option value="Hinidi">Arabic</option>
                            <option value="Geography">Geography</option>
                            <option value="History">History</option>
                            <option value="Cumputer">Cumputer</option>
                            <option value="Networking">Networking</option>
                        </select>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label">9AM - 10AM</label>
                        <select class="form-select" name="second">
                            <option value="" hidden>Select Course </option>
                            <option value="Math">Math</option>
                            <option value="English">English</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Geography">Geography</option>
                            <option value="History">History</option>
                            <option value="Cumputer">Cumputer</option>
                            <option value="Networking">Networking</option>
                        </select>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label">10AM - 11AM</label>
                        <select class="form-select" name="third">
                            <option value="" hidden>Select Course </option>
                            <option value="Math">Math</option>
                            <option value="English">English</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Geography">Geography</option>
                            <option value="History">History</option>
                            <option value="Cumputer">Cumputer</option>
                            <option value="Networking">Networking</option>
                        </select>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label">11AM - 12PM</label>
                        <select class="form-select" name="fourth">
                            <option value="" hidden>Select Course </option>
                            <option value="Math">Math</option>
                            <option value="English">English</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Geography">Geography</option>
                            <option value="History">History</option>
                            <option value="Cumputer">Cumputer</option>
                            <option value="Networking">Networking</option>
                        </select>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label">12PM - 01PM</label>
                        <select class="form-select" name="fifth">
                            <option value="" hidden>Select Course </option>
                            <option value="Math">Math</option>
                            <option value="English">English</option>
                            <option value="Arabic">Arabic</option>
                            <option value="Geography">Geography</option>
                            <option value="History">History</option>
                            <option value="Cumputer">Cumputer</option>
                            <option value="Networking">Networking</option>
                        </select>
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