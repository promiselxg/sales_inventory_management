<?php include_once("scripts/userlog.php");?>
<?php
    //Remove an ITEM
    if(isset($_POST['tbl']) && isset($_POST['cat'])){
        $id = preg_replace('#[^0-9]#','',$_POST['tbl']);
        $cat = preg_replace('#[^a-z_]#i','',$_POST['cat']);
        //check if category ID exist
        $sql = mysqli_query($conx,'SELECT id FROM '.$cat.' WHERE id = '.$id.' LIMIT 1');
        if(mysqli_num_rows($sql) < 1){
            echo "An Unknown Error Occured |error";exit();
        }
        if($cat == "category"){
            $sql_ = mysqli_query($conx, 'DELETE FROM '.$cat.' WHERE id = '.$id.' LIMIT 1');
            $msg = "Category Removed Successfully";
        }
        elseif($cat == "products"){
            //remove product
            $sql = mysqli_query($conx,'DELETE FROM '.$cat.' WHERE id = '.$id.' LIMIT 1');
            //remove stock with this product ID
            $stock = mysqli_query($conx, 'DELETE FROM product_stock WHERE product_id = '.$id.' ' );
            $msg = "Product Removed Successfully";
        }
        elseif($cat == "expense_tbl"){
            //remove Expense
            $sql = mysqli_query($conx, 'DELETE FROM '.$cat.' WHERE id = '.$id.' LIMIT 1' );
            //remove sales where product_id == deleted expense ID
            $sales_id = mysqli_query($conx, 'DELETE FROM sales_tbl WHERE product_id = '.$id.' ' );
            $msg = "This Expense has been successfully removed";
        }
        elseif($cat == "user_option"){
           $sql = mysqli_query($conx, 'DELETE FROM user_option WHERE id = '.$id.' LIMIT 1' );
           $sql_ = mysqli_query($conx, 'DELETE FROM admin WHERE id = '.$id.' LIMIT 1' );
           $msg = "This user Has been removed successfully";
        }elseif($cat == "new_sales"){
            $sql = mysqli_query($conx, 'DELETE FROM '.$cat.' WHERE id = '.$id.' LIMIT 1' );
            $msg = "This Record has been successfully removed";
        }
        if($sql){
            echo  "$msg|success";exit();
        }
    }
?>
<?php
function randStrGen($len){
    $result = "";
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++){
	    $randItem = array_rand($charArray);
	    $result .= "".$charArray[$randItem];
    }
    return $result;
}
$username = randStrGen(10);
?>
<?php
    //New Category, Edit Category
    if(isset($_POST['c_name']) && isset($_POST['author'])){
        //accept incoming values
        $c_name = preg_replace('#[^a-z0-9 ]#i','',$_POST['c_name']);
        $author = preg_replace('#[^a-z0-9 ]#i','',$_POST['author']);
        $cat_type = preg_replace('#[^a-z_]#i','',$_POST['cat_type']);
        $id = preg_replace('#[^0-9]#i','',$_POST['id']);
        if($c_name == "" || $author == ""){
            echo "Please Fill out the Form|error";exit();
        }
        //check if author exist
        $author_check = mysqli_query($conx,'SELECT id FROM user_option WHERE username = "'.$author.'" LIMIT 1');
        if(mysqli_num_rows($author_check) == 0){
          header("location:logout");exit();
        }
        //check if category already exist
        //check if Category Type == New
        if($cat_type == "new"){
          $title_check = mysqli_query($conx,'SELECT id FROM category WHERE category_name = "'.$c_name.'" LIMIT 1');
          if(mysqli_num_rows($title_check) > 0){
              echo "This Category Already Exist|error";exit();
          }
          //insert data to DB
          $sql = mysqli_query($conx,'INSERT into category (category_name,created_by,date_created) VALUES ("'.$c_name.'","'.$author.'",now() ) ');
          $msg = "New Category Created Successfully";
        }elseif($cat_type == "edit"){
          //new category
          $sql = mysqli_query($conx, 'UPDATE category SET category_name = "'.$c_name.'", created_by = "'.$author.'",modified_date = now() WHERE id = "'.$id.'" ');
          //update product table with new category name
          $sql_ = mysqli_query($conx, 'UPDATE products SET category_name = "'.$c_name.'" WHERE category_id = "'.$id.'" ');
          $msg = "Category Updated Successfully";
        }elseif($cat_type == "edit_username"){
            //update Admin and User Options Table
            $username = preg_replace('#[^a-z0-9]#i','',$c_name);
            if(strlen($username) < 3){
                echo "Username is too Short|error";exit();
            }
            //check if Username already Exist
            $user_check = mysqli_query($conx, 'SELECT id FROM user_option WHERE username = "'.$username.'" LIMIT 1');
            if(mysqli_num_rows($user_check) > 0){
                echo "Username already Exist|error";exit();
            }
            $sql = mysqli_query($conx, 'UPDATE user_option SET username = "'.$username.'" WHERE id = "'.$id.'" LIMIT 1' );
            $sql_ = mysqli_query($conx, 'UPDATE admin SET username = "'.$username.'" WHERE id = "'.$id.'" LIMIT 1' );
            $msg = "You need to LOGOUT in order to Apply this Change";
            session_destroy();
        }else{
          echo "An Unknown Error Occured|error";exit();
        }
        
        if($sql){
            echo "$msg|success";exit();
        }
    }
?>
<?php
    if(isset($_POST['p_id'])){
        $qty = "";
        $p_id = preg_replace('#[^0-9]#','',$_POST['p_id']);
        $sql = mysqli_query($conx, 'SELECT remaining_qty FROM product_stock WHERE product_id = "'.$p_id.'" LIMIT 1');
        while($row = mysqli_fetch_row($sql)){
            $qty = $row[0];
        }
        echo "$qty|success|$p_id";exit();
    }
?>
<?php
    if(isset($_POST['product_name']) && isset($_POST['price'])){
        $product_name = preg_replace('#[^a-z0-9 ]#i','',$_POST['product_name']);
        $price = preg_replace('#[^0-9.]#','',$_POST['price']);
        $stock_qty = preg_replace('#[^0-9]#','',$_POST['stock_qty']);
        $qty = preg_replace('#[^0-9]#','',$_POST['qty']);
        $customer_name = preg_replace('#[^a-z ]#i','',$_POST['customer_name']);
        $date = preg_replace('#[^0-9]#','/',$_POST['date']);
        $sales_type = preg_replace('#[^a-z]#','',$_POST['sales_type']);
        $created_by = preg_replace('#[^a-z0-9]#i','',$_POST['created_by']);
        $id = preg_replace('#[^0-9]#','',$_POST['id']);
        $product_id = preg_replace('#[^0-9]#','',$_POST['product_id']);
        $type_ = preg_replace('#[^a-z]#','',$_POST['type']);
       // echo "$stock_qty|error";exit();
        if($product_name == "" || $price == "" || $stock_qty == "" || $qty == "" || $customer_name == "" || $date == "" || $sales_type == "" || $created_by == ""){
            echo "All Fields Are Required|error";exit();
        }
        //check if stock qty is < qty
       if($qty > $stock_qty){
           echo "Quantity is greated than our Available Quantity in Stock|error";exit();
       }
       //get product name from products table using ID as provide_name
       $p_name = mysqli_query($conx, 'SELECT product_name from products WHERE id = "'.$product_name.'" LIMIT 1' );
       while($row = mysqli_fetch_row($p_name)){
         $pp_name = $row[0];
       }
       $new_qty = $stock_qty - $qty;
       $total_price = $price * $qty;

       if($type_ == "new"){
            //insert DB into Sales Table
            $sql = mysqli_query($conx, 'INSERT into new_sales (product_name,price,create_date,quantity,sales_type,customer_name,total_price) values ("'.$pp_name.'","'.$price.'","'.$date.'","'.$qty.'","'.$sales_type.'","'.$customer_name.'","'.$total_price.'") ' );
            //update product stock, minus sales quantity from old quanitity
            $sale_update = mysqli_query($conx, 'UPDATE product_stock SET remaining_qty = "'.$new_qty.'" WHERE id = "'.$product_name.'" LIMIT 1' );
            $msg = "Sales Added Successfully";
       }
       if($sql){
            echo "$msg|success";exit();
       }
      // echo "$msg|success";exit();
    }
?>
<?php
    if(isset($_POST['user']) && isset($_POST['user']) != ""){
       $username = preg_replace('#[^a-z0-9 ]#i','',$_POST['user']);
       $type =  preg_replace('#[^a-z0-9 ]#i','',$_POST['type']);
       if($username == ""){
            echo "Username Field is Empty|error";exit();
       }
       //check if Username Exist
       $u_check = mysqli_query($conx,'SELECT id FROM user_option WHERE username = "'.$username.'" LIMIT 1' );
       if(mysqli_num_rows($u_check) < 1){
           echo "Username Does not Exist|error";exit();
       }
       if($type == "Unblock User"){
            $block_user = mysqli_query($conx, 'UPDATE user_option SET blocked = "0" WHERE username = "'.$username.'" LIMIT 1' );
            $block_ = mysqli_query($conx, 'UPDATE admin SET blocked = "0" WHERE username = "'.$username.'" LIMIT 1' );
            $msg = "This User has Been Unblocked Successfully";
       }else{
            $block_user = mysqli_query($conx, 'UPDATE user_option SET blocked = "1" WHERE username = "'.$username.'" LIMIT 1' );
            $block_ = mysqli_query($conx, 'UPDATE admin SET blocked = "1" WHERE username = "'.$username.'" LIMIT 1' );
            $msg = "This User has Been Blocked Successfully";
       }
       if($block_user && $block_ ){
            echo "$msg|success";exit();
       }
    }
?>
<?php
    if(isset($_POST['current_password'])){
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
            //check for empty field
            if($current_password == "" || $new_password == "" || $confirm_password == ""){
                echo "All Fields are required|error";exit();
            }
            //check if password match
            if($new_password != $confirm_password){
                echo "The passwords you entered do NOT match|error";exit();
            }
            //check password length
            if(strlen($new_password) < 5){
                echo "Password TOO Weak|error";exit();
            }
            //get DEFAULT password from DB
            $pass_check = mysqli_query($conx, 'SELECT password FROM admin WHERE username = "'.$log_username.'" LIMIT 1' );
            while($row = mysqli_fetch_row($pass_check)){
                $db_pass = $row[0];
            }
            //check if Current Password Match OLD DB password
            if($current_password != $db_pass){
                echo "Incorrect Password|error";exit();
            }
            //hash password and update DB
            $p_hash = password_hash($new_password,PASSWORD_DEFAULT);
            $sql = mysqli_query($conx, 'UPDATE user_option SET password = "'.$p_hash.'" WHERE username = "'.$log_username.'" LIMIT 1' );
            //clear the Default Password
            $clear_pass = mysqli_query($conx, 'UPDATE admin SET password = "" WHERE username = "'.$log_username.'" LIMIT 1' );
            if($sql && $clear_pass){
                echo "Please Logout to apply this change|success";exit();
            }else{
                echo "we were unable to update your password now, please try again later|error";exit();
            }
    }
?>
<?php
    if(isset($_POST['fullname']) && isset($_POST['user_role'])){
        $fullname = preg_replace('#[^a-z0-9 ]#i','',$_POST['fullname']);
        $user_role = preg_replace('#[^a-z]#','',$_POST['user_role']);

        //check if Username exist
        $check_uname = mysqli_query($conx, 'SELECT id FROM user_option WHERE username = "'.$username.'" LIMIT 1' );
        if(mysqli_num_rows($check_uname) > 0){
            $username;
        }
        $default_pass = 12345;
        $hash_pass = password_hash($default_pass,PASSWORD_DEFAULT);
        $sql = mysqli_query($conx,'INSERT into admin (username,password,last_login,full_name,user_level) values ("'.$username.'","'.$default_pass.'",now(),"'.$fullname.'","'.$user_role.'") ' );
        $p_id = mysqli_insert_id($conx);
        $user_op = mysqli_query($conx, 'INSERT into user_option (id,username,password,user_level) values ("'.$p_id.'","'.$username.'","'.$hash_pass.'","'.$user_role.'") ' );
        if($sql && $user_op){
            echo "New User Created Successfully|success";exit();
        }else{
            echo mysqli_error($conx)."Unable to Create new User|error";exit();
        }
    }
?>