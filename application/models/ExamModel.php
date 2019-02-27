<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//測驗
class ExamModel extends Gold_Model {

    private $Exam_table = 'score';
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
    //可以考的
    function can_sets(){
        $sql = "SELECT * FROM exsets WHERE FINISH=1 AND PID=0 AND (BEGTIME='' OR (BEGTIME<='".date('Y/m/d H:i:s')."' AND ENDTIME>='".date('Y/m/d H:i:s')."'))";
        $rs = $this->db->query($sql);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    //考卷資訊
    function sets_info($sid){
        $sql = "SELECT TOP 1 * FROM exsets WHERE ID=? AND FINISH=1 AND PID=0 AND (BEGTIME='' OR (BEGTIME<='".date('Y/m/d H:i:s')."' AND ENDTIME>='".date('Y/m/d H:i:s')."'))";
        $rs = $this->db->query($sql, array($sid));
        return $rs->row();
    }
    // 考卷詳細
    function sets_detail($sid){
        $sql = "SELECT TOP 1 * FROM exsets WHERE ID=?";
        $rs = $this->db->query($sql, array($sid));
        return $rs->row();
    }
    //大題資訊
    function sets_part_info($sid){
        $sql = "SELECT * FROM exsets WHERE PID=? ORDER BY PART";
        $rs = $this->db->query($sql, array($sid));
        return $rs->result();
    }
    //第一大題題目
    function first_part($sid, $partid){
        $sql = "SELECT * FROM setsque WHERE SQ_SID=? AND SQ_PART=? ORDER BY SQ_SORT";
        $rs = $this->db->query($sql, array($sid, $partid));
        return $rs->result();
    }
    //第一題題目
    function one_que($qid) {
        $sql = "SELECT TOP 1 * FROM question WHERE QID=?";
        $rs = $this->db->query($sql, array($qid));
        return $rs->row();
    }
    // 查考卷大題的題目
    function view_sets_sub($spart){
        $sql = "SELECT isq.*, iq.ANS FROM setsque isq INNER JOIN question iq ON isq.SQ_QID=QID WHERE SQ_PART=? ORDER BY SQ_SORT";
        $rs = $this->db->query($sql, array($spart));
        return $rs->result();
    }
    //是否考過
    function examed($stu, $sid){
        $sql = "IF EXISTS(SELECT * FROM ".$this->Exam_table." WHERE SC_STN=? AND SID=?) 
        BEGIN 
            SELECT 'true' as 'examed'
        END 
        ELSE 
        BEGIN 
            SELECT 'false' as 'examed'
        END";
        $rs = $this->db->query($sql, array($stu, $sid));
        return $rs->row();
    }
    //增加學生卷
    function create_exam($stu, $sid, $date, $pid = 0){
        $data = array($stu, $sid, $date);
        if ($pid===0){
            //主卷
            $sql = "INSERT INTO ".$this->Exam_table."(SC_STN, SID, SC_DATE) VALUES(?, ?, ?)";
            $this->db->query($sql, $data);
        }else{
            //大題卷
            $sql = "INSERT INTO ".$this->Exam_table."(SC_STN, SID, SC_DATE, SC_PID) VALUES(?, ?, ?, ?)";
            $data[] = $pid;
            $this->db->query($sql, $data);
        }
        $id = $this->db->insert_id();
        return $id;
    }
    //增加學生題目記錄
    function create_que($eid, $sid){
        $sql = "INSERT INTO score_detail(SD_EID, SID, SD_QID, SD_SORT) 
        SELECT ?, ?, SQ_QID, SQ_SORT FROM setsque WHERE sq_part=? ORDER BY sq_sort";
        $this->db->query($sql, array($eid, $sid, $sid));
    }
    //儲存答案
    /*
    大題、題號、答案
    */
    function ans_save($part, $qno, $ans){
        $sql = "UPDATE score_detail SET SD_ANS=? WHERE SD_EID=? AND SD_SORT=?";
        $this->db->query($sql, array($ans, $part, $qno));
    }
    //載入下一題
    function next_que($part, $qno){
        $sql = "SELECT iq.QID, iq.QUE_TYPE, iq.QUETXT, iq.QIMGSRC, iq.QSOUNDSRC, iq.NUM, iq.ANS FROM score_detail isd INNER JOIN question iq ON isd.SD_QID=iq.QID WHERE SD_EID=? AND SD_SORT=?";
        $rs = $this->db->query($sql, array($part, $qno));
        return $rs->row();
    }
    //更改大題狀態
    // status=>1 考完
    function status_change($part, $right, $wrong, $none, $score){
        $sql = "UPDATE ".$this->Exam_table." SET SC_STATUS=1, SC_END='".date('Y/m/d H:i:s')."', SC_SCORE=?, SC_RNUM=?, SC_WNUM=?, SC_NNUM=? WHERE SCID=?";
        $this->db->query($sql, array($score, $right, $wrong, $none, $part));
    }
    function status_main_change($exam, $right, $wrong, $none, $score){
        $sql = "UPDATE ".$this->Exam_table." SET SC_END='".date('Y/m/d H:i:s')."', SC_SCORE+=?, SC_RNUM+=?, SC_WNUM+=?, SC_NNUM+=? WHERE SCID=?";
        $this->db->query($sql, array($score, $right, $wrong, $none, $exam));
    }
    function exam_end($exam){
        $sql = "UPDATE score SET SC_STATUS=1 WHERE SCID=?";
        $this->db->query($sql, array($exam));
    }
    // 載入下個大題
    function next_part($exam){
        $sql = "SELECT TOP 1 * FROM score WHERE SC_PID=? AND SC_STATUS=0 ORDER BY SCID";
        $rs = $this->db->query($sql, array($exam));
        $result = $rs->result();
        if (!empty($result)){
            return $rs->row();
        }else{
            return null;
        }
    }
    // 核對答案
    // 大題、題號、答案
    function check_corr($part, $qid, $ans){
        $sql = "UPDATE score_detail SET SD_RIGHT=1 WHERE SD_EID=? AND SD_SORT=? AND SD_ANS=?";
        $this->db->query($sql, array($part, $qid, $ans));
    }
    // 取得學生大題題目全部資訊，算成績用
    function count_score($part){
        $sql = "SELECT SD_ANS, SD_RIGHT FROM score_detail WHERE SD_EID=? ORDER BY SD_SORT";
        $rs = $this->db->query($sql, array($part));
        return $rs->result();
    }
    // 取得考卷設定資訊
    function view_exsets($pid){
        $sql = "SELECT * FROM exsets WHERE ID=?";
        $rs = $this->db->query($sql, array($pid));
        return $rs->row();
    }
    //看主結果
    function exam_rs($eid){
        $sql = "SELECT TOP 1 * FROM ".$this->Exam_table." WHERE SCID=? AND SC_PID=0";
        $rs = $this->db->query($sql, array($eid));
        return $rs->row();
    }
    //看大題結果
    function exam_srs($pid){
        $sql = "SELECT isc.*, PERCEN FROM ".$this->Exam_table." isc INNER JOIN exsets ie ON isc.SID=ie.ID WHERE SC_PID=? ORDER BY SCID";
        $rs = $this->db->query($sql, array($pid));
        return $rs->result();
    }
    //看作答與題目
    function ans_que($part){
        $sql = "SELECT isd.SD_ANS, isd.SD_RIGHT, isd.SD_QID, iq.QUE_TYPE, iq.DEGREE, iq.QIMGSRC, iq.QSOUNDSRC, iq.ANSTXT, iq.AIMGSRC, iq.ASOUNDSRC, iq.AVIDEOSRC, iq.ANS, iq.CHAP, iq.NUM FROM score_detail isd INNER JOIN question iq ON isd.SD_QID=iq.QID WHERE SD_EID=? ORDER BY SD_SORT";
        $rs = $this->db->query($sql, array($part));
        return $rs->result();
    }
    //作答數與答對數
    function ans_percen($qid){
        $sql = "SELECT COUNT(*) as row, SUM(sd_right) as correct FROM score_detail WHERE sd_qid=? GROUP BY sd_qid";
        $rs = $this->db->query($sql, array($qid));
        return $rs->row();
    }
    //看題目概念
    function que_concept($part){
        $sql = "SELECT isd.SD_RIGHT, isd.SD_SORT, isd.SD_QID, iq.CHAP 
        FROM score_detail isd INNER JOIN question iq 
        ON isd.SD_QID=iq.QID WHERE SD_EID=? ORDER BY isd.SD_SORT";
        $rs = $this->db->query($sql, array($part));
        return $rs->result();
    }
}