
<?

//for general use;
class sql_queries
{
	var $mysql;
	
	function define_settings()
	{
		/*
		This is where the settings for MySQL and error handling are set.
		This information must be correct or the class will not work.
		
		host: This is the server that mysql is on, leave as localhost in most cases!
		user: The username used for your mysql account.
		pass: The password used for your mysql account.
		db: this is the database you want to connect to, if you will be using more than one, set this to the primary db!
		*/
		
		$this -> mysql['host'] = "localhost"; 
		$this -> mysql['user'] = "root";
		$this -> mysql['pass'] = "zig2na";
		$this -> mysql['db'] = "purc";
		
		/*
		In the event of an error you can output custom messages to the user.
		The first 2 errors will only appear if the script cannot connect,
		the other setting is for general errors.
		*/
				
		$this -> mysql['con_error'] = "<b>MySQL encountered a severe error while trying to connect to the host</b>\n";
		$this -> mysql['db_error'] = "<b>MySQL encountered a severe error while trying to use the database</b>\n";
		$this -> mysql['gen_error'] = "<b>MySQL Error: <b>Due to a database error this page cannot be displayed</b>\n";
		
		/*
		If an error does occur a log file will write the error to file for debugging and error checking.
		Should you wish to put the file in a sub directory, chmod it to 777 along with the file.
		*/
		$this -> mysql['log_file'] = "mysql_errors.log";
	}
	
	// !! DO NOT EDIT PAST THIS POINT !! //
	
	function do_mysql_connect()
	{
		$this -> define_settings();
		
		$mysql_connect = @mysql_pconnect($this -> mysql['host'], $this -> mysql['user'], $this -> mysql['pass']);
		$mysql_database = @mysql_select_db($this -> mysql['db']);
		
		if (!$mysql_connect)
		{
			echo "<br>\n";
			echo $this -> mysql['con_error'];
			
			$sql_class = new sql_queries();
			$sql_error = mysql_error();
			$sql_log = $sql_class -> log_sql_error("mysql_pconnect", $sql_error);
		}
		elseif (!$mysql_database)
		{
			echo "<br>\n";
			echo $this -> mysql['db_error'];
			
			$sql_class = new sql_queries();
			$sql_error = mysql_error();
			$sql_log = $sql_class -> log_sql_error("mysql_select_db", $sql_error);
		}
	}

	function return_sql_rows($sql_code)
	{
		$sql_result = mysql_query($sql_code);
		
		if (!$sql_result)
		{
			$sql_error = mysql_error();
			
			echo "<br>\n";
			echo "<p>".$this -> mysql['gen_error']."</p>\n";
			
			$this -> log_sql_error($sql_code, $sql_error);
			return(false);
		}
		else
		{
			$sql_num_rows = @mysql_num_rows($sql_result);
			return ($sql_num_rows);
		}
	}
	
	function run_sql_query($sql_code)
	{
		$sql_result = @mysql_query($sql_code);
	
		if (!$sql_result)
		{
			$sql_error = mysql_error();
			
			echo "<br>\n";
			echo "<p>".$this -> mysql['gen_error']." <i>".mysql_error()."</p>\n";
			
			$this -> log_sql_error($sql_code, $sql_error);
			return(false);
		}
		else
		{
			return ($sql_result);
		}
	}
	
	function return_sql_array($sql_code)
	{
		$sql_result = @mysql_query($sql_code);
		
		if (!$sql_result)
		{
			$sql_error = mysql_error();
			
			echo "<br>\n";
			echo "<p>".$this -> mysql['gen_error']."</p>\n";
			
			$this -> log_sql_error($sql_code, $sql_error);
			return(false);
		}
		else
		{
			$sql_array = @mysql_fetch_array($sql_result);
			return ($sql_array);
		}
	}
	
	function log_sql_error($sql_code, $sql_error)
	{
		$this -> define_settings();
		
		if ($log_file = fopen($this -> mysql['log_file'], "a"))
		{
			$message = "[".$_SERVER["REMOTE_ADDR"]."] "
			."MySQL query \"$sql_code\" produced this error:  $sql_error";
			
			fwrite($log_file, date("[d-m-Y H:i:s] ") . $message . "\n");
			fclose($log_file);
			exit;
		}
	}
}

?>
	