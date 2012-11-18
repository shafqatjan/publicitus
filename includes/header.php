<link href="colorbox/colorbox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="colorbox/jquery.colorbox.js" type="text/javascript"></script>
<script>
jQuery.noConflict();
window.fbAsyncInit = function() {
    FB.init({
        appId: '166495106822437',
        status: true,
        cookie: true,
        xfbml: true,
        oauth: true
    });
};

function facebookLogout() {
	FB.logout(function(response) {
		logout(response);
	});	
}

function facebookLogin() {
	FB.login(function(response) {
		if (response.authResponse) {
		
			FB.api('/me', function(info) {
				//alert(info.username);
				//jQuery.facebox({ajax: 'script-includes/loginPage.php'});
				//jQuery("#myDivId").html(info.email).fadeIn(200);
				//myLogout();
				jQuery.colorbox({
					href:"script-includes/FbRegister.php?email="+info.email,
					onClosed: function(){myLogout();}
				});
				//alert(info.email);
				//login(response, info);
				});
		
			} 
		else {
			//user cancelled login or did not grant authorization
			showLoader(false);
		}
	}, {scope:'email,user_birthday,status_update,publish_stream,user_about_me'});  		
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

(function(d) {
    var js,
    id = 'facebook-jssdk';
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement('script');
    js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    d.getElementsByTagName('head')[0].appendChild(js);
} (document));

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
<?php
//printArray($objSession);
//include('fb_connect.php');
?>

<div id="header">
  <div id="logo"><a href="<?php echo SITE_ROOT?>"><img id="logo-img" src="<?php echo SITE_ROOT?>images/logo.png" border="0" /></a></div>
  <div id="nav">
    <ul>
      <li> <a href="<?php echo SITE_ROOT?>"> Home </a> </li>
      <li> <a href="<?php echo SITE_ROOT?>jobs.php"> Jobs </a> </li>      
      <!--<li> <a href=""> Join </a> </li>-->
      <?php
	  if($objSession->id)
	  {
		  //printArray($objSession);
		  $myFolder = '';
		  //1=expert,2=manager,3=advertiser,4=media
		  if($objSession->user_type==EXPERT) $myFolder = 'expert/';
		  if($objSession->user_type==PRM) $myFolder = 'manager/';
		  if($objSession->user_type==ADVERTISER) $myFolder = 'advertiser/';
		  if($objSession->user_type==MEDIA) $myFolder = 'media/';		  		  		  
	  ?>
      <li style="width:110px;"> <a href="<?php echo SITE_ROOT.$myFolder?>"> Dashboard </a> </li>
      <li style="width:85px;"> <a href="<?php echo SITE_ROOT?>logout.php"> Sign Out </a> </li>
      <li style="width:170px;border:none;"> <a href="<?php echo SITE_ROOT.$myFolder?>"> Welcome <?php echo $objSession->user_name;?></a> </li>
      <?php
	  }
	  else
	  {
	  ?>
      <li style="border:none;"> <a href="<?php echo SITE_ROOT?>login.php"> Sign In </a> </li>
      <li style="border:none;"> <!--<a href="javascript:void(0);" id="fb-auth"> <img id="fb-btn-img" src="images/fb.png" /> </a> -->
        <input type="button" border="0" id="fb-auth" style="background:url(images/fb.png) no-repeat ; cursor:pointer ;border:none; width:107px; height: 25px;" onclick='facebookLogin()'>
        </input>
      </li>
      <?php
	  }
	  ?>
    </ul>
  </div>
</div>
