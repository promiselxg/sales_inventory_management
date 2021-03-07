<div class="row tile_count" style="font-size: x-large;">
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="info-box blue-bg bg-success" style="text-align: center;border-radius: 5px;color:#fff;padding:20px">
						<div class="title">Total Products</div>
							<div class="count">
								<?php echo $total_products;?>
							</div>
							
						</div><!--/.info-box-->
					</div><!--/.col-->

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="info-box brown-bg bg-primary" style="text-align: center;border-radius: 5px;color:#fff;padding:20px">
							<?php
								$total_sales = 0;
								$sales_r = mysqli_query($conx, 'SELECT total_price FROM new_sales');
								while($row = mysqli_fetch_row($sales_r)){
									$total_sales = $total_sales += $row[0];
								}
							?>
							<div class="title">Total Sales Revenue</div>
							<div class="count">&#x20A6;<?php echo number_format($total_sales);?></div>
							
						</div><!--/.info-box-->
					</div><!--/.col-->

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="info-box dark-bg bg-red" style="text-align: center;border-radius: 5px;color:#fff;padding:20px">
						<?php
								$count = "";
								$pr_cat = mysqli_query($conx, 'SELECT id FROM category');
								$count = mysqli_num_rows($pr_cat);
							?>
							<div class="title">Total Product Category</div>
							<div class="count"><?php echo $count;?></div>
							
						</div><!--/.info-box-->
					</div><!--/.col-->
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="info-box dark-bg bg-primary" style="text-align: center;border-radius: 5px;color:#fff;padding:20px">
						<?php
								$total_expense = 0;
								$exp = mysqli_query($conx, 'SELECT paid_amount FROM expense_tbl');
								while($row = mysqli_fetch_row($exp)){
									$total_expense = $total_expense += $row[0];
								}
							?>
							<div class="title">Total Expenses</div>
							<div class="count">&#x20A6;<?php echo number_format($total_expense);?></div>
							
						</div><!--/.info-box-->
					</div><!--/.col-->
				</div>
				