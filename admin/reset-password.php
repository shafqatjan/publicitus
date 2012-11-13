<?php
include('../settings/settings.php');

$objSession = new cSession();
$objDb = new Database();
$objDb->connect();
$objUser = new Admin();
$objFun = new Functions();	

$new_password = "";
$con_password = "";

$userName 	= "";
$userID 	= "";

$error 		= "";

$getToken = isset($_GET['token'])?$_GET['token']:"";
$link_URL = "login";

$defaultMsg = 'Password Reset Request cannot proceed due to the following reasons:<br />
		<ul style="color:red;">
			<li>Invalid Token Number.</li>
			<li>Password Reset Link has been expired.<br /></li>
		</ul>
		Click <a href="'.SITE_ROOTADMIN.'">here</a> to go to login page.';

if($getToken)
{
	 $sql = $objUser->PopulateGrid("id, userName", " and verificationCode = '".htmlspecialchars(mysql_real_escape_string($getToken))."'");
	if($objDb->query($sql) && $objDb->get_num_rows()>0)
	{
		$row = $objDb->fetch_row_assoc();
		$userName = $row['userName'];
		$userID = $row['id'];
		
		$defaultMsg = "";
	}
}

if (isset($_POST['btn_update']))
{
	 $new_password	= $_POST['newpassword'];
	 $con_password	= $_POST['confirmpassword'];
	
		if(!$new_password)
		{
			$error .="&bull;&nbsp;New Password cannot be left blank.<br/>";
		}
		if(!$con_password)
		{
			$error .="&bull;&nbsp;Confirm Password cannot be left blank.<br/>";
		}
		else if($new_password != $con_password)
		{
			$error .="&bull;&nbsp;Password mismatched.<br>";
		} 

		if(empty($error))
		{
			$objUser->id = $userID;
			$objUser->password = $cur_password;
			$cur_password=md5($cur_password);

			$objUser->verificationCode = '';
			if($objDb->execute($objUser->UpdateVCode()))
				$doEmail = 1;
				
				if($doEmail==1)
				{
					$objUser->password = md5($new_password);
					$sql_chg = $objUser->ResetPassword();
					if($objDb->execute($sql_chg))
					{
						$objSession->setSessMsg("Password has been resetted successfully. Please Login.");
						$objSession->redirectTo($link_URL);
					}
				}
				else
				{
					$error  .="&bull;&nbsp;Password has not been changed.<br/>";
				}
		}
	}



?>
<html>
<head>
<title><?php echo ADMIN_PAGE_TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
<script language="javascript" src="../js/lib/jquery-1.6.4.js"></script>
<link rel="stylesheet" href="../jBread/Styles/BreadCrumb.css" type="text/css">
</head>

<body>
<table cellspacing="0" cellpadding="0" class="maintbl" align="center">
  <tr>
    <td class="logo"><?php echo ADMIN_PAGE_HEADING;?></td>
  </tr>
  <tr>
    <td class="topnav" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td class="middlearea" valign="top"><table cellspacing="0" cellpadding="10" width="100%" height="100%">
        <tr>
          <td width="180px" valign="top" id="leftnav"><?php //include("side-menu.php");?></td>
          <td valign="top" align="center"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="tbllisting">
              <tr>
                <td align="left" class="mainhead">Reset Password</td>
              </tr>
              <tr>
                <td colspan="2"><div class="breadCrumbHolder module">
                    <div class="breadCrumb module">
                      <ul>
                        <li class="Verdana_Bold_11_Link"> <a href="<?php echo MAIN_URL;?>">Home</a> </li>
                        <li> Reset Password </li>
                      </ul>
                    </div>
                  </div></td>
              </tr>
              <?php

                            if($error)

                            {

                            ?>
              <tr>
                <td class="error"><?php echo $error;?></td>
              </tr>
              <?php 

                            }

                            ?>
              <tr>
                <td><?php echo $objSession->getSessMsg();?></td>
              </tr>
              <tr>
                <td><!--CONTENTS TABLE-->
                 
                  <?php
				   if(empty($defaultMsg))
				    {
					  ?> 
                  <form method="post" name="formchangepassword">
                    <table width="96%" cellpadding="4" cellspacing="0" align="center">
                      <tr>
                        <td width="17%" class="Verdana_Bold_Black_11">New Password*</td>
                        <td width="1%" class="Verdana_Black_11">:</td>
                        <td width="82%"><input type="password" name="newpassword" id="newpassword" class="txtin"></td>
                      </tr>
                      <tr>
                        <td width="17%" class="Verdana_Bold_Black_11">Confirm New Password*</td>
                        <td width="1%" class="Verdana_Black_11">:</td>
                        <td width="82%"><input type="password" name="confirmpassword" id="confirmpassword" class="txtin"></td>
                      </tr>
                      <tr>
                        <td width="17%" class="Verdana_Bold_Black_11"></td>
                        <td width="1%" class="Verdana_Black_11"></td>
                        <td width="82%"><input type="submit" name="btn_update" value="Update" class="button" id="btn_update"></td>
                      </tr>
                    </table>
                  </form>
                  <?php }
				  	else 
						{ 
							echo '<span>'.$defaultMsg.'<span>';
						}
									  ?>
                  
                  <!--CONTENTS TABLE END--></td>
              </tr>
             
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td class="footer">&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php
$objDb->close();
?>