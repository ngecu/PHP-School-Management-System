<?php
// Include necessary functions and database connection

include 'Includes/dbcon.php';
session_start();

// Get email and token from the URL
$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';

// Validate and check if the token is valid and not expired
// (You'll need to implement this logic based on your storage mechanism)

// Display the reset password form if the token is valid
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset Password</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>
<body  class="bg-gradient-login">

<div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Forgot Password</h1>
                                    </div>
                                    <?php 
                                    




if (isset($_POST['submit'])) {
    // Validate form data and ensure both passwords match and are strong (you can add more validation as needed)
    $newPassword = $_POST['new-password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';

    if(empty($email) || empty($token) ){
        echo "<div class='alert alert-danger' role='alert'>
        Email and Token is required !
        </div>";
    }
    else {
        // Check in tbladmin table
        $admin_check_query = "SELECT * FROM tbladmin WHERE emailAddress='$email' LIMIT 1";
        $admin_rs = $conn->query($admin_check_query);
        $admin_num = $admin_rs->num_rows;
    
        // Check in tblclassteacher table
        $teacher_check_query = "SELECT * FROM tblclassteacher WHERE emailAddress='$email' LIMIT 1";
        $teacher_rs = $conn->query($teacher_check_query);
        $teacher_num = $teacher_rs->num_rows;
    
        // If email exists in tbladmin
        if ($admin_num > 0) {
            $tableToUpdate = 'tbladmin';
        }
        // If email exists in tblclassteacher
        elseif ($teacher_num > 0) {
            $tableToUpdate = 'tblclassteacher';
        } else {
            // Email not found in any expected table
            echo '<div class="alert alert-danger" role="alert">Invalid email or token!</div>';
        }
    
        if (isset($tableToUpdate)) {
            $token_check_query = "SELECT * FROM tbltoken WHERE emailAddress='$email' LIMIT 1";
            $token_rs = $conn->query($token_check_query);
            $token_num = $token_rs->num_rows;
    
            if ($token_num > 0) {
                if ($newPassword !== $confirmPassword) {
                    echo '<div class="alert alert-danger" role="alert">Passwords do not match. Please try again.</div>';
                } elseif (strlen($newPassword) < 8) {
                    echo '<div class="alert alert-danger" role="alert">Password must be at least 8 characters long.</div>';
                } else {
                    // Hash the new password using MD5
                    $hashedPassword = md5($newPassword);
    
                    // Update the password in the appropriate table
                    $updatePasswordQuery = "UPDATE $tableToUpdate SET password='$hashedPassword' WHERE emailAddress='$email'";
                    $updatePasswordResult = $conn->query($updatePasswordQuery);
    
                    if ($updatePasswordResult) {
                        // Password update successful
                        echo '<div class="alert alert-success" role="alert">Password reset successfully!</div>';

                        
                        // ...
                    } else {
                        // Password update failed
                        echo '<div class="alert alert-danger" role="alert">Error updating password. Please try again.</div>';
                        // ...
                    }
                }
            }
        }
    }
    


}

?>

<form action="" method="post">
    <!-- Password reset form fields go here -->
    <div class="form-group">
                                            <label for="new-password">New Password:</label>
                                            <input type="password" class="form-control" id="new-password" name="new-password"
                                                >
                                        </div>
                                        <!-- Confirm Password -->
                                        <div class="form-group">
                                            <label for="confirm-password">Confirm Password:</label>
                                            <input type="password" class="form-control" id="confirm-password"
                                                name="confirm-password" >
                                        </div>
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

    <input type="submit" class="btn btn-primary btn-block" value="Submit" name="submit" />
</form>

</body>
</html>
