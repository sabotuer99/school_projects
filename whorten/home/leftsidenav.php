<?php session_start(); ?>

		<div id="leftside" class="grid_4 contentbox" >
	
				<div class="navdiv">
						<button class="toggle" data-state="side" ></button>
						<a class="nav" name="home" data-target="home/home.php"> Home	</a><br>
						<div class="subnav" >	
								<a  data-target="home/news.php" >	News & Blog</a>
								<a  data-target="home/videotour.php" >	Video Tour</a>
								<a  data-target="home/messageboard.php" >	Message Board</a>									
						</div>
				</div>
				
				<div class="navdiv">						
						<button class="toggle" data-state="side" ></button>
						<a class="nav" name="about" data-target="about/about.php"> About	</a><br>
						<div class="subnav" >
								<a  data-target="about/mission.php" > Mission & Vision</a>
								<a  data-target="about/history.php" > History</a>
								<a  data-target="about/FAQ.php" > FAQ</a>
								<a  data-target="about/governance.php"> Governance</a>
								<a  data-target="about/contact.php" > Contact Us</a>
								<a  data-target="about/mascot.php" > Mascot</a>
						</div>				
				</div>		
								
				<div class="navdiv">
						<button class="toggle" data-state="side"></button>
						<a class="nav" name="academics" data-target="academics/academics.php" > Academics	</a><br>
						<div class="subnav" >
								<a  data-target="academics/majors.php" > Majors</a>
								<a  data-target="academics/accreditation.php" > Accreditation</a>
								<a  data-target="academics/honorcode.php" > Honor Code</a>
								<a  data-target="academics/colleges.php" > Colleges</a>
								<a  data-target="academics/catalog.php" > Course Catalog</a>
						</div>
				</div>
				
				<div class="navdiv">		
						<button class="toggle" data-state="side"></button>
						<a class="nav" name="community" data-target="community/community.php"> Community	</a><br>
						<div class="subnav" >
								<a  data-target="community/teams.php" > Competitive Teams</a>
								<a  data-target="community/showcase.php" > Student Showcase</a>
								<a  data-target="community/newsletter.php" > The Throwing Star</a>
								<a  data-target="community/clubs.php" > Online Clubs</a>
								<a  data-target="community/alumni.php" > Alumni</a>
						</div>
				</div>
					
				<div class="navdiv">	
						<button class="toggle" data-state="side"></button>
						<a class="nav" name="market" data-target="market/market.php"> Market	</a><br>
						<div class="subnav" >
								<a  data-target="market/books.php" > Books & Supplies</a>
								<a  data-target="market/affiliates.php" > Affiliate Partners</a>
								<a  data-target="market/merchandise.php" > Our Merchandise</a>
								<a  data-target="market/classifieds.php" > Classifieds</a>
						</div>
				</div>
				
<?php if($_SESSION['auth'] == true && $_SESSION['perm_Contributor']) { ?> 
				<div class="navdiv">						
						<button class="toggle" data-state="side"></button>
						<a class="nav" name="contributors" data-target="contributors/contributors.php"> Contributors	</a><br>
						<div class="subnav" >
								<a  data-target="contributors/courseadmin.php" > Manage Courses</a>
								<a  data-target="contributors/programadmin.php" > Manage Programs</a>
								<a  data-target="contributors/evaluate.php" > Evaluate Course</a>
								<a  data-target="contributors/collaborate.php" > Collaborate</a>
						</div>
				</div>
<?php } 
 		if($_SESSION['auth'] == true && $_SESSION['perm_Admin']) { ?> 					
				<div class="navdiv">	
						<button class="toggle" data-state="side"></button>
						<a class="nav" name="administration" data-target="administration/administration.php"> Administration	</a><br>
						<div class="subnav" >
								<a  data-target="administration/createcollege1.php" > Manage Colleges</a>
							<!--	<a  data-target="administration/createdept.php" > Create Department</a> -->
								<a  data-target="administration/reports.php" > Reports</a>
								<a  data-target="administration/userman.php" > Manage Users</a>
						</div>
				</div>
<?php } 				
		if($_SESSION['auth'] ) { ?> 					
				<div class="navdiv last">	
						<button class="toggle" data-state="side"></button>
						<a class="nav" name="mywhorten" data-target="mywhorten/mywhorten.php"> My Whorten	</a><br>
						<div class="subnav" >
								<a  data-target="mywhorten/mycourses.php" > My Courses</a>
								<a  data-target="mywhorten/mygrades.php" > My Grades</a>
								<a  data-target="mywhorten/gradingtasks.php" > Grading Tasks</a>
								<a  data-target="mywhorten/acadplan.php" > Academic Plan</a>
								<a  data-target="mywhorten/settings.php" > Settings</a>
								<a  data-target="mywhorten/messages.php" > Messages</a>
						</div>	
				</div>
<?php } ?>				
							
				<p id="sidebarlinks">
						<br>
						<a>Privacy Policy</a><br>
						<a>Terms of Service</a><br>
						<a>Become a contributor</a><br>
						<a>Site map</a><br>
						Copyright 2012-2013				
				</p>
		</div>
		