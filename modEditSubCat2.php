<?php 
     $url = $_SERVER['HTTP_REFERER'];
    $urlid = substr($url, strrpos($url, '/') + 1);
    $uID = $_GET['id'];

    
    
 ?>
	 <script src="vendor/jquery/jquery.min.js"></script>

    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="ext/semantic.min.css"/>
  <link rel="stylesheet" type="text/css" href="dist/css/mystyle.css"/>
  <script type="text/javascript" src="ext/semantic.min.js"></script>

<form class="ui form" enctype="multipart/form-data" method="GET" action="" id="myDelFrm">
	<input type="hidden" name="userid" id="userid" value="<?php echo $uID; ?>">
<div class="ui basic modal" id="editModal">
  <div class="header">
    
  </div>
  <div class="content">
          <form class="ui form basic mini segment" enctype="multipart/form-data" method="POST" action="" id="myFrm">
                <div class="inline field">
                  <label>Subcategory Name</label>
                  <input type="text" name="">
                </div>
                                    
            </form>
  </div>
  <div class="actions">

   	
    <div class="ui green ok inverted button" >
      <i class="checkmark icon"></i>
      Yes
    </div>  
    
    <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      No
    </div>
    
  </div>
</div>
</form>

<script type="text/javascript">
	$('#editModal').modal({
    		closable  : false,
    		onApprove : function() {
      		var myID = $('#userid').val();
      		DeleteUser(myID);
      		return false;
    		},
    		onDeny    : function(){
    		window.location='userroles.php'; 
    		}
  })
	.modal('show')
;
 
</script>

