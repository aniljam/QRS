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

<?php
$selUserProfile = new getUserProfile();

if(!empty($_SESSION['uID'])){
    $selUserProfile -> getbyID($_SESSION['uID']);
}
else{
    $selUserProfile -> getbyEmpID($_SESSION['portal_loguser']); 
}

if(isset($_POST['Submit']) == "Save"){
    $selUserProfile -> upUserData($_SESSION['portal_loguser']);
}
?>
        <style>
        .image-upload > input
        {
        display: none;
        }
        #dispPic2{
            display: none;
        }
        
        </style>
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

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    <br />
                        <div class="col-md-12">
                            <div class="ui secondary raised segment ">
                                
                                <div class="ui teal ribbon label pageLabel"><i class="user circle outline icon"></i>User's Profile</div>
                                <div class="panel-body">
                                    <div class="col-md-8">
                                        <div class="ui basic segment">
                                           <form action="" id="myfrm" method="post" name="myfrm" enctype="multipart/form-data" class="ui form basic segment">
                                                
                                                        
                                                 <?php if($selUserProfile -> UPavatar != ""){
                                                    ?>
                                                <img id="dispPic" src="<?php echo $selUserProfile -> UPavatar; ?>" alt="your image" class="img-circle" height="120" width="120"/>
                                                <?php }else{ ?>
                                                <a class="ui green circular label" style="height:80px!important;width:80px!important;font-size: 45px" id="defDP"><?php echo substr($_SESSION['Pname'], 0, 1); ?>
                                                </a>
                                                <img id="dispPic2" src="" alt="your image" class="img-circle" height="120" width="120"/>
                                                <?php } ?>

                                                <div class="image-upload">
                                                <label for="file-input" data-tooltip="Change Display Picture" data-position="right center">
                                                <i class="edit icon"></i>
                                                </label>
                                                
                                                <input type='file' id="file-input" onchange="readURL(this);" class="input-sm" name="prefPicture" id="prefPicture" />
                                                <input type="hidden" value="<?php echo $selUserProfile -> UPavatar; ?>" name="avatar" />
                                                </div>     
                                                <div class="two fields">
                                                    <div class="field">
                                                        
                                                    <label>Employee ID</label>
                                                    <input type="text" name="EmpID" id="EmpID" placeholder="Employee ID" readOnly value="<?php echo $selUserProfile -> UPempid; ?>">
                                                    </div>
                                                    <div class="field">
                                                        <label>Preferred Name</label>
                                                        <input type="text" name="Pname" id="Pname" placeholder="Preferred Name" value="<?php echo $selUserProfile -> UPpname; ?>">
                                                    </div>
                                                </div>
                                                <div class="three fields">
                                                    <div class="field">
                                                        <label>Firstname</label>
                                                        <input type="text" name="fname" id="fname" placeholder="Firstname" value="<?php echo $selUserProfile -> UPfname; ?>">
                                                    </div>
                                                    <div class="field">
                                                        <label>Middlename</label>
                                                        <input type="text" name="mname" id="mname" placeholder="Middlename" value="<?php echo $selUserProfile -> UPmname; ?>">
                                                    </div>
                                                    <div class="field">
                                                        <label>Lastname</label>
                                                        <input type="text" name="lname" id="lname" placeholder="Lastname" value="<?php echo $selUserProfile -> UPlname; ?>">
                                                    </div>        
                                                </div>
                                                <div class="two fields">
                                                    <div class="field">
                                                        <label>Contact</label>
                                                        <input type="text" name="contact" id="contact" placeholder="Contact No." value="<?php echo $selUserProfile -> UPcontact; ?>">
                                                    </div>
                                                    <div class="field">
                                                        <label>Gender</label>
                                                        <select class="ui dropdown" id="gender" name="gender">
                                                            <option value=""></option>
                                                            <option value="Male" <?php if($selUserProfile -> UPgender == "Male"){echo "selected='selected'";} ?>>Male</option>
                                                            <option value="Female" <?php if($selUserProfile -> UPgender == "Female"){echo "selected='selected'";} ?>>Female</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="field">
                                                    <label>Department</label>
                                                    <input type="text" name="deptname" id="deptname" placeholder="Department Name" value="<?php echo $selUserProfile -> UPdeptname; ?>">
                                                </div>

                                                <div class="field">
                                                    <input type="submit" name="Submit" id="btnSubmit" class="ui submit green button" value="Save">
                                                    <button class="ui cancel teal button">Cancel</button>
                                                </div>
                                            </form>

                                        </div>
                                        <script type="text/javascript">
                                            function readURL(input){
                                                if(input.files && input.files[0]){
                                                    var reader = new FileReader();
                                                    reader.onload = function(e) {
                                                        
                                                    if($('#dispPic').length){
                                                            $('#dispPic').attr('src', e.target.result);
                                                        }
                                                        else{
                                                            $('#defDP').css('display','none');
                                                            $('#dispPic2').css('display','inline');
                                                            $('#dispPic2').attr('src', e.target.result);
                                                        } 
                                                    }
                                                     reader.readAsDataURL(input.files[0]);
                                                }
                                            }

                                            $(document).ready(function(){

                                               $('#myfrm').form({
                                                    inline: true,
                                                    on : 'blur',
                                                    fields: {
                                                        EmployeeID : 'empty',
                                                        Pname : 'empty',
                                                        fname : 'empty',
                                                        mname : 'empty',
                                                        lname : 'empty',
                                                        contact : 'empty',
                                                        gender : 'empty',
                                                        deptname : 'empty'
                                                    }
                                               });
                                            });
                                        </script>
                                    </div>
                                    <!--<div class="col-md-4">
                                        <div class="ui basic segment">
                                            <div class="ui horizontal divider">Role(s)</div>
                                            <table class="ui table">
                                                <tbody>
                                                    <tr><td>Employee</td></tr>
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                    </div>-->
                                </div>
                                
                            </div>
                            <!--Footer-->
                            <div class="ui invisible divider"></div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
                    <!-- /.col-lg-12 -->
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

<script type="text/javascript">

</script>