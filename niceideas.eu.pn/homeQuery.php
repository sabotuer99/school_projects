<?php

					$query = 	"SELECT * FROM IDEAS JOIN members ON IDEAS.AUTHOR_ID=members.id WHERE scope = ".$scope." AND ideaType = ".$ideaType;
					$result = 	mysqli_query($db_server, $query);
       	$rowcount = mysqli_num_rows($result);					
					
					require 'timeinterval.php';			
					$timeSeek = round(time()/(60*$timeInterval));
					$seekLoc = $timeSeek % $rowcount;
					
					mysqli_data_seek($result, $seekLoc);		
					$fetchrow = mysqli_fetch_assoc($result);
					echo "Idea #<span class='ideanum'>" . $fetchrow["ID_NUM"] . "</span> by " . $fetchrow["username"] . ":";
					echo "<p class='ideacontent'>" . $fetchrow["ideatext"] . "</p>";	
					//debugging
					//echo time()." ".$timeSeek." ".$rowcount." ".$seekLoc;	
?>	