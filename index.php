<?php
	error_reporting(E_ALL);
	session_start();
include("fonctions.php");

if(isset($_REQUEST['submit-form'])) {
	if(isset($_REQUEST['username']) &&  strtolower($_REQUEST['username']) == 'elie' && $_REQUEST['password'] == 'test12') {
		$_SESSION['username'] = 'elie';
		header('Location: dashboard.php');      
		exit();
	} else {
		echo "erreur bad login/password";
	}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>IOT</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="" name="description" />
        <meta content="themes-lab" name="author" />
        <link rel="shortcut icon" href="assets/global/images/favicon.png">
        <link href="assets/global/css/style.css" rel="stylesheet">
        <link href="assets/global/css/ui.css" rel="stylesheet">
        <link href="assets/global/plugins/bootstrap-loading/lada.min.css" rel="stylesheet">
    </head>
    <body class="account separate-inputs" data-page="login">
        <!-- BEGIN LOGIN BOX -->
        <div class="container" id="login-block">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <div class="account-wall">
                        <i class="user-img icons-faces-users-03"></i>
                        <form class="form-signin" role="form" method="POST" action="index.php">
                            <div class="append-icon">
                                <input type="text" name="username" id="username" class="form-control form-white username" placeholder="Username" required>
                                <i class="icon-user"></i>
                            </div>
                            <div class="append-icon m-b-20">
                                <input type="password" name="password" class="form-control form-white password" placeholder="Password" required>
                                <i class="icon-lock"></i>
                            </div>
                            <button type="submit" id="submit-form" name="submit-form" class="btn btn-lg btn-danger btn-block ladda-button" data-style="expand-left">Sign In</button>
                            
                        </form>
                        
                    </div>
                </div>
            </div>
            <p class="account-copyright">
                <span>Copyright © 2016 </span><span>Elie</span> <span>All rights reserved.</span>
            </p>
        </div>
       <script src="assets/global/plugins/jquery/jquery-3.1.0.min.js"></script>
        <script src="assets/global/plugins/jquery/jquery-migrate-3.0.0.min.js"></script>
        <script src="assets/global/plugins/gsap/main-gsap.min.js"></script>
        <script src="assets/global/plugins/tether/js/tether.min.js"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/global/plugins/backstretch/backstretch.min.js"></script>
        <script src="assets/global/plugins/bootstrap-loading/lada.min.js"></script>
        <script src="assets/global/js/pages/login-v1.js"></script>
    </body>
</html>