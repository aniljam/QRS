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

    $myID = $_GET['id'];

    global $db;

    $db->where('catid',$myID);
    $selC = $db->getOne('tbl_category');

 ?>
 <?php 
 if(isset($_POST['btnSubmit']) == "Update"){
      editCat($selC['catid']);
    } 

    ?>

<div class="ui mini modal" id="mymodal">
<div class="header">
  <label><?php echo $selC['catdesc']; ?></label>
</div>
            
            <form class="ui form segment" enctype="multipart/form-data" method="POST" action="" id="myFrm">
                
                  <input type="hidden" name="catID" id="catID" value="<?php echo $selC['catid']; ?>">
                
                <div class="two fields">
                  
                <div class="field">
                  <label>Category Name</label>
                  <input type="text" name="catname" id="catname" value="<?php echo $selC['catdesc']; ?>">
                </div>
                <div class="field">
                  <label>Active ? </label>
                  <select class="ui dropdown" name="catstat" id="catstat">
                    <option value=""></option>
                    <option value="1" <?php if($selC['catstatus'] == 1){echo "selected='selected'";} ?>>YES</option>
                    <option value="0" <?php if($selC['catstatus'] != 1){echo "selected='selected'";} ?>>NO</option>
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
                                                      catID: {
                                                        identifier  : 'catID',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Category ID is Required'
                                                          }
                                                        ]
                                                      },
                                                      catname: {
                                                        identifier  : 'catname',
                                                        rules: [
                                                          {
                                                            type   : 'empty',
                                                            prompt : 'Please input Category name'
                                                          }
                                                        ]
                                                      },
                                                      catstat: {
                                                        identifier  : 'catstat',
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

  $('#catstat').dropdown();
  </script>








