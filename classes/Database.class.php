<?php

class Database
{
	var $rs;
	var $dbh;
	
	function Database()
	{
		$this->rs = "";
		$this->dbh = "";
	}
		
	function select_db ()
	{
     	return mysql_select_db(DB_NAME);
	}
	    
	//Connect to Database
	function connect ()
	{
     $this->dbh = mysql_connect(DB_HOST, DB_USER, DB_PASS) or  die('connection_error');
	  $this->select_db();
		return $this->dbh;
    }	
    
	//Query Database and Return Resource (For Selection Purpose)
	function query($sql)
	{
		$this->rs = mysql_query($sql,$this->dbh) or die(mysql_error());
		if($this->rs)
			return true;
		else
			return false;
	}
		
	//Query Database and Return True/False (For Insert/Update/Delete)
	function execute($sql)
	{
		if(mysql_query($sql,$this->dbh))
			return true;
		else
			return false;
	}
	
	function getArraySingle($sql)
	{ 
		$rs = array();
		if($this->query($sql) and $this->get_num_rows()>0)
			$rs = $this->fetch_row_assoc();

		return $rs;
	}
	
	function getArray($sql)
	{
		$rs = array();
		if($this->query($sql) and $this->get_num_rows()>0)
		{
			for($i=0;$i<$this->get_num_rows();$i++)
			{
				$row = $this->fetch_row_assoc();
				array_push($rs,$row);
			}
		}
		return $rs;
	}
	
	//Fetch Single Record
	function fetch_row()
	{
		return mysql_fetch_row($this->rs);
	}	
		
	function fetch_row_assoc()
	{
		return mysql_fetch_assoc($this->rs);
	}
		
	//Fetch All Records
	function fetch_all()
	{
		$ret= array();
		$num = $this->get_num_rows();
		
		for($i=0;$i<$num;$i++)
		{
			array_push($ret,$this->fetch_row());
		}		
		return $ret;
	}
		
	//Fetch Number of Rows Returned
	function get_num_rows()
	{
		if($this->rs)
			return mysql_num_rows($this->rs);
		else
			return 0;
	}
	
	//Move in Rows One by One
	function move_to_row($num)
	{
		if($num>=0 && $this->rs)
		{
			return mysql_data_seek($this->rs,$num);
		}
		return 1;
	}											
	
	//Fetch Number of Columns.
	function get_num_columns()
	{
		return mysql_num_fields($this->rs);
	}
	
	//Fetch Column Names					
	function get_column_names()
	{
		$nofields= mysql_num_fields($this->rs);
		$fieldnames=array();
		
		for($k=0;$k<$nofields;$k++)
		{
			array_push($fieldnames,mysql_field_name($this->rs,$k));
		}
		return $fieldnames;
	}			
		
	//Fetch Last Error Produced by MySql (Use for debuging purpose)
	function debug ()
	{
    	echo mysql_errno().": ". mysql_error ()."";
   	}
   	
	//Fetch MySql Recent Inserted Id
   	function insert_id ()
	{
    	return mysql_insert_id($this->dbh);
    }
    
	//Fetch MySql Error
	function mysqlError()
	{
		return mysql_error($this->dbh);
	}
		
    //Fetch Records as an Array    	
    function fetch_array ($res) 
	{
    	return mysql_fetch_array ($res);        
    }
    
	//Fetch all record as an Associative Array
    function fetch_all_assoc()
	{
		$ret= array();
		while ($row = mysql_fetch_assoc($this->rs)) 
		{
			array_push($ret,$row);
		}					
		return $ret;
	}
		
	//Fetch single record as an Associative Array
	function fetch_one_assoc()
	{
		$ret= array();
		$ret = mysql_fetch_assoc($this->rs);
		return $ret;
	}
							
	//Fetch one cell from given query
	function executeScalar($sql)
	{
		$this->query($sql);
		$row = $this->fetch_row();
		return $row[0];
	}
	
	//Fetch 2 cell from given query
	function  executeTwise($sql)
	{
		$this->query($sql);
		$row = $this->fetch_row();
		$temp = array();
		
		$temp[0] =  $row[0];
		$temp[1] =  $row[1];
		
		return $temp;
	}
		
	//Fetch 3 cell from given query
	function  executeThrise($sql)
	{
		$this->query($sql);
		$row = $this->fetch_row();
		$temp = array();
		
		$temp[0] =  $row[0];
		$temp[1] =  $row[1];
		$temp[2] =  $row[2];
		
		return $temp;
	}
		
	//Fetch 4 cell from given query
	function  executeFour($sql)
	{
		$this->query($sql);
		$row = $this->fetch_row();
		$temp = array();
		
		$temp[0] =  $row[0];
		$temp[1] =  $row[1];
		$temp[2] =  $row[2];
		$temp[3] =  $row[3];
		return $temp;
	}
	
	function  executeFive($sql)
	{
		$this->query($sql);
		$row = $this->fetch_row();
		$temp = array();
		
		$temp[0] =  $row[0];
		$temp[1] =  $row[1];
		$temp[2] =  $row[2];
		$temp[3] =  $row[3];
		$temp[4] =  $row[4];
		return $temp;
	}
	
	function  executesix($sql)
	{
		$this->query($sql);
		$row = $this->fetch_row();
		$temp = array();
		
		$temp[0] =  $row[0];
		$temp[1] =  $row[1];
		$temp[2] =  $row[2];
		$temp[3] =  $row[3];
		$temp[4] =  $row[4];
		$temp[5] =  $row[5];
		
		return $temp;
	}
	
	function get_record($table,$field = "", $whr_clz, $row_col = 1)
	{
		$res = "";
		$row = "";
		$sql = "";
			
		 $sql = "select ".$field." from ".$table." where ".$whr_clz;
		
		$row = $this->getArraySingle($sql);

		if(!empty($row))
		{
			if($row_col == 1)
				$res = $row[$field];
			else
				$res = $row;
		}
		
		return $res;
	}
	
		function get_field($table,$field,$id,$whr_calues="")
		{
			$rs = "";
			$row = "";
			$sql = "";
			
			if($whr_calues)
			{
				  $sql = "select ".$field." from ".$table." where " . $whr_calues.""; 
			}
			else
			{

				$sql = "select ".$field." from ".$table." where id = ".$id."";				
			}
			
			$row = $this->getArraySingle($sql);
			
			if(!empty($row))
				$rs = $row[$field];
			return $rs;
		
		}
	
	function GetCountSql($table,$whr_clz="")
	{	
		$sql = "select count(*) from ".$table." WHERE 1=1 ".$whr_clz;
		
		$this->query($sql);
		$row = array();
		if($this->get_num_rows()>0)
		{
			$row = $this->fetch_row();
			return $row[0];
		}
		
		return 0;
	}
	
	
	// Increment / Decreament
	function IncDecField($table, $field, $incDec, $whrClz)
	{
		$sql = "";
		$rtnVal = 0;
		
		if($incDec == 1)
			$sql = "UPDATE ".$table." SET ".$field." = ".$field." + 1 WHERE ".$whrClz.";";
		else if($incDec == 0)
			$sql = "UPDATE ".$table." SET ".$field." = ".$field." - 1 WHERE ".$whrClz.";";
		
		if($sql && $this->query($sql))
			$rtnVal = 1;
		
		return $rtnVal;	
	}
	
	function updateField($table,$field,$newValue,$whrClz)
	{
	 echo $sql = "UPDATE ".$table." SET ".$field." = ".$newValue." WHERE ".$whrClz; 
		
		if($this->execute($sql))
			return true;
		else
			return false;	
	}
	
	//Close Database Connection
    function close()
	{
		mysql_close($this->dbh);
	}		
	
}// End of class
?>