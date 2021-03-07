<?php include_once('scripts/userlog.php');?>
<?php
	if($log_username != ""){
		header('location:dashboard');exit();
	}
	//echo $log_username;
?>
<?php
	if(isset($_POST['u']) && isset($_POST['p'])){
		$u = preg_replace('#[^a-zA_Z0-9_]#','',$_POST['u']);
		$p = $_POST['p'];
		$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
			if($u == "" || $p == ""){
				echo "Enter your Username and Password|warning";exit();
			}else{
				$user_pass_check = mysqli_query($conx,'SELECT id,username,password,user_level FROM user_option WHERE username = "'.$u.'" AND blocked = "0" LIMIT 1');
					if(mysqli_num_rows($user_pass_check) > 0){
						$row = mysqli_fetch_row($user_pass_check);
							$db_pass = $row[2];
							$username = $row[1];
              $id = $row[0];
              $ul = $row[3];
						if(!password_verify($p,$db_pass)){
							echo "Incorrect Username or Password|error";exit();
						}else{
							//session_start();
							$_SESSION['userid'] = $id;
							$_SESSION['user'] = $username;
              $_SESSION['pass'] = $db_pass;
              $_SESSION['ul'] = $ul;
							setcookie("id", $id, strtotime( '+30 days' ), "/", "", "", TRUE);
							setcookie("user", $username, strtotime( '+30 days' ), "/", "", "", TRUE);
              setcookie("pass", $db_pass, strtotime( '+30 days' ), "/", "", "", TRUE); 
              setcookie("ul", $db_pass, strtotime( '+30 days' ), "/", "", "", TRUE);
						  $sql = "UPDATE admin SET ip_address='$ip', last_login=now() WHERE username='$username' LIMIT 1";
							$query = mysqli_query($conx, $sql);
							echo "Successfully Logged In|success";exit();
						}
					}
					else{
						echo "Incorrect Username or Password.|warning";exit();
					}
			}	
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Login</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form>
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" id="uname"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" id="pass"/>
              </div>
              <div>
                <a class="btn btn-success" style="float:right;color:#fff;cursor:pointer" onclick="loginForm()" id="loginBtn">Log in</a>
              </div>
             
              <div class="clearfix"></div>

              
            <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1 style="font-size:20px;">Versity Food and Beverages Enterprise.</h1>
                  <p>&copy; <?php echo date('Y');?> All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/custom.js"></script>     
  </body>
</html>
