<?php
		require_once 'db_login.php';
		
		$row = $_GET['row'];		
		$col = $_GET['col'];	
		$cat1 = $_GET['cat1'];
		$cat2 = $_GET['cat2'];
		$cat3 = $_GET['cat3'];
		$cat4 = $_GET['cat4'];
		$opt1 = $_GET['opt1'];
		$opt2 = $_GET['opt2'];
		$opt3 = $_GET['opt3'];
		$opt4 = $_GET['opt4'];		
		$mood = $_GET['mood'];

		$starttime = time();
		
		$query = 	"SELECT * FROM IDEAS JOIN members ON IDEAS.AUTHOR_ID=members.id";
		$conditions = " WHERE ";
		
		switch(strtoupper(mysqli_real_escape_string($db_server, strip_tags(trim($row))))) 
						{
							case "TODAY":
									$conditions .= "scope = 0 AND ";
									break;
							case "BIGGER":
									$conditions .= "scope = 1 AND ";
									switch(strtoupper(mysqli_real_escape_string($db_server, strip_tags(trim($opt3))))) 
										{
											case "THISWEEK":
													$conditions .= "option4 = 0 AND ";
													break;
											case "THISMONTH":
													$conditions .= "option4 = 1 AND ";
													break;					
											case "THISSEASON":
													$conditions .= "option4 = 2 AND ";
													break;
											case "THISYEAR":
													$conditions .= "option4 = 3 AND ";
													break;										
											case "LIFETIME":
													$conditions .= "option4 = 4 AND ";
													break;	
											}		
									
									break;
							case "SPECIAL":
									$conditions .= "scope = 2 AND ";
									switch(strtoupper(mysqli_real_escape_string($db_server, strip_tags(trim($opt3))))) 
										{
											case "NEXTHOLIDAY":
													$conditions .= "option4 = 0 AND ";
													break;										
											case "BIRTHDAY":
													$conditions .= "option4 = 1 AND ";
													break;										
											case "ANNIVERSARY":
													$conditions .= "option4 = 2 AND ";
													break;										
											case "GRADUATION":
													$conditions .= "option4 = 3 AND ";
													break;										
											case "PROMOTION":
													$conditions .= "option4 = 4 AND ";
													break;										
											case "BEREAVEMENT":
													$conditions .= "option4 = 5 AND ";
													break;	
											}		
									break;
						}
						
		switch(strtoupper(mysqli_real_escape_string($db_server, strip_tags(trim($opt2))))) 
						{
							case "BOTH":
									$conditions .= "sex = 2 AND ";
									break;
							case "GUY":
									$conditions .= "sex = 1 AND ";
									break;
							case "GAL":
									$conditions .= "sex = 0 AND ";
									break;			
						}
						
		switch(strtoupper(mysqli_real_escape_string($db_server, strip_tags(trim($opt4))))) 
						{
							case "KIDS":
									$conditions .= "kids = 1 AND ";
									break;
							case "TEENS":
									$conditions .= "teens = 1 AND ";
									break;
							case "ADULTS":
									$conditions .= "adults = 1 AND ";
									break;		
							case "SENIORS":
									$conditions .= "seniors = 1 AND ";
									break;		
						}						
	
		switch(strtoupper(mysqli_real_escape_string($db_server, strip_tags(trim($col))))) 
						{
							case "SAY":
									$conditions .= "ideaType = 0 AND ";
									break;
							case "DO":
									$conditions .= "ideaType = 1 AND ";
									break;
							case "GIVE":
									$conditions .= "ideaType = 2 AND ";
									break;			
						}	
						
		if(preg_match("/^[0-9]{5,}$/", mysqli_real_escape_string($db_server, strip_tags(trim($opt1))))) 
						{					
		 				$conditions .= "mood_id = ".$opt1." AND ";
		 			 	}
		elseif(preg_match("/^[\(][0-9]{5,},[0-9]{5,},[0-9]{5,},[0-9]{5,},[0-9]{5,},[0-9]{5,},[0-9]{5,},[0-9]{5,},[0-9]{5,},[0-9]{5,}[\)]$/", mysqli_real_escape_string($db_server, strip_tags(trim($opt1))))) 
						{
						$conditions .= "mood_id NOT IN ".$opt1." AND ";	
						}		 			 	
		 			 	
		$query .=	$conditions."1"; 	
		
		$result = 	mysqli_query($db_server, $query);		

		$rowcount = mysqli_num_rows($result);

		$endtime = time();
		
		if(time_nanosleep(0, 500000000-($endtime-$starttime)*1000000)) 
		{				
				if($rowcount == 0) 
				{		
					echo "<div class='ideatext transparent'>";
					echo "<span>Oh noes! No ".$row." ideas for something nice to ".$col." with these criteria: </span><br>";
					if (!($cat1 == "")) echo "<span>". $cat1 . " = " . $mood . "</span><br>";	
					if (!($cat2 == "")) echo "<span>". $cat2 . " = " . $opt2 . "</span><br>";
					if (!($cat3 == "")) echo "<span>". $cat3 . " = " . $opt3 . "</span><br>";
					if (!($cat4 == "")) echo "<span>". $cat4 . " = " . $opt4 . "</span><br>";	
					echo "<span>Maybe you could share one? :)</span>";
					echo "</div>";
				//	$endtime = time();
				//	echo 1000000000-($endtime-$starttime)*1000000;
				}
				else 
				{			
					require 'timeinterval.php';			
					$timeSeek = round(time()/(60*$timeInterval));
					$seekLoc = $timeSeek % $rowcount;
					
					mysqli_data_seek($result, $seekLoc);			
					$fetchrow = mysqli_fetch_assoc($result);
					
		//			$endtime = time();
					
		//			if(time_nanosleep(0, ($endtime-$starttime)*1000000)) 
		//			{
							echo "<div class='ideatext transparent'>Idea #<span class='ideanum'>" . $fetchrow["ID_NUM"] . "</span> by " . $fetchrow["username"] . ":";
							echo "<p class='ideacontent'>" . $fetchrow["ideatext"] . "</p></div>";	
					//		echo 1000000000-($endtime-$starttime)*1000000;
					//		echo $query." ".$opt1;
					//		echo $row . ", " . $col . "<br>";	
					//		if (!($cat1 == "")) echo $cat1 . " = " . $opt1 . "<br>";	
					//		if (!($cat2 == "")) echo $cat2 . " = " . $opt2 . "<br>";
					//		if (!($cat3 == "")) echo $cat3 . " = " . $opt3 . "<br>";
					//		if (!($cat4 == "")) echo $cat4 . " = " . $opt4 . "<br>";		
					//		echo $query;		
		//			}
				}
		}
?>