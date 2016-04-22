<?php 
session_start();
$_SESSION['navigate']="mysqltest.php','sharelink";
?>
<div id="maincolumn" class="grid_20">

<?php
$con = mysql_connect("fdb4.freehostingeu.com","1250984_ni","sentry5");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// some code
?>

<div id="inputform" class="grid_10 alpha">
<h4 class="shareheading">Your Idea:</h4><br><br><br>
<form method="GET">
	Author name: <input type="text" id="authornameinput" onchange="ideapreview('authornameinput','ideaauthor');"><br>
	How big is the idea?
	<select name="ideascope" id="ideascope" onchange="ideapreview('ideascope','scopepreview');">
		<option value="today">Today Idea</option>	
		<option value="bigger">Bigger Idea</option>	
		<option value="special">Special Occasion</option>				
	</select>	<br>
	<div id="option4"></div>
	Is it a say, do, or gift idea?
	<select name="ideatype" id="ideatype" onchange="ideapreview('ideatype','typepreview');">
		<option value="say">Idea to say</option>	
		<option value="do">Idea to do</option>	
		<option value="gift">Idea for gift</option>				
	</select>	<br>
	Is it for guys, gals, or both?
	<select name="genderselect" id="genderselect" onchange="ideapreview('genderselect','genderpreview');">
		<option value="both">Both</option>
		<option value="guy">Guy</option>	
		<option value="gal">Gal</option>			
	</select>	<br>	
<div>
	<div>
	What is the mood of your idea? <br>
	<select multiple name="moodselect[]" id="moodselect" onchange="ideapreview('moodselect','moodpreview');">
		<option value="fun">Fun</option>	
		<option value="flirty">Flirty</option>	
		<option value="romantic">Romantic</option>				
	</select>	<br> </div>
	<div>
	What is the age range of your idea? <br>
	<select multiple name="ageselect[]" id="ageselect" onchange="ideapreview('ageselect','agepreview');">
		<option value="kids">Kids</option>
		<option value="teens">Teens</option>	
		<option value="adults">Adults</option>		
		<option value="seniors">Seniors</option>	
	</select>	<br> </div>
</div>

	What is your idea? <br>
	<textarea name="ideatextinput" id="ideatextinput" rows="4" cols="40" onchange="ideapreview('ideatextinput','ideacontent');"></textarea>	<br>
	<div id="urlpaste"></div>

</form>

</div>


<div id="preview_container" class="grid_6 omega">
	<h4 class="shareheading">Preview</h4><br><br><br>
		A <span id="moodpreview">nice</span> <span id="scopepreview">today/bigger/special</span> thing to <span id="typepreview">do/say/give</span> for <span id="genderpreview">guy/gal</span> <span id="agepreview"> </span>.
		<div class="idea" id="ideapreview">
				
			Idea #<span id="ideanum">XXXX</span>	
			by <a id="ideaauthor" href="#"> troywhorten</a>:		
			<p id="ideacontent"> A nice thing to do today</p>
				
		</div>	


</div>


</div>
		
<div id="adsidebar" class="grid_4">INSERT ADS HERE</div>	