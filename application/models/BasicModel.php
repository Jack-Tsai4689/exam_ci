<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//考卷
class BasicModel extends Gold_Model {

    private $Basic_table = 'gsc';

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION)) session_start();
        $this->Set_db($_SESSION['gold']->code);
    }
    //列年級
    function get_grade(){
        $sql = "SELECT ID, NAME, OWNER, UPDATETIME FROM ".$this->Basic_table." WHERE GRAID=0 AND SUBJID=0;";
        $rs = $this->db->query($sql);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //列科目
    function get_subject($data){
        $sql = "SELECT ID, NAME, OWNER, UPDATETIME FROM ".$this->Basic_table." WHERE GRAID=? AND SUBJID=0;";
        $rs = $this->db->query($sql, $data);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //列章節
    function get_chapter($data){
        $sql = "SELECT ID, NAME, OWNER, UPDATETIME FROM ".$this->Basic_table." WHERE GRAID=? AND SUBJID=?;";
        $rs = $this->db->query($sql, $data);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //建資料
    function add_gsc($data){
        $sql = $this->sqlinsert($this->Basic_table, $data);
        $rs = $this->db->query($sql->sql, $sql->value);
        return $rs;
    }
    //更新
    function upd_gsc($data){
        $sql = "UPDATE ".$this->Basic_table." SET NAME=? WHERE ID=?;";
        $this->db->query($sql, $data);
    }
    //單一年級、科目
    function get_onegsc($data){
        $sql = "SELECT TOP 1 NAME FROM ".$this->Basic_table." WHERE ID=?";
        $rs = $this->db->query($sql, $data);
        return $rs->row();
    }
}