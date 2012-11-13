<?php


class UserMedia
{

	private $id; //int(11)
	private $user_id;
	private $media_id;
	private $status;
	private $dated;
	private $table;
	

	public function __construct()
	{
		$this->id='';
		$this->user_id = '';
		$this->media_id = '';
		$this->status = '';
		$this->dated = '';
		$this->table = TBL_USER_MEDIA;
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
		if(!$this->user_id)
			$error .= '&nbsp;&bull;&nbsp;Please select user.</br>';
		if(!$this->media_id)
			$error .= '&nbsp;&bull;&nbsp;Please select media.</br>';
			
		return $error;
	}

	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		user_id = '".hlpMysqlRealScape($this->user_name)."', 
		media_id = '".hlpMysqlRealScape($this->media_id)."', 
		status = '".hlpMysqlRealScape($this->status)."';";
	}

	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		user_id = '".hlpMysqlRealScape($this->user_name)."', 
		media_id = '".hlpMysqlRealScape($this->media_id)."', 
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
		return "UPDATE ".$this->table." SET 
		status = '".hlpMysqlRealScape($this->status)."'
		WHERE id = ".intval($this->id);
	}
	public function UpdateField($col,$val)
	{
		return "UPDATE ".$this->table." SET ".$col." = ".hlpMysqlRealScape($val)." WHERE id = ".intval($this->id);
	}	
	


}

?>