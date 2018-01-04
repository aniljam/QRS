<?php 
if(isset($_POST['SubmitResponse']) == "Submit")
{
   Response();
}
                            
$reassignto = $selTrans -> trnsReassignedID;
?>
<div class="col-md-4">
<div class="ui horizontal divider">Response History</div>
      <div id="RespHist" class="RespHist" style="height: 600px; overflow: auto;">
            
                <?php 
                global $db;
                $db->where('resptransid',$selTrans -> trnsid);
                $db->join('tbl_transactions','tbl_response.resptransid = tbl_transactions.transid','INNER');
                $db->join('tbl_status','tbl_response.respstatus = tbl_status.statid','INNER');
                $db->orderBy('respid',ASC);
                $selResp = $db->withTotalCount()->get("tbl_response",null,"respid, respby, respdatetime, respactual, statdesc, statremarks, tbl_response.relativeid HRuserID");
                //echo $db->getLastQuery();
                 if($db->totalCount != 0)
                 { 
                    foreach ($selResp as $key => $value) 
                    { 
                        if(($_SESSION['portal_loguser'] == $value['respby']) || ($_SESSION['uID'] == $value['HRuserID']))
                        {
                            $divClass = "ui stacked green mini segment";
                        }else{
                            $divClass = "ui stacked teal mini segment";
                        }
                ?>
                        <?php 
                            if ($value['HRuserID']){
                            $respbyFullName = getUser($value['HRuserID']);
                            $uRole = getHRRoles($value['HRuserID']);
                            $RespByName = "<strong>".$respbyFullName['fullname']."</strong><br/><small>".$uRole."</small>";
                            }
                            else{
                            $respbyuser = getDPortalUser($value['respby']);
                            $RespByName = "<strong>".$respbyuser['FName']." ".$respbyuser['LName']."</strong><br/><small>Employee</small>";
                            }
                        ?>
                    
                    <div class="<?php echo $divClass; ?>" style="font-size: 0.85em;">
                    <div class="ui avatar image">
                        
                    </div>    
                    <label class="ui top right attached basic label"><?php echo "<small>".date("F j, y, g:i a ", strtotime($value['respdatetime']))."</small>"; ?></label>

                    <p>
                    <p>
                        Name: &nbsp;
                        <?php 
                        echo $RespByName; 
                        ?>
                    </p>
                    <p>
                         Status: &nbsp;
                            <?php echo "<strong>".$value['statdesc']."</strong><br/><small>".$value['statremarks']."</small>"; ?>
                    </p>
                    </p>
                    <p>Message: 
                        <p style="word-break: break-all;">
                            <?php echo "<em>".$value['respactual']."</em>"; ?>
                        </p>
                    </p>
                        <?php 
                        global $db;
                        $db->where("referenceid", $selTrans -> trnsid);
                        $db->where("relativeid", $value['respid']);
                        $s = $db->getValue("tbl_attachments","count(attachid)");

                        if($s){
                        ?>
                    <br/>
                    <p><small>Attachment(s) : &nbsp;&nbsp;<?php dispAttachment($selTrans -> trnsid, 2 ,$value['respid']); ?></small></p>
                        <?php } ?>
                    
                    </div>
                <?php 
                    }
                }
                ?>   
    <!--###############################################   Response Form  ######################################################-->
       
        <?php 
         $trnsAction = getStatAccess($currStat);
         if($trnsAction){$arrStat = explode(",", $trnsAction);}
            if (($action == "UPDATESTAT") || ($trnsAction != ""))
            {
        ?>
                                <form class="ui mini form stacked segment" id="frmResp" action="" method="POST" enctype="multipart/form-data">
                                    <div class="ui active loader disabled" id="frmloader">
                                        
                                      </div>
                                    <input type="hidden" name="transID" value="<?php echo $selTrans -> trnsid; ?>">
                                    <input type="hidden" name="AssUserID" id="AssUserID" value="<?php echo $selTrans -> trnsAssignToID; ?>">
                                    <div class="ui right corner label" id="lnkAttach" data-position="left center" data-variation="mini" data-content="Add Attachment"><i class="attach icon"></i></div>
                                    <div class="required field">
                                    <label>Add Response</label>
                                        <textarea name="res_actual" id="res_actual" rows="2"></textarea>
                                    </div>
                                    <div class="required field">
                                        <input type="hidden" name="currStatID" id="currStatID" value="<?php echo $currStat; ?>">
                                        <label>New Status</label>
                                        <select name="res_stat" id="res_stat" onchange="enableElementFunc(this.value);" >
                                            <option value="" selected disabled></option>
                                            <?php 
                                                if($arrStat)
                                                {
                                                    global $db;
                                                    $db->where("statid", $arrStat, "IN");
                                                    $selStat = $db->get("tbl_status");
                                                    
                                                    foreach ($selStat as $key => $value) 
                                                    {
                                             ?>
                                             <option value="<?php echo $value['statid']; ?>"><?php echo $value['statdesc']; ?></option>
                                             <?php  
                                                    } 
                                                }
                                             ?>
                                        </select>
                                    </div>
                                
                                    <div id="datescommitted">
                                        <input type="checkbox" name="comdateRequired" id="comdateRequired">
                                        <div class="required field">
                                            <div class="ui calendar" id="rangestart">
                                            <?php $dtFrom = ($selTrans -> datecommittedFr != "") ? ($selTrans -> datecommittedFr) : ""; ?>
                                            <label>Dates Committed *</label>
                                            <input type="text" name="comdate_fr" id="comdate_fr" readonly value="<?php echo $dtFrom; ?>" placeholder="Date from..">
                                            </div>
                                        </div>
                                        <div class="required field">
                                            <?php $dtTo = ($selTrans -> datecommittedTo != "") ? ($selTrans -> datecommittedTo) : ""; ?>
                                            <div class="ui calendar" id="rangeend">
                                            <input type="text" name="comdate_to" id="comdate_to" readonly value="<?php echo $dtTo; ?>" placeholder="Date to..">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="required field">
                                        <?php $dtFinished = ($selTrans -> date_finished != "") ? ($selTrans -> date_finished) : "";  ?>
                                        
                                        <div class="ui calendar" id="d_finished">
                                        <input type="checkbox" name="dateFinRequired" id="dateFinRequired">
                                            <label>Date Finished *</label>
                                            <input type="text" name="finishdate" id="finishdate" readonly value="<?php echo $dtFinished; ?>">
                                        </div>
                                    </div>
                                    

                                    <div class="required field" id="reassign">
                                        <input type="checkbox" name="ReAssRequired" id="ReAssRequired">
                                        <label>Reassigned To </label>
                                        <input type="hidden" name="reassigntoID" id="reassigntoID" value="<?php echo $selTrans -> trnsReassignedID; ?>" readOnly>
                                        <select name="reassignID" id="reassignID">
                                            <option value="" selected disabled></option>
                                            <?php $excludeID = ($selTrans -> trnsReassignedID != "") ? ($selTrans -> trnsReassignedID) : ($selTrans -> trnsAssignToID); ?>
                                            <?php viewUsers(3); ?>
                                        </select>
                                    </div>
                                    <div id="divAttachments">
                                    <div class="ui horizontal divider"><small>Attach files here</small></div>
                                        <div class="field">
                                            <input type="file" name="trnsAttach[]" id="file1">
                                            <div id="file1err"></div>
                                        </div>
                                        <div class="field">
                                            <input type="file" name="trnsAttach[]" id="file2">
                                            <div id="file2err"></div>
                                        </div>
                                        <div class="field">
                                            <input type="file" name="trnsAttach[]" id="file3">
                                            <div id="file3err"></div>
                                        </div>
                                    </div>    
                                        <?php 
                                        $url = $_SERVER['HTTP_REFERER'];
                                            $urlid = substr($url, strrpos($url, '/') + 1);
                                        ?>
                                    
                                    <div class="ui horizontal divider"></div>
                                    <input type="hidden" name="SubmitResponse" value="Submit" />
                                    <div class="mini ui submit green basic button" id="btnSubmit">Submit</div>
                                    <div class="mini ui teal basic button"><a href="<?php echo $urlid; ?>">Cancel</a></div>
                                    <div class="ui error message"></div>
                                    
                                </form>                 
        <?php 
            } 
        ?>
    <!--##############################################  // Response Form  ##############################################################-->
      </div> 
</div>

<!--############################################   SCRIPTS  ########################################################################-->
 <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#frmResp')
                                                  .form({
                                                    inline : false,
                                                    on: 'blur',
                                                    fields: {
                                                      res_actual: {
                                                        identifier  : 'res_actual',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Response message is required.'
                                                          },{
                                                            type   : 'maxLength[250]',
                                                            prompt : 'Response message is maximum of 250 characters only.' 
                                                          }
                                                        ]
                                                      },
                                                      res_stat: {
                                                        identifier  : 'res_stat',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Please update New Status.'
                                                          }
                                                        ]
                                                      },
                                                      comdate_fr : {
                                                        depends: 'comdateRequired',
                                                        identifier : 'comdate_fr',
                                                        rules: [{
                                                            type: 'empty',
                                                            prompt : 'Please commit date from'
                                                        }]
                                                      },
                                                      comdate_to : {
                                                        depends: 'comdateRequired',
                                                        identifier : 'comdate_to',
                                                        rules: [{
                                                            type: 'empty',
                                                            prompt : 'Please commit date to'
                                                        }]
                                                      },
                                                      finishdate : {
                                                        identifier : 'finishdate',
                                                        depends: 'dateFinRequired',
                                                        rules: [{
                                                            type: 'empty',
                                                            prompt : 'Date Finished is required'
                                                        }]
                                                      },
                                                      reassignID : {
                                                        depends : 'ReAssRequired',
                                                        identifier : 'reassignID',
                                                        rules : [{
                                                            type : 'empty',
                                                            prompt : 'Please input Reassignment Name'
                                                        }]
                                                      }

                                                    },
                                                    onSuccess : function(){
                                                        $('#btnSubmit').addClass("disabled");
                                                        $('#frmResp').addClass("disabled");
                                                        $('#frmloader').removeClass("disabled");
                                                    }
                                                  })
                                                ;
                                    });
                        </script>
                         <script type="text/javascript">
                            $(document).ready(function(){
                                    $('#rangestart').calendar({
                                      type: 'date',
                                      endCalendar: $('#rangeend'),
                                    },autoScroll());
                                    $('#rangeend').calendar({
                                      type: 'date',
                                      startCalendar: $('#rangestart')
                                    },autoScroll());


                                    $('#d_finished').calendar({
                                        type: 'date'
                                    },autoScroll());

                                    $( '#d_finished' ).hide();
                                    $('#reassign').hide();
                                    $('#datescommitted').hide();
                                    $('#comdateRequired').hide();
                                    $('#dateFinRequired').hide();
                                    $('#ReAssRequired').hide();

                                    $('#divAttachments').hide();
                                    $('#lnkAttach').hide();


                                    $('#lnkAttach').on("click",function(){
                                        $('#divAttachments').toggle();
                                        autoScroll();  
                                    });

                                    $('#lnkAttach').popup();


                            });
                        </script>

                        <script type="text/javascript">
                            function enableElementFunc(statid){
                                switch(statid){
                                    case '2':
                                    $('#comdateRequired').prop("checked",true);
                                    $('#datescommitted').show();
                                    $('#reassign').hide();
                                    $('#d_finished').hide();
                                    $('#dateFinRequired').prop("checked",false);
                                    $('#ReAssRequired').prop("checked",false);
                                    autoScroll();                                  
                                    break;

                                    case '3':
                                    $('#dateFinRequired').prop("checked",true);
                                    $('#d_finished').show();
                                    $('#datescommitted').hide();
                                    $('#reassign').hide();
                                    $('#comdateRequired').prop("checked",false);
                                    $('#ReAssRequired').prop("checked",false);
                                    $('#lnkAttach').show();
                                    autoScroll();
                                    break;

                                    case '5':
                                    $('#ReAssRequired').prop("checked",true);
                                    $('#reassign').show();
                                    $('#d_finished').hide();
                                    $('#datescommitted').hide();
                                    $('#dateFinRequired').prop("checked",false);
                                    $('#comdateRequired').prop("checked",false);
                                    autoScroll();
                                    break;

                                    case '8':
                                    $('#lnkAttach').show();
                                    break;

                                    default:
                                    $('#comdateRequired').prop("checked",false);
                                    $('#dateFinRequired').prop("checked",false);
                                    $('#ReAssRequired').prop("checked",false);
                                    $('#d_finished').hide();
                                    $('#reassign').hide();
                                    $('#datescommitted').hide();
                                    $('#lnkAttach').hide();
                                    $('#divAttachments').hide();
                                    autoScroll();
                                    break;

                                } 
                            }
                        </script>

                         <script type="text/javascript">
                 $(document).ready(function(){

                        $('#file1').bind('change', function() {
                            var file1size = this.files[0].size/1024/1024;
                            var file1type = document.getElementById("file1").value; 
                            var file1EXT = file1type.split('.');
                            var file1Final = file1EXT[file1EXT.length - 1];

                                if(file1size > 1){
                                document.getElementById("file1err").innerHTML = "<small style='color:#ff0000'>File attachment should be less than 1 MB.</small>";
                                document.getElementById("file1").value = "";
                                }else{
                                document.getElementById("file1err").innerHTML = "";    
                                    }


                                if(file1Final == "exe" || file1Final == "php" || file1Final == "js" || file1Final == "asp"){
                                    document.getElementById("file1err").innerHTML = "<small style='color:#ff0000'>File attachment cannot be an exe/script file.</small>";
                                    document.getElementById("file1").value = "";   
                                }
                                else{
                                    document.getElementById("file1err").innerHTML = "";  
                                }
                        });

                        $('#file2').bind('change', function(){
                            var file2size = this.files[0].size/1024/1024;
                            var file2type = document.getElementById("file2").value; 
                            var file2EXT = file2type.split('.');
                            var file2Final = file2EXT[file2EXT.length - 1];

                                if(file2size > 1){
                                document.getElementById("file2err").innerHTML = "<small style='color:#ff0000'>File attachment should be less than 1 MB.</small>";
                                document.getElementById("file2").value = "";
                                }else{
                                document.getElementById("file2err").innerHTML = "";    
                                    }

                                if(file2Final == "exe" || file2Final == "php" || file2Final == "js" || file2Final == "asp"){
                                    document.getElementById("file2err").innerHTML = "<small style='color:#ff0000'>File attachment cannot be an exe/script file.</small>";
                                    document.getElementById("file2").value = "";   
                                }
                                else{
                                    document.getElementById("file2err").innerHTML = "";  
                                }
                        });

                        $('#file3').bind('change', function() {
                            var file3size = this.files[0].size/1024/1024;
                            var file3type = document.getElementById("file3").value; 
                            var file3EXT = file3type.split('.');
                            var file3Final = file3EXT[file3EXT.length - 1];
                                if(file3size > 1){
                                document.getElementById("file3err").innerHTML = "<small style='color:#ff0000'>File attachment should be less than 1 MB.</small>";
                                document.getElementById("file3").value = "";
                                }else{
                                document.getElementById("file3err").innerHTML = "";    
                                    }

                                if(file3Final == "exe" || file3Final == "php" || file3Final == "js" || file3Final == "asp"){
                                    document.getElementById("file3err").innerHTML = "<small style='color:#ff0000'>File attachment cannot be an exe/script file.</small>";
                                    document.getElementById("file3").value = "";   
                                }
                                else{
                                    document.getElementById("file3err").innerHTML = "";  
                                }
                            });
                        });
                    </script>

                    <script type="text/javascript">
                        function autoScroll(){
                            $('#RespHist').animate({
                                scrollTop: $('#RespHist').get(0).scrollHeight}, 1500);
                        }

                        $(document).ready(function(){
                           autoScroll(); 


                        });
                    </script>