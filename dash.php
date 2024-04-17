<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/form.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            /* Center horizontally */
            align-items: center;
            /* Center vertically */
            height: 100%;
            /* Ensure full viewport height */
            margin: 0;
            /* Remove default body margin */
        }

        .card {
            margin-bottom: 20px;
        }

        .card-title {
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .text-center {
            margin-bottom: 20px;
        }

        .chart {
            display: flex;
            justify-content: center;
            /* Horizontally center the content */
            align-items: center;
            /* Vertically center the content */
            flex-direction: column;
            /* Stack items vertically */
            margin-top: 30px;
            /* Optional: Add some space at the top */
        }


        .chart-card {
            margin-top: 30px;
            width: 300px;
            /* Adjust width as needed */
        }

        /* Add this CSS to your existing stylesheet */

        .flexHDjdf {
            display: flex;
            background-color: #f2f0f0;
            justify-content: space-evenly;
            margin: 2rem 0;
            padding: 2rem 0;
            border-radius: 1rem;
        }



        .chartBan {
            width: 40% !important;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .main {
                padding: 20px 15px;
            }
        }

        @media (max-width: 768px) {
            #sidebar {
                width: 80px;
            }

            .main {
                margin-left: 80px;
            }
        }

        @media (max-width: 576px) {
            .main {
                padding: 20px 10px;
            }
        }
    </style>
</head>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<body>
    <?php
    require_once 'config.php';

    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }

    // Fetch l data
    $stmt_teachers = $pdo->query('SELECT * FROM teachers');
    $teachers = $stmt_teachers->fetchAll(PDO::FETCH_ASSOC);

    $stmt_students = $pdo->query('SELECT * FROM students');
    $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

    $stmt_marks = $pdo->query('SELECT * FROM marks');
    $marks = $stmt_marks->fetchAll(PDO::FETCH_ASSOC);

    $stmt_schedules = $pdo->query('SELECT * FROM schedules');
    $schedules = $stmt_schedules->fetchAll(PDO::FETCH_ASSOC);

    $stmt_departments = $pdo->query('SELECT * FROM departments');
    $departments = $stmt_departments->fetchAll(PDO::FETCH_ASSOC);

    // var l chart
    $teachersCount      = count($teachers);
    $studentsCount      = count($students);
    $marksCount         = count($marks);
    $schedulesCount     = count($schedules);
    $departmentsCount   = count($departments);

    ?>
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

            <div class="main p-3">
                <div class="text-center">
                    <h1 class="display-4">School Management System - Dashboard</h1>
                </div>

                <div class="container">
                    <!-- Chart card -->
                    <div class="flexHDjdf">
                        <div class="chartBan" id="myChart"></div>
                        <div class="chartBan" id="myPlot"> </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Teachers</h5>
                                    <p class="card-text">Total Teachers: <?php echo count($teachers); ?></p>
                                    <a href="teachers.php" class="btn btn-primary">View Teachers</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Students</h5>
                                    <p class="card-text">Total Students: <?php echo count($students); ?></p>
                                    <a href="students.php" class="btn btn-primary">View Students</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Marks</h5>
                                    <p class="card-text">Total Marks: <?php echo count($marks); ?></p>
                                    <a href="marks.php" class="btn btn-primary">View Marks</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Schedules</h5>
                                    <p class="card-text">Total Schedules: <?php echo count($schedules); ?></p>
                                    <a href="schedules.php" class="btn btn-primary">View Schedules</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Departments</h5>
                                    <p class="card-text">Total Departments: <?php echo count($departments); ?></p>
                                    <a href="depar.php" class="btn btn-primary">View Departments</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script/sidebar.js"></script>
    <script src="https://kit.fontawesome.com/384cdfd76e.js" crossorigin="anonymous"></script>

    <script>
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            // Set Data
            const data = google.visualization.arrayToDataTable([
                ['option', 'Mhl'],
                ['Teachers', <?php echo $teachersCount; ?>],
                ['Students', <?php echo $studentsCount; ?>],
                ['Marks', <?php echo $marksCount; ?>],
                ['Schedules', <?php echo $schedulesCount; ?>],
                ['Departments', <?php echo $departmentsCount; ?>]
            ]);

            // Set Options
            const options = {
                title: 'Total Counts :',
                is3D: true
            };

            // Draw
            const chart = new google.visualization.PieChart(document.getElementById('myChart'));
            chart.draw(data, options);

        }
    </script>
    <script>
        const xArray = ["Teachers", "Students", "Marks", "Schedules", "Departments"];
        const yArray = [<?php echo $teachersCount; ?>,
            <?php echo $studentsCount; ?>,
            <?php echo $marksCount; ?>,
            <?php echo $schedulesCount; ?>,
            <?php echo $departmentsCount; ?>
        ];

        const data = [{
            x: xArray,
            y: yArray,
            type: "bar",
            orientation: "v",
            marker: {
                color: "rgba(0,0,255,0.6)"
            }
        }];

        const layout = {
            title: "World Wide Wine Production"
        };

        Plotly.newPlot("myPlot", data, layout);
    </script>

</body>

</html>