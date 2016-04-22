<?php 
session_start();
$_SESSION['navigate']="home.php','homelink";
require_once 'db_login.php';
?>
			<div id="containtoday" class="grid_20 idearow">
			
			<h3>Today Ideas</h3>
			<p id="headingsubtext">Small ideas you can use every day...</p>
			
			<div id="todaysay" class="grid_5 alpha prefix_1 BOX">
				<div class="idea" id="todaysay_cont">
					<div class="ideatext" >					
					<?php
					$scope = 0;
					$ideaType = 0;
					require 'homeQuery.php';
					?>
					</div>
				</div>	
				<a href="#" >Said it!</a> 
				<a href="#" >Rate it!</a>
				<a href="#" onclick="ShareIt('genImg','todaysay')"><img src="img/fb_share.gif" class="fbShareButton"alt="Share!" title="Share on Facebook" ></a>	
								
			</div>	 
			<div id="todaydo" class="grid_5 BOX" >
				<div class="idea" id="todaydo_cont">
					<div class="ideatext">			
					<?php
					$scope = 0;
					$ideaType = 1;
					require 'homeQuery.php';
					?>
					</div>
				</div>	
				<a href="#" >Did it!</a>
				<a href="#" >Rate it!</a>
				<a href="#" onclick="ShareIt('genImg','todaydo')"><img src="img/fb_share.gif" class="fbShareButton"alt="Share!" title="Share on Facebook" ></a>	
								
			</div>
			<div id="todaygive" class="grid_5 BOX" >
				<div class="idea" id="todaygive_cont">
					<div class="ideatext">			
					<?php
					$scope = 0;
					$ideaType = 2;
					require 'homeQuery.php';
					?>
					</div>
				</div>	
				<a href="#" >Gave it!</a>
				<a href="#" >Rate it!</a>
				<a href="#" onclick="ShareIt('genImg','todaygive')"><img src="img/fb_share.gif" class="fbShareButton"alt="Share!" title="Share on Facebook" ></a>	
								
			</div>
			<div id="todayoptions" class="grid_3 omega">
			<!-- ***************************************************************
			*****			                    											*****
			*****    	Options controlling what kind of ideas display   	*****
			*****                           											*****
			*****************************************************************-->
				<span>Mood:</span>				
				<select id="todaymood" onchange="ideaquery('today');">
					<option value="any">Any</option>	
					<?php
						$scope = 0;
						require 'homeMoodQuery.php';
					?>			
				</select>	
				<span>Gender:</span>				
				<select id="todaygender" onchange="ideaquery('today');">
					<option value="any">Any</option>
					<option value="guy">Guy</option>	
					<option value="gal">Gal</option>		
					<option value="both">Both</option>	
				</select>	
				<span>Age Range:</span>				
				<select id="todayage" onchange="ideaquery('today');">
					<option value="Any">Any</option>					
					<option value="kids">Kids</option>
					<option value="teens">Teens</option>	
					<option value="adults">Adults</option>		
					<option value="seniors">Seniors</option>	
				</select>			
			</div>	
		</div>	
			<div id="containbigger" class="grid_20 idearow">
			<h3>Bigger Ideas</h3>
			<p id="headingsubtext">When a small idea won't cut it...</p>			
			
			<div id="biggersay" class="grid_5 alpha prefix_1 BOX" >
				<div class="idea" id="biggersay_cont">
					<div class="ideatext">			
					<?php
					$scope = 1;
					$ideaType = 0;
					require 'homeQuery.php';
					?>
					</div>
				</div>	
				<a href="#" >Said it!</a>
				<a href="#" >Rate it!</a>
				<a href="#" onclick="ShareIt('genImg','biggersay')"><img src="img/fb_share.gif" class="fbShareButton"alt="Share!" title="Share on Facebook" ></a>
									
			</div>	
			<div id="biggerdo" class="grid_5 BOX" >
				<div class="idea" id="biggerdo_cont">
					<div class="ideatext">			
					<?php
					$scope = 1;
					$ideaType = 1;
					require 'homeQuery.php';
					?>
					</div>
				</div>	
				<a href="#" >Did it!</a>
				<a href="#" >Rate it!</a>
				<a href="#" onclick="ShareIt('genImg','biggerdo')"><img src="img/fb_share.gif" class="fbShareButton"alt="Share!" title="Share on Facebook" ></a>	
								
			</div>
			<div id="biggergive" class="grid_5 BOX" >
				<div class="idea" id="biggergive_cont">
					<div class="ideatext">			
					<?php
					$scope = 1;
					$ideaType = 2;
					require 'homeQuery.php';
					?>
					</div>
				</div>	
				<a href="#" >Gave it!</a>
				<a href="#" >Rate it!</a>
				<a href="#" onclick="ShareIt('genImg','biggergive')"><img src="img/fb_share.gif" class="fbShareButton"alt="Share!" title="Share on Facebook" ></a>
									
			</div>
			<div id="biggeroptions" class="grid_3 omega">
			<!-- ***************************************************************
			*****			                    											*****
			*****    	Options controlling what kind of ideas display   	*****
			*****                           											*****
			*****************************************************************-->		
				<span>Mood:</span>				
				<select id="biggermood" onchange="ideaquery('bigger');">
					<option value="any">Any</option>	
					<?php
						$scope = 1;
						require 'homeMoodQuery.php';
					?>		
				</select>	
				<span>Gender:</span>				
				<select id="biggergender" onchange="ideaquery('bigger');">
					<option value="any">Any</option>					
					<option value="both">Both</option>
					<option value="guy">Guy</option>	
					<option value="gal">Gal</option>			
				</select>
				<span>Timeframe:</span>
				<select id="biggertimeframe" onchange="ideaquery('bigger');">
					<option value="any">Any</option>
					<option value="thisweek">This Week</option>
					<option value="thismonth">This Month</option>
					<option value="thisseason">This Season</option>
					<option value="thisyear">This Year</option>
					<option value="lifetime">Once in a lifetime</option>	
				</select>
				<span>Age Range:</span>				
				<select id="biggerage" onchange="ideaquery('bigger');">
					<option value="any">Any</option>
					<option value="kids">Kids</option>
					<option value="teens">Teens</option>	
					<option value="adults">Adults</option>		
					<option value="seniors">Seniors</option>	
				</select>
		
			</div>	
		</div>	
			<div id="containspecial" class="grid_20 idearow">
			<h3>Special Ideas</h3>
			<p id="headingsubtext">Ideas for those special occasions...</p>
			
			<div id="specialsay" class="grid_5 alpha prefix_1 BOX" title="A nice thing to say for a special occasion">
				<div class="idea" id="specialsay_cont">
					<div class="ideatext">			
					<?php
					$scope = 2;
					$ideaType = 0;
					require 'homeQuery.php';
					?>
					</div>
				</div>	
				<a href="#" >Said it!</a>
				<a href="#" >Rate it!</a>
				<a href="#" onclick="ShareIt('genImg','specialsay')"><img src="img/fb_share.gif" class="fbShareButton"class="fbShareButton" alt="Share!" title="Share on Facebook" ></a>
									
			</div>	
			<div id="specialdo" class="grid_5 BOX" title="A nice thing to do for a special occasion">
				<div class="idea" id="specialdo_cont">
					<div class="ideatext">			
					<?php
					$scope = 2;
					$ideaType = 1;
					require 'homeQuery.php';
					?>
					</div>
				</div>	
				<a href="#" >Did it!</a>
				<a href="#" >Rate it!</a>
				<a href="#" onclick="ShareIt('genImg','specialdo')"><img src="img/fb_share.gif" class="fbShareButton"alt="Share!" title="Share on Facebook" ></a>	
								
			</div>
			<div id="specialgive" class="grid_5 BOX" title="A nice thing to give for a special occasion">
				<div class="idea" id="specialgive_cont">
					<div class="ideatext">			
					<?php
					$scope = 2;
					$ideaType = 2;
					require 'homeQuery.php';
					?>
					</div>
				</div>	
				<a href="#" >Gave it!</a>
				<a href="#" >Rate it!</a>
				<a href="#" onclick="ShareIt('genImg','specialgive')"><img src="img/fb_share.gif" class="fbShareButton"alt="Share!" title="Share on Facebook" ></a>
									
			</div> 
			<div id="specialoptions" class="grid_3 omega">
			<!-- ***************************************************************
			*****			                    											*****
			*****    	Options controlling what kind of ideas display   	*****
			*****                           											*****
			*****************************************************************-->
				<span>Mood:</span>				
				<select id="specialmood" onchange="ideaquery('special');">
					<option value="any">Any</option>	
					<?php
						$scope = 2;
						require 'homeMoodQuery.php';
					?>		
				</select>	
				<span>Gender:</span>				
				<select id="specialgender" onchange="ideaquery('special');">
					<option value="any">Any</option>
					<option value="both">Both</option>
					<option value="guy">Guy</option>	
					<option value="gal">Gal</option>			
				</select>				
				<span>Occasion:</span>				
				<select id="specialoccasion" onchange="ideaquery('special');">
					<option value="any">Any</option>
					<option value="nextholiday">Next Holiday</option>
					<option value="birthday">Birthday</option>	
					<option value="anniversary">Anniversary</option>		
					<option value="graduation">Graduation</option>	
					<option value="promotion">Promotion</option>	
					<option value="bereavement">Bereavement</option>		
				</select>	
				<span>Age Range:</span>				
				<select id="specialage" onchange="ideaquery('special');">
					<option value="any">Any</option>
					<option value="kids">Kids</option>
					<option value="teens">Teens</option>	
					<option value="adults">Adults</option>		
					<option value="seniors">Seniors</option>	
				</select>	
				
			</div>	
		</div>
	