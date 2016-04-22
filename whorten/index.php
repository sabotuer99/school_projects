<?php
session_start();
?>
<!DOCTYPE html>
<html>

<?php
 
require_once 'home/variables.php';
require_once $HeadLocation;

?>

<body>
<?php
if(isset($_GET['navtarget'])) 
{
			$navtarget = $_GET['navtarget'];
}
else 
{
			$navtarget = 'home/home.php';
}
require_once $BodyLocation;


?>
</body>
</html>