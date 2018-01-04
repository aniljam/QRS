		 								<?php if($_GET['action'] == "UpCatsuccess"){?>
                                        <div class="ui positive message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Category was updated successfully!</p>
                                        </div>
                    <?php } ?>
                    <?php if($_GET['action'] == "UpCatfailed"){?>
                                        <div class="ui negative message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Updating of Category was failed!</p>
                                          <p>Error Encountered : <?php echo $_GET['err'];?></p>
                                        </div>
                    <?php } ?>
										<?php if($_GET['action'] == "UpSCsuccess"){?>
                                        <div class="ui positive message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Subcategory was updated successfully!</p>
                                        </div>
                    <?php } ?>
                    <?php if($_GET['action'] == "UpSCfailed"){?>
                                        <div class="ui negative message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Updating of subcategory was failed!</p>
                                          <p>Error Encountered : <?php echo $_GET['err'];?></p>
                                        </div>
                    <?php } ?>
                    <?php if($_GET['action'] == "AddSCsuccess"){?>
                                        <div class="ui positive message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Subcategory was added successfully!</p>
                                        </div>
                    <?php } ?>
                    <?php if($_GET['action'] == "AddSCfailed"){?>
                                        <div class="ui negative message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Addition of subcategory was failed!</p>
                                          <p>Error Encountered : <?php echo $_GET['err'];?></p>
                                        </div>
                    <?php } ?>
                    <?php if($_GET['action'] == "AddCatsuccess"){?>
                                        <div class="ui positive message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Category was added successfully!</p>
                                        </div>
                    <?php } ?>
                    <?php if($_GET['action'] == "AddCatfailed"){?>
                                        <div class="ui negative message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Addition of category was failed!</p>
                                          <p>Error Encountered : <?php echo $_GET['err'];?></p>
                                        </div>
                    <?php } ?>