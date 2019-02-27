<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//診斷
class Analy extends Gold_Controller {

	function __construct(){
		parent::__construct();
	}
	//考題來源表
	public function result($eid){
		//主卷
		$eid = (int)$eid;
		$this->load->model("SetsModel");
		$this->load->model("ExamModel");
		$this->load->model("BasicModel");
		$main = $this->ExamModel->exam_rs($eid);
		$sets_set = $this->SetsModel->review_sets(array($main->SID));
		$sub = $this->ExamModel->exam_srs($eid);
		$part = array();
		foreach ($sub as $s) {
			$que = $this->ExamModel->ans_que($s->SCID);
			$info = new stdClass;
			$info->rnum = $s->SC_RNUM;
			$info->wnum = $s->SC_WNUM;
			$info->nnum = $s->SC_NNUM;
			$info->percen = $s->PERCEN;
			$info->score = $s->SC_SCORE;
			$qdata = array();
			foreach ($que as $q) {
				$percen = $this->ExamModel->ans_percen($q->SD_QID);
				$tmp = new stdClass;
				$tmp->right = ($q->SD_RIGHT) ? '<font color="green">O</font>':'<font color="red">X</font>';
				$ans = $this->_ques_ans_format($q);
				$tmp->my_ans = $ans->my_ans;
				$tmp->ans_right = $ans->ans_right;
				$chap = $this->BasicModel->get_onegsc(array($q->CHAP));
				$tmp->chap = $chap->NAME;
				$tmp->percen = round($percen->correct / $percen->row, 2)*100;
				//難度
				switch ($q->DEGREE) {
					case "M": $tmp->degree = "中等"; break;
					case "H": $tmp->degree = "困難"; break;
					case "E": $tmp->degree = "容易"; break;
					default: $tmp->degree = "容易"; break;
				}
				array_push($qdata, $tmp);
			}
			$info->qdata = $qdata;
			array_push($part, $info);
		}
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '考題來源表'
		));
		$this->load->view('exam/analy', array(
			'Eid' => $eid,
			'Setsname' => $sets_set->SETS_NAME,
			'Part' => $part
		));
	}
	private function _ques_ans_format($v){
		$data = new stdClass;
		$data->ans_right = '';
		$data->my_ans = '';
		switch ($v->QUE_TYPE) {
			case "S": 
				$data->ans_right = chr($v->ANS+64);
				if (!empty($v->SD_ANS)) $data->my_ans = chr($v->SD_ANS+64);
				break;
			case "D": 
				$ans = array();
				$ans = explode(",", $v->ANS);
				$ans_html = array();
				foreach ($ans as $o) {
					$ans_html[] = chr($o+64);
				}
				$data->ans_right = implode(", ", $ans_html);

				if (!empty($v->SD_ANS)){
					$ans = array();
					$ans = explode(",", $v->SD_ANS);
					$ans_html = array();
					foreach ($ans as $o) {
						$ans_html[] = chr($o+64);
					}
					$data->my_ans = implode(", ", $ans_html);
				}
				break;
			case "R": 
				$data->ans_right = ($v->ANS==="1") ? "O":"X";
				if (!empty($v->SD_ANS)) $data->my_ans = ($v->SD_ANS==="1") ? "O":"X";
				break;
			case "M": 
				$ans = array();
				$ans = explode(",", $v->ANS);
				$ans_html = array();
				foreach ($ans as $o) {
					if (!preg_match("/^[0-9]*$/", $o)){
						$ans_html[] = ($o==="a") ? '-':'±';
					}else{
						$ans_html[] = $o;
					}
				}
				$data->ans_right = implode(", ", $ans_html);

				if (!empty($v->SD_ANS)) {
					$ans = array();
					$ans = explode(",", $v->SD_ANS);
					$ans_html = array();
					foreach ($ans as $o) {
						if (!preg_match("/^[0-9]*$/", $o)){
							$ans_html[] = ($o==="a") ? '-':'±';
						}else{
							$ans_html[] = $o;
						}
					}
					$data->my_ans = implode(", ", $ans_html);
				}
				break;
		}
		return $data;
	}
}