            <?php 
             // $arrRoles = getMyRoles($_SESSION['portal_loguser']);
             

             ?>

            <div class="row">   
                <div class="col-lg-4 col-md-8" id="conDiv1">
                    <div class="panel panel">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-4x" style="color:#337AB7;"></i>
                                </div>
                                <div class="col-xs-9 text-right" style="color:#337AB7;">
                                    <div class="huge">
                                    <?php 
                                        //echo $issCnt = checkMyTransCount("active",$arrRoles, 1);
                                        echo $issCnt = chkTrnsCnt("active", 1);
                                    ?></div>
                                    <br />
                                    <div> My Active Issues / Concerns</div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                        <a href="active2.php?servtype=1&filter=active" class="dashboardlnk" style="color:#337AB7;">
                            <div class="panel-footer">
                                <span class="pull-left">View Details </span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8" id="conDiv2">
                    <div class="panel panel">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-envelope fa-4x" style="color:#5BC0DE;" ></i>
                                </div>
                                
                                <div class="col-xs-9 text-right" style="color:#5BC0DE;" >
                                    <div class="huge">
                                    <?php 
                                    //echo $reqCnt = checkMyTransCount("active",$arrRoles, 2);
                                    echo $reqCnt = chkTrnsCnt("active", 2);
                                    ?></div>
                                    <br />
                                    <div> My Active Requests</div>
                                </div>
                            </div>
                        </div>
                        <a href="active2.php?servtype=2&filter=active" class="dashboardlnk" style="color:#5BC0DE;" >
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-8" id="conDiv3">
                    <div class="panel panel">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list-ul fa-4x" style="color:#5CB85C;"></i>
                                </div>
                                <div class="col-xs-9 text-right" style="color:#5CB85C;">
                                    <div class="huge">
                                    <?php 
                                    //echo $comIssReqCnt = checkMyTransCount("completed",$arrRoles, "");
                                    echo $comIssReqCnt = chkTrnsCnt("completed", "");
                                    ?>
                                        
                                    </div>
                                    <br />
                                    <div style="font-size:0.95em;">Completed/Cancelled Transactions</div>
                                </div>
                            </div>
                        </div>
                        <a href="active2.php?filter=completed" class="dashboardlnk" style="color:#5CB85C;">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>


            </div>

            <?php $totActive = intval($issCnt) + intval($reqCnt); ?>