<?php 
include 'Includes/dbcon.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\src\Exception.php';
require 'PHPMailer\src\SMTP.php';
require 'PHPMailer\src\PHPMailer.php';

//Define name spacese


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
    <title>School Management System- Forget Password</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">

                                <?php

function SendMail( $ToEmail, $MessageHTML, $MessageTEXT ) {
    // require_once ( 'class.phpmailer.php' ); // Add the path as appropriate
    $Mail = new PHPMailer(true);
    $Mail->IsSMTP(); // Use SMTP
    $Mail->Host        = "smtp.gmail.com"; // Sets SMTP server
    $Mail->SMTPDebug   = 0; // 2 to enable SMTP debug information
    $Mail->SMTPAuth    = TRUE; // enable SMTP authentication
    $Mail->SMTPSecure  = "ssl"; //Secure conection
    $Mail->Port        = 465; // set the SMTP port
    $Mail->Username    = 'devngecu@gmail.com'; // SMTP account username
    $Mail->Password    = 'falvxbsapmgowzel'; // SMTP account password
    $Mail->Priority    = 1; // Highest priority - Email priority (1 = High, 3 = Normal, 5 = low)
    $Mail->CharSet     = 'UTF-8';
    $Mail->Encoding    = '8bit';
    $Mail->Subject     = 'Reset Password Token';
    $Mail->ContentType = 'text/html; charset=utf-8\r\n';
    $Mail->From        = 'support@eve.com';
    $Mail->FromName    = 'EVE SCHOOL MANAGEMENT SYSTEM SUPPORT';
    $Mail->WordWrap    = 900; // RFC 2822 Compliant for Max 998 characters per line
  
    $Mail->AddAddress( $ToEmail ); // To:
  
    $Mail->isHTML( TRUE );
    $Mail->Body    = $MessageHTML;
    $Mail->AltBody = $MessageTEXT;
    $Mail->Send();
    $Mail->SmtpClose();
  
    if ( $Mail->IsError() ) { // ADDED - This error checking was missing
      return FALSE;
    }
    else {
      return TRUE;
    }
  }


              if(isset($_POST['submit'])){

               
                  
                 


                $email = $_POST['email'];
                $email = mysqli_real_escape_string($conn, $email); // Sanitize the email input

              

                if (empty($email)) { 
                    echo "<div class='alert alert-danger' role='alert'>
                    Email is required !
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
                 
                 // If email exists in either tbladmin or tblclassteacher table, send notification
                 if ($admin_num > 0 || $teacher_num > 0) {
                    $row = ($admin_num > 0) ? $admin_rs->fetch_assoc() : $teacher_rs->fetch_assoc();
    
                    // Extract firstName
                    $firstName = $row['firstName'];
                    $token = bin2hex(random_bytes(16));
                    $ToEmail = $email;
                    // Store the token, user's email, and timestamp in the database
                    
                    // Create the reset link
                    $resetLink = "http://localhost/sms/reset-password.php?email=" . urlencode($ToEmail) . "&token=" . urlencode($token);
                    
                    // Include the reset link in your email content
                    $htmlContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml">
                      <head>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <meta name="x-apple-disable-message-reformatting" />
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <meta name="color-scheme" content="light dark" />
                        <meta name="supported-color-schemes" content="light dark" />
                        <title></title>
                        <style type="text/css" rel="stylesheet" media="all">
                        /* Base ------------------------------ */
                        
                        @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
                        body {
                          width: 100% !important;
                          height: 100%;
                          margin: 0;
                          -webkit-text-size-adjust: none;
                        }
                        
                        a {
                          color: #3869D4;
                        }
                        
                        a img {
                          border: none;
                        }
                        
                        td {
                          word-break: break-word;
                        }
                        
                        .preheader {
                          display: none !important;
                          visibility: hidden;
                          mso-hide: all;
                          font-size: 1px;
                          line-height: 1px;
                          max-height: 0;
                          max-width: 0;
                          opacity: 0;
                          overflow: hidden;
                        }
                        /* Type ------------------------------ */
                        
                        body,
                        td,
                        th {
                          font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
                        }
                        
                        h1 {
                          margin-top: 0;
                          color: #333333;
                          font-size: 22px;
                          font-weight: bold;
                          text-align: left;
                        }
                        
                        h2 {
                          margin-top: 0;
                          color: #333333;
                          font-size: 16px;
                          font-weight: bold;
                          text-align: left;
                        }
                        
                        h3 {
                          margin-top: 0;
                          color: #333333;
                          font-size: 14px;
                          font-weight: bold;
                          text-align: left;
                        }
                        
                        td,
                        th {
                          font-size: 16px;
                        }
                        
                        p,
                        ul,
                        ol,
                        blockquote {
                          margin: .4em 0 1.1875em;
                          font-size: 16px;
                          line-height: 1.625;
                        }
                        
                        p.sub {
                          font-size: 13px;
                        }
                        /* Utilities ------------------------------ */
                        
                        .align-right {
                          text-align: right;
                        }
                        
                        .align-left {
                          text-align: left;
                        }
                        
                        .align-center {
                          text-align: center;
                        }
                        
                        .u-margin-bottom-none {
                          margin-bottom: 0;
                        }
                        /* Buttons ------------------------------ */
                        
                        .button {
                          background-color: #3869D4;
                          border-top: 10px solid #3869D4;
                          border-right: 18px solid #3869D4;
                          border-bottom: 10px solid #3869D4;
                          border-left: 18px solid #3869D4;
                          display: inline-block;
                          color: #FFF;
                          text-decoration: none;
                          border-radius: 3px;
                          box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                          -webkit-text-size-adjust: none;
                          box-sizing: border-box;
                        }
                        
                        .button--green {
                          background-color: #D21812;
                          border-top: 10px solid #D21812;
                          border-right: 18px solid #D21812;
                          border-bottom: 10px solid #D21812;
                          border-left: 18px solid #D21812;
                        }
                        
                        .button--red {
                          background-color: #FF6136;
                          border-top: 10px solid #FF6136;
                          border-right: 18px solid #FF6136;
                          border-bottom: 10px solid #FF6136;
                          border-left: 18px solid #FF6136;
                        }
                        
                        @media only screen and (max-width: 500px) {
                          .button {
                            width: 100% !important;
                            text-align: center !important;
                          }
                        }
                        /* Attribute list ------------------------------ */
                        
                        .attributes {
                          margin: 0 0 21px;
                        }
                        
                        .attributes_content {
                          background-color: #F4F4F7;
                          padding: 16px;
                        }
                        
                        .attributes_item {
                          padding: 0;
                        }
                        /* Related Items ------------------------------ */
                        
                        .related {
                          width: 100%;
                          margin: 0;
                          padding: 25px 0 0 0;
                          -premailer-width: 100%;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                        }
                        
                        .related_item {
                          padding: 10px 0;
                          color: #CBCCCF;
                          font-size: 15px;
                          line-height: 18px;
                        }
                        
                        .related_item-title {
                          display: block;
                          margin: .5em 0 0;
                        }
                        
                        .related_item-thumb {
                          display: block;
                          padding-bottom: 10px;
                        }
                        
                        .related_heading {
                          border-top: 1px solid #CBCCCF;
                          text-align: center;
                          padding: 25px 0 10px;
                        }
                        /* Discount Code ------------------------------ */
                        
                        .discount {
                          width: 100%;
                          margin: 0;
                          padding: 24px;
                          -premailer-width: 100%;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                          background-color: #F4F4F7;
                          border: 2px dashed #CBCCCF;
                        }
                        
                        .discount_heading {
                          text-align: center;
                        }
                        
                        .discount_body {
                          text-align: center;
                          font-size: 15px;
                        }
                        /* Social Icons ------------------------------ */
                        
                        .social {
                          width: auto;
                        }
                        
                        .social td {
                          padding: 0;
                          width: auto;
                        }
                        
                        .social_icon {
                          height: 20px;
                          margin: 0 8px 10px 8px;
                          padding: 0;
                        }
                        /* Data table ------------------------------ */
                        
                        .purchase {
                          width: 100%;
                          margin: 0;
                          padding: 35px 0;
                          -premailer-width: 100%;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                        }
                        
                        .purchase_content {
                          width: 100%;
                          margin: 0;
                          padding: 25px 0 0 0;
                          -premailer-width: 100%;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                        }
                        
                        .purchase_item {
                          padding: 10px 0;
                          color: #51545E;
                          font-size: 15px;
                          line-height: 18px;
                        }
                        
                        .purchase_heading {
                          padding-bottom: 8px;
                          border-bottom: 1px solid #EAEAEC;
                        }
                        
                        .purchase_heading p {
                          margin: 0;
                          color: #85878E;
                          font-size: 12px;
                        }
                        
                        .purchase_footer {
                          padding-top: 15px;
                          border-top: 1px solid #EAEAEC;
                        }
                        
                        .purchase_total {
                          margin: 0;
                          text-align: right;
                          font-weight: bold;
                          color: #333333;
                        }
                        
                        .purchase_total--label {
                          padding: 0 15px 0 0;
                        }
                        
                        body {
                          background-color: #F2F4F6;
                          color: #51545E;
                        }
                        
                        p {
                          color: #51545E;
                        }
                        
                        .email-wrapper {
                          width: 100%;
                          margin: 0;
                          padding: 0;
                          -premailer-width: 100%;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                          background-color: #F2F4F6;
                        }
                        
                        .email-content {
                          width: 100%;
                          margin: 0;
                          padding: 0;
                          -premailer-width: 100%;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                        }
                        /* Masthead ----------------------- */
                        
                        .email-masthead {
                          padding: 25px 0;
                          text-align: center;
                        }
                        
                        .email-masthead_logo {
                          width: 94px;
                        }
                        
                        .email-masthead_name {
                          font-size: 16px;
                          font-weight: bold;
                          color: #A8AAAF;
                          text-decoration: none;
                          text-shadow: 0 1px 0 white;
                        }
                        /* Body ------------------------------ */
                        
                        .email-body {
                          width: 100%;
                          margin: 0;
                          padding: 0;
                          -premailer-width: 100%;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                        }
                        
                        .email-body_inner {
                          width: 570px;
                          margin: 0 auto;
                          padding: 0;
                          -premailer-width: 570px;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                          background-color: #FFFFFF;
                        }
                        
                        .email-footer {
                          width: 570px;
                          margin: 0 auto;
                          padding: 0;
                          -premailer-width: 570px;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                          text-align: center;
                        }
                        
                        .email-footer p {
                          color: #A8AAAF;
                        }
                        
                        .body-action {
                          width: 100%;
                          margin: 30px auto;
                          padding: 0;
                          -premailer-width: 100%;
                          -premailer-cellpadding: 0;
                          -premailer-cellspacing: 0;
                          text-align: center;
                        }
                        
                        .body-sub {
                          margin-top: 25px;
                          padding-top: 25px;
                          border-top: 1px solid #EAEAEC;
                        }
                        
                        .content-cell {
                          padding: 45px;
                        }
                        /*Media Queries ------------------------------ */
                        
                        @media only screen and (max-width: 600px) {
                          .email-body_inner,
                          .email-footer {
                            width: 100% !important;
                          }
                        }
                        
                        @media (prefers-color-scheme: dark) {
                          body,
                          .email-body,
                          .email-body_inner,
                          .email-content,
                          .email-wrapper,
                          .email-masthead,
                          .email-footer {
                            background-color: #333333 !important;
                            color: #FFF !important;
                          }
                          p,
                          ul,
                          ol,
                          blockquote,
                          h1,
                          h2,
                          h3,
                          span,
                          .purchase_item {
                            color: #FFF !important;
                          }
                          .attributes_content,
                          .discount {
                            background-color: #222 !important;
                          }
                          .email-masthead_name {
                            text-shadow: none !important;
                          }
                        }
                        
                        :root {
                          color-scheme: light dark;
                          supported-color-schemes: light dark;
                        }
                        </style>
                        <!--[if mso]>
                        <style type="text/css">
                          .f-fallback  {
                            font-family: Arial, sans-serif;
                          }
                        </style>
                      <![endif]-->
                      </head>
                      <body>
                        <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                               
                                <!-- Email Body -->
                                <tr>
                                  <td class="email-body" width="570" cellpadding="0" cellspacing="0">
                                    <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                      <!-- Body content -->
                                      <tr>
                                        <td class="content-cell">
                                          <div class="f-fallback">
                                            <h1>Hi ' . $firstName . '</h1>
                                            <p>You recently requested to reset your password for your Eve School Management System account. Use the button below to reset it. <strong>This password reset is only valid for the next 24 hours.</strong></p>
                                            <!-- Action -->
                                            <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                              <tr>
                                                <td align="center">
                                                  <!-- Border based button
                               https://litmus.com/blog/a-guide-to-bulletproof-buttons-in-email-design -->
                                                  <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                    <tr>
                                                      <td align="center">
                                                      <a href="' . $resetLink . '" class="f-fallback button button--green" target="_blank">Reset your password</a>
                                                      </td>
                                                    </tr>
                                                  </table>
                                                </td>
                                              </tr>
                                            </table>
                                            <p>For security, this request was received from a Windows Operating System device. If you did not request a password reset, please ignore this email or <a href="tel:+254707583092">contact support</a> if you have questions.</p>
                                            <p>Thanks,
                                              <br>The Tech team</p>
                                           
                                             <table class="body-sub" role="presentation">
                                              <tr>
                                                <td>
                                                  <p class="f-fallback sub">If you’re having trouble with the button above, copy and paste the URL below into your web browser.</p>
                                                  <p class="f-fallback sub">' . $resetLink . '</p>
                                                </td>
                                              </tr>
                                            </table> 
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                                      <tr>
                                        <td class="content-cell" align="center">
                                          <p class="f-fallback sub align-center">
                                            Eve School Management System
                                          </p>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </body>
                    </html>';



$MessageTEXT = "test message";

$Send = SendMail($ToEmail, $htmlContent, $MessageTEXT);

$updateTokenResult = false;  // Initialize the variable

if ($Send) {
    echo "<div class='alert alert-success' role='alert'>Password reset link sent to your email account!! </div>";

    // Check if the token already exists for the email
    $token_check_query = "SELECT * FROM tbltoken WHERE emailAddress='$email' LIMIT 1";
    $token_rs = $conn->query($token_check_query);
    $token_num = $token_rs->num_rows;

    // Generate a new token
    $token = bin2hex(random_bytes(16));
    $currentTime = time();

    if ($token_num > 0) {
        // Token exists, update the row with the new token and current time
        $updateTokenQuery = "UPDATE tbltoken SET token='$token', timestamp='$currentTime' WHERE emailAddress='$email'";
        $updateTokenResult = $conn->query($updateTokenQuery);
    } else {
        // Token does not exist, insert a new row with the token and current time
        $insertTokenQuery = "INSERT INTO tbltoken (emailAddress, token, timestamp) VALUES ('$email', '$token', '$currentTime')";
        $updateTokenResult = $conn->query($insertTokenQuery);
    }

    if (!$updateTokenResult) {
        echo "<div class='alert alert-danger' role='alert'>Error updating token. Please try again.</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>Error: " . $Mail->ErrorInfo . "</div>";
}




   
				}
            
                else{

                    echo "<div class='alert alert-danger' role='alert'>
                    Invalid Email!
                    </div>";
            
                  }
                }
            }
			?>

                                    <div class="text-center">
                                        <img src="img/logo/attnlg.jpg" style="width:100px;height:100px">
                                        <br><br>
                                        <h1 class="h4 text-gray-900 mb-4">Forgot Password</h1>
                                        <p>Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.</p>
                                    </div>
                                    <form class="user" method="Post" action="">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" id="exampleInputEmail" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <!-- <label class="custom-control-label" for="customCheck">Remember
                          Me</label> -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary btn-block" value="Submit" name="submit" />
                                        </div>
                                    </form>

                               

                                    <!-- <hr>
                    <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a> -->
                                    <hr>
                                    <div class="text-center">
                                        <!-- <a class="font-weight-bold small" href="memberSetup.php">Create a Memeber Account!</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                                        <!-- <a class="font-weight-bold small" href="organizationSetup.php">Setup Cooperative Account!</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                                        <!-- <a class="font-weight-bold small" href="forgotPassword.php">Forgot Password?</a> -->

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