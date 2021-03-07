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
  $product_name = "";$product_id = "";
  $sql = mysqli_query($conx, 'SELECT * FROM products');
  while($row = mysqli_fetch_array($sql)){
    $product_name .= '<option value='.$row['id'].'>'.$row['product_name'].'</option>';
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

    <title>New Sale</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../vendors/build/css/custom.min.css" rel="stylesheet">
    <script>
      
    </script>
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
            <?php if($user_level == "b" || $user_level == "c"){
              echo '<div class="btn btn-success" style="float:right;margin-right:12px;"><a href="view_sales_report" style="color:#fff !important;">View Sales Report</a></div>';
            }?>
						<div class="clearfix"></div>
					 </div>
					<div class="x_content">
                     <div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="clearfix"></div>
								<div class="x_content">
								<form id="demo-form" onsubmit="return false">
									<div class="form-group">
									  <label for="heard">Product Name *:</label>
									  <select id="product_name" class="form-control" onchange="queryDB(this.id,'stock_qty','product_id')">
										<option value="">Choose..</option>
											<?php echo $product_name;?>
									  </select>
									</div>
							  
									<div class="form-group">
									  <label for="stock_qty">Stock Available * :</label>
									  <input type="text" id="stock_qty" class="form-control" name="stock_qty" data-parsley-trigger="change" disabled />
									</div>
									<div class="form-group">
									  <label for="price">Price Sold For * :</label>
									  <input type="text" id="price" class="form-control" name="price" data-parsley-trigger="change" autocomplete="off"/>
									</div>
									<div class="form-group">
									  <label for="qty">Quantity * :</label>
									  <input type="text" id="qty" class="form-control" name="qty" data-parsley-trigger="change" autocomplete="off"/>
									</div>
									<div class="form-group">
									  <label for="customer_name">Customer's Name</label>
									  <input type="text" id="customer_name" class="form-control" name="customer_name" data-parsley-trigger="change" autocomplete="off"/>
									</div>
									<div class="form-group">
									  <label for="date">Transaction Date</label>
									  <input type="date" id="date" class="form-control" name="qty" data-parsley-trigger="change" style="width:180px;cursor:pointer" autocomplete="off"/>
									</div>
									<div class="form-group">
									<label for="heard">Sales Type</label>
									  <select id="sales_type" class="form-control" style="width:180px;cursor:pointer" autocomplete="off">
										  <option value="cash">Cash Sales</option>
										  <option value="credit">Credit Sales</option>
									  </select>
									</div>
									<input type="hidden" id="type" value="new"/>
									<input type="hidden" id="created_by" value="<?php echo $log_username;?>"/>
									<input type="hidden" id="product_id"/>
									<input type="hidden" id="id" value=""/>
									<button class="btn btn-success" onclick="makeSale()">Submit</button>
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
