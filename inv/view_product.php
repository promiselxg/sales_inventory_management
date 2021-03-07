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
    if(isset($_POST['tbl']) && isset($_POST['cat'])){
        $id = preg_replace('#[^0-9]#','',$_POST['tbl']);
        $cat = preg_replace('#[^a-z]#i','',$_POST['cat']);
        //check if category ID exist
        $sql = mysqli_query($conx,'SELECT id FROM '.$cat.' WHERE id = '.$id.' LIMIT 1');
        if(mysqli_num_rows($sql) < 1){
            echo "An Unknown Errorx Occured |error";exit();
        }
        //remove category
        $sql = mysqli_query($conx,'DELETE FROM '.$cat.' WHERE id = '.$id.' LIMIT 1');
        if($sql){
            echo "Product Category Removed Successfully|success";exit();
        }
    }
?>
<?php
  $display = "";$status = "";$stock_ = "";$remaining_qty = "";
  $sql = mysqli_query($conx,'SELECT * FROM products order by date_created ASC');
  $c = 1;
  while($row = mysqli_fetch_array($sql)){
    //get stock quantity using product ID
     $stock = mysqli_query($conx,'SELECT remaining_qty FROM product_stock where  product_id = '.$row['id'].' ');
     while($row_1 = mysqli_fetch_row($stock)){
       $stock_ = $row_1[0];
       $remaining_qty = $stock_;
       //check if stock == Empty
       if($stock_ == 0){
         $status = '<span class="label label-danger"> out of stock </span>';
         $stock_ = '<span class="label label-danger"> NO</span>';
       }else{
        $status = '<span class="label label-success">in stock</span>';
        $stock_ = '<span class="label label-success"> YES</span>';
       }
     }
     if($user_level == "c"){
        $btn = '<a href="edit_product?id='.$row['id'].'"><button class="btn btn-success"><i class="fa fa-pencil"></i></button></a><a href="#" onclick="removeItem(\'tbl_'.$row['id'].'\',\'products\')"><button class="btn btn-danger"><i class="fa fa-times"></i></button></a>';
        }elseif($user_level == "b"){
            $btn = '<a href="edit_product?id='.$row['id'].'"><button class="btn btn-success"><i class="fa fa-pencil"></i></button></a>';
        }else{
          $btn = "";
        }
      $display .='<tr id="tbl_'.$row['id'].'"><td>'.$c++.'</td><td>'.$row['category_name'].'</td><td>'.$row['product_name'].'</td><td>'.$remaining_qty.'</td><td>'.$stock_.'</td><td><b>&#x20A6;'.number_format($row['price']).'</b></td><td><b>&#x20A6;'.number_format($row['total_price']).'</b></td><td>'.$status.'</td><td>'.$row['created_by'].'</td><td>'.$btn.'</td></tr>';
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

    <title>Products</title>

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
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
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
                    <h2>View Products</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                          <div class="col-sm-12">
                    <div class="btn btn-success" style="float:right;margin-right:12px;"><a href="new_product" style="color:#fff !important;">Create New Product</a></div>
                    <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <td>S/N</td>
                          <th>Category Name</th>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>In Stock </th>
                          <th>Price Per Item</th>
                          <th>Total Price</th>
                          <th>Status</th>
                          <th>Created By</th>
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