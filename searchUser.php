<?php require_once('dbfunc/panksyons.php'); ?>

<?php 
$uID = $_GET['q'];

$selQRSaccnt = new LoggedAccount();
$selQRSaccnt -> getaccountuser($uID);

if($selQRSaccnt -> uID){
    $userID = $selQRSaccnt -> uID;
    $userEmpID = $selQRSaccnt -> empid;
    $userFName = $selQRSaccnt -> QFName;
    $userMName = $selQRSaccnt -> QMName;
    $userLName = $selQRSaccnt -> QLName;
    $userContact = $selQRSaccnt -> contact;
    $userDept = $selQRSaccnt -> Dept;
    $userEmail = $selQRSaccnt -> email;
    $userNickName = $selQRSaccnt -> Pname;
    $userFullName = $selQRSaccnt -> fullname;
}else{

$selDUsers = new GetUserDportal();
$selDUsers -> getActiveUser($uID);

    $userEmpID = $selDUsers -> u_empID;
    $userFName = $selDUsers -> u_FN;
    $userMName = $selDUsers -> u_MN;
    $userLName = $selDUsers -> u_LN;
    $userDept = $selDUsers -> dept;
    $userEmail = $selDUsers -> u_email;
    $userNickName = $selDUsers -> u_FN;
    $userFullName = $selDUsers -> Dfullname;       
    
}

if($userEmpID){
?>
                                    
                                <input type="hidden" name="EmpNumberValue" id="EmpNumberValue" value="<?php echo $userEmpID; ?>">
                                    <div class="three fields">
                                        <div class="required field">
                                            <label>Last Name</label>
                                         <input type="text" name="LName" id="LName" value="<?php echo $userLName;?>">
                                        </div>
                                        <div class="required field">
                                            <label>First Name</label>
                                         <input type="text" name="FName" id="FName" value="<?php echo $userFName; ?>">
                                        </div>
                                        <div class="field">
                                            <label>Middle Name</label>
                                         <input type="text" name="MName" id="MName" value="<?php echo $userMName; ?>">
                                        </div>
                                    </div>
                                    <div class="two fields">
                                        <div class="required field">
                                           <label>Email Address</label>
                                           <input type="text" name="emailadd" id="emailadd" value="<?php echo $userEmail; ?>">
                                       </div>
                                        <div class="field">
                                            <label>Nick Name</label>
                                            <input type="text" name="PName" id="PName" placeholder="Preferred Name" value="<?php echo $userNickName; ?>">
                                        </div>
                                       
                                    </div>
                                    <div class="two fields">
                                        <div class=" required field">
                                            <label>Department</label>
                                            <input type="text" name="DeptName" id="DeptName" value="<?php echo $userDept; ?>">
                                        </div>
                                        <div class="field">
                                        <label>Contact Number</label>
                                        <input type="text" name="CNumber" id="CNumber" value="<?php echo $userContact; ?>">
                                        
                                        </div>
                                     
                                    </div>
                                            <?php 
                                                global $db;

                                                $db->where('empid', $userEmpID);
                                                $db->join('tbl_roles', 'tbl_userroles.roleid = tbl_roles.roleid','INNER');
                                                $db->join('tbl_users', 'tbl_userroles.userid = tbl_users.userid','INNER');
                                                $sel = $db->get('tbl_userroles',null,'tbl_users.userid, tbl_userroles.roleid rID, tbl_roles.roledesc RName, tbl_userroles.userrolestat crit');
                                                $arrKo = Array();
                                                foreach ($sel as $arrV) {
                                                    array_push($arrKo, $arrV['rID']);
                                                }
                                             ?>
                                    <div class="ui horizontal divider">Add Role(s)</div>
                                        <div class="field">
                                            <select class="ui dropdown" name="rolename" id="rolename">
                                                <option value="" selected disabled></option>
                                                <option value="3" <?php if(in_array(3, $arrKo)){echo "style='display:none'";} ?> >HR Specialist</option>
                                                <option value="2" <?php if(in_array(2, $arrKo)){echo "style='display:none'";} ?>>HR Coordinator</option>
                                                <option value="1" <?php if(in_array(1, $arrKo)){echo "style='display:none'";} ?>>Administrator</option>
                                            </select>
                                        </div>
                                        <div class="ui horizontal divider"></div>

                                             <?php    
                                                if($sel){
                                                     
                                             ?>
                                                <div class="field"><label>Existing Roles</label></div>
                                                <table class="ui mini celled table">
                                                    <thead>
                                                    <tr>
                                                    <th>Role Name</th>
                                                    <th>Active</th>
                                                    
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($sel as $key => $value) {?>
                                                                <tr>
                                                                <td><?php echo $value['RName']; ?></td>
                                                                <td><?php $inputVal = ($value['crit'] == 1) ? "checked" : ""; ?>
                                                                <input type="checkbox" name="Rstatus" id="Rstatus" class="ui checkbox" <?php echo $inputVal; ?>></td>
                                                                </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="ui horizontal divider"></div>
                                             <?php }else{ ?>
                                             <div class="field"><label style="color: #ff0000;">**  No Existing Roles inside QRS **</label></div>
                                             <div class="ui horizontal divider"></div>
                                             <?php } ?>
                        <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#myFrm')
                                                  .form({
                                                    inline : true,
                                                    on: 'submit',
                                                    fields: {
                                                      LName: {
                                                        identifier  : 'LName',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Lastname is required.'
                                                          }
                                                        ]
                                                      },
                                                      FName:{
                                                        identifier  : 'FName',
                                                        rules: [{
                                                            type : 'empty',
                                                            prompt : 'Firstname is required.'
                                                        }]
                                                      },
                                                      MName:{
                                                        identifier : 'MName',
                                                        rules:[{
                                                            type    : 'empty',
                                                            prompt  : 'Middlename is required.'
                                                        }
                                                        ]
                                                      },
                                                      emailadd:{
                                                        identifier : 'emailadd',
                                                        rules:[{
                                                            type    : 'empty',
                                                            prompt  : 'Email Address is required.'
                                                        }
                                                        ]
                                                      },
                                                      DeptName:{
                                                        identifier : 'DeptName',
                                                        rules:[{
                                                            type    : 'empty',
                                                            prompt  : 'Department is required.'
                                                        }
                                                        ]
                                                      }

                                                    }
                                                  });
                                    
                                    });

                        </script>


<?php }else{ ?>
                                    <div class="three fields">
                                        <div class="required field">
                                            <label>Last Name</label>
                                         <input type="text" name="LName" id="LName">
                                        </div>
                                        <div class="required field">
                                            <label>First Name</label>
                                         <input type="text" name="FName" id="FName">
                                        </div>
                                        <div class="field">
                                            <label>Middle Name</label>
                                         <input type="text" name="MName" id="MName">
                                        </div>
                                    </div>
                                    <div class="two fields">
                                        <div class="required field">
                                           <label>Email Address</label>
                                           <input type="text" name="emailadd" id="emailadd">
                                        </div>
                                        <div class="field">
                                            <label>Nick Name</label>
                                            <input type="text" name="PName" id="PName" placeholder="Preferred Name">
                                        </div>
                                      
                                    </div>
                                    <div class="two fields">
                                        <div class=" required field">
                                            <label>Department</label>
                                            <input type="text" name="DeptName" id="DeptName">
                                        </div>
                                        <div class="field">
                                        <label>Contact Number</label>
                                        <input type="text" name="CNumber" id="CNumber">
                                        
                                        </div>
                                    
                                    </div>
                                    <div class="ui horizontal divider">Role(s)</div>
                                        <div class="field">
                                            <select class="ui dropdown" name="rolename" id="rolename">
                                                <option value="" selected disabled></option>
                                                
                                            </select>
                                        </div>
                                        <div class="ui horizontal divider"></div>
 
<?php } ?>                                  

    

