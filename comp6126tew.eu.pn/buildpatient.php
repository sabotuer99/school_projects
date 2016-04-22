<?php 

		require_once 'db_login.php';
		
		//print_r($_GET);

		
			
		$query = "SELECT fname, lname, pid FROM 6126Patient";
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));		
	
	while ($row = mysqli_fetch_row($result)) 
    					{
        		echo '<option value="'.$row[2].'">'.$row[0].' '.$row[1].'</option>';
    					}


?>