<?php 

		require_once 'db_login.php';
		
		$query = "SELECT * FROM ". $_GET['table'];
		$res = 	mysqli_query($db_server, $query) or die("Couldn't execute select query: <br>".$query." error:". mysqli_error($db_server));		

		
		$data = array();
		while($row = mysqli_fetch_assoc($res))
		  {
		  $data[] = $row;
		  }
		
		  $colNames = array_keys(reset($data))
?>	
	
		 <table border="1">
		 <tr>
		 <?php
		 //print the header
		 foreach($colNames as $colName)
		 {
		 echo "<th>$colName</th>";
		 }
		 ?>
		 </tr>
		
		 <?php
		 //print the rows
		 foreach($data as $row)
		 {
		 echo "<tr>";
		 foreach($colNames as $colName)
		 {
		 echo "<td>".$row[$colName]."</td>";
		 }
		 echo "</tr>";
		 }
		 ?>
		 </table>
		
		
		
		<?php
				echo "<br>".$query . "<br>Success!<br><br>";
		?>