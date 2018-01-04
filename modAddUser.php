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

    if(isset($_POST['btnSubmit']) == "Save"){
        addUserRole();
    }
    
 ?>

<div class="ui modal" id="mymodal">
  <div class="header">
    Add User
  </div>
  <div class="image content">
      
             <form class="ui form basic segment" enctype="multipart/form-data" method="POST" action="" id="myFrm">
                                    <div class="ui horizontal divider">User's Profile</div>
                                    <div class="inline field">
                                         <!--For Profile Picture
                                         <a href="#"><img src='' class='img-circle' height='60px' width='60px;' alt='' style="border: 5px;" />
                                         </a>-->
                                         <label>Employee ID</label>
                                         <input type="text" name="EmpNumber" id="EmpNumber" placeholder="Search Employee ID ..." onkeyup="getUser(this.value);">
                                         
                                    </div>
                                    
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
                                    <div class="three fields">
                                        <div class="required field">
                                           <label>Email Address</label>
                                           <input type="text" name="emailadd" id="emailadd">
                                       </div>
                                        <div class="field">
                                            <label>Nick Name</label>
                                            <input type="text" name="PName" id="PName" placeholder="">
                                        </div>
                                        <div class="required field">
                                          <label>Gender</label>
                                          <select name="Ugender" id="Ugender" class="ui dropdown">
                                            
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                          </select>
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
                                    
                                    <div class="ui horizontal divider">Add Role(s)</div>
                                        <div class="field">
                                            <select class="ui dropdown" name="rolename" id="rolename">
                                                <option value="" selected disabled></option>
                                                <option value="3">HR Specialist</option>
                                                <option value="2">HR Coordinator</option>
                                                <option value="1">Administrator</option>
                                            </select>
                                        </div>
                                    <div class="ui error message"></div>
                                        <div class="ui buttons">
                                          <input type="Submit" name="btnSubmit" id="btnSubmit" class="ui positive button" value="Save" />
                                          <div class="or"></div>
                                                <a href="<?php echo $urlid; ?>">
                                                <div class="ui button" id="btnCancel">
                                                  Cancel  
                                                </div>
                                                </a>
                                          
                                        </div>
                                </form>
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
       .modal('show');

        $('#btnCancel').on("click",function(){
          $('#mymodal')
          .modal('setting','transition','fade')
          .modal('hide');
        });

  });

  $('#gender').dropdown();
  $('#rolename').dropdown();
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




<script type="text/javascript"> 
 function getUser(EmpID)
{
    
    $.ajax({
      url : 'searchUser2.php',
      type : 'GET',
      data : {
        "q" : EmpID
      },
      success : function(data){
          var res = JSON.parse(data);
          $('#LName').val(res['userLName']);
          $('#FName').val(res['userFName']);
          $('#MName').val(res['userMName']);
          $('#emailadd').val(res['userEmail']);
          $('#DeptName').val(res['userDept']);
          $('#PName').val(res['userNickName']);
          $('#CNumber').val(res['userContact']);
          $('#Ugender').val(res['userGen']); 
      }
    });
   
}



</script>

