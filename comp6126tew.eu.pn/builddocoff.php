<?php 

		require_once 'db_login.php';
		
		//print_r($_GET);

		
			
		$query = "SELECT rnum, description FROM 6126Room NATURAL JOIN 6126Roomtype WHERE description = 'Office'";
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));		
	
	while ($row = mysqli_fetch_row($result)) 
    					{
        		echo '<option value="'.$row[0].'">'.$row[1].' '.$row[0].'</option>';
    					}


?>