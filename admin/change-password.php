<?php
include('../settings/settings.php');
include('../helpers/helper.php');

$objSession = new Session(ADMIN_ROLE);
$objSession->checkSession(ADMIN_ROLE);

$objDb = new Database();
$objDb->connect();
$objLogin = new Admin();
	
$error = "";

if(isset($_POST['btn_update']))
{
	printArray($_POST);
	$oldpassword		= isset($_POST['oldpassword'])?$_POST['oldpassword']:"";
	$newpassword		= isset($_POST['newpassword'])?$_POST['newpassword']:"";
	$confirmpassword	= isset($_POST['confirmpassword'])?$_POST['confirmpassword']:"";
	
	if(!$oldpassword)
		$error .="&nbsp;&bull;&nbsp;Old Password cannot be left blank.<br/>";
	if(!$newpassword)
			$error .="&nbsp;&bull;&nbsp;New Password cannot be left blank.<br/>";
	if(!$confirmpassword)
		$error .="&nbsp;&bull;&nbsp;Confirm Password cannot be left blank.<br/>";
	if($newpassword && (md5($newpassword) != md5($confirmpassword)))
			$error .="&nbsp;&bull;&nbsp;Passwords does not match.<br/>";
	
	if(empty($error))
	{
		$objLogin->id  = $objSession->id;
		$objLogin->oldpassword = $oldpassword;
		
		if($objDb->query($objLogin->checkOldPassword()) && $objDb->get_num_rows()>0)
		{
			$objLogin->newpassword = $newpassword;
		   	if($objDb->query($objLogin->ChangePassword()))
			{
				$objSession->setSessMsg("Password has been changed successfully.");
				$objSession->redirectTo("change-password.php");
			}
			else
			{
				$error ="&nbsp;&bull;&nbsp;Invalid error occured, please try again.<br/>";
			}
		}
		else
		{
			$error ="&bull;&nbsp;&nbsp;Invalid Old Password.<br/>";
		}
	}
}
?>
<html>
<head>
<title><?php echo ADMIN_PAGE_TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css"/>
<script language="javascript" src="../js/lib/jquery.js"></script>
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
			<td class="middlearea" valign="top">
			<table cellspacing="0" cellpadding="10" width="100%" height="100%">
				<tr>
			    	<td width="180px" valign="top" id="leftnav"><?php include("side-menu.php");?></td>
			        <td valign="top" align="center">
                    	<table width="100%" border="0" cellpadding="5" cellspacing="0" class="tbllisting">
                            <tr>
                              <td align="left" class="mainhead">Change Password</td>
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
                     			<td>
                                    <!--CONTENTS TABLE-->
                                    <form method="post" name="formchangepassword">
                                    <table width="96%" cellpadding="4" cellspacing="0" align="center">
                                        <tr>
                                            <td width="17%" class="Verdana_Bold_Black_11">Old Password*</td>
                                            <td width="1%" class="Verdana_Black_11">:</td>
                                            <td width="82%"><input type="password" name="oldpassword" id="oldpassword" class="txtin"></td>
                                        </tr>
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
                                  	  <!--CONTENTS TABLE END-->
                              	</td>
                           </tr>
                    </table>
                   </td>
			    </tr>
			</table>
            </td>
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