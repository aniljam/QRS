<?php 
// GLOBAL CHECK FOR LOGIN SESSION
require '../../../dbconn_portal.php';
require '../../../dbfunc_portal.php';
if (!isset($_SESSION['portal_loguser'])) {
    header('Location: /diwaportal/index.php?staterr=2');
}
// END GLOBAL CHECK FOR LOGIN SESSION

?>

<!DOCTYPE html>
<html lang="en">
<?php 
    require("dbfunc/panksyons.php");
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

    <!--for VUEJS
    <script type="text/javascript" src="ext/vuejs/index.js"></script>-->
</head>



<body>

<?php 

$selQRSaccnt = new LoggedAccount();
$selQRSaccnt -> getaccountuser($_SESSION['portal_loguser']);

$selDUsers = new GetUserDportal();
$selDUsers -> getActiveUser($_SESSION['portal_loguser']);       
$selDUsers -> getMyDPortalRole($_SESSION['portal_loguser']);
$_SESSION['Ses_uRole'] = $selDUsers -> u_Roles;

if($selQRSaccnt -> uID){

    $_SESSION['uID'] = $selQRSaccnt -> uID;
    $_SESSION['Pname'] = $selQRSaccnt -> Pname;
    $_SESSION['dp'] = $selQRSaccnt -> Uavatar;
}else{
           
        if($selDUsers -> u_empID){
            $_SESSION['Pname'] = $selDUsers -> u_FN;
        }else{
            echo "<script>alert('Data not found in both diwaportal and QRS database, or you're not yet logged in diwaportal.);
                window.location='/diwaportal/showportal.php';</script>";
        } 
}

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
                            <?php include "dashboardtop.php"; ?>

                            <div class="ui seven wide stretched column">
                                <div class="ui secondary stacked segment">
                                   
                                        
                                            <div class="panel-body">
                                                <div class="col-md-6" id="dashboardchart" style="height: 350px;"></div>

                                                <div class="col-md-6">
                                                    <?php include "taskpanel.php"; ?>
                                                </div>
                                            </div>
                                           
                                </div>
                                

                            </div>
                        </div>

                         
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="ui invisible divider"></div><div class="ui invisible divider"></div><div class="ui invisible divider"></div>
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
    
    <script type="text/javascript">
        Highcharts.chart('dashboardchart',{
        chart:{type:'pie',options3d:{
            enabled:true,alpha:55,beta:0
        },
        backgroundColor: '#F3F4F5'
        },
        title:{text:''},
        credits:{enabled:false},
        tooltip:{pointFormat:'{series.name}:<b>{point.percentage:.1f}%</b>'},
        plotOptions:{pie:{allowPointSelect:true,cursor:'pointer',depth:35,dataLabels:{enabled:true,format:'{point.name}'},}},
       exporting: {
         enabled: false
            },
        series:[{
            type:'pie',
            name: 'Transaction Status Percentage',
            data:[
                <?php 
                        if($totActive){
                            echo "{name:'Active',";
                            echo "y:".$totActive.",";
                            echo "color: '#65a0d4'}";
                        }
                        if($comIssReqCnt){
                            if($totActive != ""){
                                echo ",";
                            }
                            echo "{name:'Completed',";
                            echo "y:".$comIssReqCnt.",";
                            echo "sliced:true,";
                            echo "selected: true,";
                            echo "color: '#5CB85C'}";
                        }
                 ?>
            ]

        }]

    });

   </script>
</html>
