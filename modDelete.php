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
<div class="ui basic modal" id="delModal">
  <div class="ui icon header">
    <i class="trash icon"></i>
    Are you sure you want to Delete this Role?
  </div>
  <div class="content">
   
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
	$('#delModal').modal({
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
<script type="text/javascript"> 
 function DeleteUser(uID)
{
    
    if (window.XMLHttpRequest)
    { // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            window.location='userroles.php?action=DelSuccess'; 
        }
    }
    xmlhttp.open("GET", "deleteFunc.php?q=" + uID, true);
    xmlhttp.send();
   
}
</script>
