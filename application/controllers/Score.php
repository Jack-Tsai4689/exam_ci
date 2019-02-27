<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//成績
class Score extends Gold_Controller {

	public $gold = null;

	function __construct(){
		parent::__construct();
	}
	//成績列表
	public function index(){
		$page = (isset($_GET['page']) && (int)$_GET['page']>0) ? (int)$_GET['page']:1;
		$this->_page($page);
		$this->load->model("ScoreModel");
		if ($_SESSION['gold']->ident==="S"){
			//學生
			$score_row = $this->ScoreModel->stu_score_rows($_SESSION['gold']->epno);
			$score_data = $this->ScoreModel->stu_score_data($this->_pstart(), $this->_pend());

			$pagegroup = ceil($score_row/$this->_prow());
			$prev_act = ($page>1) ? 'onclick="pg('.($page-1).')"':'style="visibility: hidden;"';
			$next_act = ($pagegroup>$page) ? 'onclick="pg('.($page+1).')"':'style="visibility: hidden;"';
			$prev = '<input type="button" class="btn btn-default" '.$prev_act.' value="上一頁">';
			$next = '<input type="button" class="btn btn-default" '.$next_act.' value="下一頁">';
			$pg = '';
			for ($i = 1; $i<=$pagegroup;$i++){
				$pg.='<option value="'.$i.'">第'.$i.'頁</option>';
			}
			$this->load->view('_header', array(
				'ident' => $this->dp_info,
				'title' => '成績'
			));
			$this->load->view('score/slist', array(
				'Data' => $score_data,
				'Prev' => $prev,
				'Next' => $next,
				'Pg' => $pg,
				'Num' => $score_row
			));
			return;
		}

		if ($_SESSION['gold']->ident==="T"){
			//老師
			$sel = new stdclass;
			$sel->ca = 0;
			$sel->cla = 0;
			$sel->sets = 0;
			if ($_GET){
				
			}
			$this->load->model("CramModel");
			//$_SESSION['gold']->code
			$cram = $this->CramModel->Get_setting('1001');

			$this->load->model('AuthModel');
			$this->AuthModel->Set_db($_SESSION['gold']->code);
			$user = $this->AuthModel->user_info(array($_SESSION['gold']->epno));
			if ($_GET){
				$sel->ca = (isset($_GET['ca']) && !empty($_GET['ca'])) ? (int)$_GET['ca']:0;
				if (isset($_GET['cla'])){
					$ca = (int)$_GET['cla'];
					if ($ca>0)$sel->cla = $ca;
				}
				$sel->sets = (isset($_GET['sets']) && !empty($_GET['sets'])) ? (int)$_GET['sets']:0;
			}
			$score_row = $this->ScoreModel->tea_score_rows($sel->ca, $sel->cla, $sel->sets);
			$score_data = $this->ScoreModel->tea_score_data($this->_pstart(), $this->_pend());
			$pagegroup = ceil($score_row/$this->_prow());
			$prev_act = ($page>1) ? 'onclick="pg('.($page-1).')"':'style="visibility: hidden;"';
			$next_act = ($pagegroup>$page) ? 'onclick="pg('.($page+1).')"':'style="visibility: hidden;"';
			$prev = '<input type="button" class="btn btn-default" '.$prev_act.' value="上一頁">';
			$next = '<input type="button" class="btn btn-default" '.$next_act.' value="下一頁">';
			$pg = '';
			for ($i = 1; $i<=$pagegroup;$i++){
				$pg.='<option value="'.$i.'">第 '.$i.' 頁</option>';
			}

			$this->load->view('_header', array(
				'ident' => $this->dp_info,
				'title' => '成績查詢'
			));
			$this->load->view('score/tlist', array(
				'Sel' => $sel,
				'Group' => $group_info,
				'Ca' => $class_info,
				'Cla' => $classa_info,
				'Sets' => $sets_info,
				'Data' => $score_data,
				'Prev' => $prev,
				'Next' => $next,
				'Pg' => $pg,
				'Num' => $score_row
			));
			return;
		}
	}
}