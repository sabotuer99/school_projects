<?php

		require_once 'db_login.php';
		
		$query = "SELECT rnum, label, CASE WHEN typeid=1 THEN 'SP' ELSE 'PR' END AS Accom, a.pid, lname, fname, b.enddate FROM 6126Bed NATURAL JOIN 6126Room NATURAL JOIN 6126Roomtype NATURAL JOIN 6126BedAssignment AS c NATURAL JOIN (SELECT pid, fname, lname FROM 6126Patient) AS a LEFT JOIN (SELECT enddate, pid, begindate FROM 6126Admission) AS b ON ( b.begindate = c.begindate AND a.pid = b.pid)";
		$result = mysqli_query($db_server, $query) or die("Couldn't execute select query: <br>".$query." error:". mysqli_error($db_server));	
	
?>

<div style="width:450px;">

<hr SIZE="3" NOSHADE>

<p style="text-align:center">Room Utilization Report<br>
Date: <?php echo date("F j, Y");?></p>

<p style="text-align:center">Expected</p>

<div style='clear:both;'>

		<div style="float:left; width:10%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Room</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['rnum'].'<br>';				
			}
		?>
		</div>

		<div style="float:left; width:10%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Bed</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['label'].'<br>';				
			}
		?>
		</div>
		
		<div style="float:left; width:12%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Accom</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['Accom'].'<br>';				
			}
		?>
		</div>
		
		<div style="float:left; width:16%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Patient#</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['pid'].'<br>';				
			}
		?>
		</div>
		
		<div style="float:left; width:26%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Patient Name</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['lname'].', '.$row['fname'].'<br>';				
			}
		?>
		</div>
		
		<div style="float:left; width:26%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Discharged</span><br>
		<?php 
		$result->data_seek(0);
		while(		$row = mysqli_fetch_assoc($result)		)
			{
			echo $row['enddate'].'<br>';				
			}
		?>
		</div>		


		
</div>  
  
<hr SIZE="3" NOSHADE>

<?php
 				echo '<br>'.$query.'<br><br>';
?>
</div>