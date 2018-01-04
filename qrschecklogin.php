<?php 
// GLOBAL CHECK FOR LOGIN SESSION
require '../../../dbconn_portal.php';
require '../../../dbfunc_portal.php';
if (!isset($_SESSION['portal_loguser'])) {
    header('Location: /diwaportal/index.php?staterr=2');
}
// END GLOBAL CHECK FOR LOGIN SESSION

?>
<?php 

//-Check DiwaPortal Role

if((chk_role($_SESSION['portal_loguser'], 71)) || 
	(chk_role($_SESSION['portal_loguser'], 72)) || 
	(chk_role($_SESSION['portal_loguser'], 73)))
{
	header('location:home.php');
}
else{
		echo "<script>
	alert('You dont have active role in DiwaPortal, Please contact administrator!')
		window.location='/diwaportal/showportal.php';
		</script>";
}
?>