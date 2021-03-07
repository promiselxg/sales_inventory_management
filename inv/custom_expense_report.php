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
     $display = "";$status = "";$grand_total = 0;$c = 1;
    if(isset($_GET['start']) && isset($_GET['end'])){
        $start = preg_replace('#[^0-9-]#','',$_GET['start']);
        $end = preg_replace('#[^0-9-]#','',$_GET['end']);
            if($start == "" || $end == ""){
                header("location:view_expense_report");exit();
            }else{
                $sql = mysqli_query($conx, 'SELECT * FROM expense_tbl WHERE date_created >="'.$start.'" AND date_created <="'.$end.'" ' );
                while($row = mysqli_fetch_array($sql)){
                    if($user_level == "c"){
                        $btn = '<a href="edit_expense?id='.$row['id'].'"><button class="btn btn-success"><i class="fa fa-pencil"></i></button></a><a href="#" onclick="removeItem(\'tbl_'.$row['id'].'\',\'expense_tbl\')"><button class="btn btn-danger"><i class="fa fa-times"></i></button></a>';
                      }elseif($user_level == "b"){
                        $btn = '<a href="edit_expense?id='.$row['id'].'"><button class="btn btn-success"><i class="fa fa-pencil"></i></button></a>';
                      }else{
                        $btn = "";
                      }
                      $display .='<tr id="tbl_'.$row['id'].'"><td>'.$c++.'</td><td>'.$row['expense_type'].'</td><td>'.$row['product_name'].'</td><td>'.$row['description'].'</td><td><b>&#x20A6;'.number_format($row['paid_amount']).'</b></td><td><b>&#x20A6;'.number_format($row['total_amount']).'</b></td><td>'.$row['expense_by'].'</td><td>'.strftime("%b %d, %Y",strtotime($row['date_created'])).'</td><td>'.$btn.'</td></tr>';
                }
                //echo $start;
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

    <title>Expense Management</title>

    <!-- Bootstrap -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

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
                <img src="images/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $log_username;?></h2>
              </div>
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
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
				
        <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Expense Management</h2>
                    <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="new_expense" style="color:#fff !important;">Add New Expenses</a></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                    
                    <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Expense Type</th>
                          <th>Product Name</th>
                          <th>Description</th>
                          <th>Paid Amount</th>
                          <th>Total Amount</th>
                          <th>Created By</th>
                          <th>Date</th>
                          <th>Manage</th>
                        </tr>
                      </thead>


                      <tbody>
                      <?php
                          echo $display;
                      ?>
                      </tbody>
                    </table>
                  </div>
                  
                </div>
                <?php
                   if($user_level == "b" || $user_level == "c"){
                      echo '<form onsubmit="return false" style="margin:30px 0px 0px 15px">
                            <div class="form-group col-md-3">
                                <label><b>Start Date</b></label>
                                <input type="date" placeholder="Start Date" id="start" class="form-control"  style="cursor:pointer"/>
                            </div>
                            <div class="form-group col-md-3">
                                <label><b>End Date</b></label>
                                <input type="date" placeholder="End Date" id="end" class="form-control"  style="cursor:pointer"/>
                            </div>
                            <input type="hidden" value="expense" id="type"/>
                            <input type="hidden" value="" id="sales_type"/>
                            <div class="form-group col-md-3">
                                <button class="btn btn-info" style="margin-top:25px" onclick="getCustomReport()">Get Expense Report</button>
                            </div>
                      </form>';
                   }
                ?>
              </div>
            </div>
          </div>
        </div>


            </div>
          </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
   <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
  

    <!-- Custom Theme Scripts -->
    <script src="../vendors/build/js/custom.min.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>