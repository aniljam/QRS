<?php 
// GLOBAL CHECK FOR LOGIN SESSION
require '../../../dbconn_portal.php';
require '../../../dbfunc_portal.php';
if (!isset($_SESSION['portal_loguser'])) {
    header('Location: /diwaportal/index.php?staterr=2');
}

?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require_once("dbfunc/panksyons.php");
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HR-QRS</title>

    
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!--Customized-->
    <link rel="stylesheet" type="text/css" href="dist/css/mystyle.css">
    <!--Customized-->

    <!--Semantic UI-->
    <link rel="stylesheet" type="text/css" href="ext/semantic.min.css"/>
    
    <script type="text/javascript" src="ext/semantic.min.js"></script>

            <!--data tables
            
            <link rel="stylesheet" type="text/css" href="vendor/datatables/dataTables.semanticui.min.css">
            <script type="text/javascript" src="vendor/datatables/js/dataTables.semanticui.min.js"></script>-->
    <!--End Semantic UI-->

    <!--Highcharts-->
    <script type="text/javascript" src="ext/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="ext/highcharts/highcharts-3d.js"></script>
    <script type="text/javascript" src="ext/highcharts/modules/exporting.js"></script>

    <script type="text/javascript" src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="vendor/datatables/css/dataTables.bootstrap.min.css"/>
    <script type="text/javascript" src="vendor/datatables/js/dataTables.bootstrap.min.js"></script>

</head>


<body>



<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand astyle" href="home.php"><strong>HR Query and Request System</strong></a>
            </div>
            <!-- /.navbar-header -->

            <?php include_once "navbartop.php"; ?>
            <!-- /.navbar-top-links -->
            <?php include_once "sidebar.php"; ?>
        
            <!-- /.navbar-static-side -->
        </nav>
<?php 


    if(isset($_POST['btnSubmit']) == "Save"){
        addUserRole();
    }
    
 ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    <br />
                        <div class="col-md-8">
                            <div class="ui raised segment ">
                            <div class="ui pink ribbon label"><i class="fa fa-users" aria-hidden="true"></i>&nbsp; Add User Role</div>
                                <form class="ui form basic segment" enctype="multipart/form-data" method="POST" action="" id="myFrm">
                                    <div class="ui horizontal divider">User's Profile</div>
                                    <div class="inline field">
                                         <!--For Profile Picture
                                         <a href="#"><img src='' class='img-circle' height='60px' width='60px;' alt='' style="border: 5px;" />
                                         </a>-->
                                         <label>Employee ID</label>
                                         <input type="text" name="EmpNumber" id="EmpNumber" placeholder="Search Employee ID ..." onkeyup="getUser(this.value);">
                                         
                                    </div>
                                    <div>
                                        <input type="text" name="testdiv" id="testdiv" >
                                        <input type="hidden" name="rIDs" id="rIDs">

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
                                    <div class="two fields">
                                        <div class="required field">
                                           <label>Email Address</label>
                                           <input type="text" name="emailadd" id="emailadd">
                                       </div>
                                        <div class="field">
                                            <label>Nick Name</label>
                                            <input type="text" name="PName" id="PName" placeholder="">
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
                                    <?php if() ?>
                                    <div class="ui horizontal divider">Add Role(s)</div>
                                        <div class="field">
                                            <select class="ui dropdown" name="rolename" id="rolename">
                                                <option value="" selected disabled></option>
                                                <option value="3">HR Specialist</option>
                                                <option value="2">HR Coordinator</option>
                                                <option value="1">Administrator</option>
                                            </select>
                                        </div>
                                    <div class="ui horizontal divider"></div>
                                   <!-- -->
                                                       
                                    <div class="actions">
                                             <?php 
                                                $url = $_SERVER['HTTP_REFERER'];
                                                $urlid = substr($url, strrpos($url, '/') + 1);
                                             ?>
                                        <div class="ui buttons">
                                          <input type="Submit" name="btnSubmit" id="btnSubmit" class="ui positive button" value="Save" />
                                          <div class="or"></div>
                                                <a href="<?php echo $urlid; ?>">
                                                <div class="ui button" id="btnCancel">
                                                  Cancel  
                                                </div>
                                                </a>
                                          
                                        </div>
                                        
                                    </div>
                                    <div class="ui error message"></div>
                                </form>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="ui basic segment">
                                        <?php if($_GET['action'] == "Success"){?>
                                        <div class="ui positive message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>User role was added successfully!</p>
                                        </div>
                                        <?php } ?>
                                        <?php if($_GET['action'] == "Failed"){?>
                                        <div class="ui negative message transition" id="notif">
                                          <i class="close icon"></i>
                                          <p>Adding of User Role was failed!</p>
                                          <p>Error Encountered : <?php echo $_GET['err'];?></p>
                                        </div>
                                        <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="ui invisible divider"></div>
                </div>
            </div>
                    <!-- /.col-lg-12 -->
        </div>

</div>


    
    <!-- /#wrapper -->


    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>


    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>

<!--##############################################################   SCRIPTS   #############################################################################-->

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
    
    if (window.XMLHttpRequest)
    { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var response = JSON.parse(xmlhttp.response);
            document.getElementById("LName").value = response['userLName'];
            document.getElementById("FName").value = response['userFName'];
            document.getElementById("MName").value = response['userMName'];
            document.getElementById("emailadd").value = response['userEmail'];
            document.getElementById("DeptName").value = response['userDept'];
            document.getElementById("PName").value = response['userNickName'];
            document.getElementById("CNumber").value = response['userContact'];
            document.getElementById("testdiv").value = response['userRoleArr'];
            document.getElementById("rIDs").value = response['userRoleArrID'];   
        }
    }
    xmlhttp.open("GET", "searchUser2.php?q=" + EmpID, true);
    xmlhttp.send();
   
}
function getRole(EmpID){
     if (window.XMLHttpRequest)
    { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            var response = JSON.parse(xmlhttp.response);
            document.getElementById("testdiv").value = response['roleArr'];
             
        }
    }
    xmlhttp.open("GET", "searchUser2.php?q=" + EmpID, true);
    xmlhttp.send();
}



</script>

                        <script type="text/javascript">
                            $(document).ready(function(){
                                $('#notif')
                                  .on('click', function() {
                                    $(this)
                                      .closest('.message')
                                      .transition('fade')
                                    ;
                                    window.location='home.php';
                                  })
                                ;

                                $('#notif').delay(5000).slideUp(1000);


                            });
                            
                        </script>