<?php

		require_once 'db_login.php';
		$eid = $_GET['eid'];		
		
		$query = "SELECT name, a.phone,  a.rnum AS office, pid, lname, fname, b.rnum, label, medproc
									FROM 6126Doctor AS a
									JOIN 6126Employee USING(eid)
									LEFT JOIN 6126PatientTreat USING(eid)
									LEFT JOIN 6126Treatment USING(tid)
									LEFT JOIN 6126BedAssignment USING(pid)
									LEFT JOIN 6126Bed AS b USING(bid)
									LEFT JOIN 6126Patient USING(pid)
									WHERE eid=".$eid;
		$result = mysqli_query($db_server, $query) or die("Couldn't execute select query: <br>".$query." error:". mysqli_error($db_server));	
		$row = mysqli_fetch_assoc($result);
?>

<div style="width:350px;">

<hr SIZE="3" NOSHADE>

<p style="text-align:center">Bay View Community Hospital<br>
Physician Report<br>
Date: <?php echo date("F j, Y");?></p><br>
<div style="width:100%">
Physician ID: <?php echo $eid;?><br>
Physician Name: <?php echo $row['name'];?><br>
Physician Phone:<?php echo $row['phone'];?><br>
Physician Office:<?php echo $row['office'];?><br>
</div>


		<div style="float:left; width:15%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Patient#</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['pid'].'<br>';				
			}
		?>
		</div>
		
				<div style="float:left; width:35%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Patient Name</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['lname'].', '.$row['fname'].'<br>';				
			}
		?>
		</div>
		
				<div style="float:left; width:15%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Location</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['rnum'].'-'.$row['label'].'<br>';				
			}
		?>
		</div>
		
				<div style="float:left; width:35%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Procedure</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['medproc'].'<br>';				
			}
		?>
		</div>
		

  
<hr SIZE="3" NOSHADE>

<?php
 				echo '<br>'.$query.'<br><br>';
?>
</div>