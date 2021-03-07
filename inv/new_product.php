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
    if(isset($_POST['p_name'])){
        $p_name = preg_replace('#[^a-z0-9 ]#i','',$_POST['p_name']);
        $category = preg_replace('#[^a-z ]#i','',$_POST['cat']);
        $qty = preg_replace('#[^0-9]#','',$_POST['qty']);
        $price = preg_replace('#[^0-9.]#','',$_POST['price']);
        $product_type = preg_replace('#[^a-z]#','',$_POST['product_type']);
        $_id = preg_replace('#[^0-9]#','',$_POST['product_id']);
        //check if everything is okay
        if($p_name == "" || $category == "" || $qty == "" || $price == ""){
            echo "Please fill out the form before clicking the submit button|error";exit();
        }
        
        //check if category exist
        $cat_chk = mysqli_query($conx,'SELECT id FROM category WHERE category_name = "'.$category.'" LIMIT 1');
        if(mysqli_num_rows($cat_chk) == 0){
            echo "Please Select A Product Category|error";exit();
        }else{
          //get category ID
          while($row = mysqli_fetch_row($cat_chk)){
            $cat_id = $row[0];
          }
        }
        if($product_type == "new"){
          //check if product name exist
          $product_check = mysqli_query($conx,'SELECT id FROM products WHERE product_name = "'.$p_name.'" LIMIT 1');
          if(mysqli_num_rows($product_check) > 0){
              echo "Product Name already Exist.|error";exit();
          }
        }
        //calculate total price
        $total_price = $price * $qty;
        if($product_type == "new"){
          //insert Data to DB
           $sql = mysqli_query($conx, 'INSERT into products (product_name,category_name,category_id,quantity,price,created_by,date_created,total_price) VALUES ("'.$p_name.'","'.$category.'","'.$cat_id.'","'.$qty.'","'.$price.'","'.$log_username.'",now(),"'.$total_price.'") ');
           $p_id = mysqli_insert_id($conx);
           //Insert Data into Product Stock Table
           $stock = mysqli_query($conx, 'INSERT into product_stock (product_id,starting_qty,remaining_qty,date_created) VALUES ("'.$p_id.'","'.$qty.'","'.$qty.'",now() ) ');
           $msg = "New Product Added Successfully";
        }else{
          //UPDATE Data in DB
          $sql = mysqli_query($conx, 'UPDATE products SET product_name = "'.$p_name.'", category_name = "'.$category.'", category_id = "'.$cat_id.'", quantity = "'.$qty.'", price = "'.$price.'", created_by = "'.$log_username.'",date_modified = now(), total_price = "'.$total_price.'" WHERE id = "'.$_id.'" LIMIT 1 ' );
          //Update Stock
          $stock = mysqli_query($conx, 'UPDATE product_stock SET remaining_qty = "'.$qty.'" WHERE product_id = "'.$_id.'" LIMIT 1' );
          $msg = "Product Updated Successfully";
        }
          //UPDATE PRODUCT STOCK TABLE
        if($sql && $stock){
            echo "$msg|success";exit();
        }else{
            echo mysqli_error($conx)."Unable to complete this Operation, Please try again|error";exit();
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
						<h2>Make A New Sale</h2>
						<div class="clearfix"></div>
					 </div>
					<div class="x_content">
                     <div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
                        
							<div class="x_panel">
								<div class="clearfix"></div>
                                <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="view_product" style="color:#fff !important;">View Products</a></div>
								<div class="x_content">
								<form id="demo-form" onsubmit="return false">
                                <div class="form-group">
								  <label for="p_name">Product Name</label>
								  <input type="text" id="p_name" class="form-control" name="p_name" data-parsley-trigger="change"  />
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
								  <input type="text" id="qty" class="form-control" name="qty" data-parsley-trigger="change"/>
								</div>
								<div class="form-group">
								  <label for="price">Price Per Item</label>
								  <input type="text" id="price" class="form-control" name="price" data-parsley-trigger="change"/>
                  <input type="hidden" value="new" id="product_type"/>
                  <input type="hidden" value="" id="product_id"/>
								</div>
								<span class="btn btn-success" onclick="addNewProduct()" style="cursor:pointer" id="product_btn">Add New Product</span>
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
