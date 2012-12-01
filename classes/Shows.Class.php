<?php

class Shows
{

	private $id; //int(11)
	private $show_name; //varchar(70)
	private $show_duration; //varchar(70)
	private $show_cost; 
	private $show_time; 
	private $show_date; 
	private $media_type_id;
	private $user_id; 
	private $status;
	private $dated; 
	

	public function __construct()
	{
	$this->id = ''; //int(11)
	$this->show_name = ''; 
	$this->show_duration = ''; //in minutes
	$this->show_cost = ''; // per minute
	$this->show_time = ''; 
	$this->show_date = ''; 
	$this->media_type_id = ''; 
	$this->user_id = ''; 
	$this->status = '';
	$this->dated = ''; 
		
		
		$this->table = TBL_SHOWS;
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
    if($this->show_name == '')
		$error .= '&nbsp;&bull;&nbsp;Show Name cannot be left blank.<br>';
    if($this->show_date == '')
		$error .= '&nbsp;&bull;&nbsp;Show Date cannot be left blank.<br>';
    if($this->show_time == '')
		$error .= '&nbsp;&bull;&nbsp;Show Date cannot be left blank.<br>';
		
		
		return $error;
	}

	public function validateUpdate()
	{
		$error='';
    if($this->show_name == '')
		$error .= '&nbsp;&bull;&nbsp;Show Name cannot be left blank.<br>';
    if($this->show_date == '')
		$error .= '&nbsp;&bull;&nbsp;Show Date cannot be left blank.<br>';
    if($this->show_time == '')
		$error .= '&nbsp;&bull;&nbsp;Show Date cannot be left blank.<br>';
		
		
		return $error;
	}

	public function Add()
	{
		return "INSERT INTO ".$this->table." SET 
		show_name = '".hlpMysqlRealScape($this->show_name)."', 
		show_duration = '".hlpMysqlRealScape($this->show_duration)."', 
		show_cost = '".hlpMysqlRealScape($this->show_cost)."', 
		show_time = '".hlpMysqlRealScape($this->show_time)."', 
		show_date = '".hlpMysqlRealScape($this->show_date)."', 
		media_type_id = '".hlpMysqlRealScape($this->media_type_id)."', 
		show_description = '".hlpMysqlRealScape($this->show_description)."', 
		user_id = '".hlpMysqlRealScape($this->user_id)."';";
		
	}
	public function Update()
	{
		return "UPDATE ".$this->table." SET 
		show_name = '".hlpMysqlRealScape($this->show_name)."', 
		show_duration = '".hlpMysqlRealScape($this->show_duration)."', 
		show_cost = '".hlpMysqlRealScape($this->show_cost)."', 
		show_time = '".hlpMysqlRealScape($this->show_time)."', 
		show_date = '".hlpMysqlRealScape($this->show_date)."', 
		media_type_id = '".hlpMysqlRealScape($this->media_type_id)."', 
		show_description = '".hlpMysqlRealScape($this->show_description)."', 
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