<div class="navbar-default sidebar" role="navigation" style="font-color: #000">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">

                            <li style='vertical-align:bottom;text-align: center;'>
                                    <br/>
                                    <!--Reserve for Profile Pic-->
                                   <?php 
                                    if(!empty($_SESSION['dp'])){

                                    ?>
                                    <a href="UserProfile.php" style="background-color: #016877!important;"><img src='<?php echo $_SESSION['dp']; ?>' class='img-circle' height='60px' width='60px;' alt='' style="border: 5px;" /></a>
                                    <?php }else{ ?>
                                        <a class="ui green circular label" style="height:60px!important;width:60px!important;font-size: 30px;" href="UserProfile.php" data-tooltip="Edit Profile" data-position="top center"><?php echo substr($_SESSION['Pname'], 0, 1); ?>
                                    </a><br/><br/>
                                    <?php } ?>
                                    <strong>
                                        <?php echo "Welcome, ".$_SESSION['Pname']." !"; ?></strong>
                                        <br/>
                                        <br/>
                            </li>
                        <li>
                            <a href="home.php" class="astyle"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <?php if(chk_role($_SESSION['portal_loguser'], 73)) {?>
                        <li >
                            <a href="#" class="astyle"><i class="fa fa-file-o fa-fw" aria-hidden="true"></i> Create New<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                               

                                <?php 
                                    global $db;

                                    $selServType = $db->get("tbl_servicetype",10,"servtypeid,servtypedesc");
                                    foreach ($selServType as $value) {
                                 ?>
                                    <li><a href="<?php echo "qrscreate.php?type=".$value['servtypedesc']; ?>" class="astyle"><?php echo $value['servtypedesc']; ?></a></li>
                                 <?php } ?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } ?>
                        <li>
                        <a href="#" class="astyle"><i class="fa fa-list fa-fw" aria-hidden="true"></i> Request/Concern Lists<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="active2.php?filter=active" class="astyle"> Active Request(s)/Concern(s)</a>
                                </li>
                                <li>
                                    <a href="active2.php?filter=all" class="astyle"> All Request(s)/Concern(s)</a>
                                </li>
                            </ul>
                        </li>

                        <?php if(chk_role($_SESSION['portal_loguser'], 71)){ ?>
                        <li>
                            <a href="#" class="astyle"><i class="fa fa-wrench fa-fw" aria-hidden="true"></i> Settings<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="userroles.php" class="astyle"> User Role</a>
                                </li>
                                <li>
                                    <a href="category.php" class="astyle"> Category</a>
                                </li>
                                <!--<li>
                                    <a href="#" class="astyle"> Services</a>
                                </li>
                                <li>
                                    <a href="#" class="astyle"> Departments</a>
                                </li>-->
                                

                            </ul>
                        </li>
                        <?php } ?>
                    </ul>


                </div>
                <!-- /.sidebar-collapse -->
            </div>