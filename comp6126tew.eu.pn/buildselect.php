<?php 

		require_once 'db_login.php';
		
		//print_r($_GET);
		$label 		=		urldecode($_GET['label']);
		$value		=		urldecode($_GET['value']);
		$table		= 	urldecode($_GET['table']);
		
			
		$query = "SELECT ". $label . ", ". $value . " FROM ". $table;
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));		
	
	$i = 0;
	while ($row = mysqli_fetch_row($result)) 
    					{
    						if($i==0) { $sel = 'selected'; } else { $sel = ' '; }
    						$i++;
        		echo '<option '.$sel.' value="'.$row[1].'">'.$row[0].'</option>';
    					}


?>