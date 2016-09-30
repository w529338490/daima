<? include dirname(__FILE__)."/../Configuration.php"?>
<?php

class db_driver {

	
                     
                     
     var $query_id      = "";
     var $connection_id = "";
     var $query_count   = 0;
     var $record_row    = array();
     var $return_die    = 0;
     var $error         = "";
	 var $record_object = array();	 
	
                  
    /*========================================================================*/
    // Connect to the database                 
    /*========================================================================*/  
                   
    function connect() { 
		global $mysqlhost,$mysqluser,$mysqlpwd,$mysqldb;
    	if ($this->obj['persistent'])
    	{
    	    $this->connection_id = mysql_pconnect( $mysqlhost , $mysqluser ,$mysqlpwd );
        }
        else
        {
			$this->connection_id = mysql_connect( $mysqlhost ,$mysqluser ,$mysqlpwd);
		}
		
        if ( !mysql_select_db($mysqldb, $this->connection_id) )
        {
            echo ("ERROR: Cannot find database ".$mysqldb);
        }
    }
    
    
    /*========================================================================*/
    // Process a query
    /*========================================================================*/
    
    function query($the_query) {
    	
        $this->query_id = mysql_query($the_query, $this->connection_id);
      
        if (! $this->query_id )
        {
            $this->fatal_error("mySQL query error: $the_query");
        }
        return $this->query_id;
    }
	
	 /*========================================================================*/
    // Process a query
    /*========================================================================*/
    
    function queryValue($query,$i,$fieldName) {
    	if(mysql_result($query,$i,$fieldName))
		{
        	return mysql_result($query,$i,$fieldName);
		}
		else
		{
        	return "";
		}
    }
   
    
    /*========================================================================*/
    // Fetch a row based on the last query
    /*========================================================================*/
    
    function fetch_row($query_id = "") {
    
    	if ($query_id == "")
    	{
    		$query_id = $this->query_id;
    	}
    	
        $this->record_row = mysql_fetch_array($query_id, MYSQL_ASSOC);
        
        return $this->record_row;
        
    }
	
	function getRow($sql){
		$res=mysql_query($sql,$this->connection_id);//resourse
		if(!$res){
			echo mysql_error();
		return;
		}
		$result=mysql_fetch_array($res,MYSQL_ASSOC);
		return $result;
	}
	
	/*========================================================================*/
    // Fetch a row based on the last query
    /*========================================================================*/
    
    function fetch_object($query_id = "") {
        return mysql_fetch_object($query_id) ;
    }
	
	/*========================================================================*/
    // Fetch a row based on the last query
    /*========================================================================*/
	
	function getAll($sql,$gettype=MYSQL_ASSOC){
		$result = array();
		$this->query_id=mysql_query($sql, $this->connection_id);
		if (! $this->query_id )
        {
            $this->fatal_error("mySQL query error: $the_query");
        }
		while($row=mysql_fetch_array($this->query_id,$gettype)){
			$result[]=$row;	
		}
		return $result;
	}

	/*========================================================================*/
    // Fetch the number of rows affected by the last query
    /*========================================================================*/
    
    function get_affected_rows() {
        return mysql_affected_rows($this->connection_id);
    }
    
    /*========================================================================*/
    // Fetch the number of rows in a result set
    /*========================================================================*/
    
    function get_num_rows() {
        return mysql_num_rows($this->query_id);
    }
    
    /*========================================================================*/
    // Fetch the last insert id from an sql autoincrement
    /*========================================================================*/
    
    function get_insert_id() {
        return mysql_insert_id($this->connection_id);
    }  
    
    /*========================================================================*/
    // Return the amount of queries used
    /*========================================================================*/
    
    function get_query_cnt() {
        return $this->query_count;
    }
    
    /*========================================================================*/
    // Free the result set from mySQLs memory
    /*========================================================================*/
    
    function free_result($query_id="") {
    
   		if ($query_id == "") {
    		$query_id = $this->query_id;
    	}
    	
    	@mysql_free_result($query_id);
    }
    
    /*========================================================================*/
    // Shut down the database
    /*========================================================================*/
    
    function close_db() { 
        return mysql_close($this->connection_id);
    }
    
    /*========================================================================*/
    // Return an array of tables
    /*========================================================================*/
    
    function get_table_names() {
    
		$result     = mysql_list_tables($this->obj['sql_database']);
		$num_tables = @mysql_numrows($result);
		for ($i = 0; $i < $num_tables; $i++)
		{
			$tables[] = mysql_tablename($result, $i);
		}
		
		mysql_free_result($result);
		
		return $tables;
   	}
   	
   	/*========================================================================*/
    // Return an array of fields
    /*========================================================================*/
    
    function get_result_fields($query_id="") {
    
   		if ($query_id == "")
   		{
    		$query_id = $this->query_id;
    	}
    
		while ($field = mysql_fetch_field($query_id))
		{
            $Fields[] = $field;
		}
		
		//mysql_free_result($query_id);
		
		return $Fields;
   	}
    
    /*========================================================================*/
    // Basic error handler
    /*========================================================================*/
    
    function fatal_error($the_error) {
    	// Are we simply returning the error?
    	
    	if ($this->return_die == 1)
    	{
    		$this->error = mysql_error();
    		return TRUE;
    	}
    }
 }

 $db=new db_driver();
 $db->connect();
 $db->query("set names utf8"); 
 $sql="select * from  ".$TableConfig."  where id=1";
 $config_row=$db->getRow($sql);

?>