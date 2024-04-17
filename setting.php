<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title mb-4">Welcome, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
                        <p class="card-text mb-4">Welcome to our site. You can manage your settings below:</p>
                        <ul class="list-group mb-3">
                            <li class="list-group-item">
                                <a href="reset-password.php" class="text-warning">Reset Your Password</a>
                            </li>
                            <li class="list-group-item">
                                <a href="logout.php" class="text-danger">Sign Out of Your Account</a>
                            </li>
                            <li class="list-group-item">
                                
                            <a href="dash.php" class="text-warning">Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>