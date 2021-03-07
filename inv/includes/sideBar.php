              <div class="menu_section">
                <ul class="nav side-menu">
                  <li><a href="dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
                  <?php
                    if($user_level == "c"){
                        echo '<li><a><i class="fa fa-table"></i> User Management <span class="fa fa-chevron-down"></span></a><ul class="nav child_menu"><li><a href="new_user">New User</a></li><li><a href="view_user">View All Users</a></li></ul></li>';
                    }
                  ?>

                  <li><a><i class="fa fa-bar-chart-o"></i> Sales Management <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="make_sale">New Sales</a></li>
                      <li><a href="expenses">Expense Management</a></li>
                      <li><a href="view_sales_report">Sales Invoice</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-shopping-cart"></i> Product Management <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php
                        if($user_level == "c"){
                            echo '<li><a href="new_category">New Category</a></li><li><a href="view_category">View Categories</a></li>';
                        }elseif($user_level == "b"){
                            echo '</li><li><a href="view_category">View Categories</a></li>';
                        }else{
                          echo '';
                        }
                    ?>
                    
                    <li><a href="new_product">Create New Product</a></li>
                    <li><a href="view_product">View Products</a></li>
                  </ul>
                  </li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>