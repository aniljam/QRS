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
    //$arrRoles = getMyRoles($_SESSION['portal_loguser']);

    if(isset($_GET['servtype'])){
        $stype = $_GET['servtype'];
        }
    if(isset($_GET['filter'])){
        $trnsFilter = $_GET['filter'];
        }
        //array of role from diwaportal
      //print_r($_SESSION['Ses_uRole']);                                  
?>

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
                        <div class="col-md-10">
                            <div class="ui secondary raised segment ">
                            <div class="ui pink ribbon label">Category List</div>
                                <table class="circular ui table">
                                    <thead><tr>
                                    <th>Category Name</th>
                                    <th>Create By</th>
                                    <th>Create Date</th>
                                    <th>Edit By</th>
                                    <th>Edit Date</th>
                                    <th>Active</th>
                                    <th></th>    
                                    </tr></thead>
                                </table>

                            </div>
                        </div>
                    </div>
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
