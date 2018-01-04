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

        <script type="text/javascript">
    $(document).ready(function(){
             $('#testmodal')
             .modal({inverted: true})
             .modal('setting','transition','horizontal flip')
             .modal('show');
        
    });
    </script>
</head>



<body>

<?php 
    if(!isset($_SESSION['uID'])){
        echo "<script>alert('You dont have access for this System!');
        window.location='/diwaportal/showportal.php';</script>";
    }
    //echo $_SESSION['uID'];
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
        
             <?php 
                $url = $_SERVER['HTTP_REFERER'];
                $urlid = substr($url, strrpos($url, '/') + 1);
              ?>

        </nav>

        </div>
        <!-- /#page-wrapper -->

            <div class="ui modal" id="testmodal">
            <a href="<?php echo $urlid; ?>"><i class="close icon"></i></a>
              
              <div class="header">
                User Profile
              </div>
              <div class="image content">
                <?php include "mytable.php"; ?>
              </div>

              <div class="ui buttons">
              <button class="ui positive button">Save</button>
              <div class="or"></div>
              <button class="ui button"><a href="<?php echo $urlid; ?>">Cancel</a></button>
            </div>
            </div>
   


    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>


    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>
   
</html>
