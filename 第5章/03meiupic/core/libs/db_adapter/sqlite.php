<?php
/**
 * $Id: sqlite.php 13 2010-05-29 16:42:01Z lingter $
 * 
 * @author : Lingter
 * @support : http://www.meiu.cn
 * @copyright : (c)2010 meiu.cn lingter@gmail.com
 */

Class adapter_sqlite{
    /**
     * 数据库请求次数
     *
     * @var Int
     */
    var $query_num = 0;
    /**
     * 数据库连接信息
     *
     * @var Array
     */
    var $dbinfo=null;
    /**
     * 数据库连接句柄
     *
     * @var resource
     */
    var $conn = null;
    /**
     * 最后一次数据库操作的错误信息
     *
     * @var mixed
     */

    var $lasterr = null;
    /**
     * 最后一次数据库操作的错误代码
     *
     * @var mixed
     */
    var $lasterrcode=null;
    /**
     * 指示事务是否启用了事务
     *
     * @var int
     */
    var $_transflag = false;
    /**
     * 启用事务处理情况下的错误
     *
     * @var Array
     */
    var $_transErrors = array();

    function adapter_sqlite($dbinfo){
        if(is_array($dbinfo)){
            $this->dbinfo=$dbinfo;
        }else{
            exit('缺少数据库参数,请检查配置文件!');
        }
    }

    /**
     * 数据库连接
     *
     * @param Array $dbinfo
     * @return boolean
     */
    function connect($dbinfo=false) {
        
        $dbinfo = $dbinfo ? $dbinfo : $this->dbinfo;
        $this->conn=false;
        if(file_exists($dbinfo['dbname'])){
            $this->conn=sqlite_open($dbinfo['dbname']);
            if($this->conn){
                return $this->conn;
            }
        }else{
            exit('Sqlite数据库不存在!');
        }
    }

    /**
     * 关闭数据库连接
     *
     */
    function close() {
        if ($this->conn) {
            sqlite_close($this->conn);
        }
        $this->conn = null;
        $this->lasterr = null;
        $this->lasterrcode = null;
        $this->_transCount = 0;
        $this->_transCommit = true;
    }
    
    function q_field($tableName){
        return $tableName;
    }
    
    function q_str($value){
        if(!$this->conn){
            $this->connect();
        }
        
        if (is_bool($value)) { return $value ? 1:0; }
        if (is_null($value)) { return 'NULL'; }
        
        //return "'".$value."'";
        
        if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
        }
        
        if(phpversion()>='4.0.3'){
        return  "'".sqlite_escape_string($value)."'";
        }else{
        return $value;
        }
    }
    /**
     * 直接查询Sql
     *
     * @param String $SQL
     * @return Mix
     */
    function query($SQL) {
        if(!$this->conn){
            $this->connect();
        }
        
        $query = sqlite_query($SQL, $this->conn);
        $this->query_num++;
        if (!$query){
            $this->lasterr = sqlite_last_error($this->conn);
            $this->lasterrcode = sqlite_error_string($this->conn);
            if($this->_transflag){
                $this->_transErrors[]['sql'] = $sql;
                $this->_transErrors[]['errcode'] = $this->lasterrcode;
                $this->_transErrors[]['err'] = $this->lasterr;
            }else{
                exit('SQL:' . $SQL .' ERROR_INFO:'.$this->lasterrcode.','.$this->lasterr);
                return false;
            }
        }else{
            $this->lasterr = null;
            $this->lasterrcode = null;
            return $query;
        }
    }
    
    function getAll($sql){
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->query($sql);
        }
        
        $data = array();
               while ($row = @sqlite_fetch_array($res,SQLITE_ASSOC)) {
            $data[] = $row;
            }
           
        return $data;
    }
    
    function getOne($sql)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->query($sql);
        }
        $row = @sqlite_fetch_array($res,SQLITE_NUM);
        
        return isset($row[0]) ? $row[0] : null;
    }

    /**
     * 执行查询，返回第一条记录
     *
     * @param string|resource $sql
     *
     * @return mixed
     */
    function getRow($sql)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->query($sql);
        }
        $row = sqlite_fetch_array($res,SQLITE_ASSOC);
        return $row;
    }

    /**
     * 执行查询，返回结果集的指定列
     *
     * @param string|resource $sql
     * @param int $col 要返回的列，0 为第一列
     *
     * @return mixed
     */
    function getCol($sql, $col = 0)
    {
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->query($sql);
        }
        $data = array();
        while ($row = @sqlite_fetch_array($res,SQLITE_NUM)) {
            $data[] = $row[$col];
        }
        return $data;
    }
    
    function getAssoc($sql){
        if (is_resource($sql)) {
            $res = $sql;
        } else {
            $res = $this->query($sql);
        }
        $data = array();
        while ($row = @sqlite_fetch_array($res,SQLITE_NUM)) {
            $data[$row[0]] = $row[1];
        }
        return $data;
    }
    /**
     * 加入边界的查询语句
     *
     * @param String $sql
     * @param Int $length
     * @param Int $offset
     * @return Resource
     */
    function selectLimit($sql, $length = null, $offset = null)
    {
        if ($offset !== null) {
            $sql .= " LIMIT " . (int)$offset;
            if ($length !== null) {
                $sql .= ', ' . (int)$length;
            } else {
                $sql .= ', 4294967294';
            }
        } elseif ($length !== null) {
            $sql .= " LIMIT " . (int)$length;
        }
        return $sql;
    }
    /**
     * 返回数组
     *
     * @param resouce $query
     * @return Array
     */
    function fetchArray($query) {
        return @sqlite_fetch_array($query,SQLITE_ASSOC);
    }
    /**
     * 返回最近一次数据库操作受到影响的记录数
     *
     * @return int
     */
    function affectedRows() {
        return sqlite_changes($this->conn);
    }
    /**
     * 从记录集中返回一行数据
     *
     * @param resouce $query
     *
     * @return array
     */
    function fetchRow($query) {
        return @sqlite_fetch_array($query,SQLITE_ASSOC);
    }

    /**
     * Enter description here...
     *
     * @param resouce $query
     * @return Int
     */
    function numRows($query) {
        if(is_resource($query))
        $rows = @sqlite_num_rows($query);
        else{
            $rows = @sqlite_num_rows($this->query($query));
        }
        return $rows;
    }
    /**
     * 获取当前Sqlite库的版本号
     *
     * @return String
     */
    function version() {
        return sqlite_libversion();
    }
    /**
     * 获得刚插入数据的ID号
     *
     * @return Int
     */
    function insertId() {
        $id = sqlite_last_insert_rowid($this->conn);
        return $id;
    }
     /**
     * 返回数据库可以接受的日期格式
     *
     * @param int $timestamp
     */
    function dbTimeStamp($timestamp)
    {
        return date('Y-m-d H:i:s', $timestamp);
    }
    /**
     * 获得查询数据库的次数
     *
     * @return Int
     */
    function getQueryNum(){
        return $this->query_num;
    }
    function strRandom(){
        return 'RAND()';
    }
    /**
     * 启动事务
     */
    function startTrans()
    {
        $rs = $this->query('BEGIN');
        $this->_transflag = true;
        $this->_transErrors = array();
        return $rs;
    }

    /**
     * 提交事务
     *
     */
    function commit()
    {
        $this->_transflag = false;
        $rs = $this->query('COMMIT');
        return $rs;
    }
    /**
     * 回滚事务
     *
     */
    function rollback(){
        $this->_transflag = false;
        $rs = $this->query('ROLLBACK');
        return $rs;
    }
    
    function transErrors(){
        $errors = $this->_transErrors;
        if(is_array($errors)){
            foreach($errors as $error){
                echo 'SQL:' . $error['sql'] .' ERROR_INFO:'.$error['errcode'].','.$error['err'];
            }
        }
        die();
    }
}
