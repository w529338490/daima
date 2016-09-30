<?php
/*
凤鸣山中小学网络办公室
*/

error_reporting(7);
// db class for mysql
// this class is used in all scripts
// do NOT fiddle unless you know what you are doing

class FMysql {
	//DB SET
	public  $database = "";
	public  $server   = "localhost";
	public  $user     = "root";
	public  $password = "";
	public  $usepconnect=0;

	private $link_id  = 0;
	private $query_id = 0;
	private $record   = array();

	private  $errdesc = "";
	private  $errno   = 0;
	private  $reporterror = 1;
	//connect
	public  function connect() {
		// connect to db server
		if ( 0 == $this->link_id ) {
			if ($this->password=="") {
				if ($this->usepconnect==1) {
					$this->link_id=mysql_pconnect($this->server,$this->user);
				} else {
					$this->link_id=mysql_connect($this->server,$this->user);
				}
			} else {
				if ($this->usepconnect==1) {
					$this->link_id=mysql_pconnect($this->server,$this->user,$this->password);
				} else {
					$this->link_id=mysql_connect($this->server,$this->user,$this->password);
				}
			}
			if (!$this->link_id) {
				$this->halt("Link-ID == 错误，连接失败");
			}
			if ($this->database!="") {
				if(!mysql_select_db($this->database, $this->link_id)) {
					$this->halt("无法使用数据库 ".$this->database);
				}
			}
		}
	}
	//select db
	public function select_db($database="") {
		// select database
		if ($database!="") {
			$this->database=$database;
		}

		if(!mysql_select_db($this->database, $this->link_id)) {
			$this->halt("无法使用数据库 ".$this->database);
		}
	}
	//query
	public function query($query_string) {
		// do query
		$this->query_id = mysql_query($query_string,$this->link_id);
		if (!$this->query_id) {
			$this->halt("无效的SQL: ".$query_string);
		}
		return $this->query_id;
	}
	//get result array
	public function fetch_array($query_id=-1,$query_string="") {
		// retrieve row
		if ($query_id!=-1) {
			$this->query_id=$query_id;
		}
		if ( isset($this->query_id) ) {
			$this->record = mysql_fetch_array($this->query_id);
		} else {
			if ( !empty($query_string) ) {
				$this->halt("无效的查询ID号 (".$this->query_id.") 在此查询中: $query_string");
			} else {
				$this->halt("指定了无效的查询ID号 ".$this->query_id."");
			}
		}

		return $this->record;
	}
	public function affected_rows() {
		return mysql_affected_rows();
	}
	public function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}
	public function free_result($query_id=-1) {
		// retrieve row
		if ($query_id!=-1) {
			$this->query_id=$query_id;
		}
		return @mysql_free_result($this->query_id);
	}
	//get record
	public function query_first($query_string) {
		// does a query and returns first row
		$query_id = $this->query($query_string);
		$returnarray=$this->fetch_array($query_id, $query_string);
		$this->free_result($query_id);
		return $returnarray;
	}
	public function data_seek($pos,$query_id=-1) {
		// goes to row $pos
		if ($query_id!=-1) {
			$this->query_id=$query_id;
		}
		return mysql_data_seek($this->query_id, $pos);
	}
	public function num_rows($query_id=-1) {
		// returns number of rows in query
		if ($query_id!=-1) {
			$this->query_id=$query_id;
		}
		return mysql_num_rows($this->query_id);
	}
	public function num_fields($query_id=-1) {
		// returns number of fields in query
		if ($query_id!=-1) {
			$this->query_id=$query_id;
		}
		return mysql_num_fields($this->query_id);
	}
	//insert id
	public function insert_id() {
		// returns last auto_increment field number assigned
		return mysql_insert_id($this->link_id);
	}
	// close
	public function close() {
		// closes connection to the database
		return mysql_close();
	}
	//get error
	public function geterrdesc() {
		$this->error=mysql_error();
		return $this->error;
	}
	public function geterrno() {
		$this->errno=mysql_errno();
		return $this->errno;
	}
	//halt
	public function halt($msg) {
		$this->errdesc=mysql_error();
		$this->errno=mysql_errno();
		// prints warning message when there is an error
		if ($this->reporterror==1) {
			$message="数据库发生错误:\n\n$msg\n";
			$message.="mysql数据库错误: " . $this->errdesc . "\n\n";
			$message.="mysql数据库错误号: " . $this->errno . "\n\n";
			$message.="时间: ".date("l dS of F Y h:i:s A")."\n";
			echo "<html><head><title>数据库错误</title><style>P,BODY{FONT-FAMILY:MS Shell Dlg,Tahoma,sans-serif,宋体;FONT-SIZE:12px;}</style><body>\n\n<!-- $message -->\n\n";
			echo "</table></td></tr></table></form>\n<blockquote><p>&nbsp;</p><p><b>看起来在 数据库中发生了一些小错误。</b><br>\n";
			echo "请重试并点击浏览器的 <a href=\"javascript:window.location=window.location;\">刷新</a>按钮。</p>";
			echo "一封邮件已经发送到技术支持信箱</a>，如果问题仍然存在，你也可以直接联系管理员。</p>";
			echo "<p>对此我们感到非常抱歉。</p>";
			echo "</blockquote></body></head></html>";
			exit;
		}
	}
}
?>