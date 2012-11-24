<?php

class JobApplication
{

	private $id; //int(11)
	private $job_id; //varchar(70)
	private $user_id; //varchar(70)	
	private $user_cover_letter; //varchar(70)
	private $user_rate; //varchar(70)
	private $status;
	private $agree;
	private $dated;

	public function __construct()
	{
		$this->id='';
		$this->job_id= '';
		$this->user_id = '';
		$this->user_cover_letter = '';
		$this->user_rate= '';
		$this->status = '';
		$this->agree = 'off';
		$this->dated = '';
		$this->table = TBL_JOB_APP;
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
		if($this->user_rate == '')
			$error .= '&nbsp;&bull;&nbsp;Your rate cannot be left blank..<br>';
		if($this->user_cover_letter == '')
			$error .= '&nbsp;&bull;&nbsp;Cover Letter cannot be left blank.<br>';
		if($this->agree=='off')
			$error .= '&nbsp;&bull;&nbsp;Please agree upon term and condition.<br>';		
			
		return $error;
	}


	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		job_id = '".hlpMysqlRealScape($this->job_id)."', 
		user_id = '".hlpMysqlRealScape($this->user_rate)."', 
		user_cover_letter = '".hlpMysqlRealScape($this->user_cover_letter)."', 
		user_rate = '".hlpMysqlRealScape($this->user_rate)."', 
		status = '".hlpMysqlRealScape($this->status)."';";
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		job_id = '".hlpMysqlRealScape($this->job_id)."', 
		user_id = '".hlpMysqlRealScape($this->user_rate)."', 
		user_cover_letter = '".hlpSafeString(hlpMysqlRealScape($this->user_cover_letter))."', 
		user_rate = '".hlpMysqlRealScape($this->user_rate)."', 
		status = '".hlpMysqlRealScape($this->status)."
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