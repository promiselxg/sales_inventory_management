<?php
    include_once('scripts/userlog.php');
?>
<?php
	if($log_username == ""){
		header('location:index');exit();
	}
	//echo $log_username;
?>
<?php 
    if(isset($_POST['c_name']) && isset($_POST['author'])){
        //accept incoming values
        $c_name = preg_replace('#[^a-z0-9 ]#i','',$_POST['c_name']);
        $author = preg_replace('#[^a-z ]#i','',$_POST['author']);
        $cat_type = preg_replace('#[^a-z]#i','',$_POST['cat_type']);
        $id = preg_replace('#[^0-9]#i','',$_POST['id']);
        if($c_name == "" || $author == ""){
            echo "Please Fill out the Form|error";exit();
        }
        //check if author exist
        $author_check = mysqli_query($conx,'SELECT id FROM admin WHERE username = "'.$author.'" LIMIT 1');
        if(mysqli_num_rows($author_check) < 1){
           header("location:logout");exit();
        }
        //check if category already exist
        //check if Category Type == New
        if($cat_type == "new"){
          $title_check = mysqli_query($conx,'SELECT id FROM expense_type WHERE type_name = "'.$c_name.'" LIMIT 1');
          if(mysqli_num_rows($title_check) > 0){
              echo "This Expense Type Already Exist|error";exit();
          }
          //insert data to DB
          $sql = mysqli_query($conx,'INSERT into expense_type (type_name,date_created,created_by) VALUES ("'.$c_name.'",now(), "'.$author.'" ) ');
          $msg = "New Expense Type Created Successfully";
        }elseif($cat_type == "edit"){
          //new category
          $sql = mysqli_query($conx, 'UPDATE expense_type SET type_name = "'.$c_name.'", created_by = "'.$author.'",modified_date = now() WHERE id = "'.$id.'" ');
          $msg = "Expense Type Updated Successfully";
        }else{
          echo "An Unknown Error Occured|error";exit();
        }
        
        if($sql){
            echo "$msg|success";exit();
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

    <title>New Expense</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $log_username;?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <?php include_once("includes/sideBar.php");?>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <?php include_once("includes/use_profile_link.php");?>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
					 <div class="x_title">
						<h2>Create New Expense Heading </h2>
						<div class="clearfix"></div>
					 </div>
                     <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="new_expense" style="color:#fff !important;">Add Expense</a></div>
					<div class="x_content">
                     <div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="clearfix"></div>
								<div class="x_content">
									<form onsubmit="return false">
								
								
								<div class="form-group">
								  <label for="category">Expenses Heading/Name</label>
								  <input type="text" id="expense_name" class="form-control"  data-parsley-trigger="change" placeholder="Enter Expense Name"/>
								</div>
                                <input type="hidden" id="created_by" value="<?php echo $log_username;?>"/>
                                <input type="hidden" id="cat_type" value="new"/>
                                <input type="hidden" id="cat_id" value=""/>
								<span class="btn btn-success" onclick="newExpenseType()" style="cursor:pointer" id="cate_Btn">Save</span>
							</form>
									<br><br>
									
									
									
								</div>
							</div>
						</div>
					 </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <?php include_once("includes/footer.php");?>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
   <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../vendors/build/js/custom.min.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>
