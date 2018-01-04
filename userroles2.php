<?php 
// GLOBAL CHECK FOR LOGIN SESSION
include '../../../dbconn_portal.php';
include '../../../dbfunc_portal.php';
if (!isset($_SESSION['portal_loguser'])) {
    header('Location: /diwaportal/index.php?staterr=2');
}
// END GLOBAL CHECK FOR LOGIN SESSION

?>

<!DOCTYPE html>
<html lang="en">
<?php 
    include("dbfunc/panksyons.php");
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
    <!--End Semantic UI-->

    <!--Highcharts-->
    <script type="text/javascript" src="ext/highcharts/highcharts.js"></script>
    <script type="text/javascript" src="ext/highcharts/highcharts-3d.js"></script>
    <script type="text/javascript" src="ext/highcharts/modules/exporting.js"></script>


</head>



<body>

<?php 
    $selcat = new LoggedAccount();
    $selcat -> getMyRoleCat($_SESSION['portal_loguser']);
 ?>

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

            <?php include "navbartop.php"; ?>
            <!-- /.navbar-top-links -->
            <?php include "sidebar.php"; ?>
        
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                    <br />
                           <script type="text/javascript">
    $(document).ready(function(){
        $('#mybutton').on("click",function(){
             $('#testmodal').modal('show');
        });
        
        $('.mybutton').popup({
    popup: '.special.popup'
  })
;
    });
    </script>

<div class="col-md-12">
<?php //include "test/home.php"; ?>
    <div class="ui segment">
        <div class="ui pink ribbon label" >User Role Table
        </div>

        <table class="ui table" id="DispTable">
            <thead><tr>
                <!--<th>Employee ID</th>-->
                <th>Name</th>
                <th>Role Name</th>
                <th>Remarks</th>
                <th>Created By</th>
                <th>Created Date</th>
                <th>Edited By</th>
                <th>Edited Date</th>
                <th>Active</th>
                <th></th>
            </tr></thead>
            <tbody>
            <?php 
                global $db;
                $prms = Array();
                $seldb = $db->rawQuery("SELECT Tusers.userid IDuser, fullname,empid,roledesc,roleremarks,Tref.createdby CRby, 
                                        Tref.createddate CRdate, Tref.editedby EDby, Tref.editeddate EDdate, Tref.userrolestat URstat 
                                        FROM tbl_users Tusers
                                        LEFT JOIN tbl_userroles Tref ON Tusers.`userid` = Tref.`userid`
                                        LEFT JOIN tbl_roles Troles ON Tref.`roleid` = Troles.`roleid`
                                        ",$prms);
                //echo $db->getLastQuery();
                foreach ($seldb as $key => $value) {
                    if($value[URstat] == 0){
                        $trClass = "disabled";
                    }
                    else{
                        $trClass = "";
                    }
             ?>
             <tr class="<?php echo $trClass; ?>">
             <!--<td><?php //echo $value[empid]; ?></td>-->
             <td><?php echo $value[fullname];?></td>
             <td><?php echo $value[roledesc];?></td>
             <td><?php echo $value[roleremarks]; ?></td>
             <td><?php $crUser = getUser($value[CRby]);
                        echo $crUser[nickname]; ?></td>
             <td><?php echo $CRdate = ($value[CRdate]) ? date("M j, y, g:i a ",strtotime($value[CRdate])): "";?></td>
             <td><?php echo $value[editedby]; ?></td>
             <td><?php echo $value[editeddate]; ?></td>
             <td><?php if($trClass != "disabled"){
                echo "<i class='large green checkmark icon'></i>";
                }
                 ?></td>
            <td>
            <div class="ui special popup">
              <div class="header">View</div>
            </div>
            <button class="ui icon primary basic button mybutton" id="mybutton"><a href="users.php?id=<?php echo $value[IDuser]; ?>" class="editLink"><i class="fa fa-pencil-square-o"></i></a></button></td>
             </tr>
             <?php } ?>
            </tbody>
            
        </table>
    </div>
</div>



                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->


    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>


    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
