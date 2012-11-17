<?php

class JobPost
{

	private $id; //int(11)
	private $job_title; //varchar(70)
	private $job_desc; //varchar(70)	
	private $budget; //varchar(70)
	private $media_id; //varchar(70)
	private $last_date; //tinyint(3)
	private $location;
	private $status;
	private $dated;

	public function __construct()
	{
		$this->id='';
		$this->job_title= '';
		$this->job_desc = '';
		$this->last_date = '';
		$this->media_id= '';
		$this->location = '';
		$this->status = '';
		$this->dated = '';
		$this->table = TBL_JOB_POST;
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


	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		job_title = '".hlpMysqlRealScape($this->job_title)."', 
		job_desc = '".hlpMysqlRealScape($this->job_desc)."', 
		budget = '".hlpMysqlRealScape($this->budget)."', 
		media_id = '".hlpMysqlRealScape($this->media_id)."', 
		last_date = '".hlpMysqlRealScape($this->last_date)."', 
		location = '".hlpMysqlRealScape($this->location)."', 
		status = '".hlpMysqlRealScape($this->status)."';";
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		job_title = '".hlpMysqlRealScape($this->job_title)."', 
		job_desc = '".hlpMysqlRealScape($this->job_desc)."', 
		budget = '".hlpMysqlRealScape($this->budget)."', 
		media_id = '".hlpMysqlRealScape($this->media_id)."', 
		last_date = '".hlpMysqlRealScape($this->last_date)."', 
		location = '".hlpMysqlRealScape($this->location)."', 
		status = '".hlpMysqlRealScape($this->status)."' 
		WHERE id = ".intval($this->id);
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
		return "UPDATE ".$this->table." SET status = '".hlpMysqlRealScape($this->status)."'  xWHERE id = ".intval($this->id);
	}
	public function UpdateField($col,$val)
	{
		return "UPDATE ".$this->table." SET ".$col." = ".hlpMysqlRealScape($val)." WHERE id = ".intval($this->id);
	}	
}

?>