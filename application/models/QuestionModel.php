<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//考卷
class QuestionModel extends Gold_Model {

    private $Question_table = 'question';
    private $sel_col = array();
    private $sel_val = array();

    private $cram_col = array();
    private $cram_val = array();

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION)) session_start();
        $this->Set_db($_SESSION['gold']->code);
    }
    //我的題庫列表題數
    function que_rows($data = array(), $keyword){
        $this->sel_col = array();
        $this->sel_val = array();
        $sql_where = '';
        if (!empty($data)){
            foreach ($data as $k => $v) {
                $this->sel_col[] = $k."=?";
                $this->sel_val[] =$v;
            }
        }
        $this->sel_col[] = "QUE_PARENT=?";
        $this->sel_val[] = 0;
        if ($_SESSION['gold']->ident==="A"){
            if (!empty($keyword)){
                $this->sel_col[] = "QUETXT like %?%";
                $this->sel_val[] = $keyword;
            }
            if (!empty($data)){
                $sql = "SELECT COUNT(*) AS row FROM ".$this->Question_table." WHERE ".implode(" AND ", $this->sel_col);
                $rs = $this->db->query($sql, $this->sel_val);
            }else{
                $sql = "SELECT COUNT(*) AS row FROM ".$this->Question_table;
                $rs = $this->db->query($sql);
            }
        }else{
            $this->sel_col[] = "OWNER=?";
            $this->sel_val[] = $_SESSION['gold']->epno;
            if (!empty($keyword)){
                $this->sel_col[] = "QUETXT like ?";
                $this->sel_val[] = '%'.$keyword.'%';
            }
            $sql = "SELECT COUNT(*) AS row FROM ".$this->Question_table." WHERE ".implode(" AND ", $this->sel_col);
            $rs = $this->db->query($sql, $this->sel_val);
        }
        $row = $rs->row();
        return $row->row;
    }
    //我的題庫列表資料
    function que_data($start, $end){
        $this->sel_val[] = $start;
        $this->sel_val[] = $end;
        if ($_SESSION['gold']->ident==="A"){
            if (count($this->sel_col)>0){
                $sql = "SELECT * FROM (
                    SELECT ROW_NUMBER() OVER (ORDER BY UPDATETIME DESC) as row, * FROM ".$this->Question_table." WHERE ".implode(" AND ", $this->sel_col)."
                ) a WHERE row>=? AND ROW<=?";
            }else{
                $sql = "SELECT * FROM (
                    SELECT ROW_NUMBER() OVER (ORDER BY UPDATETIME DESC) as row, * FROM ".$this->Question_table."
                ) a WHERE row>=? AND ROW<=?";
            }
        }else{
            $sql = "SELECT * FROM (
                SELECT ROW_NUMBER() OVER (ORDER BY UPDATETIME DESC) as row, * FROM ".$this->Question_table." WHERE ".implode(" AND ", $this->sel_col)."
            ) a WHERE row>=? AND ROW<=?";
        }
        $rs = $this->db->query($sql, $this->sel_val);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //補習班的題庫題數
    function quecram_rows($data = array(), $keyword){
        $this->cram_col = array();
        $this->cram_val = array();
        $sql_where = '';
        if (!empty($data)){
            foreach ($data as $k => $v) {
                $this->cram_col[] = $k."=?";
                $this->cram_val[] =$v;
            }
        }
        if (!empty($keyword)){
            $this->cram_col[] = "QUETXT like ?";
            $this->cram_val[] = '%'.$keyword.'%';
        }
        $this->cram_col[] = "QUE_PARENT=?";
        $this->cram_val[] = 0;
        if (!empty($data)){
            $sql = "SELECT COUNT(*) AS row FROM ".$this->Question_table." WHERE ".implode(" AND ", $this->cram_col);
            $rs = $this->db->query($sql, $this->cram_val);
        }else{
            $sql = "SELECT COUNT(*) AS row FROM ".$this->Question_table;
            $rs = $this->db->query($sql);
        }
        $row = $rs->row();
        return $row->row;
    }
    // 補習班的題庫資料
    function quecram_data($start, $end){
        $this->cram_val[] = $start;
        $this->cram_val[] = $end;
        if (count($this->cram_col)>0){
            $sql = "SELECT * FROM (
                SELECT ROW_NUMBER() OVER (ORDER BY UPDATETIME DESC) as row, * FROM ".$this->Question_table." WHERE ".implode(" AND ", $this->cram_col)."
            ) a WHERE row>=? AND ROW<=?";
        }else{
            $sql = "SELECT * FROM (
                SELECT ROW_NUMBER() OVER (ORDER BY UPDATETIME DESC) as row, * FROM ".$this->Question_table."
            ) a WHERE row>=? AND ROW<=?";
        }
        $rs = $this->db->query($sql, $this->cram_val);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //瀏覽單題
    function view_que($data){
        $sql = "SELECT TOP 1 * FROM ".$this->Question_table." WHERE QID=?";
        $rs = $this->db->query($sql, $data);
        $result = $rs->row();
        return (!empty($result)) ? $result:null;
    }
    // 瀏覽題組小題
    function view_que_sub($qid){
        $sql = "SELECT * FROM ".$this->Question_table." WHERE QUE_PARENT=?";
        $rs = $this->db->query($sql, array($qid));
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //建立題目
    function create_que($data){
        $sql = $this->sqlinsert($this->Question_table, $data);
        $this->db->query($sql->sql, $sql->value);
    }
    // 編輯題目
    function update_que($id, $data){
        $col = array();
        $value = array();
        foreach ($data as $k => $v) {
            $col[] = $k.'=?';
            $value[] = $v;
        }
        $value[] = $id;
        $sql = "UPDATE ".$this->Question_table." SET ".implode(",", $col)." WHERE QID=?";
        $this->db->query($sql, $value);
    }
    //建立群組題目
    function create_queg($data){
        $sql = $this->sqlinsert($this->Question_table, $data);
        $this->db->query($sql->sql, $sql->value);
        $id = $this->db->insert_id();
        return $id;
    }
}