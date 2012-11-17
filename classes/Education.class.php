<?php

class Education
{

	private $id; //int(11)
	private $degree; //varchar(70)
	private $subject; //varchar(70)	
	private $start_date; //varchar(70)
	private $end_date; //varchar(70)
	private $school; //tinyint(3)
	private $is_present; //int(11)
	private $user_id; //int(11)
	

	public function __construct()
	{
		$this->id='';
		$this->degree = '';
		$this->subject = '';
		$this->start_date = '';
		$this->end_date = '';
		$this->school = '';
		$this->user_id = '';
		$this->is_present = '';
		
		$this->table = TBL_EDUCATION;
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
    if($this->degree == '')
		$error .= '&nbsp;&bull;&nbsp;Degree cannot be left blank.<br>';
    if($this->start_date == '')
		$error .= '&nbsp;&bull;&nbsp;Start Date cannot be left blank.<br>';
    if($this->end_date == '' && $this->is_present == '')
		$error .= '&nbsp;&bull;&nbsp;Enter either End Date or check present .<br>';
		
		
		return $error;
	}

	public function validateUpdate()
	{
		$error='';
    if($this->degree == '')
		$error .= '&nbsp;&bull;&nbsp;Degree cannot be left blank.<br>';
    if($this->start_date == '')
		$error .= '&nbsp;&bull;&nbsp;Start Date cannot be left blank.<br>';
    if($this->end_date == '' && $this->is_present == '')
		$error .= '&nbsp;&bull;&nbsp;Enter either End Date or check present .<br>';
		
		
		return $error;
	}

	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		degree = '".hlpMysqlRealScape($this->degree)."', 
		subject = '".hlpMysqlRealScape($this->subject)."', 
		start_date = '".hlpMysqlRealScape($this->start_date)."', 
		end_date = '".md5(hlpMysqlRealScape($this->end_date))."', 
		school = '".hlpMysqlRealScape($this->school)."', 
		is_present = '".hlpMysqlRealScape($this->is_present)."',
		user_id = '".hlpMysqlRealScape($this->user_id)."';";
		
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		degree = '".hlpMysqlRealScape($this->degree)."',
		subject = '".hlpMysqlRealScape($this->subject)."',
		company = '".hlpMysqlRealScape($this->company)."',
		website = '".hlpMysqlRealScape($this->website)."',
		address = '".hlpMysqlRealScape($this->address)."',
		school = '".hlpMysqlRealScape($this->school)."',
		cell = '".hlpMysqlRealScape($this->cell)."',
		city =   '".hlpMysqlRealScape($this->city)."',
		state =  '".hlpMysqlRealScape($this->state)."',
		country = '".hlpMysqlRealScape($this->country)."',
		zipcode = '".hlpMysqlRealScape($this->zipcode)."' WHERE id = ".intval($this->id);
	}

	public function PopulateGrid($pram='*',$whr_clz='')
	{ 
		return "SELECT ".$pram." FROM ".$this->table." WHERE 1=1 ".$whr_clz;
	}

	public function Delete()
	{
		return "DELETE FROM ".$this->table." WHERE id = ".intval($this->id);
	}
	
	public function UpdateStatus()
	{
		return "UPDATE ".$this->table." SET 
		is_present = '".hlpMysqlRealScape($this->is_present)."'
		WHERE id = ".intval($this->id);
	}
	public function UpdateField($col,$val)
	{
		return "UPDATE ".$this->table." SET ".$col." = ".hlpMysqlRealScape($val)." WHERE id = ".intval($this->id);
	}	
	
	public function start_dateExists()
	{
		return 'Select 1 from '.$this->table.'  
		WHERE  start_date	= "'.hlpSafeString($this->start_date, 'char').'" LIMIT 1';
	}
	public function checkLogin()
	{
		return 'Select id, start_date,user_id,degree from '.$this->table.' WHERE is_present=1 AND start_date = "'.$this->start_date.'" AND end_date = "'.md5($this->end_date).'" LIMIT 1';
	}
	


	public function UpdateVarificationCode()
	{
		return 'UPDATE '.$this->table.' SET
				verification_code = "'.hlpSafeString($this->verification_code,'char').'" 
				WHERE start_date = "'.hlpSafeString($this->start_date,'char').'"';
	}
	public function ChangePasswordEmail()
	{
		return 'Update '.$this->table.' SET
		end_date 	="'.md5($this->nend_date).'"
		where start_date 	= '.hlpSafeString($this->start_date,'char').' LIMIT 1';
	}
	public function ChangePassword()
	{
		return 'Update '.$this->table.' SET end_date 	="'.md5($this->nend_date).'" where id 	= '.hlpSafeString($this->id,'int').' LIMIT 1';
	}
	
	public function checkOldPassword()
	{
		return 'Select 1 from '.$this->table.' WHERE end_date	= "'.md5($this->end_date).'" AND id	= '.hlpSafeString($this->id, 'int').' LIMIT 1;';
	}
	
	
	public function addAdminEmail()
	{
		return 'UPDATE '.$this->table.' 
		set start_date    = "'.hlpSafeString($this->start_date).'"
		WHERE id= '.intval($this->id).';';
	}
	

	
	public function UpdatePwdViaEmail()
	{
		return 'UPDATE '.$this->table.' SET
				end_date = "'.md5(hlpSafeString($this->end_date,'char')).'"
				WHERE start_date = "'.hlpSafeString($this->start_date,'char').'"';
	}	

	
	public function userExists()
	{
		return 'Select 1 from '.$this->table.'  
		WHERE user_name	= "'.hlpSafeString($this->user_name, 'char').'" LIMIT 1';
	}
	
	public function PasswordValidate()
	{
		
		$error = '';
		if(!$this->end_date)
			$error .= '&bull;&nbsp;Old Password cannot be left blank.<br />';
		if(!$this->nend_date)
			$error .= '&bull;&nbsp;New end_date cannot be left blank.<br />';
		if(!$this->cend_date)
			$error .= '&bull;&nbsp;Confirm passord cannot be left blank.<br />';	
		
		if($this->nend_date!=$this->cend_date)
			$error .= '&bull;&nbsp;Password mismatch.<br />';
		return $error;
	}

	

}

?>