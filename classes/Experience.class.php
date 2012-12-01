<?php

class Experience
{

	private $id; 
	private $job_title;
	private $company; 
	private $start_date;
	private $end_date; 
	private $job_description;
	private $is_present;
	private $user_id;
	private $status;
	private $dated; 
	

	public function __construct()
	{
		$this->id='';
		$this->job_title = '';
		$this->company = '';
		$this->start_date = '';
		$this->end_date = '';
		$this->job_description = '';
		$this->user_id = '';
		$this->is_present = '';
		$this->status = '';
		$this->dated = '';
		
		$this->table = TBL_EXPERIENCE;
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
    if($this->job_title == '')
		$error .= '&nbsp;&bull;&nbsp;Job Title cannot be left blank.<br>';
    if($this->company == '')
		$error .= '&nbsp;&bull;&nbsp;Company cannot be left blank.<br>';
		
		return $error;
	}

	public function validateUpdate()
	{
		$error='';
    if($this->job_title == '')
		$error .= '&nbsp;&bull;&nbsp;Job Title cannot be left blank.<br>';
    if($this->company == '')
		$error .= '&nbsp;&bull;&nbsp;Company cannot be left blank.<br>';
		
		
		return $error;
	}

	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		job_title = '".hlpMysqlRealScape($this->job_title)."', 
		company = '".hlpMysqlRealScape($this->company)."', 
		start_month = '".hlpMysqlRealScape($this->start_month)."', 
		end_month = '".hlpMysqlRealScape($this->end_month)."', 
		start_year = '".hlpMysqlRealScape($this->start_year)."', 
		end_year = '".hlpMysqlRealScape($this->end_year)."', 
		job_description = '".hlpMysqlRealScape($this->job_description)."', 
		user_id = '".hlpMysqlRealScape($this->user_id)."';";
		
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		job_title = '".hlpMysqlRealScape($this->job_title)."',
		company = '".hlpMysqlRealScape($this->company)."',
		start_month = '".hlpMysqlRealScape($this->start_month)."', 
		end_month = '".hlpMysqlRealScape($this->end_month)."', 
		start_year = '".hlpMysqlRealScape($this->start_year)."', 
		end_year = '".hlpMysqlRealScape($this->end_year)."', 
		job_description = '".hlpMysqlRealScape($this->job_description)."', 
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
	
		
	
}

?>