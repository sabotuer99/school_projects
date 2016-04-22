<?php 
session_start();
if($_SESSION['auth']!=1) {
	$_SESSION['navigate']="home.php','homelink";
	header("Location:index.php");
	}
	else {
		require_once 'db_login.php';
	}
	
?>
<div id="maincolumn" class="grid_20" ><div id="inputform" class="grid_12 alpha">
<h4 class="shareheading">Your Idea:</h4>
<div id="inputformmenu">
		<span>How big is the idea?</span>
		<div id="option4"></div>
		<span>Is it a say, do, or gift idea?</span>
		<span>Is it for guys, gals, or both?</span>
		<span>What is the mood of your idea? </span>
		<br>
		<span>What is the age range of your idea?</span>
</div>

<form method="GET">
	<div id="divShareMenuItems">	

	<select name="ideascope" id="ideascope" onchange="ideapreview('ideascope','scopepreview');" >
		<option value="today">Today Idea</option>	
		<option value="bigger">Bigger Idea</option>	
		<option value="special">Special Occasion</option>				
	</select>	<br>

	<div id="option4menu"></div>

	<select name="ideatype" id="ideatype" onchange="ideapreview('ideatype','typepreview');" >
		<option value="say">Idea to say</option>	
		<option value="do">Idea to do</option>	
		<option value="gift">Idea for gift</option>				
	</select>	<br>

	<select name="genderselect" id="genderselect" onchange="ideapreview('genderselect','genderpreview');" >
		<option value="both">Both</option>
		<option value="guy">Guy</option>	
		<option value="gal">Gal</option>			
	</select>	<br>	


  <input type="text" id="moodselect" onkeyup="showHint(this.value)" onchange="ideapreview('moodselect','moodpreview');" style="width:115px;margin-bottom:4px;" /><br>
  <span id="txtHint" style="margin-bottom:4px;display:block;">...</span>

  <!--<br>
	<select multiple name="moodselect[]" id="moodselect" onchange="ideapreview('moodselect','moodpreview');">
		<option value="fun">Fun</option>	
		<option value="flirty">Flirty</option>	
		<option value="romantic">Romantic</option>				
	</select>	<br> </div> -->

	<form name="ageselect[]" id="ageselect" onchange="ideapreview('ageselect','agepreview');">
		<input type="checkbox" value="kids" id="kids" onchange="ideapreview('ageselect','agepreview');">Kids</option><br>
		<input type="checkbox" value="teens" id="teens" onchange="ideapreview('ageselect','agepreview');">Teens</option>	<br>
		<input type="checkbox" value="adults" id="adults" onchange="ideapreview('ageselect','agepreview');">Adults</option>		<br>
		<input type="checkbox" value="seniors" id="seniors" onchange="ideapreview('ageselect','agepreview');">Seniors</option>	
	</form>	<br> 
	</div>
	<div id="shareTextInputArea">
	<span>What is your idea?</span> <br>
	<textarea name="ideatextinput" id="ideatextinput" rows="4" cols="40" onchange="ideapreview('ideatextinput','ideacontent');"></textarea>	<br>
	<div id="urlpaste"></div>
	</div>
	
	<button onclick="SubmitIdea()">Submit Idea</button><span id="ideaMessage"></span>
</form>

</div>


<div id="preview_container" class="grid_6 omega" >
	<h4 class="shareheading">Preview</h4>
		<div style="clear:left">		
		<span> A </span><span id="moodpreview">nice</span> <span id="scopepreview">today</span><span> thing to </span><span id="typepreview">say</span><span> for </span><span id="genderpreview">guy or gal</span> <span id="agepreview"> </span>.
		<div class="idea" id="ideapreview">
				
			Idea #<span id="ideanum">XXXX</span>	
			by <a id="ideaauthor" href="#"> 	<?php echo $_SESSION['username']; ?></a>:		
			<p id="ideacontent"> A nice thing to do today</p>
				
		</div>	
		</div>

</div>