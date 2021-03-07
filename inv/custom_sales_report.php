<?php
    include_once('scripts/userlog.php');
?>
<?php
	if($log_username == ""){
    header('location:index');exit();
  }
?>
<?php
    $table = "";$status = "";$grand_total = 0;$c = 1;
    if(isset($_GET['start']) && isset($_GET['end']) && isset($_GET['type'])){
        $start = preg_replace('#[^0-9]#','/',$_GET['start']);
        $end = preg_replace('#[^0-9]#','/',$_GET['end']);
        $type = preg_replace('#[^a-z]#','',$_GET['type']);
            if($start == "" || $end == "" || $type == ""){
                header("location:view_sales_report");exit();
            }else{
                $sql = mysqli_query($conx, 'SELECT * FROM new_sales WHERE create_date >="'.$start.'" AND create_date <="'.$end.'" AND sales_type = "'.$type.'" ' );
                while($row = mysqli_fetch_array($sql)){
                    $sales_type = $row['sales_type'];
                    //sales type
                    if($sales_type == "credit"){
                         $status = '<span class="label label-danger">'.$row['sales_type'].'</span>';
                    }else{
                         $status = '<span class="label label-success">'.$row['sales_type'].'</span>';
                    }
                    if($user_level == "c"){
                         $btn = '<a href="#" onclick="removeItem(\'tbl_'.$row['id'].'\',\'new_sales\')"><button class="btn btn-danger"><i class="fa fa-times"></i></button></a>';
                    }else{
                         $btn = "";
                    }
                      $table .= '<tr id="tbl_'.$row['id'].'"><td>'.$c++.'</td><td>'.$row['product_name'].'</td><td>'.$row['quantity'].'</td><td><b>&#x20A6;'.number_format($row['price']).'</b></td><td><b>&#x20A6;'.number_format($row['total_price']).'</b></td><td>'.strftime("%b %d, %Y",strtotime($row['create_date'])).'</td><td>'.$status.'</td><td><a href="invoice?id='.$row['id'].'"><button class="btn btn-success"><i class="fa fa-eye"></i></button></a>'.$btn.'</td></tr>';
                        //calculate grand total
                      $grand_total = $grand_total += $row['total_price'];
                }
            }
       // echo $start;
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

    <title>Sales Report Management</title>

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
    <style>
      .label {
        display: inline;
        padding: .2em .6em .3em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;
    }
    .label-danger{
      background-color: #d9534f;
    }
    .label-success{
      background-color: #5cb85c;
    }
    </style>
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
                    <h2>Customized Sales Report</h2>
                    <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="make_sale" style="color:#fff !important;">Make New Sales</a></div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                    
                    <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>Price per Item</th>
                          <th>Total Price</th>
                          <th>Date Sold</th>
                          <th>Sales Type</th>
                          <th>Manage</th>
                        </tr>
                      </thead>


                      <tbody>
                        <?php echo $table;?>
                      </tbody>
                      <thead>
                        <tr>
                          <th colspan="3"></th>
                          <th>Grand Total</th>
                          <th><?php echo '<b>&#x20A6;'.number_format($grand_total).'</b>';?></th>
                          <th colspan="3"></th>
                        </tr>
                      </thead>
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
                            <div class="form-group col-md-3">
                                <label><b>Sales Type</b></label>
                                <select id="sales_type" class="form-control" style="cursor:pointer">
                                    <option value="cash">Cash Sales</option>
                                    <option value="credit">Credit Sales</option>
                                </select>
                            </div>
                            <input type="hidden" value="sales" id="type"/>
                            <div class="form-group col-md-3">
                                <button class="btn btn-info" style="margin-top:25px" onclick="getCustomReport()">Get Sales Report</button>
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