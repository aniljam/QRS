<!DOCTYPE html>
<html>
<head>
  <title>QRS Category</title>
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
    global $db;

    $db->where('tbl_subcategory.subcatid',$myID);
    $db->join('tbl_assignedref','tbl_subcategory.`subcatid` = tbl_assignedref.`subcatid`','LEFT');
    $db->join('tbl_users','tbl_assignedref.`userid` = tbl_users.`userid`','LEFT');
    $db->join('tbl_category','tbl_subcategory.catid = tbl_category.catid','INNER');
    $selSC = $db->getOne('tbl_subcategory','tbl_subcategory.subcatid SCID, tbl_subcategory.subcatdesc SCNAME,tbl_assignedref.userid SCASSID, tbl_subcategory.subcatstatus SCSTAT,tbl_category.catdesc SCcatname');


 ?>
 <?php 
 if(isset($_POST['btnSubmit']) == "Update"){
      editSC();
    } 

    ?>

<div class="ui mini modal" id="mymodal">
<div class="header">
  <label><?php echo $selSC['SCcatname']; ?></label>
</div>
            
            <form class="ui form segment" enctype="multipart/form-data" method="POST" action="" id="myFrm">
                
                <div class="field">
                  <input type="hidden" name="subcatID" id="subcatID" value="<?php echo $selSC['SCID']; ?>">
                  <label>Subcategory Name</label>
                  <input type="text" name="subcatname" id="subcatname" value="<?php echo $selSC['SCNAME']; ?>">
                </div>
                <div class="two fields">
                  
                <div class="field">
                  
                  <label>Assigned HR Specialist Name</label>
                  <select class="ui dropdown" name="HRassign" id="HRassign">
                    <?php 
                    global $db;
                      $db->where('tbl_userroles.roleid',3);
                      $db->where('tbl_userroles.userrolestat',1);
                      $db->join('tbl_users','tbl_userroles.userid = tbl_users.userid','INNER');
                      $sel = $db->get("tbl_userroles",null,"tbl_users.userid usID, tbl_users.fullname usName");
                      foreach ($sel as $key => $value) {
                      
                     ?>
                     <option value="<?php echo $value['usID']; ?>" <?php if($value['usID'] == $selSC['SCASSID']){echo "selected='selected'";} ?>><?php echo $value['usName']; ?>
                     </option>
                      <?php } ?>
                  </select>

                </div>
                <div class="field">
                  <label>Active ? </label>
                  <select class="ui dropdown" name="subcatstat" id="subcatstat">
                    <option value=""></option>
                    <option value="1" <?php if($selSC['SCSTAT'] == 1){echo "selected='selected'";} ?> >YES</option>
                    <option value="0" <?php if($selSC['SCSTAT'] != 1){echo "selected='selected'";} ?> >NO</option>
                  </select>
                </div>
                </div>
                <div class="ui horizontal divider">-</div>
                <div class="ui error message"></div>
                                      <div class="ui buttons">
                                          <input type="Submit" name="btnSubmit" id="btnSubmit" class="ui positive button" value="Update" />
                                          <div class="or"></div>
                                                <a href="<?php echo $urlid; ?>">
                                                <div class="ui button" id="btnCancel">
                                                  Cancel  
                                                </div>
                                                </a>
                                          
                                        </div>
                                    
            </form>

                                 
</div>
  
</body>
</html>

<script type="text/javascript">
                                    $(document).ready(function(){
                                        $('#myFrm')
                                                  .form({
                                                    inline : false,
                                                    on: 'submit',
                                                    fields: {
                                                      subcatID: {
                                                        identifier  : 'subcatID',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Subcategory ID is required'
                                                          }
                                                        ]
                                                      },
                                                      subcatname: {
                                                        identifier  : 'subcatname',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Please input Subcategory name'
                                                          }
                                                        ]
                                                      },
                                                      HRassign: {
                                                        identifier  : 'HRassign',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Please select HR name to assign'
                                                          }
                                                        ]
                                                      },
                                                      subcatstat: {
                                                        identifier  : 'subcatstat',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Please select if Active or Inactive'
                                                          }
                                                        ]
                                                      }
                                                    }
                                                  });
                                    
                                    });

                        </script>
 <script type="text/javascript">
  $(document).ready(function(){
       $('#mymodal')
       .modal({inverted: false})
       .modal('setting', 'closable', false)
       .modal('setting','transition','fade up')
       .modal('show');

        $('#btnCancel').on("click",function(){
          $('#mymodal')
          .modal('setting','transition','fade')
          .modal('hide');
        });

  });

  $('#HRassign').dropdown();
  $('#subcatstat').dropdown();
  </script>










