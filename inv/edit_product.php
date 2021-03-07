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
        $id = preg_replace('#[^0-9]#','',$_GET['id']);
            if($id == ""){
                header("location:index");exit();
            }
        $sql = mysqli_query($conx, 'SELECT * FROM products WHERE id = '.$id.' ' );
        while($row = mysqli_fetch_array($sql)){
            $sql_ = mysqli_query($conx,'SELECT remaining_qty FROM product_stock WHERE product_id = '.$id.' ' );
            while($row_ = mysqli_fetch_row($sql_)){
              $qtt = $row_[0];
            }
            $qty = $qtt;
            $price = $row['price'];
            $p_name = $row['product_name'];
        }
    }else{
        header("location:index");exit();
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

    <title>Create New Product </title>

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
						<h2>Edit Product</h2>
						<div class="clearfix"></div>
					 </div>
					<div class="x_content">
                     <div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
                        
							<div class="x_panel">
								<div class="clearfix"></div>
                                <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="view_product" style="color:#fff !important;">View Products</a></div>
                                <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="new_product" style="color:#fff !important;">New Products</a></div>
								<div class="x_content">
								<form id="demo-form" onsubmit="return false">
                                <div class="form-group">
								  <label for="p_name">Product Name</label>
								  <input type="text" id="p_name" class="form-control" name="p_name" data-parsley-trigger="change" value="<?php echo $p_name;?>" />
								</div>
								<div class="form-group">
								  <label for="category">Category</label>
                                  <select id="cat" class="form-control">
                                  <option value="">Choose..</option>
                                  <?php 
                                    $sql = mysqli_query($conx,'SELECT * FROM category');
                                    while($row = mysqli_fetch_array($sql)){
                                        echo '<option value="'.$row['category_name'].'">'.ucwords($row['category_name']).'</option>';
                                        
                                    }
                                  ?>
								  </select>
								</div>
								<div class="form-group">
								  <label for="qty">Quantity Available</label>
								  <input type="text" id="qty" class="form-control" name="qty" data-parsley-trigger="change" value="<?php echo $qty;?>"/>
								</div>
								<div class="form-group">
								  <label for="price">Price Per Item</label>
								  <input type="text" id="price" class="form-control" name="price" data-parsley-trigger="change" value="<?php echo $price;?>"/>
                                    <input type="hidden" value="edit" id="product_type"/>
                                    <input type="hidden" value="<?php echo $id;?>" id="product_id"/>
								</div>
								<span class="btn btn-success" onclick="addNewProduct()" style="cursor:pointer" id="product_btn">Edit Product</span>
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
