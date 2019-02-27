<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//知識點
class KnowledgeModel extends Gold_Model {

    private $Knowledge_table = 'knowledge';
    private $sel_col = array();
    private $sel_val = array();

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION)) session_start();
        $this->Set_db($_SESSION['gold']->code);
    }
    //列表題數
    function knowledge_rows($data = array(), $keyword){
        $this->sel_col = array();
        $this->sel_val = array();
        if (!empty($data)){
            foreach ($data as $k => $v) {
                $this->sel_col[] = $k."=?";
                $this->sel_val[] =$v;
            }
        }
        if ($_SESSION['gold']->ident==="A"){
            if (!empty($keyword)){
                $this->sel_col[] = "K_NAME like ?";
                $this->sel_val[] = '%'.$keyword.'%';
            }
            if (!empty($data)){
                $sql = "SELECT COUNT(*) AS row FROM ".$this->Knowledge_table." WHERE ".implode(" AND ", $this->sel_col);
                $rs = $this->db->query($sql, $this->sel_val);
            }else{
                $sql = "SELECT COUNT(*) AS row FROM ".$this->Knowledge_table;
                $rs = $this->db->query($sql);
            }
        }else{
            $this->sel_col[] = "K_OWNER=?";
            $this->sel_val[] = $_SESSION['gold']->epno;
            if (!empty($keyword)){
                $this->sel_col[] = "K_NAME like ?";
                $this->sel_val[] = '%'.$keyword.'%';
            }
            $sql = "SELECT COUNT(*) AS row FROM ".$this->Knowledge_table." WHERE ".implode(" AND ", $this->sel_col);
            $rs = $this->db->query($sql, $this->sel_val);
        }
        $row = $rs->row();
        return $row->row;
    }
    //列表資料
    function knowledge_data($start, $end){
        $this->sel_val[] = $start;
        $this->sel_val[] = $end;
        if ($_SESSION['gold']->ident==="A"){
            if (count($this->sel_col)>0){
                $sql = "SELECT * FROM (
                    SELECT ROW_NUMBER() OVER (ORDER BY K_UPDATETIME DESC) as row, * FROM ".$this->Knowledge_table." WHERE ".implode(" AND ", $this->sel_col)."
                ) a WHERE row>=? AND ROW<=?";
            }else{
                $sql = "SELECT * FROM (
                    SELECT ROW_NUMBER() OVER (ORDER BY K_UPDATETIME DESC) as row, * FROM ".$this->Knowledge_table."
                ) a WHERE row>=? AND ROW<=?";
            }
        }else{
            $sql = "SELECT * FROM (
                SELECT ROW_NUMBER() OVER (ORDER BY K_UPDATETIME DESC) as row, * FROM ".$this->Knowledge_table." WHERE ".implode(" AND ", $this->sel_col)."
            ) a WHERE row>=? AND ROW<=?";
        }
        $rs = $this->db->query($sql, $this->sel_val);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //瀏覽單個
    function view_knowledge($data){
        $sql = "SELECT TOP 1 * FROM ".$this->Knowledge_table." WHERE KID=?";
        $rs = $this->db->query($sql, $data);
        $result = $rs->row();
        return (!empty($result)) ? $result:null;
    }
    //新增
    function create_knowledge($data){
        $sql = $this->sqlinsert($this->Knowledge_table, $data);
        $this->db->query($sql->sql, $sql->value);
    }
    //更新單個
    function update_knowledge($data, $id){
        $col = array();
        $val = array();
        foreach ($data as $k => $v) {
            $col[] = $k."=?";
            $val[] = trim($v);
        }
        $val[] = $id;
        $sql = "UPDATE ".$this->Knowledge_table." SET ".implode(", ", $col)." WHERE KID=?";
        $this->db->query($sql, $val);
    }
}