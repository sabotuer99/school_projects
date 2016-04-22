<?php 

		require_once 'db_login.php';
		
		//print_r($_GET);

		
			
		$query = "SHOW TABLES LIKE '6126%'";
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute show tables query: <br>".$query." error:". mysqli_error($db_server));		
	
	$i = 0;
	while ($row = mysqli_fetch_row($result)) 
    					{
    						if($i==0) { $sel = 'selected'; } else { $sel = ' '; }
    						$i++;
        		echo '<option '.$sel.' value="'.$row[0].'">'.$row[0].'</option>';
    					}

?>