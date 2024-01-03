<?php 
include 'Includes/dbcon.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/attnlg.jpg" rel="icon">
    <title>School Management System</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login" style="background-image: url('img/logo/loral1.jpe00g');">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <h5 align="center">SCHOOL MANAGEMENT SYSTEM</h5>
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Login Panel</h1>
                                    </div>
                                    
                                    <?php

                                        if(isset($_POST['login'])){

                                            $username = $_POST['username'];
                                            $password = $_POST['password'];
                                            $password = md5($password);

                                            // Check in tbladmin table
                                            $admin_check_query = "SELECT * FROM tbladmin WHERE emailAddress='$username' AND password='$password' LIMIT 1";
                                            $admin_rs = $conn->query($admin_check_query);
                                            $admin_num = $admin_rs->num_rows;
                                            $admin_row = $admin_rs->fetch_assoc();

                                            // Check in tblclassteacher table
                                            $teacher_check_query = "SELECT * FROM tblclassteacher WHERE emailAddress='$username' AND password='$password' LIMIT 1";
                                            $teacher_rs = $conn->query($teacher_check_query);
                                            $teacher_num = $teacher_rs->num_rows;
                                            $teacher_row = $teacher_rs->fetch_assoc();

                                            // If email exists in either tbladmin or tblclassteacher table, send notification
                                            if ($admin_num > 0 || $teacher_num > 0) {

                                                // Check if it's an admin login
                                                if ($admin_num > 0) {
                                                    $_SESSION['userId'] = $admin_row['Id'];
                                                    $_SESSION['firstName'] = $admin_row['firstName'];
                                                    $_SESSION['lastName'] = $admin_row['lastName'];
                                                    $_SESSION['emailAddress'] = $admin_row['emailAddress'];

                                                    echo "<script type = \"text/javascript\">
                                                    window.location = (\"Admin/index.php\")
                                                    </script>";
                                                    
                                                } 
                                                // If it's a class teacher login
                                                else if ($teacher_num > 0) {
                                                    $_SESSION['userId'] = $teacher_row['Id'];
                                                    $_SESSION['firstName'] = $teacher_row['firstName'];
                                                    $_SESSION['lastName'] = $teacher_row['lastName'];
                                                    $_SESSION['emailAddress'] = $teacher_row['emailAddress'];
                                                    $_SESSION['classId'] = $teacher_row['classId'];
                                                    $_SESSION['classArmId'] = $teacher_row['classArmId'];

                                                    echo "<script type = \"text/javascript\">
                                                    window.location = (\"ClassTeacher/index.php\")
                                                    </script>";
                                                    
                                                }
                                            } else {
                                                echo "<div class='alert alert-danger' role='alert'>
                                                        Invalid Username/Password!
                                                      </div>";
                                            }
                                        }
                                    ?>

                                    <form class="user" method="Post" action="">
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="username" id="exampleInputEmail" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" required class="form-control" id="exampleInputPassword" placeholder="Enter Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <!-- <label class="custom-control-label" for="customCheck">Remember Me</label> -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block" value="Login" name="login" />
                                        </div>
                                    </form>

                                    <div class="row">
                                    
                                        <div class="col-6">
                                            <a href="forgotPassword.php">Forgot Password?</a>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>
</body>

</html>
