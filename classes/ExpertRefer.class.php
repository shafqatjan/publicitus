<?php

class ExpertRefer
{

	private $id; //int(11)
	private $prifile_id; //varchar(255)
	private $job_id;
	private $user_id;
	private $status;
	private $dated;
	private $table;

	public function __construct()
	{
		$this->id = '';
		$this->profile_id = '';
		$this->job_id = '';
		$this->user_id = '';
		$this->status = '';
		$this->dated = '';
		$this->table = TBL_EXPERTREFER;
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
		$error = '';
		if(!$this->profile_id)
			$error .= '&nbsp;&bull;&nbsp;Profile cannot be left blank.<br />';
		return $error;
	}	

	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		profile_id = '".hlpMysqlRealScape($this->profile_id)."',
		job_id = '".hlpMysqlRealScape($this->job_id)."',
		user_id = '".hlpMysqlRealScape($this->user_id)."',
		status = '".hlpMysqlRealScape($this->status)."';";
	}

	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		profile_id = '".hlpMysqlRealScape($this->profile_id)."',
		job_id = '".hlpMysqlRealScape($this->job_id)."',
		user_id = '".hlpMysqlRealScape($this->user_id)."',
		status = '".hlpMysqlRealScape($this->status)."'
		WHERE id = ".intval($this->id);
	}

	public function PopulateGrid($params = '*', $whr_clz='')
	{
		return 'SELECT '.$params.' FROM '.$this->table.' WHERE 1=1 '.$whr_clz;
	}

	public function Delete()
	{
		return "DELETE FROM ".$this->table." WHERE id = ".intval($this->id);
	}
	public function statusUpdate()
	{
		return "UPDATE ".$this->table." SET 
		status = '".hlpMysqlRealScape($this->status)."'
		WHERE id = ".intval($this->id);
	}	
}

?>