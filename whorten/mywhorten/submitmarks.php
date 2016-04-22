<?php 
/********************************************************
	This section checks to make sure the path to the 
	include file exists, then drops it in
*********************************************************/
session_start();
$path = $_SERVER['DOCUMENT_ROOT'].'/includes';
if(file_exists($path)) 
{
	$baseroot = "";
	require_once $_SERVER['DOCUMENT_ROOT'].'/includes/includes.php';	
}
else 
{
	$baseroot = "/whorten";
	require_once $_SERVER['DOCUMENT_ROOT'].'/whorten/includes/includes.php';	
}
//End include code
?>

<?php 

	if(isset($_POST['subID']) ? $_POST['subID'] == 'sim' : false) 
	{
		require_once '../db_login.php'; 	
		
		$purifier = new HTMLPurifier();
		$fields = Array();
		$values = Array();			
		foreach($_POST as $key => $val)
		{
			/*echo $key.": ".$purifier->purify(urldecode($val))."<br>";		*/
			if($key!="subID" && $key!="ajax") 
			{
				$fields[]=mysqli_real_escape_string($db_server,stripcslashes(strip_tags($purifier->purify(urldecode($key)))));
				$values[]=mysqli_real_escape_string($db_server,stripcslashes(strip_tags($purifier->purify(urldecode($val)))));								
			}
		
		}	
		
		/* validate the rubric marks, should be between 1 and 10 */
		$errors = Array();
		foreach($values as $key => $val)
		{
			switch($fields[$key]) 
			{
				case 'rubric1':	
				case 'rubric2':
				case 'rubric3':
				case 'rubric4':
				case 'rubric5':
					if(!($val >= 1 && $val <= 10)) 
					{
						$errors  .= "Value '".$val."' for ".$fields[$key]." is not valid.<br>";
					}
				break;
			}
		}
	
		if(count($errors)>0) 
		{
			die($errors);	
		}	
	
		/* build query and insert into database */ 
		date_default_timezone_set('America/Denver'); 
		$today = date("Y-m-d");
		$fields_str = implode(",", $fields);
		$values_str = implode('","',$values);
		$fields_str .= ",createDate";
		$values_str .= '"'.",".'"'.$today;
		  
		$sql  = "INSERT INTO PGSsim ";
		$sql .= "(".$fields_str.")";
		$sql .= " VALUES ";
		$sql .= "(".'"'.$values_str.'"'.")";
		  
		$result = mysqli_query($db_server, $sql) 
		  							or die("Couldn't execute insert query: ".$sql." error:". mysqli_error($db_server));	
		$insertid = mysqli_insert_id($db_server);			
		
		$sql1 = "SELECT COUNT(*) FROM PGSsim";
		$rowcnt = $fetch_result = mysqli_fetch_row(mysqli_query($db_server, $sql1)) 
		  							or die("Couldn't execute insert query: ".$sql." error:". mysqli_error($db_server));
		  							
		if($rowcnt[0] < 5) 
		{
			die ("Thanks for your submission. There are not yet enough recorded marks to determine a final grade.");	
		}
		
		$sql2 = "(SELECT * FROM PGSsim WHERE sim_id = '".$insertid."') UNION (SELECT DISTINCT * FROM PGSsim WHERE sim_id != '".$insertid."' ORDER BY RAND() LIMIT 4)";
		$rawmarks = mysqli_query($db_server, $sql2) 
		  							or die("Couldn't execute insert query: ".$sql." error:". mysqli_error($db_server));
		  							
		/* collate into separate arrays */  
		$collate = Array();
		
		while($fetch_result = mysqli_fetch_assoc($rawmarks)) 
		{
			foreach($fetch_result as $key => $value)
			{
				if($key!="visitor" && $key!="createDate" && $key!="sim_id") 
				{
					$collate[$key][] = $value;
				}				
			}				
		}							
		

		/* FUNCTIONS FROM STACK OVERFLOW TO CALCULATE STANDARD DEVIATION */
		// Function to calculate square of value - mean
		function sd_square($x, $mean) { return pow($x - $mean,2); }
		
		// Function to calculate standard deviation (uses sd_square)    
		function sd($array) {
		    // square root of sum of squares devided by N-1
		    return sqrt(array_sum(array_map("sd_square", $array, array_fill(0,count($array), (array_sum($array) / count($array)) ) ) ) / (count($array)-1) );
			}		
		
		
		
		/* calculate average, stdev, and acceptable range for each rubric */
		$calcs = Array();
		foreach($collate as $key => $value)
		{
			$calcs[$key]["rawave"]   = array_sum($value) / count($value);		
			$calcs[$key]["rawstdev"] = sd($value);
			$calcs[$key]["modstdev"] =	ceil($calcs[$key]["rawstdev"] * 5)/5;
			$calcs[$key]["mingood"]  = $calcs[$key]["rawave"] - $calcs[$key]["modstdev"];
			$calcs[$key]["maxgood"]  = $calcs[$key]["rawave"] + $calcs[$key]["modstdev"];
		}		

		/* determine which marks are ok to use, calculate sum and count of used marks */
		$used_marks = Array();
		$finalsum = Array();
		$finalcnt = Array();

		mysqli_data_seek ($rawmarks,0);
		while($fetch_result = mysqli_fetch_assoc($rawmarks)) 
		{
			foreach($fetch_result as $key => $value)
			{
				if($key!="visitor" && $key!="createDate" && $key!="sim_id") 
				{
					if($value >= $calcs[$key]["mingood"] && $value <= $calcs[$key]["maxgood"]) 
					{
						$used_marks[$fetch_result['sim_id']][$key] = 1;
						$finalsum[$key] += $value;
						$finalcnt[$key] += 1;
					}
					else 
					{
						$used_marks[$fetch_result['sim_id']][$key] = 0;
						$finalsum[$key] += 0;
						$finalcnt[$key] += 0;	
					}
				}										
			}				
		}		
		  	
		  	
		/* Display results */
		?>
			<br><p>The following table summarizes how your grading marks would be used to 
			determine the student's final grade.  Marks highlighted in red were determined
			to be outliers and were excluded from the calculation. Grading your peers 
			effectively is required to receive credit for assignments, and having marks
			rejected will result in the need to grade additional papers. So always follow
			the rubric carefully!</p>
			<table class='rubric_table' summary=''>
				<tr>
					<td>
						Grader Name					
					</td>
					<td>
						Date					
					</td>
					<td>
						Rubric 1:	Original Work			
					</td>
					<td>
						Rubric 2:	Signed Work				
					</td>
					<td>
						Rubric 3:	Subject & Focus				
					</td>
					<td>
						Rubric 4:	Style & Effort				
					</td>
					<td>
						Rubric 5:	Shadow & Contrast				
					</td>			
				</tr>		
		<?php
		
		mysqli_data_seek ($rawmarks,0);
		while($fetch_result = mysqli_fetch_assoc($rawmarks)) 
		{
			echo 	"<tr>";
			
			echo	"<td>".
					$fetch_result['visitor'].
					"</td>";		
					
			echo	"<td>".
					$fetch_result['createDate'].
					"</td>";

			foreach($fetch_result as $key => $value)
			{
				if($key!="visitor" && $key!="createDate" && $key!="sim_id") 
				{
					if($used_marks[$fetch_result['sim_id']][$key] == 1) 
					{
						echo	"<td title='This mark was used'>".
							$fetch_result[$key].
							"</td>";
					}
					else 
					{
						if($value < $calcs[$key]["mingood"]) 
						{
							$rejected = "low";
						}
						else 
						{
							$rejected = "high";
						}
					
						echo	"<td style='background-color:red;' title='This mark was too ".$rejected."'>".
							$fetch_result[$key].
							"</td>";	
					}
				}										
			}								
			echo	"</tr>";			
		}	
		echo 	"<tr>";		
			$overall = number_format(array_sum($finalsum)/array_sum($finalcnt),2);
			echo	"<td colspan='2'> Final Marks <br> Overall: ".$overall."<br>";
			$thisrow = "";
			$failcnt = 0;

			for ($i=1; $i<=5;$i++)
			{
				$key = "rubric".$i;
				$ave = number_format($finalsum[$key]/$finalcnt[$key],2);
			
				if($ave <=4) 
				{
					$fail = "style='background-color:red;'";
					$failcnt++;
				}
				else 
				{
					$fail = "";
				}
								
						
			$thisrow .=	"<td ".$fail.">".
					"Mark:<br>".$ave."<br>"."Used:<br>".$finalcnt[$key]."/5".
					"</td>";
			}
			$pass = $failcnt == 0 ? "Yes" : "No";
			echo 	"# of Fails: ".$failcnt."<br>".
					"Overall Pass: ".$pass.			
					"</td>";
			echo $thisrow;
		echo	"</tr>";				
		echo	"</table>";		  							
	
	$visitor_used = 	array_sum($used_marks[$insertid]);
	$a = ($visitor_used/5);
	$b = (5-$visitor_used/5);
	$c = ceil((5-$visitor_used/5)/($visitor_used/5));
	echo 	"<p>You had ".$visitor_used." of 5 marks used in the final grading, and earned ".$a." grading points.".
	 		" If started with 5 grading points owed, you would now owe ".$b.".".
			" If you averaged a similar rate on subsequent grading tasks, you would have to complete ".$c.
			" more to completely repay your grading debt.</p>";
	
	die();
	}
	else 
	{
		die("Non-simulation rubric submission code not completed yet, try again later");	
	}

if(isset($_SESSION['auth']) ? $_SESSION['auth']==1 : false) 
{
	/*  Insert operational rubric mark submission code here */
}
else 
{
	echo 'Not Authorized';
}
?>