<?php 

		require_once 'db_login.php';
		
		//print_r($_GET);

		$query = "UPDATE 6126Admission SET enddate='". $_GET['date']	. "' WHERE enddate is NULL AND pid=" . $_GET['patient'];
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute update query: <br>".$query." error:". mysqli_error($db_server));		
		echo "<br>".$query . "<br>Success!<br><br>";
//		echo $numfields . "<br> " . $i. "<br> " . $result;
/*		$rowcount = mysqli_num_rows($result);
		$fetchrow = mysqli_fetch_assoc($result);		
		print_r($_GET);*/

?>