<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

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
						<h2>Make A New Sale</h2>
						<div class="clearfix"></div>
					 </div>
					<div class="x_content">
                     <div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="clearfix"></div>
								<div class="x_content">
									<form id="demo-form" >
								<div class="form-group">
								  <label for="heard">Product Name *:</label>
								  <select id="heard" class="form-control" required>
									<option value="">Choose..</option>
									<option value="press">Press</option>
									<option value="net">Internet</option>
									<option value="mouth">Word of mouth</option>
								  </select>
								</div>
							  
								<div class="form-group">
								  <label for="email">Stock Available * :</label>
								  <input type="text" id="email" class="form-control" name="email" data-parsley-trigger="change" disabled />
								</div>
								<div class="form-group">
								  <label for="email">Price Sold For * :</label>
								  <input type="email" id="email" class="form-control" name="email" data-parsley-trigger="change" required />
								</div>
								<div class="form-group">
								  <label for="email">Quantity * :</label>
								  <input type="email" id="email" class="form-control" name="email" data-parsley-trigger="change" required />
								</div>
								<div class="form-group">
								  <p><label>Type of Sale *:</label>
									Cash Sales
									<input type="radio" class="flat" name="Cash Sales" id="genderM" value="Cash Sales" checked="" required /> Credit Sales
									<input type="radio" class="flat" name="Credit Sales" id="genderF" value="Credit Sales" />
								  </p>
								</div>
								<span class="btn btn-primary">Submit</span>
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
  </body>
</html>
