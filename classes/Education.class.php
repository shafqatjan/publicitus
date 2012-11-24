<?php

class Education
{

	private $id; //int(11)
	private $degree; //varchar(70)
	private $subject; //varchar(70)	
	private $start_month; //varchar(70)
	private $end_month; //varchar(70)
	private $start_year; //varchar(70)
	private $end_year; //varchar(70)
	private $school; //tinyint(3)
	private $edu_description; //int(11)
	private $user_id; //int(11)
	private $status;
	private $dated; 
	

	public function __construct()
	{
		$this->id='';
		$this->degree = '';
		$this->subject = '';
		$this->start_month = '';
		$this->end_month = '';
		$this->start_year = '';
		$this->end_year = '';
		$this->school = '';
		$this->user_id = '';
		$this->edu_description = '';
		$this->status = '';
		$this->dated = '';
		
		
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
    if($this->school == '')
		$error .= '&nbsp;&bull;&nbsp;school cannot be left blank.<br>';
    if($this->subject == '')
		$error .= '&nbsp;&bull;&nbsp;Subject cannot be left blank .<br>';


    if($this->school == '' && $this->school == '')
		$error .= '&nbsp;&bull;&nbsp;School cannot be left blank .<br>';
		return $error;
	}

	public function validateUpdate()
	{
		$error='';
    if($this->degree == '')
		$error .= '&nbsp;&bull;&nbsp;Degree cannot be left blank.<br>';
    if($this->school == '')
		$error .= '&nbsp;&bull;&nbsp;school cannot be left blank.<br>';
    if($this->subject == '')
		$error .= '&nbsp;&bull;&nbsp;Subject cannot be left blank .<br>';		
		return $error;
	}

	public function Add()
	{
		return  "INSERT INTO ".$this->table." SET 
		degree = '".hlpMysqlRealScape($this->degree)."', 
		subject = '".hlpMysqlRealScape($this->subject)."', 
		start_month = '".hlpMysqlRealScape($this->start_month)."', 
		end_month = '".hlpMysqlRealScape($this->end_month)."', 
		start_year = '".hlpMysqlRealScape($this->start_year)."', 
		end_year = '".hlpMysqlRealScape($this->end_year)."', 
		school = '".hlpMysqlRealScape($this->school)."', 
		edu_description = '".hlpMysqlRealScape($this->edu_description)."',
		user_id = '".hlpMysqlRealScape($this->user_id)."';";
		
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		degree = '".hlpMysqlRealScape($this->degree)."',
		subject = '".hlpMysqlRealScape($this->subject)."',
		start_month = '".hlpMysqlRealScape($this->start_month)."', 
		end_month = '".hlpMysqlRealScape($this->end_month)."', 
		start_year = '".hlpMysqlRealScape($this->start_year)."', 
		end_year = '".hlpMysqlRealScape($this->end_year)."', 	
		school = '".hlpMysqlRealScape($this->school)."', 
		edu_description = '".hlpMysqlRealScape($this->edu_description)."' WHERE id = ".intval($this->id);
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
		edu_description = '".hlpMysqlRealScape($this->edu_description)."'
		WHERE id = ".intval($this->id);
	}
	public function UpdateField($col,$val)
	{
		return "UPDATE ".$this->table." SET ".$col." = ".hlpMysqlRealScape($val)." WHERE id = ".intval($this->id);
	}	
	
	public function UpdateVarificationCode()
	{
		return 'UPDATE '.$this->table.' SET
				verification_code = "'.hlpSafeString($this->verification_code,'char').'" 
				WHERE start_month = "'.hlpSafeString($this->start_month,'char').'"';
	}
	public function ChangePasswordEmail()
	{
		return 'Update '.$this->table.' SET
		end_month 	="'.md5($this->nend_month).'"
		where start_month 	= '.hlpSafeString($this->start_month,'char').' LIMIT 1';
	}
	
	public function checkOldPassword()
	{
		return 'Select 1 from '.$this->table.' WHERE end_month	= "'.md5($this->end_month).'" AND id	= '.hlpSafeString($this->id, 'int').' LIMIT 1;';
	}
		
	public function degreeExists()
	{
		return 'Select 1 from '.$this->table.'  
		WHERE degree	= "'.hlpSafeString($this->degree, 'char').'" LIMIT 1';
	}
	
}

?>