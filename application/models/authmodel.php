<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class AuthModel extends Gold_Model
{

    function __construct()
    {
        parent::__construct();
    }
    function user_check($acc, $type, $pwd){
    	$sql = "SELECT EPNO, EPNAME, DPNO, GROUPID FROM employ WHERE epno=? AND ident=? AND password=?";
    	$rs = $this->db->query($sql, array($acc, $type, $pwd));
    	$result = $rs->row();
        return (!empty($result)) ? $result:false;
    }
    //增加用戶
    function user_add($data){
    	$sql = $this->sqlinsert('employ', $data);
    	$this->db->query($sql->sql, $sql->value);
    }
    //查詢用戶
    function user_info($data){
        $sql = "SELECT PA_TEMP as PASS, WEBID FROM employ WHERE epno=?";
        $rs =  $this->db->query($sql, $data);
        return $rs->row();
    }
    //更新用戶
    //$update_data, 條件字串, 條件參數 
    function user_update($data, $condition_sql, $condition_value){
    	$col = array();
    	$val = array();
    	foreach ($data as $k => $v) {
    		$col[] = $k."=?";
    		$val[] = trim($v);
    	}
    	$val = array_merge($val, $condition_value);
    	$sql = "UPDATE employ SET ".implode(",", $col)." WHERE ".$condition_sql;
    	$this->db->query($sql, $val);
    }
    //學生端
    function stu_check($acc, $type){
        $sql = "SELECT * FROM stu WHERE stno=? AND ident=?";
        $rs = $this->db->query($sql, array($acc, $type));
        $result = $rs->row();
        $check = (!empty($result)) ? true:false;
        return $check;
    }
    //增加用戶
    function stu_add($data){
        $sql = $this->sqlinsert('stu', $data);
        $this->db->query($sql->sql, $sql->value);
    }
    //查詢用戶
    function stu_info($data){
        $sql = "SELECT PA_TEMP as PASS, WEBID FROM stu WHERE stno=?";
        $rs =  $this->db->query($sql, $data);
        return $rs->row();
    }
    //更新用戶
    //$update_data, 條件字串, 條件參數 
    function stu_update($data, $condition_sql, $condition_value){
        $col = array();
        $val = array();
        foreach ($data as $k => $v) {
            $col[] = $k."=?";
            $val[] = trim($v);
        }
        $val = array_merge($val, $condition_value);
        $sql = "UPDATE stu SET ".implode(",", $col)." WHERE ".$condition_sql;
        $this->db->query($sql, $val);
    }
}