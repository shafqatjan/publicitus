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
	private $status;
	private $dated; 
	

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
    if($this->start_date == '')
		$error .= '&nbsp;&bull;&nbsp;Start Date cannot be left blank.<br>';
    if($this->end_date == '' && $this->is_present == '')
		$error .= '&nbsp;&bull;&nbsp;Enter either End Date or check present .<br>';

    if($this->school == '' && $this->school == '')
		$error .= '&nbsp;&bull;&nbsp;School cannot be left blank .<br>';





		
		
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
		start_date = '".hlpMysqlRealScape($this->start_date)."', 
		end_date = '".md5(hlpMysqlRealScape($this->end_date))."', 
		school = '".hlpMysqlRealScape($this->school)."', 
		is_present = '".hlpMysqlRealScape($this->is_present)."',
		user_id = '".hlpMysqlRealScape($this->user_id)."', WHERE id = ".intval($this->id);
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
	
	public function checkOldPassword()
	{
		return 'Select 1 from '.$this->table.' WHERE end_date	= "'.md5($this->end_date).'" AND id	= '.hlpSafeString($this->id, 'int').' LIMIT 1;';
	}
		
	public function degreeExists()
	{
		return 'Select 1 from '.$this->table.'  
		WHERE degree	= "'.hlpSafeString($this->degree, 'char').'" LIMIT 1';
	}
	
}

?>