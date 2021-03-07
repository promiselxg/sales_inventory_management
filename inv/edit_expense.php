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
        $sql = mysqli_query($conx, 'SELECT * FROM expense_tbl WHERE id = '.$id.' LIMIT 1' );
        while($row = mysqli_fetch_array($sql)){
            $expense_id = $row['id'];
            $expense_type = $row['expense_type'];
            $expense_desc = $row['description'];
            $total_amount = $row['total_amount'];
            $paid_amount = $row['paid_amount'];
            $product_name = $row['product_name'];
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

    <title><?php echo $product_name;?></title>

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
            <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="expense_type" style="color:#fff !important;">Create Expense Type</a></div>
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
                                            <textarea id="expense_desc" rows="3"  class="form-control" onkeyup="notAllowed(this.id)"><?php echo $expense_desc;?></textarea>
										</div>
										<div class="form-group">
										  <label for="total_amount">Total Amount</label>
										  <input type="text" id="total_amount" class="form-control" value="<?php echo $total_amount;?>" data-parsley-trigger="change" required />
										</div>
										<div class="form-group">
										  <label for="paid_amount">Paid Amount</label>
										  <input type="text" id="paid_amount" class="form-control" value="<?php echo $paid_amount;?>" data-parsley-trigger="change" required />
										</div>
										<div class="form-group">
										  <label for="product_name">Product Name</label>
										  <input type="text" id="product_name" class="form-control" value="<?php echo $product_name;?>" data-parsley-trigger="change" required />
										</div>
                                        <input type="hidden" id="created_by" value="<?php echo $log_username;?>"/>
                                        <input type="hidden" id="type" value="edit"/>
                                        <input type="hidden" id="expense_id" value="<?php echo $expense_id;?>"/>
										<span class="btn btn-success" onclick="newExpense()">Update</span>
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
