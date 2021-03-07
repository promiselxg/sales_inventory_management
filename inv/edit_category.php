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
    if(isset($_GET['id']) && isset($_GET['id']) != ""){
        //accept incoming values
        $id = preg_replace('#[^0-9]#','',$_GET['id']);
        //$author = preg_replace('#[^a-z ]#i','',$_POST['author']);
        if($id == ""){
            header("location:index");exit();
        }
        //check if ID exist
        $id_check = mysqli_query($conx, 'SELECT * FROM category WHERE id = '.$id.' LIMIT 1');
        if(mysqli_num_rows($id_check) < 1){
            header("location:index");exit();
        }else{
            while($row = mysqli_fetch_array($id_check)){
                $category_name = $row['category_name'];
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

    <title><?php echo $category_name;?>'s Category </title>

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
						<h2>Update Category </h2>
						<div class="clearfix"></div>
					 </div>
                     <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="view_category" style="color:#fff !important;">View Category</a></div>
                     <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="new_category" style="color:#fff !important;">New Category</a></div>
					<div class="x_content">
                     <div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="clearfix"></div>
								<div class="x_content">
									<form onsubmit="return false">
								
								
								<div class="form-group">
								  <label for="category">Category Name</label>
								  <input type="text" id="category_name" class="form-control"  data-parsley-trigger="change" value="<?php echo $category_name;?>"/>
								</div>
                                <input type="hidden" id="created_by" value="<?php echo $log_username;?>"/>
                                <input type="hidden" id="cat_type" value="edit"/>
                                <input type="hidden" id="cat_id" value="<?php echo $id;?>"/>
								<span class="btn btn-success" onclick="newCategory()" style="cursor:pointer" id="cate_Btn">Edit Category</span>
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
