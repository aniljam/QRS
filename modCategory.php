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
	<script type="text/javascript">
	$(document).ready(function(){
			 $('#mymodal')
			 .modal({inverted: false})
       .modal('setting', 'closable', false)
			 .modal('setting','transition','horizontal flip')
			 .modal('show');

        $('#btnCancel').on("click",function(){
          $('#mymodal')
          .modal('setting','transition','horizontal flip')
          .modal('hide');
        });

        $('.tabular.menu .item').tab();

	});


	</script>
</head>
<?php 
    require_once("dbfunc/panksyons.php");
?>
<body>
 <?php 
    $url = $_SERVER['HTTP_REFERER'];
    $urlid = substr($url, strrpos($url, '/') + 1);

    $catID = $_GET['id'];
    if($catID){
      global $db;

      $db->where('catid',$catID);
      $sel = $db->getOne('tbl_category','tbl_category.catid CID, catdesc CName');

    }


  ?>

<div class="ui modal" id="mymodal">
  <div class="header">
    Category Setup
  </div>
  <div class="image content">
       <form class="ui basic form segment">
         <div class="inline field">
           <label>Category Name :</label>
           <input type="text" name="catname" id="catname" value="<?php echo $sel['CName']; ?>">
           <input type="hidden" name="test" value="<?php echo $sel['CID']; ?>">
         </div>
         <table class="ui medium celled padded green table">
           <thead>
           <tr>
            <th>Subcategory</th>
            <th>HR Specialist Assigned</th>
            <th>Date Updated</th>
            <th>Update By</th>
            <th>Active</th>
            <th></th>  
           </tr>
           </thead>
            
                <tbody>
                  <?php
                    if($sel['CID']){
                    global $db;

                    $db->where('catid',$sel['CID']);
                    $db->join('tbl_assignedref','tbl_subcategory.subcatid = tbl_assignedref.subcatid','LEFT');
                    $db->join('tbl_users','tbl_assignedref.userid = tbl_users.userid','LEFT');
                    $db->join('tbl_users Teditby','tbl_assignedref.relativeid = Teditby.userid','INNER');
                    $selData = $db->get('tbl_subcategory',null,'tbl_subcategory.subcatid SCID,subcatdesc,tbl_users.fullname SCASSName, tbl_subcategory.subcatstatus SCstat, tbl_assignedref.edittimestamp edDate, Teditby.fullname edbyname');

                      foreach ($selData as $key => $value) {
                      
                   ?>
                    <tr>
                    <td><?php echo $value['subcatdesc']; ?></td>
                    <td><?php echo $value['SCASSName']; ?></td>
                    <td><?php echo $eddate = ($value['edDate']) ? date("F j, Y, g:i a ",strtotime($value['edDate'])): "";?></td>
                    <td><?php echo $value['edbyname']; ?></td>
                    <td><?php if ($value['SCstat'] == 1) {
                      echo "<i class='large green checkmark icon'></i>";
                    } ?></td>
                    <td><a href="#"><i class="fa fa-pencil-square-o"></i></a></td>
                    </tr>
                      <?php  }?>

                   <?php } ?>
                </tbody>
            <?php

              
            ?>
         </table>
       </form>
            
  </div>
<div class="actions">
  <div class="ui buttons">
  <button class="ui positive button">Save</button>
  <div class="or"></div>
  <a href="<?php echo $urlid; ?>"><button class="ui button" id="btnCancel">Cancel</button></a>
  </div>
</div>
</div>
	
</body>
</html>
<script type="text/javascript">

</script>