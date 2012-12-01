<?php 
class Admin
{
	private $id, $user_name, $password, $email, $verificationCode , $oldpassword, $newpassword, $confirmpassword, $table, $status, $dated;

	public function __construct()
	{				
		$this->id=0;
		$this->user_name ='';
		$this->password='';
		$this->email = '';		
		$this->verificationCode ='';
		$this->confirmpassword='';
		$this->table = TBL_ADMIN;
		$this->status = '';				
		$this->dated = '';		
	}

	public function __set($field, $val)
	{
		if(is_array($val))
		{
			foreach($val as $key=>$value)
				if(isset($this->$key)) 
					$this->$key = $value;			
		}
		else
			$this->$field = $val;
	}

	

	public function __get($field)
	{
		return $this->$field;
	}
	
	public function validate()
	{
		$error = '';
		if(!$this->user_name)
			$error .= '&bull;&nbsp;Username cannot be left blank.<br />';
		if(!$this->password)
			$error .= '&bull;&nbsp;Password cannot be left blank.<br />';
			
		return $error;
	}
	public function validateEmail()
	{
		$error = '';
		if(!$this->email)
			$error .= '&bull;&nbsp;Email cannot be left blank.<br />';
		else if(!preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/",$this->email))		
			$error .= '&bull;&nbsp;Invalid email.<br />';			
		return $error;
	}	
	public function validateAdmin()
	{
		$error = '';
		if(!$this->user_name)
			$error .= '&bull;&nbsp;Username cannot be left blank.<br />';
/*		if(!$this->password)
			$error .= '&bull;&nbsp;Password cannot be left blank.<br />';*/			
		if(!$this->email)
			$error .= '&bull;&nbsp;Email cannot be left blank.<br />';
		else if(!preg_match("/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/",$this->email))		
			$error .= '&bull;&nbsp;Invalid email.<br />';				
		return $error;
	}
	public function PasswordValidate()
	{
		$error = '';
		if(!$this->oldpassword)
			$error .= '&bull;&nbsp;Old password cannot be left blank.<br />';
		if(!$this->newpassword)
			$error .= '&bull;&nbsp;New password cannot be left blank.<br />';
		if(!$this->confirmpassword)
			$error .= '&bull;&nbsp;Confirm password cannot be left blank.<br />';	
		else if($this->newpassword!=$this->confirmpassword)
			$error .= '&bull;&nbsp;Password mismatch.<br />';
		return $error;
	}
	public function ChangePassword()
	{
		return 'Update '.$this->table.' SET		password 	="'.md5($this->newpassword).'"		where id 	= '.$this->id.' LIMIT 1';
	}
	public function ResetPassword()
	{
		return 'Update '.$this->table.' SET		password 	="'.$this->password.'"		where id 	= '.$this->id.' LIMIT 1';
	}
	public function ChangeEmail()
	{
		return 'Update '.$this->table.' SET email = "'.$this->email.'" where id = '.$this->id.' LIMIT 1';
	}	
	public function checkOldPassword()
	{
		return 'Select 1 from '.$this->table.' WHERE password = "'.md5($this->oldpassword).'" AND id = '.$this->id.' LIMIT 1;';
	}
	public function PopulateGrid($params = '*', $whr_clz='')
	{
		return 'SELECT '.$params.' FROM '.$this->table.' WHERE 1=1 '.$whr_clz;
	}
	public function UpdateVarificationCode()
	{
		return 'UPDATE '.$this->table.' SET				verificationCode = "'.$this->verificationCode.'" 				WHERE email = "'.$this->email.'"';
	}	
	public function checkLogin()
	{
		return 'Select id, user_name from '.$this->table.' 		WHERE status=1 AND user_name	= "'.$this->user_name.'" 		AND password    = "'.md5($this->password).'" LIMIT 1';
	}
	public function emailExists()
	{
		return 'Select 1 from '.$this->table.'  		WHERE email	= "'.$this->email.'" LIMIT 1';
	}
	public function UpdateVCode()
	{
		return "UPDATE ".$this->table." SET 		verificationCode = '".$this->verificationCode."'		WHERE id = ".intval($this->id);
	}
	public function userExists()
	{
		return 'Select 1 from '.$this->table.'  		WHERE status=1 AND user_name	= "'.$this->user_name.'" LIMIT 1';
	}
	public function Delete($whr_clz)
	{
		return 'DELETE FROM '.$this->table.' WHERE '.$whr_clz;
	}	
	public function UpdateStatus()
	{
		return 'UPDATE '.$this->table.' SET				status = "'.$this->status.'"				WHERE id = '.$this->id;
	}	
/*
	2 	user_name 	
	3 	password 	
	4 	email
*/	
	public function Add()
	{
		return 'INSERT INTO '.$this->table.' SET user_name = "'.$this->user_name.'",password = "'.md5($this->password).'",email = "'.$this->email.'",status = "'.$this->status.'"';
	}

	public function Update()
	{
		return 'UPDATE '.$this->table.' SET user_name = "'.$this->user_name.'",email = "'.$this->email.'",status = "'.$this->status.'" WHERE id = '.$this->id;
	}	
}
?>