<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//考卷
class ScoreModel extends Gold_Model {

    private $Score_table = 'score';
    private $stu_sel_col = array();
    private $stu_sel_val = array();

    private $tea_sel_col = array();
    private $tea_sel_val = array();
    
    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION)) session_start();
        $this->Set_db($_SESSION['gold']->code);
    }
    // 學生的成績筆數
    function stu_score_rows($stu){
        $this->stu_sel_col = array('SC_STN=?', 'SC_PID=?', 'SC_STATUS=?');
        $this->stu_sel_val = array($stu, 0, 1);
        $sql = "SELECT COUNT(*) as ROW FROM ".$this->Score_table." WHERE ".implode(" AND ", $this->stu_sel_col);
        $rs = $this->db->query($sql, $this->stu_sel_val);
        $row = $rs->row();
        return $row->ROW;
    }
    // 學生的成績資料
    function stu_score_data($start, $end){
        $this->stu_sel_val[] = $start;
        $this->stu_sel_val[] = $end;
        $sql = "SELECT * FROM (
            SELECT ROW_NUMBER() OVER (ORDER BY SC_DATE DESC) as ROW, iss.*, SETS_NAME FROM ".$this->Score_table." iss INNER JOIN exsets ie ON iss.SID=ie.ID WHERE ".implode(" AND ", $this->stu_sel_col)."
        ) a WHERE a.ROW BETWEEN ? AND ?";
        $rs = $this->db->query($sql, $this->stu_sel_val);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
    // 老師的班級別成績筆數
    function tea_score_rows($c, $ca, $sets){
        //一定有班級
        $this->tea_sel_col = array("CID=?");
        $this->tea_sel_val = array($c);
        if (!empty($ca)){
            $this->tea_sel_col[] = "CAID=?";
            $this->tea_sel_val[] = $ca;
        }
        if (!empty($sets)){
            $this->tea_sel_col[] = "SID=?";
            $this->tea_sel_val[] = $sets;
        }
        $sql = "SELECT COUNT(*) AS ROW FROM ".$this->Score_table." WHERE SID in (
            SELECT SID FROM setsclass WHERE ".implode(" AND ", $this->tea_sel_col)
        .") AND SC_PID=0";
        $rs = $this->db->query($sql, $this->tea_sel_val);
        $row = $rs->row();
        return $row->ROW;
    }
    // 老師的班級別成績資料
    function tea_score_data($start, $end){
        $this->tea_sel_val[] = $start;
        $this->tea_sel_val[] = $end;
        $sql = "SELECT * FROM (
            SELECT ROW_NUMBER() OVER (ORDER BY SC_STN) as ROW, ifs.*, STNAME FROM ".$this->Score_table." ifs INNER JOIN ftctl_stu fs ON ifs.SC_STN=fs.STNO WHERE SID in (
                SELECT SID FROM setsclass WHERE ".implode(" AND ", $this->tea_sel_col)
            .") AND SC_PID=0
        ) as a WHERE ROW BETWEEN ? AND ?";
        $rs = $this->db->query($sql, $this->tea_sel_val);
        $result = $rs->result();
        return (!empty($result)) ? $result:array();
    }
}