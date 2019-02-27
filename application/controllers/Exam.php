<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//測驗
class Exam extends Gold_Controller {

	function __construct(){
		parent::__construct();
	}
	//學生的
	public function index(){
		$method = $_SERVER['REQUEST_METHOD'];

		$etype = (isset($_GET['etype']) && !empty($_GET['etype'])) ? trim($_GET['etype']):"S";
		$this->load->model("ExamModel");
		
		$data = '';
		$sets_first = false;
		$intro = '';
		$gra_html = '';
		$subj_html = '';
		$this->load->model("BasicModel");
		switch ($etype) {
			case 'S':
				$exam_data = $this->ExamModel->can_sets();
				if (!empty($exam_data)){
					foreach ($exam_data as $ev) {
						if ($ev->AGAIN===0){
							$status = $this->ExamModel->examed($_SESSION['gold']->epno, $ev->ID);
							if ($status->examed==="true")continue;
						}
						$data.= '<option value="'.$ev->ID.'">'.trim($ev->SETS_NAME).'</option>';
						if (!$sets_first){
							if (!empty($ev->BEGTIME)){
								$days = $ev->BEGTIME.'~'.$ev->ENDTIME;
							}else{
								$days = '不限';
							}
							$lim = explode(":", $ev->LIMTIME);
							$gra_data = $this->BasicModel->get_onegsc(array($ev->GRA));
							$subj_data = $this->BasicModel->get_onegsc(array($ev->SUBJ));
							$intro = '年級：'.$gra_data->NAME.'　科目：'.$subj_data->NAME;
			                $intro.= '　總分：'.$ev->SUM;
							$intro.= '　及格分數：'.$ev->PASS_SCORE;
							$intro.= '<br>考卷說明：'.nl2br(trim($ev->INTRO));
							$intro.= '<br>考試期間：'.$days;
							$intro.= '<br>考試限時：'.$lim[0].'時'.$lim[1].'分'.$lim[2].'秒';
							$sets_first = true;
						}
					}
				}else{
					$data = '<option value="">無考卷</option>';
				}
				break;
			case 'C':
				$grade_data = $this->BasicModel->get_grade();
				if (!empty($grade_data)){
					foreach ($grade_data as $v) {
						$gra_html.= '<option value="'.$v->ID.'">'.$v->NAME.'</option>';
					}
					$subject_data = $this->BasicModel->get_subject(array($grade_data[0]->ID));
					if (!empty($subject_data)){
						foreach ($subject_data as $v) {
							$subj_html.= '<option value="'.$v->ID.'">'.$v->NAME.'</option>';
						}
					}
				}
				break;
		}
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '評量測驗'
		));
		$this->load->view('exam/index', array(
			'Etype' => $etype,
			'Grade' => $gra_html,
			'Subject' => $subj_html,
			'Setsname' => $data,
			'Intro' => $intro
		));
	}
	//取得考試資訊
	public function ajinfo(){
		$sid = (isset($_GET['sid']) && !empty($_GET['sid'])) ? trim($_GET['sid']):0;
		if (!is_numeric($sid)){
			$this->_errmsg(400);
			return;
		}
		$sid = (int)$sid;
		if ($sid<1){
			$this->_errmsg(400);
			return;	
		}
		$this->load->model("BasicModel");
		$this->load->model("ExamModel");
		$sets = $this->ExamModel->sets_info($sid);

		if (!empty($sets->BEGTIME)){
			$days = $sets->BEGTIME.'~'.$sets->ENDTIME;
		}else{
			$days = '不限';
		}
		$lim = explode(":", $sets->LIMTIME);
		$gra_data = $this->BasicModel->get_onegsc(array($sets->GRA));
		$subj_data = $this->BasicModel->get_onegsc(array($sets->SUBJ));
		$intro = '年級：'.$gra_data->NAME.'　科目：'.$subj_data->NAME;
        $intro.= '　總分：'.$sets->SUM;
		$intro.= '　及格分數：'.$sets->PASS_SCORE;
		$intro.= '<br>考卷說明：'.nl2br(trim($sets->INTRO));
		$intro.= '<br>考試期間：'.$days;
		$intro.= '<br>考試限時：'.$lim[0].'時'.$lim[1].'分'.$lim[2].'秒';
		$json['data'] = $intro;
		echo json_encode($json);
	}
	//session傳值 初始化
	public function ajginfo(){
		$type = (isset($_POST['etype']) && !empty($_POST['etype'])) ? trim($_POST['etype']):'';
		$sets = (isset($_POST['sets']) && !empty($_POST['sets'])) ? (int)$_POST['sets']:0;
		$_SESSION['tmp']['type'] = $type;
		switch ($type) {
			case 'C':
					
				break;
			case 'S':
				if ($sets<1){
					$this->_errmsg(400);
					return;
				}
				$_SESSION['tmp']['sets'] = $sets;
				break;
		}
		echo true;
	}
	//準備畫面
	public function start(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET")return;
		$etype = (isset($_SESSION['tmp']['type']) && !empty($_SESSION['tmp']['type'])) ? trim($_SESSION['tmp']['type']):'';
		$sets = (isset($_SESSION['tmp']['sets']) && !empty($_SESSION['tmp']['sets'])) ? trim($_SESSION['tmp']['sets']):0;
		if ($etype==="S"){
			if (!is_numeric($sets)){
				$this->_errmsg(400);
				return;
			}
			$sid = (int)$sets;
			if ($sid<1){
				$this->_errmsg(400);
				return;
			}
			unset($_SESSION['tmp']['type']);
			unset($_SESSION['tmp']['sets']);
			$this->load->model("ExamModel");
			$exsets = $this->ExamModel->sets_info($sid);
			if (!$exsets->AGAIN){
				//不能重覆
				$ed = $this->ExamModel->examed($_SESSION['gold']->epno, $sid);
				if ($ed->examed==="true"){
					echo '此試卷已考過';
					return;
				}
			}
			$lim = explode(":", $exsets->LIMTIME);
			$lime = '';
			if ($lim[0]>0) $lime.= (int)$lim[0].'小時';
			if ($lim[1]>0) $lime.= (int)$lim[1].'分';
			if ($lim[2]>0) $lime.= (int)$lim[2].'秒';

			$again = ($exsets->AGAIN) ? '可重複考':'僅限一次';

			$part = $this->ExamModel->sets_part_info($sid);

			$this->load->view('exam/start', array(
				'title' => '評量測驗',
				'Etype' => $etype,
				'Num' => 0,
				'Grade' => '',
				'Subject' => '',
				'Chapter' => '',
				'Degree' => '',
				'Sid' => $sid,
				'Setsname' => $exsets->SETS_NAME,
				'Sum' => $exsets->SUM,
				'Sub_info' => $part,
				'Pass_core' => $exsets->PASS_SCORE,
				'Limetime' => $lime,
				'Times' => $again
			));
			return;
		}
		die('此連結已失效');
	}
	//開始測驗
	public function go(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST") return;
		$etype = (isset($_POST['etype']) && !empty($_POST['etype'])) ? trim($_POST['etype']):'';
		$sets = (isset($_POST['sets']) && !empty($_POST['sets'])) ? trim($_POST['sets']):0;

		$lime = (isset($_POST['lime']) && !empty($_POST['lime'])) ? trim($_POST['lime']):'';
        $exam = (isset($_POST['exam']) && !empty($_POST['exam'])) ? (int)$_POST['exam']:0;
        $epart = (isset($_POST['epart']) && !empty($_POST['epart'])) ? (int)$_POST['epart']:0;
        $spart = (isset($_POST['spart']) && !empty($_POST['spart'])) ? (int)$_POST['spart']:0;

		if ($etype==="S"){
			if (!is_numeric($sets)){
				$this->_errmsg(400);
				return;
			}
			$sid = (int)$sets;
			if ($sid<1){
				$this->_errmsg(400);
				return;
			}
			$this->load->model("ExamModel");
			$exsets = $this->ExamModel->sets_info($sid);
            //直接下個大題
            if ($exam>0 && $epart>0 && $spart>0){
                $lim = explode(":", $lime);
                $time = array(
					'hour' => $lim[0],
					'min' => $lim[1],
					'sec' => $lim[2]
				);
				$first_partq = $this->ExamModel->first_part($sid, $spart);
				$qrows = array();
				$qno = '<div class="current" id="go1" onclick=go(1)>'.str_pad(1,2,0,STR_PAD_LEFT).'</div>
	                ';
				foreach ($first_partq as $k => $v) {
					$qrows[] = $v->SQ_SORT;
					if ($k>0){
						$qno.= '<div id="go'.$v->SQ_SORT.'" onclick=go('.$v->SQ_SORT.')>'.str_pad($v->SQ_SORT,2,0,STR_PAD_LEFT).'</div>
						';
					}
				}
				$all_part = $this->ExamModel->sets_part_info($sid);
				$next_part_no = 0;
				foreach ($all_part as $v) {
					if ($v->ID===$spart){
						$next_part_no = $v->PART;
						break;
					}
				}
				$one_que = $this->ExamModel->one_que($first_partq[0]->SQ_QID);
				$que = $this->_que_info_format($one_que, 1);
                $this->load->view('exam/ing', array(
					'title' => '評量測驗',
					'Etype' => $etype,
					'Sid' => $sid,
					'Eid' => $exam,
					'Epart' => $epart,
					'Spart' => $spart,
					'Grade' => '',
					'Subject' => '',
					'Chapter' => '',
					'Setsname' => $exsets->SETS_NAME,
					'Qrows' => $qrows,
					'Que' => $que,
					'Qno' => $qno,
					'Time' => json_decode(json_encode($time)),
					'First_qno' => 1,
					'Part_no' => $next_part_no
				));
                return;
            }
			if (!$exsets->AGAIN){
				//不能重覆
				$ed = $this->ExamModel->examed($_SESSION['gold']->epno, $sid);
				if ($ed->examed==="true"){
					echo '此試卷已考過';
					return;
				}
			}
			$lim = explode(":", $exsets->LIMTIME);

			$time = array(
				'hour' => $lim[0],
				'min' => $lim[1],
				'sec' => $lim[2]
			);
			//大題資訊
			$part_info = $this->ExamModel->sets_part_info($sid);
			//第一大題題目id
			$first_partq = $this->ExamModel->first_part($sid, $part_info[0]->ID);
			$qrows = array();
			$qno = '<div class="current" id="go1" onclick=go(1)>'.str_pad(1,2,0,STR_PAD_LEFT).'</div>
                ';
			foreach ($first_partq as $k => $v) {
				$qrows[] = $v->SQ_SORT;
				if ($k>0){
					$qno.= '<div id="go'.$v->SQ_SORT.'" onclick=go('.$v->SQ_SORT.')>'.str_pad($v->SQ_SORT,2,0,STR_PAD_LEFT).'</div>
					';
				}
			}
			//第一大題題目
			// $qdata = array();
			// foreach ($first_partq as $qv) {
			// 	$one_que = $this->ExamModel->one_que($qv->SQ_QID);
			// 	$oque = $this->_que_info_format($one_que, $qv->SQ_SORT);
			// 	$qdata[] = $oque;
			// }
			//第一題題目
			$one_que = $this->ExamModel->one_que($first_partq[0]->SQ_QID);
			$que = $this->_que_info_format($one_que, 1);
			//建學生卷
			$eid = $this->ExamModel->create_exam($_SESSION['gold']->epno, $sid, date('Y/m/d H:i:s'));
			$esid = 0;
			foreach ($part_info as $pk => $pv) {
				$subid = $this->ExamModel->create_exam($_SESSION['gold']->epno, $pv->ID, date('Y/m/d H:i:s'), $eid);
				if ($pk===0)$esid = $subid;
				$this->ExamModel->create_que($subid, $pv->ID);
			}

			$this->load->view('exam/ing', array(
				'title' => '評量測驗',
				'Etype' => $etype,
				'Sid' => $sid,
				'Eid' => $eid,
				'Epart' => $esid,
				'Spart' => $part_info[0]->ID,
				'Grade' => '',
				'Subject' => '',
				'Chapter' => '',
				'Setsname' => $exsets->SETS_NAME,
				'Qrows' => $qrows,
				'Que' => $que,
				'Qno' => $qno,
				'Time' => json_decode(json_encode($time)),
				'First_qno' => 1,
				'Part_no' => 1
			));
		}
	}
	//存答案
	public function save(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST")return;
		$qtype = (isset($_POST['qtype']) && !empty($_POST['qtype'])) ? trim($_POST['qtype']):'';
		$qnum = (isset($_POST['qnum']) && !empty($_POST['qnum'])) ? (int)$_POST['qnum']:0;
		$epart = (isset($_POST['epart']) && !empty($_POST['epart'])) ? trim($_POST['epart']):0;
		$spart = (isset($_POST['spart']) && !empty($_POST['spart'])) ? trim($_POST['spart']):0;
		$qno = (isset($_POST['current_qno']) && !empty($_POST['current_qno'])) ? trim($_POST['current_qno']):0;
		$act = (isset($_POST['next_qa']) && !empty($_POST['next_qa'])) ? trim($_POST['next_qa']):'';
		$exam = $_POST['exam'];
		$sets = $_POST['sets'];
		if ($act==="part"){
			$hour = $_POST['hour'];
            $min = $_POST['min'];
            $sec = $_POST['sec'];
			$this->load->model("ExamModel");
			// 算成績
			$allnum = 0;
			$nnum = 0;
			$rnum = 0;
			$wnum = 0;
			$score_num = $this->ExamModel->count_score($epart);
			foreach ($score_num as $v) {
				if ($v->SD_RIGHT){
					$rnum++;
				}else{
					if (!empty($v->SD_ANS)){
						$wnum++;
					}else{
						$nnum++;
					}
				}
				$allnum++;
			}
			// 考卷總分
			$sets_info = $this->ExamModel->view_exsets($sets);
			// 大題滿分比例
			$part_info = $this->ExamModel->view_exsets($spart);
			$score = $rnum / $allnum * ($part_info->PERCEN / $sets_info->SUM) * 100;
			// 更新此大題狀態
			$this->ExamModel->status_change($epart, $rnum, $wnum, $nnum, $score);
			$this->ExamModel->status_main_change($exam, $rnum, $wnum, $nnum, $score);
			//下個大題
			$part = $this->ExamModel->next_part($exam);
			if ($part===null){
				// 學生卷關閉
				$this->ExamModel->exam_end($exam);
				die('考試結束');
				exit;
			}
            $lime = $hour.":".$min.":".$sec;
            $this->load->view('exam/nextpart', array(
                'title' => '',
                'etype' => 'S',
                'exam' => $exam,
                'exnum' => '',
                'gra' => '',
                'subj' => '',
                'chap' => '',
                'degree' => '',
                'sets' => $sets,
                'lime' => $lime,
                'epart' => $part->SCID,
                'spart' => $part->SID
            ));
            return;
		}
		$ans_html = '';
		switch ($qtype) {
			case 'S':
			case 'R':
				$ans_html = (isset($_POST['ans'.$qno]) && !empty($_POST['ans'.$qno])) ? trim($_POST['ans'.$qno]):'';
				break;
			case 'D':
				$ans = (isset($_POST['ans'.$qno]) && !empty($_POST['ans'.$qno])) ? $_POST['ans'.$qno]:array();
				if (!empty($ans))$ans_html = implode(",", $ans);
				break;
			case 'M':
				$n = 1;
                $ans_arr = array();
                while($n<=$qnum){
                	$ans_arr[] = (isset($_POST['ans'.$qno.'_'.$n]) && !empty($_POST['ans'.$qno.'_'.$n])) ? trim($_POST['ans'.$qno.'_'.$n]):'';
                    $n++;
                }
                $ans_html = implode(",", $ans_arr);
                break;
		}
		$this->load->model("ExamModel");
		//存答案
		$this->ExamModel->ans_save($epart, $qno, $ans_html);
		switch ($act) {
			case 'n': //下一題
				$qno++;
				break;
			case 'p': //上一題
				$qno--;
				break;
			case 'q':
				$qno = $_POST['next_qno'];
				break;
			case 'f': //完成
				$sets_sub = $this->ExamModel->view_sets_sub($spart);
				// 核對答案
				foreach ($sets_sub as $sv) {
					$this->ExamModel->check_corr($epart, $sv->SQ_SORT, $sv->ANS);
				}				
				return;
				break;
		}
		$que = $this->ExamModel->next_que($epart, $qno);
		$data = $this->_que_info_format($que, $qno);
		echo json_encode($data);
	}
	//看結果
	public function score($eid){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET")return;
		$eid = (int)$eid;
		$show_ans = false;
		$ans_alt = '';
		if (!empty($_GET)){
			$ans_alt = (isset($_GET['alt']) && !empty($_GET['alt'])) ? trim($_GET['alt']):'';
			if ($ans_alt==="ans")$show_ans = true;
		}

		$this->load->model("ExamModel");
		//主卷結果
		$main_score = $this->ExamModel->exam_rs($eid);
		$this->load->model("SetsModel");
		$sets_set = $this->SetsModel->review_sets(array($main_score->SID));
		//大題結果
		$sub_score = $this->ExamModel->exam_srs($eid);
		$data = array();
		foreach ($sub_score as $i => $sv) {
			$sub_que = $this->ExamModel->ans_que($sv->SCID);
			$data_q = array();
			foreach ($sub_que as $q) {
				$tmp = $this->_score_que_format($q);
				array_push($data_q, $tmp);
			}
			array_push($data, $data_q);
		}
		$url = '';
		if (!$show_ans){
			$url = '$(".ans").on("click", function(){
		        location.href = "'.site_url('/exam/score/'.$eid).'?alt=ans";
		    });';
		}else{
			$url = '$(".nans").on("click", function(){
		        location.href = "'.site_url('/exam/score/'.$eid).'";
		    });';
		}
		$uses_time = strtotime($main_score->SC_END) - strtotime($main_score->SC_DATE);
		$use = new stdclass;
        $use->hour = floor($uses_time/3600);
        $use->min = floor(($uses_time%3600)/60);
        $use->sec = floor($uses_time%60);

		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '測驗結果'
		));
		$this->load->view('exam/result', array(
			'Eid' => $eid,
			'Setsname' => $sets_set->SETS_NAME,
			'Open_ans' => $show_ans,
			'Data' => $data,
			'Part' => $sub_score,
			'Main' => $main_score,
			'Url' => $url,
			'UseTime' => $use
		));
	}
	//結果格式化
	private function _score_que_format($que){
		$data = new stdclass;
		$my_ans = '';
		//題型、答案
		switch ($que->QUE_TYPE) {
			case "S": 
				$data->ANS_RIGHT = chr($que->ANS+64);
				if (!empty($que->SD_ANS)) $my_ans = chr($que->SD_ANS+64);
				break;
			case "D": 
				$ans = array();
				$ans = explode(",", $que->ANS);
				$ans_html = array();
				foreach ($ans as $o) {
					$ans_html[] = chr($o+64);
				}
				$data->ANS_RIGHT = implode(", ", $ans_html);

				if (!empty($que->SD_ANS)) {
					$ans = array();
					$ans = explode(",", $que->SD_ANS);
					$ans_html = array();
					foreach ($ans as $o) {
						$ans_html[] = chr($o+64);
					}
					$my_ans = implode(", ", $ans_html);
				}
				break;
			case "R": 
				$data->ANS_RIGHT = ($que->ANS==="1") ? "O":"X";
				if (!empty($que->SD_ANS)) $my_ans = ($que->SD_ANS==="1") ? "O":"X";
				break;
			case "M": 
				$ans = array();
				$ans = explode(",", $que->ANS);
				$ans_html = array();
				foreach ($ans as $o) {
					if (!preg_match("/^[0-9]*$/", $o)){
						$ans_html[] = ($o==="a") ? '-':'±';
					}else{
						$ans_html[] = $o;
					}
				}
				$data->ANS_RIGHT = implode(", ", $ans_html);

				if (!empty($que->SD_ANS)){
					$ans = array();
					$ans = explode(",", $que->SD_ANS);
					$ans_html = array();
					foreach ($ans as $o) {
						if (!preg_match("/^[0-9]*$/", $o)){
							$ans_html[] = ($o==="a") ? '-':'±';
						}else{
							$ans_html[] = $o;
						}
					}
					$my_ans = implode(", ", $ans_html);
				}
				break;
		}
		$data->MY_ANS = $my_ans;
		$data->CORR = ($data->ANS_RIGHT===$data->MY_ANS) ? '<font color="green">O</font>':'<font color="red">X</font>';
		
		$qcont =  array();
		//題目文字
		if (!empty($que->QUETXT)) $qcont[] = nl2br(trim($que->QUETXT));
		//題目圖檔
		if (!empty($que->QIMGSRC)){
			if(is_file($que->QIMGSRC))$qcont[] = '<IMG src="'.base_url($que->QIMGSRC).'" width="98%">';
		}
		//題目聲音檔
		if (!empty($que->QSOUNDSRC)){
    		if(is_file($que->QSOUNDSRC)){
    			$qcont[] = '<font color="green">題目音訊</font>';
    		}else{
    			$qcont[] = '<font color="red">題目音訊遺失</font>';
    		}
    	}
    	$data->QCONT = implode("<br>", $qcont);

    	$acont = array();
    	//詳解文字
    	if (!empty($que->ANSTXT)) $acont[] = nl2br(trim($que->ANSTXT));
    	//詳解圖檔
    	if(!empty($que->AIMGSRC)){
			if (is_file($que->AIMGSRC))$acont[] = '<IMG  src="'.base_url($que->AIMGSRC).'" width="98%">';
		}
		$amedia = array();
		//詳解聲音檔
		if(!empty($que->ASOUNDSRC)){
			if(is_file($que->ASOUNDSRC)){
				$amedia[] = '<audio controls preload controlsList="nodownload" oncontextmenu="return false;">
                        <source src="'.base_url($que->ASOUNDSRC).'" type="audio/mpeg">
                        <em>提醒您，您的瀏覽器無法支援此服務的媒體，請更新</em>
                      </audio>';
        	}else{
        		$amedia[] = '<font color="red">詳解音訊遺失</font>';
        	}
		}
		//詳解影片檔
		if(!empty($que->AVIDEOSRC)){
			if(is_file($que->AVIDEOSRC)){
				$amedia[] = '<video controls preload controlsList="nodownload" oncontextmenu="return false;" style="max-width:100%;">
                        <source src="'.base_url($que->AVIDEOSRC).'" type="video/mp4">
                        <em>提醒您，您的瀏覽器無法支援此服務的媒體，請更新</em>
                     </video>';
        	}else{
        		$amedia[] = '<font color="red">詳解視訊遺失</font>';
        	}
        }
    	$data->ACONT = '<br>'.implode("<br>", $amedia);
    	return $data;
	}
	// 題目格式化
	private function _que_info_format($que, $no){
		$data = new stdclass;
		$data->qid = $que->QID;
		$data->qnum = $que->NUM;
		$data->type = $que->QUE_TYPE;
		$ans_html = '';
		switch ($que->QUE_TYPE) {
			case 'S': 
			case 'D': 
				$i = 1;
				if ($que->QUE_TYPE==="S"){
					while ($i<=$que->NUM) {
						$ans_html.= '<label><input type="radio" name="ans'.$no.'" value="'.$i.'">'.chr($i+64).'</label>';
						$i++;
					}
				}else{
					while ($i<=$que->NUM) {
						$ans_html.= '<label><input type="checkbox" name="ans'.$no.'[]" value="'.$i.'">'.chr($i+64).'</label>';
						$i++;
					}
				}
				break;
			case 'R': 
				$ans_html.= '<label><input type="radio" name="ans'.$no.'" value="1">O</label>  ';
				$ans_html.= '<label><input type="radio" name="ans'.$no.'" value="2">X</label>';
				break;
			case 'M': 
				$ans = explode(',', $que->ANS);
				foreach ($ans as $i => $o) {
					$ans_html.= '<div id="a'.($i+1).'" class="Mq"><span>No.'.($i+1).'</span>';
					if (preg_match("/^[0-9]*$/", $o)){
						$now = (int)$o;
					}else{
						if ($o==="a")$now = 10;
						if ($o==="b")$now = 11;
					}
					$each = 1;
					while($each<=9){
						$ans_html.= '<label><input type="radio" name="ans'.$no.'_'.($i+1).'" value="'.$each.'">'.$each.'</label>';
						$each++;
					}
					$ans_html.= '<label><input type="radio" name="ans'.$no.'_'.($i+1).'" value="0">0</label>';
					$ans_html.= '<label><input type="radio" name="ans'.$no.'_'.($i+1).'" value="a">-</label>';
					$ans_html.= '<label><input type="radio" name="ans'.$no.'_'.($i+1).'" value="b">±</label>';
					$ans_html.= '</div>';
				}
				break;
		}
		$data->ans = $ans_html;

		$qcont =  array();
		//題目文字
		if (!empty($que->QUETXT)) $qcont[] = nl2br(trim($que->QUETXT));
		//題目圖檔
		if (!empty($que->QIMGSRC)){
			if(is_file($que->QIMGSRC))$qcont[] = '<IMG class="pic" src="'.base_url($que->QIMGSRC).'">';
		}
		//題目聲音檔
		if (!empty($que->QSOUNDSRC)){
    		if(is_file($que->QSOUNDSRC))$qcont[] = '音訊';
    	}
    	$data->qcont = implode("<br>", $qcont);
    	return  $data;
	}
}