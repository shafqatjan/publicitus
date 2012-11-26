<?php

class User
{

	private $id; //int(11)
	private $first_name; //varchar(70)
	private $last_name; //varchar(70)	
	private $email; //varchar(70)
	private $password; //varchar(70)
	private $phone; //tinyint(3)
	private $cell; //int(11)
	private $address;
	private $company;
	private $website;
	private $city;
	private $zipcode; 
	private $country;
	private $state;
	private $user_type;
	private $status;
	private $dated;
	private $verification_code;
	private $last_login;
	private $current_login;
	private $npassword;
	private $cpassword;
	private $rate;
	private $image_name;

	public function __construct()
	{
		$this->id='';
		$this->first_name = '';
		$this->last_name = '';
		$this->email = '';
		$this->password = '';
		$this->phone = '';
		$this->cell = '';
		$this->address = '';
		$this->company = '';
		$this->website = '';
		$this->city = '';
		$this->zipcode = '';
		$this->country = '';
		$this->state = '';
		$this->user_type = '';
		$this->status = '';
		$this->dated = '';
		$this->verification_code = '';
		$this->last_login = '';
		$this->current_login = '';
		$this->image_name='';
		
		$this->table = TBL_USER;
    	$this->npassword = '';
	    $this->cpassword = '';
		$this->rate = 0;
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

	public function __get($var)
	{
		return $this->$var;
	}
	
	public function validate()
	{
		$error='';
    if($this->first_name == '')
		$error .= '&nbsp;&bull;&nbsp;First name cannot be left blank.<br>';
    if($this->email == '')
		$error .= '&nbsp;&bull;&nbsp;Email cannot be left blank.<br>';
	else if(!hlpValidEmail($this->email))
		$error .= '&nbsp;&bull;&nbsp;Invalid email.<br>';		
    if($this->password == '')
		$error .= '&nbsp;&bull;&nbsp;Password cannot be left blank.<br>';
    if($this->cpassword == '')
		$error .= '&nbsp;&bull;&nbsp;Confirm password cannot be left blank.<br>';
    else if($this->password != $this->cpassword)
		$error .= '&nbsp;&bull;&nbsp;Password mismatch.<br>';
    if($this->cell == '')
		$error .= '&nbsp;&bull;&nbsp;Cell no cannot be left blank.<br>';
		
		
		return $error;
	}

	public function validateUpdate()
	{
		$error='';
    if($this->first_name == '')
		$error .= '&nbsp;&bull;&nbsp;First name cannot be left blank.<br>';
    if($this->cell == '')
		$error .= '&nbsp;&bull;&nbsp;Cell no cannot be left blank.<br>';
		
		
		return $error;
	}

	public function validateForgot()
	{
		$error='';
		if($this->email == '')
			$error .= '&nbsp;&bull;&nbsp;Email cannot be left blank.<br>';
		else if(!hlpValidEmail($this->email))
			$error .= '&nbsp;&bull;&nbsp;Invalid email.<br>';		
		return $error;
	}		
	public function validateLogin()
	{
		$error='';
		if($this->email == '')
			$error .= '&nbsp;&bull;&nbsp;Email cannot be left blank.<br>';
		else if(!hlpValidEmail($this->email))
			$error .= '&nbsp;&bull;&nbsp;Invalid email.<br>';		
		if($this->password == '')
			$error .= '&nbsp;&bull;&nbsp;Password cannot be left blank.<br>';
		return $error;
	}	
	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		first_name = '".hlpMysqlRealScape($this->first_name)."', 
		last_name = '".hlpMysqlRealScape($this->last_name)."', 
		email = '".hlpMysqlRealScape($this->email)."', 
		password = '".md5(hlpMysqlRealScape($this->password))."', 
		website = '".hlpMysqlRealScape($this->website)."', 
		company = '".hlpMysqlRealScape($this->company)."', 
		address = '".hlpMysqlRealScape($this->address)."', 
		phone = '".hlpMysqlRealScape($this->phone)."', 
		cell = '".hlpMysqlRealScape($this->cell)."', 
		city = '".hlpMysqlRealScape($this->city)."', 
		state = '".hlpMysqlRealScape($this->state)."', 
		country = '".hlpMysqlRealScape($this->coduntry)."', 
		image_name = '".hlpMysqlRealScape($this->image_name)."', 		
		zipcode = '".hlpMysqlRealScape($this->zipcode)."';";
	}
	public function AddByUsertype()
	{
		return "INSERT INTO ".$this->table." SET 
		email = '".hlpMysqlRealScape($this->email)."', 
		password = '".hlpMysqlRealScape($this->password)."', 
		first_name = '".hlpMysqlRealScape($this->first_name)."', 		
		user_type = '".hlpMysqlRealScape($this->user_type)."';";
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		first_name = '".hlpMysqlRealScape($this->first_name)."',
		last_name = '".hlpMysqlRealScape($this->last_name)."',
		company = '".hlpMysqlRealScape($this->company)."',
		website = '".hlpMysqlRealScape($this->website)."',
		address = '".hlpMysqlRealScape($this->address)."',
		phone = '".hlpMysqlRealScape($this->phone)."',
		cell = '".hlpMysqlRealScape($this->cell)."',
		city =   '".hlpMysqlRealScape($this->city)."',
		state =  '".hlpMysqlRealScape($this->state)."',
		country = '".hlpMysqlRealScape($this->country)."',
		rate = '".hlpMysqlRealScape($this->rate)."',
		image_name = '".hlpMysqlRealScape($this->image_name)."', 				
		zipcode = '".hlpMysqlRealScape($this->zipcode)."' WHERE id = ".intval($this->id);
	}

	public function PopulateGrid($pram='*',$whr_clz='')
	{ 
		return "SELECT ".$pram." FROM ".$this->table." WHERE 1=1 ".$whr_clz;
	}
	public function PopulateJoinGrid($pram='*',$join,$whr_clz='',$groub_by='',$order_by='' )
	{ 
		return "SELECT ".$pram." FROM ".$join." WHERE 1=1 ".$whr_clz .$groub_by.$order_by;
	}
	public function Delete()
	{
		return "DELETE FROM ".$this->table." WHERE id = ".intval($this->id);
	}
	
	public function UpdateStatus()
	{
		return "UPDATE ".$this->table." SET 
		status = '".hlpMysqlRealScape($this->status)."'
		WHERE id = ".intval($this->id);
	}
	public function UpdateField($col,$val)
	{
		return "UPDATE ".$this->table." SET ".$col." = ".hlpMysqlRealScape($val)." WHERE id = ".intval($this->id);
	}	
	
	public function emailExists()
	{
		return 'Select 1 from '.$this->table.'  
		WHERE  email	= "'.hlpSafeString($this->email, 'char').'" LIMIT 1';
	}
	public function checkLogin()
	{
		return 'Select id, email,user_type,last_name from '.$this->table.' WHERE status=1 AND email = "'.$this->email.'" AND password = "'.md5($this->password).'" LIMIT 1';
	}
	


	public function UpdateVarificationCode()
	{
		return 'UPDATE '.$this->table.' SET
				verification_code = "'.hlpSafeString($this->verification_code,'char').'" 
				WHERE email = "'.hlpSafeString($this->email,'char').'"';
	}
	public function ChangePasswordEmail()
	{
		return 'Update '.$this->table.' SET
		password 	="'.md5($this->npassword).'"
		where email 	= '.hlpSafeString($this->email,'char').' LIMIT 1';
	}
	public function ChangePassword()
	{
		return 'Update '.$this->table.' SET password 	="'.md5($this->npassword).'" where id 	= '.hlpSafeString($this->id,'int').' LIMIT 1';
	}
	
	public function checkOldPassword()
	{
		return 'Select 1 from '.$this->table.' WHERE password	= "'.md5($this->password).'" AND id	= '.hlpSafeString($this->id, 'int').' LIMIT 1;';
	}
	
	
	public function addAdminEmail()
	{
		return 'UPDATE '.$this->table.' 
		set email    = "'.hlpSafeString($this->email).'"
		WHERE id= '.intval($this->id).';';
	}
	

	
	public function UpdatePwdViaEmail()
	{
		return 'UPDATE '.$this->table.' SET
				password = "'.md5(hlpSafeString($this->password,'char')).'"
				WHERE email = "'.hlpSafeString($this->email,'char').'"';
	}	

	
	public function userExists()
	{
		return 'Select 1 from '.$this->table.'  
		WHERE user_name	= "'.hlpSafeString($this->user_name, 'char').'" LIMIT 1';
	}
	
	public function PasswordValidate()
	{
		
		$error = '';
		if(!$this->password)
			$error .= '&bull;&nbsp;Old Password cannot be left blank.<br />';
		if(!$this->npassword)
			$error .= '&bull;&nbsp;New password cannot be left blank.<br />';
		if(!$this->cpassword)
			$error .= '&bull;&nbsp;Confirm passord cannot be left blank.<br />';	
		
		if($this->npassword!=$this->cpassword)
			$error .= '&bull;&nbsp;Password mismatch.<br />';
		return $error;
	}

	

}

?>