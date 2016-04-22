<?php

		require_once 'db_login.php';
		
		$pid = $_GET['pid'];
		
		$cusquery = "SELECT lname, fname, street, city, state, zip FROM 6126Patient WHERE pid=". $pid;
		$result = mysqli_query($db_server, $cusquery) or die("Couldn't execute select query: <br>".$cusquery." error:". mysqli_error($db_server));
		$cusresult = mysqli_fetch_assoc($result);		
	
		$admitquery = 	"SELECT MIN(begindate) FROM 6126Admission WHERE pid=".$pid." GROUP BY pid";
		$result = mysqli_query($db_server, $admitquery) or die("Couldn't execute select query: <br>".$admitquery." error:". mysqli_error($db_server));
		$admitdate = mysqli_fetch_row($result);		
		
		$dischargequery = 'SELECT enddate FROM 6126Admission WHERE pid='.$pid.' AND begindate="'.$admitdate[0].'"';
		$result = mysqli_query($db_server, $dischargequery) or die("Couldn't execute select query: <br>".$dischargequery." error:". mysqli_error($db_server));
		$dischargedate = mysqli_fetch_row($result);		
	
		$bedquery = "SELECT description, rate, typeid FROM 6126Roomtype NATURAL JOIN 6126Bed NATURAL JOIN 6126Room NATURAL JOIN 6126BedAssignment WHERE pid=".$pid." AND begindate='".$admitdate[0]."'";
		$result = mysqli_query($db_server, $bedquery) or die("Couldn't execute select query: <br>".$bedquery." error:". mysqli_error($db_server));
		$bedresult = mysqli_fetch_assoc($result);		
		$bedtype = $bedresult['description'];
		$bedrate = $bedresult['rate'];
		$bedtypeid = $bedresult['typeid'];

		$datediff = strtotime($dischargedate[0]) - strtotime($admitdate[0]);
   $daysadmitted = floor($datediff/(60*60*24))+1;
   $roomcharge = $daysadmitted * $bedrate;

		$procsquery = "SELECT tid, medproc, (ctid*ccfee) AS cost FROM 6126CostCat NATURAL JOIN 6126Treatment NATURAL JOIN (SELECT tid, COUNT(tid) AS ctid FROM 6126PatientTreat WHERE pid=".$pid." GROUP BY tid) AS a";
		$procresult = mysqli_query($db_server, $procsquery) or die("Couldn't execute select query: <br>".$procsquery." error:". mysqli_error($db_server));

		$staffquery = 	"SELECT ecid, label, (cecid*fee) AS cost 
													FROM 6126EmpCat NATURAL JOIN (
																																SELECT ecid, SUM(hours) AS cecid FROM 6126Employee NATURAL JOIN (
																																																									SELECT eid, SUM(hours) as hours FROM 6126PatientTreat WHERE pid=".$pid." GROUP BY eid
																																																									) AS b 
																															GROUP BY ecid 
																															) AS a";
		$staffresult = mysqli_query($db_server, $staffquery) or die("Couldn't execute select query: <br>".$staffquery." error:". mysqli_error($db_server));

?>

<div style="width:350px;">

<hr SIZE="3" NOSHADE>

<p style="text-align:center">Bay View Community Hospital<br>
200 Lakeshore Dr. Bay View, AL</p>

<p style="text-align:center"><?php echo date("F j, Y");?></p>

<div>
Statement of account for:<br>
		<br>
		<div style="width:48%;float:left;">
				Patient Name: <?php echo $cusresult['lname'].', '.$cusresult['fname']; ?><br> 
				Patient address:<br> <?php  echo $cusresult['street']; ?> <br>
				<?php echo $cusresult['city'].', '.$cusresult['state'].' '.$cusresult['zip'] ?>
		</div>
		
		
		<div style="width:48%;float:right;">
				Patient#: <?php echo $pid ?><br>
				Date admitted:<br> <?php echo $admitdate[0] ?><br>
				Date discharged:<br> <?php echo $dischargedate[0] ?><br>
		</div>
</div><br>

<div style='clear:both;'>

		<div style="float:left; width:25%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Item Code</span><br>
		<?php echo $bedtypeid."<br>";
		$procresult->data_seek(0);
		while(		$row = mysqli_fetch_assoc($procresult)		)
			{
			echo $row['tid'].'<br>';				
			}
		$staffresult->data_seek(0);			
		while(		$row = mysqli_fetch_assoc($staffresult)		)
			{
			echo $row['ecid'].'<br>';				
			}
		?>
		</div>
		
		<div style="float:left; width:50%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Description</span><br>
		<?php echo $bedtype."<br>";
		$procresult->data_seek(0);
		while(		$row = mysqli_fetch_assoc($procresult)		)
			{
			echo $row['medproc'].'<br>';				
			}
		$staffresult->data_seek(0);			
		while(		$row = mysqli_fetch_assoc($staffresult)		)
			{
			echo $row['label'].'<br>';				
			}		
		?>	
		</div>
		
		<div style="float:left; width:25%; text-align:center;">
		<span style='text-decoration: underline; text-align:center;width:100%;' class='underline'>Charge</span><br>
		<?php 
		$totalcost = $roomcharge;
		
		echo $roomcharge."<br>";
		$procresult->data_seek(0);		
		while(		$row = mysqli_fetch_assoc($procresult)		)
			{
			echo $row['cost'].'<br>';	
			$totalcost+=	$row['cost'];		
			}
		$staffresult->data_seek(0);			
		while(		$row = mysqli_fetch_assoc($staffresult)		)
			{
			echo $row['cost'].'<br>';		
			$totalcost+=	$row['cost'];				
			}		
			echo '<hr SIZE="2" NOSHADE>'.$totalcost;
		
		?>		
		</div>
		
</div>  
  
<hr SIZE="3" NOSHADE>

<?php
 				echo '<br>'.$cusquery.'<br><br>';
				echo $admitquery.'<br><br>';
				echo $dischargequery.'<br><br>';
				echo $bedquery.'<br><br>';
				echo $procsquery.'<br><br>';
				echo $staffquery.'<br><br>';
?>
</div>