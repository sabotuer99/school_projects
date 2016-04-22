<?php

$value = $_GET['value'];

if($value=='bigger') {
	echo ' What is the timeframe?';
	echo '		<select id="biggertimeframe" onchange="ideapreview(&#39;biggertimeframe&#39;,&#39;opt4preview&#39;);">';
	echo '				<option value="thisweek">This Week</option>';
	echo '				<option value="thismonth">This Month</option>';
	echo '				<option value="thisseason">This Season</option>';
	echo '				<option value="thisyear">This Year</option>';
	echo '				<option value="lifetime">Once in a lifetime</option>	';
	echo '			</select>';
}

if($value=='special') {
	echo ' What special occasion?';
	echo '		<select id="specialoccasion" onchange="ideapreview(&#39;specialoccation&#39;,&#39;opt4preview&#39;);">';
	echo '				<option value="nextholiday">Next Holiday</option>';
	echo '				<option value="birthday">Birthday</option>	';
	echo '				<option value="anniversary">Anniversary</option>'		;
	echo '				<option value="graduation">Graduation</option>	';
	echo '				<option value="promotion">Promotion</option>	';
	echo '				<option value="bereavement">Bereavement</option>'		;
	echo '			</select>';
}

?>