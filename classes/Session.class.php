<?php

class Session
{
	private $login = array();
	
	public function __construct($role="")
	{
		if(ADMIN_ROLE == $role)
		{
			$this->login['id'] 		 = intval(isset($_SESSION[ADMIN_ID])?$_SESSION[ADMIN_ID]:'');
			$this->login['username'] = isset($_SESSION[ADMIN_USERNAME])?$_SESSION[ADMIN_USERNAME]:'';
			$this->login['role'] 	 = isset($_SESSION[ADMIN_ROLE])?$_SESSION[ADMIN_ROLE]:'';
		}
		else
		{
			$this->login['id'] 		 = intval(isset($_SESSION[CLIENT_ID])?$_SESSION[CLIENT_ID]:'');
			$this->login['user_type'] = isset($_SESSION[CLIENT_USERTYPE])?$_SESSION[CLIENT_USERTYPE]:'';
			$this->login['user_name'] = isset($_SESSION[CLIENT_USERNAME])?$_SESSION[CLIENT_USERNAME]:'';
			$this->login['email'] = isset($_SESSION[CLIENT_EMAIL])?$_SESSION[CLIENT_EMAIL]:'';			
			$this->login['role'] 	 = isset($_SESSION[CLIENT_ROLE])?$_SESSION[CLIENT_ROLE]:'';
		}
	}
	
	public function __set($field,$value)
	{
		$this->login[$field] = $value;
	}
	
	public function __get($field)
	{
		return $this->login[$field];
	}

	public function currentLoginUserLink()
	{
		return "<a target='_blank' href='".SITE_ROOT.USER."?u=".$this->username."'>".$this->username."</a>";	
	}
	

	public function setSessMsg($msg)
	{
		$_SESSION[$this->login['role'].'sessMsg'] = $msg;
	}
	
	public function getSessMsg()
	{
		if(isset($_SESSION[$this->login['role'].'sessMsg']) && $_SESSION[$this->login['role'].'sessMsg'])
		{
			$rs ='';			
			if(ADMIN_ROLE == $this->login['role'])
			{
				$rs = "<div id='sessMsg' style='border:1px solid #749c41; height:auto; margin:0px auto 10px auto; width:98%; background-color:#c2e14b; font-family:Tahoma; 	font-size:11px; font-weight:normal !important; line-height:16px; color:#000; padding:5px 0px 7px 1.5%; position:relative;'>";
				$rs .= $_SESSION[$this->login['role'].'sessMsg'];			
				$rs .= '<div style="position:absolute; width:auto; font-size:16px; font-family:Arial; font-weight:bold; color:red; cursor:pointer; text-align:center; right:4px; top:4px;" onclick="jQuery(\'#sessMsg\').fadeOut(1000);">x</div>';			
				$rs .= "</div>";
			}
			else
			{ 

				$rs = '<div class="mes-box" id="success-box"><div>';
				$rs .= $_SESSION[$this->login['role'].'sessMsg'];			
				//$rs .= '<div style="position:absolute; width:auto; font-size:16px; font-family:Arial; font-weight:bold; color:red; cursor:pointer; text-align:center; right:473px; top:153px;" onclick="jQuery(\'#success-box\').fadeOut(1000);">x</div>';			
				$rs .= "</div></div>";				
			}
			
			$_SESSION[$this->login['role'].'sessMsg'] = '';
			unset($_SESSION[$this->login['role'].'sessMsg']);
			
			return $rs;
		}
	}

	public function checkSession($role="", $redirect="index.php")
	{
		if($this->role != $role)
			$this->redirectTo($redirect);	
	}
	
	public function redirectTo($redirectURL)
	{
		if($redirectURL)
		{
			header("Location: ".$redirectURL);
			exit;
		}
	}

	public function isSession($redirect="index.php")
	{
		if(!empty($this->login['id']))
			$this->redirectTo($redirect);
	}
	
	public function setCookies($cookieName,$cookieValue)
	{
		setcookie($cookieName,$cookieValue);
	}
		
	public function setSession($role="",$redirect="main.php")
	{
	
		if(ADMIN_ROLE == $this->login['role'])
		{
			$_SESSION[ADMIN_ID] = $this->login['id'];
			$_SESSION[ADMIN_USERNAME] = $this->login['username'];
			$_SESSION[ADMIN_ROLE] = $this->login['role'];
		}
		else
		{
			$_SESSION[CLIENT_ID] = $this->login['id'];
			$_SESSION[CLIENT_USERTYPE] = $this->login['user_type'];
			$_SESSION[CLIENT_USERNAME] = $this->login['user_name'];			
			$_SESSION[CLIENT_EMAIL] = $this->login['email'];	
			$_SESSION[CLIENT_ROLE] = $this->login['role'];
		}
		
		$this->redirectTo($redirect);
	}
	function setSessionFB()
	{
		$_SESSION[CLIENT_ID] = $this->login['id'];
		$_SESSION[CLIENT_USERTYPE] = $this->login['user_type'];
		$_SESSION[CLIENT_USERNAME] = $this->login['user_name'];		
		$_SESSION[CLIENT_EMAIL] = $this->login['email'];			
		$_SESSION[CLIENT_ROLE] = $this->login['role'];						
	}		
	public function destroySession($redirect="index.php")
	{
		//echo $this->login['role'].ADMIN_SUPER_ROLE;exit;
		
		if($this->login['role'] == ADMIN_ROLE)
		{
			$_SESSION[ADMIN_ID] = "";
			$_SESSION[ADMIN_SCHOOLID] = "";
			$_SESSION[ADMIN_USERNAME] = "";
			$_SESSION[ADMIN_ROLE] = "";
			
			unset($_SESSION[ADMIN_ID]);
			unset($_SESSION[ADMIN_USERNAME]);
			unset($_SESSION[ADMIN_ROLE]);
			
			unset($this->login); 
		}
		else 
		{
			$_SESSION[CLIENT_ID] = "";
			$_SESSION[CLIENT_USERTYPE] = "";
			$_SESSION[CLIENT_USERNAME] = "";			
			$_SESSION[CLIENT_EMAIL] = "";
			$_SESSION[CLIENT_ROLE] = "";
			
			unset($_SESSION[CLIENT_ID]);
			unset($_SESSION[CLIENT_USERTYPE]);
			unset($_SESSION[CLIENT_USERNAME]);			
			unset($_SESSION[CLIENT_EMAIL]);
			unset($_SESSION[CLIENT_ROLE]);
	
			unset($this->login); 			
		}			
		$this->redirectTo($redirect);
	}
}
?>