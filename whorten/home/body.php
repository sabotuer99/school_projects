<!-- page header  -->
<div id="header" class="container_24">
		<div class="grid_4">		
		<a  data-crumbtitle="Heraldry" data-target="home/heraldry.php" onclick="navigate(this)/*;resetcrumbs();document.getElementById('breadcrumbs').innerHTML='&lt;a data-target=&quot;home/home.php&quot;  onclick=&quot; navigate(this);deletesibs(this); &quot; &gt; Home	&lt;/a&gt;';addcrumb(this);*/"><img id="coatofarms" src="home/coatofarms_small.gif" alt="" ></a>
		</div>
		
		<div class="grid_20">
				<div id="loginarea">
						<div id="themeselector">
								<span>Theme:</span>
								<button id="darkthemebutton" ></button>		
								<button id="lightthemebutton" ></button>
						</div>
						<table id="logintable" border="0">
						<!--
								<tr id="themeselect">
										<td><span>Theme:</span></td>
										<td><button id="darkthemebutton" ></button>		
										<button id="lightthemebutton" ></button>	</td>
								</tr>	-->
								<tbody id="loginbox">
								<?php require_once 'home/login.php'; ?>
								</tbody>									
						</table>	
				</div>
		
				<div id="titleh1">		<h1><span>Whorten   </span><span>Academy</span></h1>	

						<!--						
						<hr>
						
						<div id="breadcrumbs">
								<span> Home </span>
						</div>-->
						
				</div>
		</div>

</div>

<!-- content area below header  -->
<div id="mainbody" class="container_24">
		
		<!-- left side nav bar  -->

		<div id="leftsidenavdiv">
		<?php require_once 'home/leftsidenav.php'; ?>
		</div>		
		
			
		<!-- main content loading area  -->
		<div id="maincontentdiv" class="grid_15">
			<div id="maincontent" class="contentbox">
				<!-- using navigate is fucking this up, use PHP include instead... or tweak index.php...
				<script type="text/javascript" >
					navigate('home/home.php');
				</script>	
				-->
			</div>
		</div>	
		<!-- right sidebar -->

		<div id="rightsidediv" class="grid_5">		
			<div id="rightside" class="contentbox">
					<button class="toggle nomargin" data-state="down"></button>
					<span class="nopad" name="generalchat" > General Chat	</span>
					<div class="subnav nopad" data-style="show" style="height:381px">		
							<script id="sid0020000037535605388">(function() {function async_load(){s.id="cid0020000037535605388";s.src='http://st.chatango.com/js/gz/emb.js';s.style.cssText="width:190px;height:375px;";s.async=true;s.text='{"handle":"whorten","arch":"js","styles":{"a":"000066","c":"4a86e8","d":"ffffff","k":"000066","l":"000066","m":"000066","n":"FFFFFF","q":"000066","t":0,"usricon":0,"surl":0}}';var ss = document.getElementsByTagName('script');for (var i=0, l=ss.length; i < l; i++){if (ss[i].id=='sid0020000037535605388'){ss[i].id +='_';ss[i].parentNode.insertBefore(s, ss[i]);break;}}}var s=document.createElement('script');if (s.async==undefined){if (window.addEventListener) {addEventListener('load',async_load,false);}else if (window.attachEvent) {attachEvent('onload',async_load);}}else {async_load();}})();</script>
					</div>	
			</div>
		</div>
		
</div>

<div id="bodyscript">
	<script type="text/javascript" >
	<?php if( isset($navtarget) )  { echo ("navigate('".$navtarget."','replace');");} /*document.querySelectorAll('[data-target=".'"'.$navtarget.'"'."]')[0]*/?>	
			addEventListeners();
	</script>
</div>

