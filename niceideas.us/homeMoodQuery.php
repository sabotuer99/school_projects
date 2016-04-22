<?php

						$other = "(";
						$query = 	"SELECT mood_id, COUNT(ID_NUM) AS moodcount, MOODS.Mood FROM IDEAS JOIN MOODS ON IDEAS.mood_id=MOODS.MoodID WHERE scope = ".$scope." GROUP BY mood_id ORDER BY moodcount DESC LIMIT 10";
						$result = 	mysqli_query($db_server, $query);
						$rowcount = mysqli_num_rows($result);
    				while ($row = mysqli_fetch_assoc($result)) 
    					{
        		echo '<option value="'.$row['mood_id'].'">'.$row['Mood'].' ('.$row['moodcount'].')</option>';
        		if(strlen($other)>1) { $other .= ",";}			
    					$other .= 	$row['mood_id'];
    					}
    				$other .= ")";
    				
    				if($rowcount==10) 
    				{
    				echo '<option value="'.$other.'">All Others</option>';
						}
?>