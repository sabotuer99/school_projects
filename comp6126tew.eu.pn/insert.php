<?php 

		require_once 'db_login.php';
		
		//print_r($_GET);

		$i = 1;	
		$fields = "(";
		$values = "(";	
		$numfields = count($_GET) - 1;
		
		foreach ($_GET as $field => $value)	
		{
		
				if ($field != 'table') 
				{
						
						$fields .= urldecode($field);
						$values .= '"'. urldecode($value).'"';
								
					 	if($i == $numfields) 
					 	{
							
						$fields .= ")";
						$values .= ")";
									
						}
						else 
						{
							
						$fields .= ", ";
						$values .= ", ";	
						
						}	
						
						$i = $i + 1; 
				}
		}
		
		$query = "INSERT INTO ". $_GET['table']	. " " . $fields . " VALUES " . $values;
		$result = 	mysqli_query($db_server, $query) or die("Couldn't execute insert query: <br>".$query." error:". mysqli_error($db_server));		
		echo "<br>".$query . "<br>Success!<br><br>";
//		echo $numfields . "<br> " . $i. "<br> " . $result;
/*		$rowcount = mysqli_num_rows($result);
		$fetchrow = mysqli_fetch_assoc($result);		
		print_r($_GET);*/

?>