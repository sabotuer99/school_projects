<?php

		require_once 'db_login.php';
		$pid = $_GET['pid'];		
		
		$query = "SELECT * 
									FROM 6126Patient
									JOIN 6126BedAssignment USING(pid)
									JOIN 6126Bed USING(bid)
									JOIN 6126Admission USING(pid)
									WHERE pid=".$pid;
		$result = mysqli_query($db_server, $query) or die("Couldn't execute select query: <br>".$query." error:". mysqli_error($db_server));	
		$row = mysqli_fetch_assoc($result);
?>

<div style="width:350px;">

<hr SIZE="3" NOSHADE>

<p style="text-align:center">Patient Report<br>
Date: <?php echo date("F j, Y");?></p><br>

Patient#: <?php echo $pid;?><br>
Patient Name: <?php echo $row['lname'].', '.$row['fname'];?><br>
Street:<?php echo $row['street'];?><br>
City:<?php echo $row['city'];?><br>
State:<?php echo $row['state'];?><br>
Zip:<?php echo $row['zip'];?><br>
Date Admitted:<?php echo $row['begindate'];?><br>
Date Discharged:<?php echo $row['enddate'];?><br>
Room:<?php echo $row['rnum'];?><br>
Bed:<?php echo $row['label'];?><br>
Insurance:<?php echo $row['inscarrier'].', '.$row['policynum'];?><br>			

  
<hr SIZE="3" NOSHADE>

<?php
 				echo '<br>'.$query.'<br><br>';
?>
</div>