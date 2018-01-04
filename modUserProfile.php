<!DOCTYPE html>
<html>
<head>
  <title>User Profile Modal</title>
  <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="ext/semantic.min.css"/>
  <link rel="stylesheet" type="text/css" href="dist/css/mystyle.css"/>
  <script type="text/javascript" src="ext/semantic.min.js"></script>
 
</head>
<?php 
    require_once("dbfunc/panksyons.php");
?>
<body>
 <?php 
    $url = $_SERVER['HTTP_REFERER'];
    $urlid = substr($url, strrpos($url, '/') + 1);

    $myID = $_GET['id'];
    if ($myID) {
      global $db;
      $db->join("tbl_users","tbl_userroles.userid = tbl_users.userid","LEFT");
       $db->where('tbl_userroles.userid',$myID);
       
       $selUData = $db->getOne('tbl_userroles','tbl_users.userid myuserID, empid myuserEmpID, firstname myuserFN, middlename myuserMN, lastname myuserLN, email myuserEmail,gender myuserGen, nickname myuserPN, deptid myuserDept, contact myuserContact,tbl_userroles.userroleid myuserroleUID, tbl_userroles.roleid myuserRoleID, tbl_userroles.userrolestat myuserRoleStat');
    }

    if(isset($_POST['btnSubmit']) == "Update"){
      editUserRoles($selUData['myuserID'],$selUData['myuserroleUID']);
    }


 ?>

<div class="ui mini modal" id="mymodal">
  <div class="header">
    <i class="spy icon"></i>
    Update User Profile
  </div>
  <div class="image content">
      
             <form class="ui form basic segment" enctype="multipart/form-data" method="POST" action="" id="myFrm">
                                    
                                    <div class="inline field">
                                         <!--For Profile Picture
                                         <a href="#"><img src='' class='img-circle' height='60px' width='60px;' alt='' style="border: 5px;" />
                                         </a>-->
                                         <label>Employee ID</label>
                                         <input type="text" name="EmpNumber" id="EmpNumber" value="<?php echo $selUData['myuserEmpID']; ?>">
                                         
                                    </div>
                                    
                                    <div class="three fields">
                                        <div class="required field">
                                            <label>Last Name</label>
                                         <input type="text" name="LName" id="LName" value="<?php echo $selUData['myuserLN']; ?>">
                                        </div>
                                        <div class="required field">
                                            <label>First Name</label>
                                         <input type="text" name="FName" id="FName" value="<?php echo $selUData['myuserFN']; ?>">
                                        </div>
                                        <div class="field">
                                            <label>Middle Name</label>
                                         <input type="text" name="MName" id="MName" value="<?php echo $selUData['myuserMN']; ?>">
                                        </div>
                                    </div>
                                    <div class="three fields">
                                        <div class="required field">
                                           <label>Email Address</label>
                                           <input type="text" name="emailadd" id="emailadd" value="<?php echo $selUData['myuserEmail']; ?>">
                                       </div>
                                        <div class="field">
                                            <label>Nick Name</label>
                                            <input type="text" name="PName" id="PName" value="<?php echo $selUData['myuserPN']; ?>">
                                        </div>
                                        <div class="required field">
                                          <label>Gender</label>
                                          <select name="Ugender" id="Ugender" class="ui dropdown">
                                            
                                            <option value="Male" <?php if($selUData['myuserGen'] == 'Male'){echo "selected='selected'";} ?>>Male</option>
                                            <option value="Female" <?php if($selUData['myuserGen'] == 'Female'){echo "selected='selected'";} ?>>Female</option>
                                          </select>
                                        </div>
                                       
                                    </div>
                                    <div class="two fields">
                                        <div class=" required field">
                                            <label>Department</label>
                                            <input type="text" name="DeptName" id="DeptName" value="<?php echo $selUData['myuserDept']; ?>">
                                        </div>
                                        <div class="field">
                                        <label>Contact Number</label>
                                        <input type="text" name="CNumber" id="CNumber" value="<?php echo $selUData['myuserContact']; ?>">
                                        </div>
                                     
                                    </div>
                                    <?php 
                                      global $db;

                                      $db->where('tbl_userroles')
                                     ?>
                                    <div class="ui horizontal divider"><i class="asterisk icon"></i></div>
                                        
                                    <div class="ui error message"></div>
                                    
                                        
                                </form>
  </div>
         <div class="actions">
           <div class="ui buttons">
                                          <input type="Submit" name="btnSubmit" id="btnSubmit" class="ui positive button" value="Update" />
                                          <div class="or"></div>
                                                <a href="<?php echo $urlid; ?>">
                                                <div class="ui button" id="btnCancel">
                                                  Cancel  
                                                </div>
                                                </a>
                                          
                                        </div>
         </div>                        
</div>
  
</body>
</html>


 <script type="text/javascript">
  $(document).ready(function(){
       $('#mymodal')
       .modal({inverted: false})
       .modal('setting', 'closable', false)
       .modal('setting','transition','horizontal flip')
       .modal({'can fit':true})
       .modal('show');

        $('#btnCancel').on("click",function(){
          $('#mymodal')
          .modal('setting','transition','fade')
          .modal('hide');
        });

  $('.ui.dropdown').dropdown();
  });


  </script>

 <script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#myFrm')
                                                  .form({
                                                    inline : false,
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
                                                      },
                                                      gender:{
                                                        identifier : 'gender',
                                                        rules:[{
                                                            type    : 'empty',
                                                            prompt  : 'Please select gender.'
                                                        }
                                                        ]
                                                      },
                                                      rolename:{
                                                        identifier : 'rolename',
                                                        rules:[{
                                                            type : 'empty',
                                                            prompt : 'Please select role name to add'
                                                        }]
                                                      }

                                                    }
                                                  });
                                    
                                    });

                        </script>






