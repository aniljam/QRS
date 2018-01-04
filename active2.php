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
                        <div class="col-md-12">
                            <div class="ui secondary raised segment ">
                                <?php 
                                    $listTitle = ($trnsFilter == "completed") ? $trnsFilter." / cancelled" : $trnsFilter;
                                    
                                 ?>
                                <div class="ui teal ribbon label pageLabel"><i class="fa fa-list-ol"></i>&nbsp;&nbsp;<?php echo strtoupper($listTitle)." "; ?> TRANSACTIONS</div>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        var table = $('#DispTable').DataTable( {
                                            lengthChange: false,
                                            "order": [[ 0, "desc" ]]
                                        }); 

                                        $('.updatebutton').popup()
                                        ;
                                        $('.viewbutton').popup()
                                        ;
                                    });
                                </script>
                                <div class="ui basic segment table-responsive" >
                                <table class="ui mini green table" id="DispTable" style="font-size:0.9em;">
                                    <thead>
                                    <tr class="single line">
                                    <th>Id</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Sub-Category</th>
                                        <?php 
                                            if(in_array_any(Array(71, 72), $_SESSION['Ses_uRole']))/*Admin or HR Specialist*/
                                            {
                                                echo "<th>Created by</th>";}
                                            if(in_array_any(Array(71, 73), $_SESSION['Ses_uRole']))/*Admin or Employee*/
                                            {
                                                echo "<th>Assigned to</th>";
                                                echo "<th>Reassigned to</th>";
                                            }
                                             
                                        ?>
                                    <th>Status</th>
                                    <th></th>   
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                        <?php
                                                global $db;

                                                
                                                    if($trnsFilter == "active")
                                                    {
                                                        
                                                        $db->where("transstat",Array(6,7),"NOT IN");
                                                        //check role
                                                        if(chk_role($_SESSION['portal_loguser'], 73)){
                                                            $db->where("transby",$_SESSION['portal_loguser']);
                                                        }
                                                        elseif(chk_role($_SESSION['portal_loguser'], 72)){
                                                           $db->where("((transstat = 1 AND transassignto = ".$_SESSION['uID'].") OR (transstat = 5 AND tbl_transactions.relativeid = ".$_SESSION['uID'].") OR (transstat IN(2,8) AND tbl_transactions.relativeid2 = ".$_SESSION['uID']."))");
                                                        }
                                                        if(isset($stype)){
                                                            $db->where("transservtypeid",$stype);
                                                        }
                                                    }

                                                    elseif($trnsFilter == "completed")
                                                    {   
                                                        if($stype){
                                                        $db->where("transservtypeid",$stype);
                                                        }

                                                        $db->where("transstat",Array(6,7),"IN");

                                                        if(chk_role($_SESSION['portal_loguser'], 73)){
                                                            $db->where("transby",$_SESSION['portal_loguser']);
                                                        }
                                                        elseif(chk_role($_SESSION['portal_loguser'], 72)){
                                                            $db->where("((transassignto = ".$_SESSION['uID']." AND tbl_transactions.relativeid IS NULL) OR (tbl_transactions.relativeid = ".$_SESSION['uID']."))");
                                                        }
                                                    }
                                                    elseif($trnsFilter == "all" || $trnsFilter == ""){

                                                        if(chk_role($_SESSION['portal_loguser'], 73)){
                                                        $db->where("transby",$_SESSION['portal_loguser']);
                                                        }elseif(chk_role($_SESSION['portal_loguser'], 72)){
                                                          $db->where("((transassignto = ".$_SESSION['uID']." AND tbl_transactions.relativeid IS NULL) OR (tbl_transactions.relativeid = ".$_SESSION['uID']."))");
                                                        }

                                                            if($type){
                                                            $db->where("transservtypeid",$type);
                                                            }
                                                    }
                                                    

                                                
                                                $db->join("tbl_servicetype","tbl_transactions.`transservtypeid` = tbl_servicetype.`servtypeid`", "INNER");
                                                $db->join("tbl_category"," tbl_transactions.`transcat` = tbl_category.`catid`","LEFT");
                                                $db->join("tbl_subcategory","tbl_transactions.`transsubcat` = tbl_subcategory.`subcatid`","LEFT");
                                                $db->join("tbl_status","tbl_transactions.`transstat` = tbl_status.`statid`","LEFT");
                                                $db->join("tbl_users TAssignTo","tbl_transactions.`transassignto` = TAssignTo.`userid`", "LEFT");
                                                 $db->join("tbl_users TReAssignTo","tbl_transactions.`relativeid` = TReAssignTo.`userid`", "LEFT");
                                                $selMyTrns = $db->WithTotalCount()->get("tbl_transactions",null,"tbl_transactions.transid tID, tbl_transactions.transcat tcatid, tbl_transactions.transby crby, tbl_servicetype.servtypedesc tStype, tbl_transactions.transdatetime tDT, tbl_category.catdesc catname, tbl_subcategory.subcatdesc subcatname, tbl_status.statdesc statname, tbl_transactions.transstat Tstatid, TAssignTo.fullname UserAssignName, TReAssignTo.fullname UserReAssignName");
                                            //echo $db->getLastQuery();

                                            if($db->totalCount == 0){
                                         ?>
                                         <tr><td colspan="7">You don't have any active request/concern</td></tr>
                                         <?php }else{foreach ($selMyTrns as $key => $value) { ?>

                                         <tr>   
                                            <td><?php echo $value['tID']; ?></td>
                                            <td><?php echo $value['tStype'];?></td>
                                            <td><?php echo date("M j, y,  h:i a",strtotime($value['tDT']));?></td>
                                            <td><?php echo $value['catname'];?></td>
                                            <td><?php echo $value['subcatname']; ?></td> 
                                                <?php 
                                                //diwaportal function
                                                    if(in_array_any(Array(71, 72), $_SESSION['Ses_uRole']))/*Admin or HR Specialist*/
                                                    {
                                                        $cby = getDPortalUser($value['crby']);
                                                        echo "<td>".$cby['FName']." ".$cby['LName']."</td>";

                                                        
                                                    }
                                                    if(in_array_any(Array(71, 73), $_SESSION['Ses_uRole']))/*Admin or Employee*/
                                                    {

                                                        echo "<td>".$value['UserAssignName']."</td>";
                                                        echo "<td>".$value['UserReAssignName']."</td>";
                                                        
                                                    }
                                                   
                                                ?>
                                            <td><?php echo $value['statname']; ?></td>
                                            <td>
                                                <?php 
                                                $trnsAction = getStatAccess($value['Tstatid']);
                                                if($trnsAction){
                                                ?>
                                                <a href="details2.php?QRSid=<?php echo $value['tID'];?>&action=UPDATESTAT" class="btnLink">
                                                <div class="mini circular ui right floated green icon button" data-position="left center" data-variation="mini" data-tooltip="Update Status" >
                                                <i class="fa fa-pencil-square-o"></i>
                                                </div></a>
                                                <?php }else{?>
                                                <a href="details2.php?QRSid=<?php echo $value['tID'];?>&action=VIEW" class="btnLink">
                                                <div class="mini circular ui right floated teal icon button" data-position="left center" data-variation="mini" data-tooltip="View Details">
                                                <i class="fa fa-folder-open-o"></i>
                                                </div></a>
                                                <?php } ?>
                                            </td>
                                            <!--<td><i class="fa fa-pencil">&nbsp;UPDATE</i></td>-->
                                        </tr>

                                         <?php 
                                            } 
                                            //echo "Found ".$db->totalCount." Active Transactions";
                                            }

                                         ?>
                                    </tbody>
                                </table>
                                </div>
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
