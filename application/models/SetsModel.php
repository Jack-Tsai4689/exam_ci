<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//考卷
class SetsModel extends Gold_Model {

    private $Sets_table = 'exsets';
    private $Setsclass_table = 'setsclass';
    private $Setsque_table = 'setsque';
    private $sel_col = array();
    private $sel_val = array();
    
    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION)) session_start();
        $this->Set_db($_SESSION['gold']->code);
    }
    function tea_sets_row($acc, $gra, $subj){
        $this->sel_col[] = 'OWNER=? AND PID=0';
        $this->sel_val[] = $acc;
        if ($gra>0){
            $this->sel_col[] = "GRA=?";
            $this->sel_val[] = $gra;
        }
        if ($subj>0){
            $this->sel_col[] = "SUBJ=?";
            $this->sel_val[] = $subj;
        }

        $sql = "SELECT COUNT(id) as row FROM ".$this->Sets_table." WHERE ".implode(" AND ", $this->sel_col);
        $rs = $this->db->query($sql, $this->sel_val);
        $data = $rs->row();
        return $data->row;
    }
    function tea_sets_data($start, $end){
        $this->sel_val = array_merge($this->sel_val, array($start, $end));
        $sql = "SELECT * FROM (
            SELECT *, ROW_NUMBER() OVER (ORDER BY CREATETIME DESC) AS row FROM ".$this->Sets_table." WHERE ".implode(" AND ", $this->sel_col)."
        ) a WHERE row>=? AND row<=?;";
        $rs = $this->db->query($sql, $this->sel_val);
        $data = $rs->result();
        return (!empty($data)) ? $data:array();
    }
    //建立考卷
    function create_sets($data){
        $sql = $this->sqlinsert($this->Sets_table, $data);
        $this->db->query($sql->sql, $sql->value);
        $id = $this->db->insert_id();
        return $id;
    }
    //瀏覽考卷
    function review_sets($data){
        $sql = "SELECT SETS_NAME, SUM, PASS_SCORE, SUB, LIMTIME, FINISH FROM ".$this->Sets_table." WHERE ID=?";
        $rs = $this->db->query($sql, $data);
        return $rs->row();
    }
    //編輯用考卷
    function view_sets($data){
        $sql = "SELECT * FROM ".$this->Sets_table." WHERE ID=?";
        $rs = $this->db->query($sql, $data);
        $result = $rs->result();
        if (!empty($result)){
            return $rs->row();
        }else{
            return null;
        }
    }
    //找大題
    function view_sets_sub($data){
        $sql = "SELECT * FROM ".$this->Sets_table." WHERE PID=? ORDER BY PART";
        $rs = $this->db->query($sql, $data);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    // 刪題目
    function delete_que($data){
        $sql = "DELETE FROM ".$this->Setsque_table." WHERE SQ_PART=? AND SQ_SORT=?";
        $this->db->query($sql, $data);
    }
    //查考卷串接
    function sets_gca($data){
        $sql = "SELECT GID, CID, CAID FROM ".$this->Setsclass_table." WHERE SID=?";
        $rs = $this->db->query($sql, $data);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //查考卷串接-列表顯示用
    function sets_gca_showone($data){
        $sql = "SELECT TOP 1 GID, CID, CAID FROM ".$this->Setsclass_table." WHERE SID=?";
        $rs = $this->db->query($sql, $data);
        $result = $rs->row();
        return (!empty($result)) ? $result:null;
    }
    //更新考卷串接id
    function sets_update_webid($data){
        $sql = "UPDATE ".$this->Sets_table." SET WEBSETID=? WHERE ID=?";
        $this->db->query($sql, $data);
    }
    //變更考卷串接-刪除
    function delete_sets_gca($data){
        $sql = "DELETE FROM ".$this->Setsclass_table." WHERE SID=? AND CID=? AND CAID=?";
        $this->db->query($sql, $data);
    }
    //變更考卷串接-新增
    function insert_sets_gca($data){
        $sql = $this->sqlinsert($this->Setsclass_table, $data);
        $this->db->query($sql->sql, $sql->value);
    }
    //更新考卷設定
    function update_sets($data, $id){
        $col = array();
        $val = array();
        foreach ($data as $k => $v) {
            $col[] = $k."=?";
            $val[] = $v;
        }
        $val[] = $id;
        $sql = "UPDATE ".$this->Sets_table." SET ".implode(", ", $col)." WHERE ID=?";
        $this->db->query($sql, $val);
    }
    //查詢大題
    function subofsets($data){
        $sql = "SELECT ID, INTRO, PERCEN, PAGE FROM ".$this->Sets_table." WHERE pid=? ORDER BY part;";
        $rs = $this->db->query($sql, $data);
        $data = $rs->result();
        return (!empty($data)) ? $data:array();
    }
    //建立大題
    function create_sub($data){
        $sql = $this->sqlinsert($this->Sets_table, $data);
        $this->db->query($sql->sql, $sql->value);
    }
    //更新大題
    function update_sub($data, $id){
        $col = array();
        $val = array();
        foreach ($data as $k => $v) {
            $col[] = $k."=?";
            $val[] = trim($v);
        }
        $val[] = $id;
        $sql = "UPDATE ".$this->Sets_table." SET ".implode(",", $col)." WHERE ID=?";
        $this->db->query($sql, $val);        
    }
    //刪除大題
    function delete_sub($data){
        $sql = "DELETE FROM ".$this->Sets_table." WHERE ID=? AND PID=?";
        $this->db->query($sql, $data);
    }
    //切換是否有大題
    function change_sets_sub($data){
        $sql = "UPDATE ".$this->Sets_table." SET sub=? WHERE id=?";
        $this->db->query($sql, $data);
    }
    //變更大題順序
    function chage_sub_sort($data){
        $sql = "UPDATE ".$this->Sets_table." SET part=? WHERE ID=? AND PID=?";
        $this->db->query($sql, $data);
    }
    // 變更題目順序
    function chage_que_sort($data){
        $sql = "UPDATE ".$this->Setsque_table." SET SQ_SORT=? WHERE SQ_QID=? AND SQ_PART=?";
        $this->db->query($sql, $data);
    }
    //年級、科目範圍找考卷
    function gs_getsets($data){
        $sql = "SELECT ID, SETS_NAME FROM ".$this->Sets_table." WHERE gra=? AND subj=?;";
        $rs = $this->db->query($sql, $data);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //查詢大題的題目
    function sub_que($data){
        $sql = "SELECT isq.SQ_SORT, iq.QID, iq.QUE_TYPE, iq.QUETXT, iq.QIMGSRC, iq.QSOUNDSRC, iq.ANS FROM setsque isq INNER JOIN question iq ON isq.sq_qid=iq.qid WHERE sq_sid=? AND sq_part=? ORDER BY sq_sort";
        $rs = $this->db->query($sql, $data);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //確認大題是否有題目
    function subque_check($data){
        $sql = "IF EXISTS (SELECT * FROM setsque WHERE SQ_SID=? AND SQ_PART=?)
        BEGIN 
            SELECT 'true' as 'have'
        END 
        ELSE 
        BEGIN 
            SELECT 'false' as 'have'
        END";
        $rs = $this->db->query($sql, $data);
        return $rs->row();
    }
    //查詢我的未完成考卷
    function mysets_nonfinish($acc){
        $sql = "SELECT ID, SETS_NAME, SUB FROM ".$this->Sets_table." WHERE owner=? AND finish=0 AND PID=0";
        $rs = $this->db->query($sql, array($acc));
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //查詢我的未完成考卷的大題
    function mysets_nonfinish_sub($sid){
        $sql = "SELECT ID, PERCEN FROM ".$this->Sets_table." WHERE PID=? ORDER BY part";
        $rs = $this->db->query($sql, array($sid));
        $result = $rs->result();
        return (!empty($result)) ? $result:array();   
    }
    // 題目加入考卷
    function quesadd_sets($q, $sid, $part, $owner, $time){
        $sql = "IF NOT EXISTS (SELECT * FROM ".$this->Setsque_table." WHERE SQ_SID=? AND SQ_PART=? AND SQ_QID=?) 
        BEGIN 
            INSERT INTO ".$this->Setsque_table."(SQ_SID, SQ_PART, SQ_QID, SQ_SORT, SQ_OWNER, SQ_TIME) VALUES(?, ?, ?, 
                (SELECT (Case when MAX(SQ_SORT) is null then 0 ELSE Max(SQ_SORT) END) SQ_SORT FROM ".$this->Setsque_table." WHERE SQ_SID=? AND SQ_PART=?)+1, 
                ?, ?)
        END ";
        $rs = $this->db->query($sql, array(
            $sid, $part, $q,
            $sid, $part, $q, 
            $sid, $part,
            $owner, $time
        ));
    }
    // 配分比例合計確認
    function part_percen_check($data){
        $sql = "SELECT SUM(PERCEN) as SCORE FROM ".$this->Sets_table." WHERE PID=?";
        $rs = $this->db->query($sql, $data);
        $score = $rs->row();
        return ($score->SCORE!==100) ? false:true;
    }
    function destroy($sid){
        // 大題
        $sql = "DELETE FROM setsque WHERE SQ_SID=?";
        $this->db->query($sql, array($sid));
        // 設定班級
        $sql = "DELETE FROM setsclass WHERE SID=?";
        $this->db->query($sql, array($sid));
        // 主卷
        $sql = "DELETE FROM exsets WHERE ID=?";
        $this->db->query($sql, array($sid));
    }
    // score
    // 依班級別找考卷
    function getsets_byclass($ca, $cla){
        $col = array("CID=?");
        $val = array($ca);
        if ($cla>0){
            $col[] = "CAID=?";
            $val[] = $cla;
        }
        $sql = "SELECT SID as id, SETS_NAME as name FROM setsclass isc INNER JOIN exsets ie ON 
             isc.SID=ie.ID WHERE ".implode(" AND ", $col);
        $rs = $this->db->query($sql, $val);
        $result = $rs->result();
        return(!empty($result)) ? $result:array();
    }
}