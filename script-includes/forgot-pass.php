<?php
include('../settings/settings.php');
require('../helpers/helper.php');

$objSession = new Session(CLIENT_ROLE);


?>
<script>
function sendPwd()
{
	jQuery(".message-error1").hide().html("");
	var email = jQuery("#email").val();
	 if(email==null || email=="")
	 {
		 jQuery("#message-error1").show();
		 jQuery("#all_msg1").html("Email cannot be left blank.");
		 return false;
	 }
	 var mynum = 0;
	jQuery.ajax({
		type	:	"GET",
		url		:	"ajax/client-forgotPwd.php",
		data	: 	"email="+email,
		async	: 	false,
		success :	function(rtnMsg)
		{
			alert(rtnMsg);
			if(rtnMsg==1)
				mynum = 1;
			else
			{
				jQuery("#message-error1").show();
				jQuery("#all_msg1").html(rtnMsg)
			}
			
		}
	});
	if(mynum)
		return true;
	else
		return false;
}
</script>
<style>
.main td {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	color: #393939;
	line-height:18px;
	position:relative;
	border:3px solid rgba(0, 0, 0, 0);
	padding:2px !important;
	border-radius:5px;/* 	-moz-box-shadow:0 0 18px rgba(0,0,0,0.4);
  	box-shadow:0 0 18px rgba(0,0,0,0.4);*/
}
.body {
	width:280px !important;
}
.errmsg {
	display:none;
}
</style>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>

<div class="heading2">
  <h1><strong>Forgot Password</strong></h1></div>
<div class="fields"> 
  <!-- Start Error Message or Success Message -->
  
  <div class="message message-error " id="message-error1"  style="display:none;">
    <div class="text"> <span id="all_msg1">
      <?php if($error) { echo $error; }?>
      </span> </div>
    <div class="dismiss"> <a href="javascript:void(0);" onclick="jQuery('#message-error').fadeOut(1000);"></a></div>
  </div>
  
  <!-- End Error Message or Success Message --> 
  <!-- START FORM HERE  -->
  
  <form method="post" enctype="multipart/form-data">
    <div class="field">
      <div class="label">
      <h3>
        <label for="input-small"><h2>
        Email:&nbsp;</label>

        <input type="text" name="email" id="email" value="<?php echo $email ?>"/>
     
        </h3>
      </div>
    </div>
    <div class="buttons">
      <input type="submit" value="Save" name="btn_sub" id="btn_sub" class="ui-button ui-widget ui-state-default ui-corner-all" onclick="return sendPwd();"  style=" cursor:pointer;">
      <div class="highlight"></div>
    </div>
  </form>
  
  <!-- END FORM HERE  --> 
</div>
