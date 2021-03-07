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
    if(isset($_POST['expense_type'])){
        $expense_type = preg_replace('#[^a-z0-9 ]#i','',$_POST['expense_type']);
        $expense_desc = preg_replace('#[^a-z0-9. ]#i','',$_POST['expense_desc']);
        $total_amount = preg_replace('#[^0-9.]#','',$_POST['total_amount']);
        $paid_amount = preg_replace('#[^0-9.]#','',$_POST['paid_amount']);
        $type = preg_replace('#[^a-z]#','',$_POST['type']);
        $product_name = preg_replace('#[^a-z ]#i','',$_POST['product_name']);
        $created_by = preg_replace('#[^a-z]#i','',$_POST['created_by']);
        $expense_id = preg_replace('#[^0-9]#','',$_POST['expense_id']);
        //check if everything is okay
        if($expense_type == "" || $expense_desc == "" || $total_amount == "" || $paid_amount == "" || $created_by == ""|| $product_name == ""){
            echo "Please fill out the form before clicking the submit button|error";exit();
        }
        
        //check if category exist
        $cat_chk = mysqli_query($conx,'SELECT id FROM expense_type WHERE type_name = "'.$expense_type.'" LIMIT 1');
        if(mysqli_num_rows($cat_chk) == 0){
            echo "Please Select An Expense Type|error";exit();
        }else{
          //get category ID
          while($row = mysqli_fetch_row($cat_chk)){
            $cat_id = $row[0];
          }
        }
        //check if Paid Amount > Total Amount
        if($paid_amount > $total_amount){
          echo "Paid Amount CANNOT be Greater than the Total Amount|error";exit();
        }
        if($type == "new"){
          //insert Data to DB
          $sql = mysqli_query($conx, 'INSERT into expense_tbl (
              expense_type,type_id,description,total_amount,paid_amount,product_name,expense_by,date_created
          ) values (
              "'.$expense_type.'","'.$cat_id.'","'.$expense_desc.'","'.$total_amount.'","'.$paid_amount.'","'.$product_name.'","'.$created_by.'",now()
          )  ' );
           $p_id = mysqli_insert_id($conx);
           //Insert Data into Product SALES Table
           $sales = mysqli_query($conx, 'INSERT into sales_tbl (product_id,amount,date_created) VALUES ("'.$p_id.'","'.$total_amount.'",now() ) ');
           $msg = "New Expense Added Successfully";
        }else{
          //UPDATE Data in DB
          $sql = mysqli_query($conx, 'UPDATE expense_tbl SET expense_type = "'.$expense_type.'", type_id = "'.$cat_id.'", description = "'.$expense_desc.'", total_amount = "'.$total_amount.'", paid_amount = "'.$paid_amount.'", product_name = "'.$product_name.'", expense_by = "'.$created_by.'", date_modified = now() WHERE id = "'.$expense_id.'" LIMIT 1' );
          //UPDATE SALES TABLE
          $sales = mysqli_query($conx, 'UPDATE sales_tbl SET amount = "'.$total_amount.'", modified_date = now() WHERE product_id = "'.$expense_id.'" LIMIT 1' );
          $msg = "Expense Updated Successfully";
        }
        if($sql){
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

    <title>Expense Management</title>

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
						<h2>Expense Management</h2>
						<div class="btn btn-success" style="float:right;margin-right:12px;"><a href="expenses" style="color:#fff !important;">View Expenses</a></div>
            <?php
              if($user_level == "c"){
                echo '<div class="btn btn-success" style="float:right;margin-right:12px;"><a href="expense_type" style="color:#fff !important;">Create Expense Type</a></div>';
              }
            ?>
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
										  <label for="expense_type">Expense Type</label>
										  <select id="expense_type" class="form-control" required>
											<option value="">Choose..</option>
                        <?php
                          $sql = mysqli_query($conx,'SELECT * FROM expense_type');
                          while($row = mysqli_fetch_array($sql)){
                            echo '<option value="'.$row['type_name'].'" >'.$row['type_name'].'</option>';
                          }
                        ?>
										  </select>
										</div>
									  
										<div class="form-group">
										  <label for="expense_desc">Description</label>
                        <textarea id="expense_desc" rows="3" placeholder="Describe What this Expense is For" class="form-control" onkeyup="notAllowed(this.id)"></textarea>
										</div>
										<div class="form-group">
										  <label for="total_amount">Total Amount</label>
										  <input type="text" id="total_amount" class="form-control" name="Total Amount" data-parsley-trigger="change" required />
										</div>
										<div class="form-group">
										  <label for="paid_amount">Paid Amount</label>
										  <input type="text" id="paid_amount" class="form-control" name="Paid Amount" data-parsley-trigger="change" required />
										</div>
										<div class="form-group">
										  <label for="paid_amount">Product Name</label>
										  <input type="text" id="product_name" class="form-control" name="Product Name" data-parsley-trigger="change" required />
										</div>
                    <input type="hidden" id="created_by" value="<?php echo $log_username;?>"/>
                    <input type="hidden" id="type" value="new"/>
                    <input type="hidden" id="expense_id" value=""/>
										<span class="btn btn-success" onclick="newExpense()">Submit</span>
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
