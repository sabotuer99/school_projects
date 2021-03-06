
   var button;
   var userInfo;
 
         
window.fbAsyncInit = function() {
      // init the FB JS SDK
  	  	FB.init({
  	        appId      : '423489751063562', // App ID from the App Dashboard
  	        channelUrl : '//niceideas.eu.pn/channel.html', // Channel File for x-domain communication
  	        status     : true, // check the login status upon init?
  	        cookie     : true, // set sessions cookies to allow your server to access the session?
  	        xfbml      : true,  // parse XFBML tags on this page?
  	        oauth		: true //enables site for OAuth 2.0 authentication
  	   });

		   showLoader(true);
   
   
   document.getElementById('fb-auth').onclick = function() {
                       showLoader(true);
                       FB.login(function(response) {
                            if (response.authResponse) {
                                 FB.api('/me', function(info) {
                                 login(response, info);
                                 });
                            } else {
                            //user cancelled login or did not grant authorization
                            showLoader(false);
                            }
                       }, {scope:'email,user_birthday,status_update,publish_stream,user_about_me'});
                  }
 
   
    	 function updateButton(response) {
                 alert(response);
            button       =   document.getElementById('fb-auth');
            userInfo     =   document.getElementById('user-info');
            userPic				 =		document.getElementById('userPic');
 
            if (response.authResponse) {
                  //user is already logged in and connected
                  FB.api('/me', function(info) {
                       login(response, info);
                  });
 
//    button.onclick = function() {
//                       FB.logout(function(response) {
//                       logout(response);
//                       });
//                  };
            } else {
                  //user is not connected to your app or logged out
                  button.innerHTML = '<img src="img/icons/facebook.png" id="fbconnectimg" style="width:16px;height:16px;margin:0 0 0 0;padding:0 0 0 0;"/>';
                  button.onclick = function() {
                       showLoader(true);
                       FB.login(function(response) {
                            if (response.authResponse) {
                                 FB.api('/me', function(info) {
                                 login(response, info);
                                 });
                            } else {
                            //user cancelled login or did not grant authorization
                            showLoader(false);
                            }
                       }, {scope:'email,user_birthday,status_update,publish_stream,user_about_me'});
                  }
            }
        }
 
 
 
 
        // run once with current status and whenever the status changes
//        FB.getLoginStatus(updateButton);
//        FB.Event.subscribe('auth.statusChange', updateButton);
        showLoader(false);
};
   


(function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol
            + '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
}());

            
            
function login(response, info){
      if (response.authResponse) {
//var accessToken          =   response.authResponse.accessToken;
                    
	userPic.innerHTML	=   '<img src="https://graph.facebook.com/' + info.id + '/picture">';                
//             userInfo.innerHTML       = '<img src="https://graph.facebook.com/' + info.id + '/picture">' + info.name
//                                                                     + "<br /> Your Access Token: " + accessToken;
//button.innerHTML         = '<img src="img/icons/fblogout.png" id="fbconnectimg" style="width:16px;height:16px;margin:0 0 0 0;padding:0 0 0 0;"/>';
             //alert(info.id);
             showLoader(false);
//document.getElementById('other').style.display = "block";
             
             FbIdLookup(info.id,info.first_name,info.last_name,info.email,info.gender);
             
             //loginAction();
       }
}
        


function logout(response){
      userInfo.innerHTML                             =   "";
      userPic.innerHTML                              =   "";
      document.getElementById('debug').innerHTML     =   "";
      document.getElementById('other').style.display =   "none";
      showLoader(false);
      window.location.href = "logout.php";
}



 //stream publish method
function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
      showLoader(true);
      FB.ui(
      {
             method: 'stream.publish',
                    message: '',
                    attachment: {
                    name: name,
                    caption: '',
                    description: (description),
                    href: hrefLink
              },
              action_links: [
                    { text: hrefTitle, href: hrefLink }
              ],
              user_prompt_message: userPrompt
        },
        function(response) {
              showLoader(false);
        });

}
            
            
            function showStream(){
                FB.api('/me', function(response) {
                    //console.log(response.id);
                    streamPublish(response.name, 'Looks like Troy got Facebook Integration working', 'hrefTitle', 'http://niceideas.eu.pn', "Share niceideas.eu.pn");
                });
            }



function share(){
      showLoader(true);
      var share = {
           method: 'stream.share',
           u: 'http://niceideas.eu.pn/'
      };

      FB.ui(share, function(response) { 
           showLoader(false);
           console.log(response); 
      });
}



function graphStreamPublish(){
      showLoader(true);  
                   
      FB.api('/me/feed', 'post', 
      { 
           message     : "I love thinkdiff.net for facebook app development tutorials",
           link        : 'http://ithinkdiff.net',
           picture     : 'http://thinkdiff.net/iphone/lucky7_ios.jpg',
           name        : 'iOS Apps & Games',
           description : 'Checkout iOS apps and games from iThinkdiff.net. I found some of them are just awesome!'
                        
      }, 
      function(response) {
           showLoader(false);
                    
           if (!response || response.error) {
                alert('Error occured');
           } else {
                alert('Post ID: ' + response.id);
           }
       });
}



function fqlQuery(){
      showLoader(true);
                
      FB.api('/me', function(response) {
      showLoader(false);
                    
      //http://developers.facebook.com/docs/reference/fql/user/
      var query       =  FB.Data.query('select name, profile_url, sex, pic_small from user where uid={0}', response.id);
      query.wait(function(rows) {
           document.getElementById('debug').innerHTML =  
           'FQL Information: '+  "<br />" + 
           'Your name: '      +  rows[0].name                                                            + "<br />" +
           'Your Sex: '       +  (rows[0].sex!= undefined ? rows[0].sex : "")                            + "<br />" +
           'Your Profile: '   +  "<a href='" + rows[0].profile_url + "'>" + rows[0].profile_url + "</a>" + "<br />" +
           '<img src="'       +  rows[0].pic_small + '" alt="" />' + "<br />" +
           response.id;
           });
       });
}



function setStatus(){
      showLoader(true);
                
      status1 = document.getElementById('status').value;
      FB.api(
      {
          method: 'status.set',
          status: status1
      },
      function(response) {
           if (response == 0){
                alert('Your facebook status not updated. Give Status Update Permission.');
           }
           else{
                alert('Your facebook status updated');
           }
           showLoader(false);
       });
}
           
           
            
function showLoader(status){
      if (status)
         document.getElementById('loader').style.display = 'inline';
      else
         document.getElementById('loader').style.display = 'none';
}
    
    
            
function ShareIt(div_id){
      FB.api('/me', function(response) {
      //console.log(response.id);
      var stuff = (document.getElementById(div_id).innerText || document.getElementById(div_id).textContent);
      streamPublish(response.name, stuff, 'Nice Ideas!', 'http://niceideas.eu.pn', "Share niceideas.eu.pn");
      });
}
