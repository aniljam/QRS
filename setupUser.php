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
			 $('#myModal')
			 .modal({inverted: false})
       .modal('setting', 'closable', false)
			 .modal('setting','transition','horizontal flip')
			 .modal('show');

        $('#btnCancel').on("click",function(){
          $('#testmodal')
          .modal('setting','transition','horizontal flip')
          .modal('hide');
        });


	});


	</script>
</head>
<?php 
    include("dbfunc/panksyons.php");
?>
<body>


<div class="ui modal" id="myModal">
  <div class="header">
    <i class="fa fa-users" aria-hidden="true"></i>&nbsp; Add User
  </div>
  <div class="image content">
            <form>

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