                        <div class="col-md-8">
                            <div class="ui raised segment">
                                <div class="ui teal ribbon label pageLabel"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Request / Concern Details</div>
                    <?php if($_GET['action'] == "newlyCreated"){?>
                                        <div class="ui top right attached label positive message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p style="color:#ff0000;">Your transaction was added successfully.</p>
                                        </div>
                    <?php } ?>
                                 <table class="ui very basic blue table" style="height:300px;">
                                                <thead>
                                                <tr class="single line">
                                                    <th style="font-size: 1.2em;">
                                                        <?php echo "QRS - ".$selTrans -> trnsType." # ".$selTrans -> trnsid;?>

                                                    </th>
                                                    <th class="right aligned"><?php echo $DT = ($selTrans -> trnsDT) ? date("F j, Y, g:i a ", strtotime($selTrans -> trnsDT)) : " - ";?></th>
                                                </tr>
                                                   
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                    <td>Category</td>
                                                    <td><?php echo $selTrans -> trnsCat;?></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Subcategory</td>
                                                    <td><?php echo $selTrans -> trnsSubCat;?></td>
                                                    </tr>
                                                    <tr style="height:120px!important;">
                                                    <td>Description</td>
                                                    <td><p style="word-break: break-all;"><?php echo $selTrans -> trnsDesc;?></p></td>
                                                    </tr>
                                                    <?php 
                                                    if ($selTrans -> datecommittedFr != "" AND $selTrans -> datecommittedTo != "") {
                                                        
                                                    $commitDate =  date("M j ", strtotime($selTrans -> datecommittedFr))." - ". date("M j, Y", strtotime($selTrans -> datecommittedTo)); 
                                                    }
                                                    else{$commitDate = " - ";}

                                                    ?>
                                                    <tr><td>Dates Committed</td><td><?php echo $commitDate; ?></td></tr>
                                                    

                                                    
                                                        <tr>
                                                        <td>Date Finished </td>
                                                        <td><?php 
                                                        if($selTrans -> date_finished){
                                                           $dtfinished = date("F j, Y",strtotime($selTrans -> date_finished));  
                                                       }else{
                                                        $dtfinished = " - ";
                                                       }
                                                       echo $dtfinished;
                                                        ?></td></tr>
                                                    

                                                    <tr ><td>Attachment(s)</td><td><?php dispAttachment($selTrans -> trnsid, 1); ?></td></tr>
                                                    
                                                </tbody>
                                                <tfoot >
                                                    <tr><td colspan="2"> Status : <strong><em><?php echo $selTrans -> trnsStatDesc; ?></em></strong>
                                                        <br/>
                                                        <small><em><?php echo $selTrans -> trnsStatRem; ?></em></small>
                                                    </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                            </div>
                            <div class="ui raised segment">
                                            <table class="ui very basic table" style="height:50px!important;overflow: scroll!important;">
                                                <thead>
                                                    <tr>
                                                    <th>
                                                        Reported by
                                                    </th>
                                                    <th>
                                                        Assigned to
                                                    </th>
                                                    <?php if($selTrans -> trnsReassignedID){?>
                                                        <th>Reassigned to</th>
                                                    <?php }?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                <td>
                                                    <?php 
                                                    //$uRoles = getMyRoles($selTrans -> trnsCreatedByID);
                                                    $crby = getDPortalUser($selTrans -> trnsCreatedByID);
                                                    echo "<strong>".$crby['FName']." ".$crby['LName']."</strong><br/>";
                                                    echo "<small>Employee</small>";
                                                    ?>
                                                </td>   
                                                <td>
                                                    <?php 
                                                    //$uRoles2 = getMyRoles($selTrans -> trnsAssignToID);
                                                    
                                                    echo "<strong>".$selTrans -> trnsAssignToName."</strong><br/>";
                                                    $uRole = getHRRoles($selTrans -> trnsAssignToID);
                                                    echo "<small>".$uRole."</small>";
                                                    ?>
                                                </td>
                                                    <?php if($selTrans -> trnsReassignedID){?>
                                                <td>
                                                    <?php 
                                                    //$uRoles2 = getMyRoles($selTrans -> trnsReassignedID);
                                                    
                                                    echo "<strong>".$selTrans -> trnsReassignedName."</strong><br/>";
                                                    $uRole = getHRRoles($selTrans -> trnsReassignedID);
                                                    echo "<small>".$uRole."</small>";
                                                    ?>
                                                </td>
                                                    <?php }?>
                                                </tr>

                                                </tbody>
                                            </table>
                            </div>
                            <div class="ui invisible divider"></div>
                        </div>

<script type="text/javascript">
                            $(document).ready(function(){
                                $('#notif')
                                  .on('click', function() {
                                    $(this)
                                      .closest('.message')
                                      .transition('slide up')
                                    ;
                                    
                                  })
                                ;

                                $('#notif').delay(5000).slideUp(1000);


                            });
                            
                        </script>