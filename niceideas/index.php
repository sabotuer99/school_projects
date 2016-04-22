<?php session_start();


//echo $_SESSION['navigate'];
?>


<!DOCTYPE html>
<!--
 _   _ _            _____    _                  _    _      _         _ _       
| \ | (_)          |_   _|  | |                | |  | |    | |       (_) |      
|  \| |_  ___ ___    | |  __| | ___  __ _ ___  | |  | | ___| |__  ___ _| |_ ___ 
| . ` | |/ __/ _ \   | | / _` |/ _ \/ _` / __| | |/\| |/ _ \ '_ \/ __| | __/ _ \
| |\  | | (_|  __/  _| || (_| |  __/ (_| \__ \ \  /\  /  __/ |_) \__ \ | ||  __/
\_| \_/_|\___\___|  \___/\__,_|\___|\__,_|___/  \/  \/ \___|_.__/|___/_|\__\___|
-->
<html lang=en prefix="fb: http://www.facebook.com/2008/fbml">

<?php 
// load head section
	require_once 'head.php';
?>
	
<!-- MAIN CONTENT AREA -->	
<body onload="<?php if (isset($_SESSION['navigate'])) {echo "navigate('".$_SESSION['navigate']."');";} ?>" title="">
	<div id="fb-root"></div>



	<?php 
	//MySQL Scripts	 -- Probably don't need...
	//Connect to MySQL
	require_once 'db_login.php';
	?>



	<div id="header" class="container_24 rounded">
	
	<a href="#" id="pudding" class="" onclick="navigate('pudding.php','pudding');"><img id="mascot" src="img/JellyFish.png" alt="Mascot"></a>
 <div id="menuleft" class="grid_12">	
	<h1>Nice Ideas</h1>
	<nav>
		
		<a href="#" id="homelink" class="" onclick="navigate('home.php','homelink');">Home</a>
		<a href="#" id="sharelink" class="" onclick="navigate('share.php','sharelink');">Share Idea</a>
<!--
		add these back in when the code is finished
		<a href="#" id="newlink" class="" onclick="navigate('newideas.php','newlink');">New Ideas</a>
		<a href="#" id="browselink" class="" onclick="navigate('browse.php','browselink');">Browse Gifts</a>	
-->
		<a href="#" id="profilelink" class="" onclick="navigate('profile.php','profilelink');">My Profile</a>
		<a href="#" id="aboutlink" class="" onclick="navigate('about.php','aboutlink');">About</a>
		<div id="loginaction" style="display:none;"></div>
		
		
	</nav>
	</div>
	
	<!-- social networking icons -->
	<div class="menu">
		
		<!--
		<div class="fb-like" data-href="http://niceideas.eu.pn" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
		<div class="fb-login-button" data-show-faces="true" data-width="200" data-max-rows="1" size="small"></div>
		-->	
	

				<div id="userPic">
				<?php
				if(isset($_SESSION['FbId'])) 
					{
					echo "<img src='https://graph.facebook.com/".$_SESSION['FbId']."/picture' alt='FB Profile Pic'>";
					}
				?>
				</div>
				<img src="img/ajax-loader.gif" alt="loading" id="loader" />
				<button id="fb-auth" onclick="FB.getLoginStatus(updateButton);"><img src="img/icons/facebook.png" id="fbconnectimg" alt="FB Share"/></button>
      
      	
   <div id="loginDiv" >
		<!-- php login scripts  -->   
   <?php   
			  
   
			if(!isset($_SESSION['auth'])) 
				{				
				//echo $_SESSION['auth'];
				//echo session_id();
				require 'main_login.php';  
				}
			else 
				{
				//echo $_SESSION['auth'];
				//echo session_id();
				require 'main_logout.php';	
				}
                                
                       if(isset($_SESSION['loginMsg'])) 
				{
					echo $_SESSION['loginMsg'];
                                        unset ($_SESSION['loginMsg']);
                                    
				} 
		?>


<script type="text/javascript">
	<?php 
//load facebook scripts
	require_once 'js/fb_scripts.js';
	?>
</script>



   </div>
		

				
	</div>
		
	</div>
	
	<div id="container" class="container_24 rounded">
		<div id="maincolumn" class="grid_20">
				<?php if (!isset($_SESSION['navigate'])) {echo "<script>navigate('home.php','homelink');</script>";}	?>
		</div>		
		
		<div id="adsidebar" class="grid_4">	
				<div id="socialDiv" class="rounded">			
						<h4>Visit us @ </h4><br>	
						<a href="https://www.facebook.com/pages/Nice-Ideas/204601213010702"><img src="img/icons/facebook.png" alt="Facebook" ></a>
						<a href="https://twitter.com/NiceIdeas1"><img src="img/icons/twitter.png" alt="Twitter" ></a>	
						<a href="http://pinterest.com/niceideas1/"><img src="img/icons/pinterest.png" alt="Pinterest" ></a>
				</div>		

				<div style="margin-left:11px;">
					<script type="text/javascript">
					ch_client = "sabotuer99";
					ch_width = 120;
					ch_height = 600;
					ch_type = "mpu";
					ch_sid = "Chitika Default";
					ch_color_site_link = "0000CC";
					ch_color_title = "0000CC";
					ch_color_border = "D10DD1";
					ch_color_text = "000000";
					ch_color_bg = "FFFFFF";
					</script>
					<script src="http://scripts.chitika.net/eminimalls/amm.js" type="text/javascript">
					</script>	
				</div>
				
		</div>	
	</div> 
	
	<div id="footer" class="container_24 rounded">
			<span>Copyright Troy Whorten 2012-<?php echo date("Y"); ?></span>
			<div id="genImgDiv"></div>
				 <!--       
       <div id="user-info" style="display:block"></div>
        <div id="debug"></div>
 
        <div id="other" style="display:none;">
            <a href="#" onclick="showStream(); return false;">Publish Wall Post</a> |
            <a href="#" onclick="share(); return false;">Share With Your Friends</a> |
            <a href="#" onclick="graphStreamPublish(); return false;">Publish Stream Using Graph API</a> |
            <a href="#" onclick="fqlQuery(); return false;">FQL Query Example</a>
 
            <br />
            <textarea id="status" cols="50" rows="5">Write your status here and click 'Status Set Using Legacy Api Call'</textarea>
            <br />
            <a href="#" onclick="setStatus(); return false;">Status Set Using Legacy Api Call</a>
        </div>	
        -->
	</div> 
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<div id="accessToken" style="display:none"></div>
</body>
</html>