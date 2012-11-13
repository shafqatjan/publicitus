<link href="colorbox/colorbox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="colorbox/jquery.colorbox.js" type="text/javascript"></script>

<div id="fb-root"></div>
<script type="text/javascript">
            var button;

            var userInfo;
			var myUserInfo=0;
            

            window.fbAsyncInit = function() {

                FB.init({ appId: '192117357532818', //change the appId to your appId

                    status: true, 

                    cookie: true,

                    xfbml: true,

                    oauth: true});



               showLoader(true);

               

               function updateButton(response) {

                    button       =   document.getElementById('fb-auth');

                    userInfo     =   document.getElementById('user-info');
alert('asdf');
                    if (response.authResponse) {
						
						//user is already logged in and connected

                        FB.api('/me', function(info) {
							return false;
                           login(response, info);

                        });

                        button.onclick = function() {

                            FB.logout(function(response) {

                                logout(response);

                            });

                        };

                    } else {
					   //user is not connected to your app or logged out
					
                       button.innerHTML = '<img src="images/facebook.jpg" border="0" />';

					   button.onclick = function() {

                            showLoader(true);

                            FB.login(function(response) {

                                if (response.authResponse) {

                                    FB.api('/me', function(info) {
										alert('hey');										
										//jQuery.facebox({ajax: 'script-includes/loginPage.php'});
										//jQuery("#myDivId").html(info.email).fadeIn(200);
										//myLogout();
										$.colorbox({
												href:"script-includes/FbRegister.php?email="+info.email+"&dob="+info.birthday+"&userName="+info.username,
												onClosed: function(){myLogout();}
										});
										//alert(info.email);
										//login(response, info);
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

                FB.getLoginStatus(updateButton);

                FB.Event.subscribe('auth.statusChange', updateButton);

				FB.Event.subscribe('auth.login', function(response)
				{
					//window.location="http://thewebtesting.com/big4fun/index.php";
				});	

			 };

            function login(response, info){
				
                if (response.authResponse) {
					var accessToken                                =   response.authResponse.accessToken;
					userInfo.innerHTML                             = '<img src="https://graph.facebook.com/' + info.id + '/picture">' + info.name;

                  	button.innerHTML                               = '<img src="images/facebook.jpg" border="0" />';

                    showLoader(false);
					
				}

            }

        

            function logout(response){

                userInfo.innerHTML =   "";

                showLoader(false);

            }

		  function showLoader(status){
return false;
                if (status)

                    document.getElementById('loader').style.display = 'block';

                else

                    document.getElementById('loader').style.display = 'none';

            }

            

        </script>
<div id="loader" style="display:none"> <img src="images/loading.gif"  id="loader" name="loader"/> </div>
<div id="user-info"></div>
<script>
function myLogout()
{
	FB.logout(function(response) {
		logout(response);
	});
}
function reloadMe()
{
	myLogout();
	window.setTimeout(window.location='index.php', 500);
}
</script>