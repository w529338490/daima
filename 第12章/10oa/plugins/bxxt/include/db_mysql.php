<?php
/*
凤鸣山中小学校网络办公室
*/
error_reporting(7);
// db class for mysql
// this class is used in all scripts
// do NOT fiddle unless you know what you are doing

class DB_Sql_vb {
  var $database = "";

  var $link_id  = 0;
  var $query_id = 0;
  var $record   = array();

  var $errdesc    = "";
  var $errno   = 0;
  var $reporterror = 1;

  var $server   = "localhost";
  var $user     = "root";
  var $password = "";

  var $appname  = "vBulletin";
  var $appshortname = "vBulletin (cp)";

  function connect() {
    global $usepconnect;
    // connect to db server

    if ( 0 == $this->link_id ) {
      if ($this->password=="") {
        if ($usepconnect==1) {
          $this->link_id=mysql_pconnect($this->server,$this->user);
        } else {
          $this->link_id=mysql_connect($this->server,$this->user);
        }
      } else {
        if ($usepconnect==1) {
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

  function geterrdesc() {
    $this->error=mysql_error();
    return $this->error;
  }

  function geterrno() {
    $this->errno=mysql_errno();
    return $this->errno;
  }

  function select_db($database="") {
    // select database
    if ($database!="") {
      $this->database=$database;
    }

    if(!mysql_select_db($this->database, $this->link_id)) {
      $this->halt("无法使用数据库 ".$this->database);
    }

  }

  function query($query_string) {
    global $query_count,$showqueries,$explain,$querytime;
    // do query

    if ($showqueries) {
      echo "查询: $query_string\n";

      global $pagestarttime;
      $pageendtime=microtime();
      $starttime=explode(" ",$pagestarttime);
      $endtime=explode(" ",$pageendtime);

      $beforetime=$endtime[0]-$starttime[0]+$endtime[1]-$starttime[1];

      echo "在此时之前: $beforetime\n";
    }

    $this->query_id = mysql_query($query_string,$this->link_id);
    if (!$this->query_id) {
      $this->halt("无效的SQL: ".$query_string);
    }

    $query_count++;

    if ($showqueries) {
      $pageendtime=microtime();
      $starttime=explode(" ",$pagestarttime);
      $endtime=explode(" ",$pageendtime);

      $aftertime=$endtime[0]-$starttime[0]+$endtime[1]-$starttime[1];
      $querytime+=$aftertime-$beforetime;

      echo "在此时之后:  $aftertime\n";

      if ($explain and substr(trim(strtoupper($query_string)),0,6)=="SELECT") {
        $explain_id = mysql_query("EXPLAIN $query_string",$this->link_id);
        echo "</pre>\n";
        echo "
        <table width=100% border=1 cellpadding=2 cellspacing=1>
        <tr>
          <td><b>table</b></td>
          <td><b>type</b></td>
          <td><b>possible_keys</b></td>
          <td><b>key</b></td>
          <td><b>key_len</b></td>
          <td><b>ref</b></td>
          <td><b>rows</b></td>
          <td><b>Extra</b></td>
        </tr>\n";
        while($array=mysql_fetch_array($explain_id)) {
          echo "
          <tr>
            <td>$array[table]&nbsp;</td>
            <td>$array[type]&nbsp;</td>
            <td>$array[possible_keys]&nbsp;</td>
            <td>$array[key]&nbsp;</td>
            <td>$array[key_len]&nbsp;</td>
            <td>$array[ref]&nbsp;</td>
            <td>$array[rows]&nbsp;</td>
            <td>$array[Extra]&nbsp;</td>
          </tr>\n";
        }
        echo "</table>\n<BR><hr>\n";
        echo "\n<pre>";
      } else {
        echo "\n<hr>\n\n";
      }
    }

    return $this->query_id;
  }

  function fetch_array($query_id=-1,$query_string="") {
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
  	function affected_rows() {
		return mysql_affected_rows();
	}
	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}
  function free_result($query_id=-1) {
    // retrieve row
    if ($query_id!=-1) {
      $this->query_id=$query_id;
    }
    return @mysql_free_result($this->query_id);
  }

  function query_first($query_string) {
    // does a query and returns first row
    $query_id = $this->query($query_string);
    $returnarray=$this->fetch_array($query_id, $query_string);
    $this->free_result($query_id);
    return $returnarray;
  }

  function data_seek($pos,$query_id=-1) {
    // goes to row $pos
    if ($query_id!=-1) {
      $this->query_id=$query_id;
    }
    return mysql_data_seek($this->query_id, $pos);
  }

  function num_rows($query_id=-1) {
    // returns number of rows in query
    if ($query_id!=-1) {
      $this->query_id=$query_id;
    }
    return mysql_num_rows($this->query_id);
  }

  function num_fields($query_id=-1) {
    // returns number of fields in query
    if ($query_id!=-1) {
      $this->query_id=$query_id;
    }
    return mysql_num_fields($this->query_id);
  }

  function insert_id() {
    // returns last auto_increment field number assigned

    return mysql_insert_id($this->link_id);

  }

  function close() {
  	// closes connection to the database

	return mysql_close();
  }

  function halt($msg) {
    $this->errdesc=mysql_error();
    $this->errno=mysql_errno();
    // prints warning message when there is an error
    global $technicalemail, $bbuserinfo, $scriptpath, $HTTP_SERVER_VARS;

    if ($this->reporterror==1) {
      $message="在" . $this->appname . " $GLOBALS[templateversion]里数据库发生错误:\n\n$msg\n";
      $message.="mysql数据库错误: " . $this->errdesc . "\n\n";
      $message.="mysql数据库错误号: " . $this->errno . "\n\n";
      $message.="时间: ".date("l dS of F Y h:i:s A")."\n";
      $message.="脚本: $GLOBALS[bburl]" . (($scriptpath) ? $scriptpath : $HTTP_SERVER_VARS['REQUEST_URI']) . "\n";
      $message.="涉及: ".$HTTP_SERVER_VARS['HTTP_REFERER']."\n";

      if ($technicalemail) {
        @mail ($technicalemail,$this->appshortname. " 数据库发生错误！",$message,"From: $technicalemail");
      }

      echo "<html><head><title>$GLOBALS[bbtitle]数据库错误</title><style>P,BODY{FONT-FAMILY:MS Shell Dlg,Tahoma,sans-serif,宋体;FONT-SIZE:12px;}</style><body>\n\n<!-- $message -->\n\n";

      echo "</table></td></tr></table></form>\n<blockquote><p>&nbsp;</p><p><b>看起来在 $GLOBALS[bbtitle] 数据库中发生了一些小错误。</b><br>\n";
      echo "请重试并点击浏览器的 <a href=\"javascript:window.location=window.location;\">刷新</a>按钮。</p>";
      echo "一封邮件已经发送到<a href=\"mailto:$technicalemail\">技术支持信箱</a>，如果问题仍然存在，你也可以直接联系管理员。</p>";
      echo "<p>对此我们感到非常抱歉。</p>";

      if ($bbuserinfo['usergroupid']==6) {
        echo "<form><textarea rows=\"12\" cols=\"60\">".htmlspecialchars($message)."</textarea></form>";
      }

	  echo "</blockquote></body></head></html>";
      exit;
    }
  }
}
?>