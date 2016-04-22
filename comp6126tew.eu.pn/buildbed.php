<?php 

		require_once 'db_login.php';
		
		//print_r($_GET);

		
			
		$query = "SELECT bid, rnum, label, description FROM 6126Bed NATURAL JOIN 6126Room NATURAL JOIN 6126Roomtype WHERE description = 'Semi-private' OR description = 'Private'";
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));		
	
	$i = 0;
	while ($row = mysqli_fetch_row($result)) 
    					{
    						if($i==0) { $sel = 'selected'; } else { $sel = ' '; }
    						$i++;
        		echo '<option '.$sel.' value="'.$row[0].'">'.$row[1].'-'.$row[2].', '.$row[3].'</option>';
    					}

?>