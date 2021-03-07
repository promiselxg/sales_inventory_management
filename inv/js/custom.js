function newCategory(){
    var c_name = _('category_name').value
    var author = _('created_by').value;
    var type = _('cat_type').value;
    var id = _('cat_id').value;
    //check if value is empty
    if(c_name != "" || author != "" || type != ""){
        var ajax = ajaxObj("POST", "parser.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
        var response = ajax.responseText.split("|");
        //alert(response[1]);return false;
        if(response[1] == "success" ){
            swal('Successfull',response[0],response[1]);
        }else{
            swal('An Error Occured',response[0],response[1]);
                }
            }
        }
        ajax.send("c_name="+c_name+"&author="+author+"&cat_type="+type+"&id="+id);
    }else{
        swal('Fill out the Form','Please all Fields are required','error');
    }
}

// FUNCTION TO REMOVE AN ITEM (DYNAMIC) WITH A CONFIRM DIALOG BOX
function removeItem(id,tbl){
    swal({
        title: "Please Confirm",
        text: "Are you sure you want to delete this item?",
        icon: "warning",
        buttons: ["Cancel", "Delete"],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            // Ok Button was Clicked
            if(id != "" || tbl != ""){
                var ajax = ajaxObj("POST", "parser.php");
                ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                var response = ajax.responseText.split("|");
                //alert(response[1]);return false;
                if(response[1] == "success" ){
                    _(id).style.display = "none";
                    swal('Item Removed Successfully',response[0],response[1]);
                }else{
                    swal('Unable to Remove Item',response[0],response[1]);
                        }
                    }
                }
                ajax.send("tbl="+id+"&cat="+tbl);
            }
        } else {
            //cancel button was clicked
            //you can decide to perform another action here.
        }
      });
}


function addNewProduct(){
    var product_name = _('p_name').value;
    var category = _('cat').value;
    var qty = _('qty').value;
    var price = _('price').value;
    var product_type = _('product_type').value;
    var btn = _('product_btn');
    var product_id = _('product_id').value;
    if(product_name == "" || category == "" || qty == "" || price == "" || product_type == ""){
        swal('All Fileds Are Required','Please fill out the form before clicking the submit button','warning');
    }else{
        var ajax = ajaxObj("POST", "new_product.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
        var response = ajax.responseText.split("|");
        //alert(response[1]);return false;
        if(response[1] == "success" ){
            swal('Operation Completed Successfully',response[0],response[1]);
        }else{
            swal('Error Occured',response[0],response[1]);
                }
            }
        }
        ajax.send("p_name="+product_name+"&cat="+category+"&qty="+qty+"&price="+price+"&product_type="+product_type+"&product_id="+product_id);
    }
}


function loginForm(){
    var u = _('uname').value;
	var p = _('pass').value;
		if(u == "" || p == ""){
			swal('Empty Fields Detected','Enter your Username and Password','warning');
		}else{
            var ajax = ajaxObj("POST", "index.php");
            _('loginBtn').innerHTML = "Please Wait...";
			ajax.onreadystatechange = function() {
			if(ajaxReturn(ajax) == true) {
				var response = ajax.responseText.split("|");
				//alert(response[1]);return false;
				if(response[1] != "success"){
                    _('loginBtn').innerHTML = "Log In";
                    swal('Unable to Login',response[0],response[1]);
				}else{
					window . location = "dashboard"; 
				}
			}
		}
		ajax.send("u="+u+"&p="+p);
	}
}

function newExpenseType(){
    var c_name = _('expense_name').value
    var author = _('created_by').value;
    var type = _('cat_type').value;
    var id = _('cat_id').value;
    
    //check if value is empty
    if(c_name != "" || author != "" || type != ""){
        var ajax = ajaxObj("POST", "expense_type.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
        var response = ajax.responseText.split("|");
        //alert(response[1]);return false;
        if(response[1] == "success" ){
            swal('Successfull',response[0],response[1]);
        }else{
            swal('An Error Occured',response[0],response[1]);
                }
            }
        }
        ajax.send("c_name="+c_name+"&author="+author+"&cat_type="+type+"&id="+id);
    }else{
        swal('Fill out the Form','Please all Fields are required','error');
    }
}

function newExpense(){
    var expense_type = _('expense_type').value;
    var expense_desc = _('expense_desc').value;
    var total_amount = _('total_amount').value;
    var paid_amount = _('paid_amount').value;
    var product_name = _('product_name').value;
    var type = _('type').value;
    var created_by = _('created_by').value;
    var expense_id = _('expense_id').value;
    if(expense_type == "" || expense_desc == "" || total_amount == "" || paid_amount == "" || product_name == "" || created_by == ""){
        swal('All Fileds Are Required','Please fill out the form before clicking the submit button','warning');
    }else{
        var ajax = ajaxObj("POST", "new_expense.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
        var response = ajax.responseText.split("|");
        //alert(response[1]);return false;
        if(response[1] == "success" ){
            swal('Operation Completed Successfully',response[0],response[1]);
        }else{
            swal('Error Occured',response[0],response[1]);
                }
            }
        }
        ajax.send("expense_type="+expense_type+"&expense_desc="+expense_desc+"&total_amount="+total_amount+"&paid_amount="+paid_amount+"&type="+type+"&created_by="+created_by+"&expense_id="+expense_id+"&product_name="+product_name);
    }
}

function queryDB(pid,qty,pr_id){
    var val = _(pid).value;
    var ajax = ajaxObj("POST", "parser.php");
    ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
    var response = ajax.responseText.split("|");
    //alert(response[1]);return false;
            if(response[1] == "success" ){
                _(qty).value = response[0];
                _(pr_id).value = response[2];
            }
        }
    }
    ajax.send("p_id="+val);
}

function makeSale(){
    var product_name = _('product_name').value;
    var price = _('price').value;
    var stock_qty = _('stock_qty').value;
    var qty = _('qty').value;
    var customer_name = _('customer_name').value;
    var date = _('date').value;
    var sales_type = _('sales_type').value;
    var created_by = _('created_by').value;
    var id = _('id').value;
    var product_id = _('product_id').value;
    var type_ = _('type').value;
    if(product_name == "" || price == "" || stock_qty == "" || qty == "" || customer_name == "" || date == "" || sales_type == "" || created_by == ""){
        swal("All Fields Are Required","Please Fill out the Form","error");
    }else{
        var ajax = ajaxObj("POST", "parser.php");
        ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
        var response = ajax.responseText.split("|");
        //alert(response[1]);return false;
        if(response[1] == "success" ){
            swal('Successfull',response[0],response[1]);
        }else{
            swal('An Error Occured',response[0],response[1]);
                }
            }
        }
        ajax.send("product_name="+product_name+"&price="+price+"&stock_qty="+stock_qty+"&id="+id+"&qty="+qty+"&customer_name="+customer_name+"&date="+date+"&sales_type="+sales_type+"&created_by="+created_by+"&product_id="+product_id+"&type="+type_);
    }

}

function notAllowed(elem){
    var tf = _(elem);
    var rx = new RegExp;
    rx = /[&]/gi;
    tf.value = tf.value.replace(rx,"and");
}


function blockUser(id,user,type){
    swal({
        title: "Please Confirm",
        text: "Please confirm that you actually want to perform this Action",
        icon: "warning",
        buttons: ["Cancel", type],
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            // Ok Button was Clicked
            if(id != "" || user != ""){
                var ajax = ajaxObj("POST", "parser.php");
                ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                var response = ajax.responseText.split("|");
                //alert(response[1]);return false;
                if(response[1] == "success" ){
                    
                    swal('User Blocked Successfully',response[0],response[1]);
                }else{
                    swal('Unable to Block User',response[0],response[1]);
                        }
                    }
                }
                ajax.send("user="+user+"&user_tbl="+id+"&type="+type);
            }
        } else {
            //cancel button was clicked
            //you can decide to perform another action here.
        }
      });
}


function changePassword(){
    var current_password = _('current_password').value;
    var new_password = _('new_password').value;
    var confirm_password = _('confirm_password').value;
    if(current_password == "" || new_password == "" || confirm_password == ""){
        swal('All Fields are Required','Please fill out the form first','error');
    }
    if(new_password != confirm_password){
        swal('Password Mismatch','The Passwords you entered do not Match','error');
    }
    var ajax = ajaxObj("POST", "parser.php");
    ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
    var response = ajax.responseText.split("|");
    //alert(response[1]);return false;
    if(response[1] == "success" ){
        swal('Successfull',response[0],response[1]);
    }else{
        swal('Unable to Change Password',response[0],response[1]);
            }
        }
    }
    ajax.send("current_password="+current_password+"&new_password="+new_password+"&confirm_password="+confirm_password);
}

function newUser(){
    var fullname = _('fullname').value;
    var user_role = _('user_role').value;
        if(fullname == "" || user_role == ""){
            swal("All Fields are Required","Please Fill out the form","error");
        }else{
            var ajax = ajaxObj("POST", "parser.php");
            ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
            var response = ajax.responseText.split("|");
            //alert(response[1]);return false;
            if(response[1] == "success" ){
                swal('Successfull',response[0],response[1]);
            }else{
                swal('An Error Occured',response[0],response[1]);
                    }
                }
            }
            ajax.send("fullname="+fullname+"&user_role="+user_role);
        }
}

function  getCustomReport(){
    var start = _('start').value;
    var stop = _('end').value;
    var type = _('type').value;
    var sales_type = _('sales_type').value;
        if(start == "" || stop == "" || type == ""){
            swal('All fields are required','Please fill out the required fields','error');
        }else{
            if(type == "sales"){
                window.location = "custom_sales_report?start="+start+"&end="+stop+"&type="+sales_type;
            }else{
                window.location = "custom_expense_report?start="+start+"&end="+stop;
            }
        }
}