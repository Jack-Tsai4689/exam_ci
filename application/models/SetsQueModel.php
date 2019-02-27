<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//考卷
class SetsQueModel extends Gold_Model {

    private $setsque_table = 'setsque';
    private $sel_col = array();
    private $sel_val = array();

    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION)) session_start();
        $this->Set_db($_SESSION['gold']->code);
    }
    //題目加至考卷中
    function qusjoin2set($sid, $part, $qid){
        $sql = "IF EXISTS(SELECT * FROM ".$this->setsque_table." WHERE sq_sid=? AND sq_part=? AND sq_qid=?) 
                BEGIN 
                    SELECT 'true' as 'have'                 
                END 
                ELSE 
                BEGIN 
                    SELECT 'false' as 'have'
                END";
        $rs = $this->db->query($sql, array($sid, $part, $qid));
        $row = $rs->row();
        if ($row->have==="false"){
            $sql = "INSERT INTO ".$this->setsque_table." (SQ_SID, SQ_PART, SQ_QID, SQ_SORT, SQ_OWNER, SQ_TIME)
                VALUES(?, ?, ?, (SELECT CASE WHEN MAX(SQ_SORT) is null THEN 1 ELSE MAX(SQ_SORT)+1 END FROM ".$this->setsque_table." WHERE SQ_SID=? AND SQ_PART=?), ?, ?)";
            $this->db->query($sql, array($sid, $part, $qid, $sid, $part, $_SESSION['gold']->epno, date('Y/m/d H:i:s')));
        }
    }
    // 從考卷刪整個大題的題目
    function sets_deletequs($sid, $part){
        $sql = "";
    }
}