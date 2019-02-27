<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//題庫
class Question extends Gold_Controller {

	function __construct(){
		parent::__construct();
	}
	// 老師的
	public function index(){
		$method = $_SERVER['REQUEST_METHOD'];
		$page = (isset($_GET['p']) && (int)$_GET['p']>0) ? (int)$_GET['p']:1;
		$this->_page($page);
		$this->load->model("QuestionModel");
		$search = array();
		$p_gra = 0;
		$p_subj = 0;
		$p_chap = 0;
		$p_degree = '';
		$p_keyword = '';

		$sel_Degree = new stdClass;
		$sel_Degree->A = '';
		$sel_Degree->E = '';
		$sel_Degree->M = '';
		$sel_Degree->H = '';
		if (!empty($_GET)){
			$p_gra = (isset($_GET['gra']) && (int)$_GET['gra']>0) ? (int)$_GET['gra']:0;
			$p_subj = (isset($_GET['subj']) && (int)$_GET['subj']>0) ? (int)$_GET['subj']:0;
			$p_chap = (isset($_GET['chap']) && (int)$_GET['chap']>0) ? (int)$_GET['chap']:0;
			$p_degree = (isset($_GET['degree']) && !empty($_GET['degree'])) ? trim($_GET['degree']):'';
			$p_keyword = (isset($_GET['q']) && !empty($_GET['q'])) ? trim($_GET['q']):'';
			if ($p_gra>0)$search['GRA'] = $p_gra;
			if ($p_subj>0)$search['SUBJ'] = $p_subj;
			if ($p_chap>0)$search['CHAP'] = $p_chap;
			if (!empty($p_degree)){
				$in = true;
				switch ($p_degree) {
		        	case 'M': $sel_Degree->M = 'selected'; break;
		        	case 'H': $sel_Degree->H = 'selected'; break;
		        	case 'E': $sel_Degree->E = 'selected'; break;
		        	default: $in = false; break;
		        }
		        if ($in)$search['DEGREE'] = $p_degree;
			}
		}
		$que_row = $this->QuestionModel->que_rows($search, $p_keyword);
		$que_data = $this->QuestionModel->que_data($this->_pstart(), $this->_pend());

		$pagegroup = ceil($que_row/$this->_prow());
		$prev_act = ($page>1) ? 'onclick="pg('.($page-1).')"':'style="visibility: hidden;"';
		$next_act = ($pagegroup>$page) ? 'onclick="pg('.($page+1).')"':'style="visibility: hidden;"';
		$prev = '<input type="button" class="btn btn-default" '.$prev_act.' value="上一頁">';
		$next = '<input type="button" class="btn btn-default" '.$next_act.' value="下一頁">';
		$pg = '';
		for ($i = 1; $i<=$pagegroup;$i++){
			$pg.='<option value="'.$i.'">第'.$i.'頁</option>';
		}
		//年級、科目 篩選條件
		$this->load->model("BasicModel");
		$gra_html = '';
		$subj_html = '';
		$chap_html = '';
		$grade_data = $this->BasicModel->get_grade();
		$subject_data = array();
		$chapter_data = array();
		if (!empty($grade_data)){
			foreach ($grade_data as $v) {
				$sel_gra = ($p_gra===$v->ID) ? 'selected':'';
				$gra_html.= '<option '.$sel_gra.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
		}
		if ($p_gra>0){
			$subject_data = $this->BasicModel->get_subject(array($p_gra));
			if (!empty($subject_data)){
				foreach ($subject_data as $v) {
					$sel_subj = ($p_subj===$v->ID) ? 'selected':'';
					$subj_html.= '<option '.$sel_subj.' value="'.$v->ID.'">'.$v->NAME.'</option>';
				}
			}
		}
		if ($p_subj>0){
			$chapter_data = $this->BasicModel->get_chapter(array($p_gra, $p_subj));
			if (!empty($chapter_data)){
				foreach ($chapter_data as $v) {
					$sel_chap = ($p_chap===$v->ID) ? 'selected':'';
					$chap_html.= '<option '.$sel_chap.' value="'.$v->ID.'">'.$v->NAME.'</option>';
				}
			}
		}
		$this->load->model("KnowledgeModel");

		$gra_id = array();
		$gra_name = array();
		$subj_id = array();
		$subj_name = array();
		$chap_id = array();
		$chap_name = array();				

		foreach ($que_data as $k => $v) {
			
			
			$qcont =  array();
			//題目文字
			if (!empty($v->QUETXT)) $qcont[] = nl2br(trim($v->QUETXT));
			//題目圖檔
			if (!empty($v->QIMGSRC)){
				if(is_file($v->QIMGSRC))$qcont[] = '<IMG name="t_imgsrc" src="'.base_url($v->QIMGSRC).'" width="80%">';
			}
			//題目聲音檔
			if (!empty($v->QSOUNDSRC)){
        		if(is_file($v->QSOUNDSRC)){
        			$qcont[] = '<font color="green">題目音訊</font>';
        		}else{
        			$qcont[] = '<font color="red">題目音訊遺失</font>';
        		}
        	}
        	$que_data[$k]->QCONT = implode("<br>", $qcont);

        	$acont = array();
        	//詳解文字
        	if (!empty($v->ANSTXT)) $acont[] = nl2br(trim($v->ANSTXT));
        	//詳解圖檔
        	if(!empty($v->AIMGSRC)){
				if (is_file($v->AIMGSRC))$acont[] = '<IMG name="t_imgsrc"  src="'.base_url($v->AIMGSRC).'" width="80%">';
			}
			$amedia = array();
			//詳解聲音檔
			if(!empty($v->ASOUNDSRC)){
				if(is_file($v->ASOUNDSRC)){
	        		$amedia[] = '<font color="green">詳解音訊</font>';
	        	}else{
	        		$amedia[] = '<font color="red">詳解音訊遺失</font>';
	        	}
			}
			//詳解影片檔
			if(!empty($v->AVIDEOSRC)){
				if(is_file($v->AVIDEOSRC)){
	        		$amedia[] = '<font color="green">詳解視訊</font>';
	        	}else{
	        		$amedia[] = '<font color="red">詳解視訊遺失</font>';
	        	}
	        }
	        $acont[] = implode(' | ', $amedia);
        	$que_data[$k]->ACONT = '<br>'.implode("<br>", $acont);
        	$que_data[$k]->KCONT = '';
			//難度
			switch ($v->DEGREE) {
				case "M": $que_data[$k]->DEGREE = "中等"; break;
				case "H": $que_data[$k]->DEGREE = "困難"; break;
				case "E": $que_data[$k]->DEGREE = "容易"; break;
				default: $que_data[$k]->DEGREE = "容易"; break;
			}
			if ($v->QUE_TYPE!=="G"){
			//年級
				if (!empty($v->GRA)){
					if(in_array($v->GRA, $gra_id)){
						$que_data[$k]->GRA = $gra_name[array_search($v->GRA, $gra_id)];
					}else{
						$gra_id[] = $v->GRA;
						$gname = $this->BasicModel->get_onegsc(array($v->GRA));
						$gra_name[] = $gname->NAME;
						$que_data[$k]->GRA = $gname->NAME;
					}
				}
				//科目
				if (!empty($v->SUBJ)){
					if (in_array($v->SUBJ, $subj_id)){
						$que_data[$k]->SUBJ = $subj_name[array_search($v->SUBJ, $subj_id)];
					}else{
						$subj_id[] = $v->SUBJ;
						$subjname = $this->BasicModel->get_onegsc(array($v->SUBJ));
						$subj_name[] = $subjname->NAME;
						$que_data[$k]->SUBJ = $subjname->NAME;
					}
				}
				//科目
				if (!empty($v->CHAP)){
					if (in_array($v->CHAP, $chap_id)){
						$que_data[$k]->CHAP = $chap_name[array_search($v->CHAP, $chap_id)];
					}else{
						$chap_id[] = $v->CHAP;
						$chapname = $this->BasicModel->get_onegsc(array($v->CHAP));
						$chap_name[] = $chapname->NAME;
						$que_data[$k]->CHAP = $chapname->NAME;
					}
				}
			}else{
				$que_data[$k]->GRA = '';
				$que_data[$k]->SUBJ = '';
				$que_data[$k]->CHAP = '';
				$que_data[$k]->DEGREE = '';
			}
			// 知識點
			if ($v->POINT>0){
				$know = $this->KnowledgeModel->view_knowledge(array($v->POINT));
				$que_data[$k]->KCONT = '<br>知識點：'.$know->K_NAME;
			}
			$que_data[$k]->QUE_TYPE_EN = $v->QUE_TYPE;
			$data = $this->_que_ans_format($v);
			$que_data[$k]->QUE_TYPE = $data->QUE_TYPE;
			$que_data[$k]->ANS = $data->ANS;
		}
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '我的題庫'
		));
		$this->load->view('question/index', array(
			'Grade' => $gra_html,
			'Subject' => $subj_html,
			'Chapter' => $chap_html,
			'Keyword' => $p_keyword,
			'Data' => $que_data,
			'Prev' => $prev,
			'Next' => $next,
			'Pg' => $pg,
			'Degree' => $sel_Degree,
			'Num' => $que_row
		));
	}
	// 補習班的
	public function cram(){
		$method = $_SERVER['REQUEST_METHOD'];
		$page = (isset($_GET['p']) && (int)$_GET['p']>0) ? (int)$_GET['p']:1;
		$this->_page($page);
		$this->load->model("QuestionModel");
		$search = array();
		$p_gra = 0;
		$p_subj = 0;
		$p_chap = 0;
		$p_degree = '';
		$p_keyword = '';
		$sel_Degree = new stdClass;
		$sel_Degree->A = '';
		$sel_Degree->E = '';
		$sel_Degree->M = '';
		$sel_Degree->H = '';

		if (!empty($_GET)){
			$p_gra = (isset($_GET['gra']) && (int)$_GET['gra']>0) ? (int)$_GET['gra']:0;
			$p_subj = (isset($_GET['subj']) && (int)$_GET['subj']>0) ? (int)$_GET['subj']:0;
			$p_chap = (isset($_GET['chap']) && (int)$_GET['chap']>0) ? (int)$_GET['chap']:0;
			$p_degree = (isset($_GET['degree']) && !empty($_GET['degree'])) ? trim($_GET['degree']):'';
			$p_keyword = (isset($_GET['q']) && !empty($_GET['q'])) ? trim($_GET['q']):'';
			if ($p_gra>0)$search['GRA'] = $p_gra;
			if ($p_subj>0)$search['SUBJ'] = $p_subj;
			if ($p_chap>0)$search['CHAP'] = $p_chap;
			if (!empty($p_degree)){
				$in = true;
				switch ($p_degree) {
		        	case 'M': $sel_Degree->M = 'selected'; break;
		        	case 'H': $sel_Degree->H = 'selected'; break;
		        	case 'E': $sel_Degree->E = 'selected'; break;
		        	default: $in = false; break;
		        }
		        if ($in)$search['DEGREE'] = $p_degree;
			}
		}
		$que_row = $this->QuestionModel->quecram_rows($search, $p_keyword);
		$que_data = $this->QuestionModel->quecram_data($this->_pstart(), $this->_pend());

		$pagegroup = ceil($que_row/$this->_prow());
		$prev_act = ($page>1) ? 'onclick="pg('.($page-1).')"':'style="visibility: hidden;"';
		$next_act = ($pagegroup>$page) ? 'onclick="pg('.($page+1).')"':'style="visibility: hidden;"';
		$prev = '<input type="button" class="btn btn-default" '.$prev_act.' value="上一頁">';
		$next = '<input type="button" class="btn btn-default" '.$next_act.' value="下一頁">';
		$pg = '';
		for ($i = 1; $i<=$pagegroup;$i++){
			$pg.='<option value="'.$i.'">第'.$i.'頁</option>';
		}
		//年級、科目 篩選條件
		$this->load->model("BasicModel");
		$gra_html = '';
		$subj_html = '';
		$chap_html = '';
		$grade_data = $this->BasicModel->get_grade();
		$subject_data = array();
		$chapter_data = array();
		if (!empty($grade_data)){
			foreach ($grade_data as $v) {
				$sel_gra = ($p_gra===$v->ID) ? 'selected':'';
				$gra_html.= '<option '.$sel_gra.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
		}
		if ($p_gra>0){
			$subject_data = $this->BasicModel->get_subject(array($p_gra));
			if (!empty($subject_data)){
				foreach ($subject_data as $v) {
					$sel_subj = ($p_subj===$v->ID) ? 'selected':'';
					$subj_html.= '<option '.$sel_subj.' value="'.$v->ID.'">'.$v->NAME.'</option>';
				}
			}
		}
		if ($p_subj>0){
			if (!empty($subject_data)){
				foreach ($subject_data as $v) {
					$sel_subj = ($p_subj===$v->ID) ? 'selected':'';
					$subj_html.= '<option '.$sel_subj.' value="'.$v->ID.'">'.$v->NAME.'</option>';
				}
				$chapter_data = $this->BasicModel->get_chapter(array($p_gra, $p_subj));
			}
		}
		if (!empty($chapter_data)){
			foreach ($chapter_data as $v) {
				$sel_chap = ($p_chap===$v->ID) ? 'selected':'';
				$chap_html.= '<option '.$sel_chap.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
		}
		$gra_id = array();
		$gra_name = array();
		$subj_id = array();
		$subj_name = array();
		$chap_id = array();
		$chap_name = array();
		foreach ($que_data as $k => $v) {
			$data = $this->_que_ans_format($v);
			$que_data[$k]->QUE_TYPE = $data->QUE_TYPE;
			$que_data[$k]->ANS = $data->ANS;
			$que_data[$k]->DEGREE = $data->DEGREE;
			$qcont =  array();
			//題目文字
			if (!empty($v->QUETXT)) $qcont[] = nl2br(trim($v->QUETXT));
			//題目圖檔
			if (!empty($v->QIMGSRC)){
				if(is_file($v->QIMGSRC))$qcont[] = '<IMG src="'.base_url($v->QIMGSRC).'" width="80%">';
			}
			//題目聲音檔
			if (!empty($v->QSOUNDSRC)){
        		if(is_file($v->QSOUNDSRC)){
        			$qcont[] = '<font color="green">題目音訊</font>';
        		}else{
        			$qcont[] = '<font color="red">題目音訊遺失</font>';
        		}
        	}
        	$que_data[$k]->QCONT = implode("<br>", $qcont);

        	$acont = array();
        	//詳解文字
        	if (!empty($v->ANSTXT)) $acont[] = nl2br(trim($v->ANSTXT));
        	//詳解圖檔
        	if(!empty($v->AIMGSRC)){
				if (is_file($v->AIMGSRC))$acont[] = '<IMG  src="'.base_url($v->AIMGSRC).'" width="80%">';
			}

			$amedia = array();
			//詳解聲音檔
			if(!empty($v->ASOUNDSRC)){
				if(is_file($v->ASOUNDSRC)){
	        		$amedia[] = '<font color="green">詳解音訊</font>';
	        	}else{
	        		$amedia[] = '<font color="red">詳解音訊遺失</font>';
	        	}
			}
			//詳解影片檔
			if(!empty($v->AVIDEOSRC)){
				if(is_file($v->AVIDEOSRC)){
	        		$amedia[] = '<font color="green">詳解視訊</font>';
	        	}else{
	        		$amedia[] = '<font color="red">詳解視訊遺失</font>';
	        	}
	        }
	        $acont[] = implode(' | ', $amedia);
        	$que_data[$k]->ACONT = '<br>'.implode("<br>", $acont);
			
			//年級
			if (!empty($v->GRA)){
				if(in_array($v->GRA, $gra_id)){
					$que_data[$k]->GRA = $gra_name[array_search($v->GRA, $gra_id)];
				}else{
					$gra_id[] = $v->GRA;
					$gname = $this->BasicModel->get_onegsc(array($v->GRA));
					$gra_name[] = $gname->NAME;
					$que_data[$k]->GRA = $gname->NAME;
				}
			}
			//科目
			if (!empty($v->SUBJ)){
				if (in_array($v->SUBJ, $subj_id)){
					$que_data[$k]->SUBJ = $subj_name[array_search($v->SUBJ, $subj_id)];
				}else{
					$subj_id[] = $v->SUBJ;
					$subjname = $this->BasicModel->get_onegsc(array($v->SUBJ));
					$subj_name[] = $subjname->NAME;
					$que_data[$k]->SUBJ = $subjname->NAME;
				}
			}
			//科目
			if (!empty($v->CHAP)){
				if (in_array($v->CHAP, $chap_id)){
					$que_data[$k]->CHAP = $chap_name[array_search($v->CHAP, $chap_id)];
				}else{
					$chap_id[] = $v->CHAP;
					$chapname = $this->BasicModel->get_onegsc(array($v->CHAP));
					$chap_name[] = $chapname->NAME;
					$que_data[$k]->CHAP = $chapname->NAME;
				}
			}
		}
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '補習班題庫'
		));
		$this->load->view('question/list', array(
			'Grade' => $gra_html,
			'Subject' => $subj_html,
			'Chapter' => $chap_html,
			'Keyword' => $p_keyword,
			'Data' => $que_data,
			'Prev' => $prev,
			'Next' => $next,
			'Pg' => $pg,
			'Degree' => $sel_Degree,
			'Num' => $que_row
		));
	}
	// 新增頁
	public function create(){
		$sets_message = '';//'<div id="sets_title"><label class="17">'.$msg.'</label></div>';
		$data = array();
		//年級、科目 篩選條件
		$this->load->model("BasicModel");
		$Q_Grade = '';
		$Q_Subject = '';
		$Q_Chapter = '';
		$Sets = '';
		$grade_data = $this->BasicModel->get_grade();
		$subject_data = array();
		$chap_data = array();
		if (!empty($grade_data)){
			foreach ($grade_data as $v) {
				$Q_Grade.= '<option value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
			$subject_data = $this->BasicModel->get_subject(array($grade_data[0]->ID));
		}
		if (!empty($subject_data)){
			foreach ($subject_data as $v) {
				$Q_Subject.= '<option value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
			$chap_data = $this->BasicModel->get_chapter(array($grade_data[0]->ID, $subject_data[0]->ID));
		}
		if (!empty($chap_data)){
			foreach ($chap_data as $v) {
				$Q_Chapter.= '<option value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
		}
		
		//題目圖片
		$qimg_html = '';
		$data['Qimg'] = '';
		
		$qimg_html.= '<input type="button" value="上傳圖檔" id="nque" class="btn w160 h25" onClick="uque(this.id)" >   ';
		$data['Qimg_html'] = $qimg_html;
		$data['Sets_msg'] = $sets_message;
		$data['Q_Grade'] = $Q_Grade;
        $data['Q_Subject'] = $Q_Subject;
        $data['Q_Chapter'] = $Q_Chapter;

        //詳解圖片
        $aimg_html = '';
		$data['Aimg'] = '';
		
		$aimg_html.= '<input type="button" value="上傳圖檔" id="nans" class="btn w160 h25" onClick="uans(this.id)" >   ';
		$data['Aimg_html'] = $aimg_html;
		//難度
        $degree = new stdClass;
        $degree->E = 'checked';
        $degree->M = '';
        $degree->H = '';
        $data['Degree'] = $degree;
        $data['que_type'] = '';
		$this->load->view('_header_sub', array(
			'title' => '建立題庫'
		));
		$this->load->view('question/create', $data);
	}
	//執行新增
	public function add(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		$que_type = (isset($_POST['f_qus_type']) && !empty($_POST['f_qus_type'])) ? trim($_POST['f_qus_type']):'';
		$quetxt = (isset($_POST['f_quetxt']) && !empty($_POST['f_quetxt'])) ? trim($_POST['f_quetxt']):'';
		$graid = (isset($_POST['f_grade']) && (int)$_POST['f_grade']>0) ? (int)$_POST['f_grade']:0;
		$subjid = (isset($_POST['f_subject']) && (int)$_POST['f_subject']>0) ? (int)$_POST['f_subject']:0;
		$chapid = (isset($_POST['f_chapterui']) && (int)$_POST['f_chapterui']>0) ? (int)$_POST['f_chapterui']:0;
		$degree = (isset($_POST['f_degree']) && !empty($_POST['f_degree'])) ? trim($_POST['f_degree']):"E";
		$anstxt = (isset($_POST['f_anstxt']) && !empty($_POST['f_anstxt'])) ? trim($_POST['f_anstxt']):'';
		$qimg = (isset($_POST['f_qimg']) && !empty($_POST['f_qimg'])) ? trim($_POST['f_qimg']):'';
		$aimg = (isset($_POST['f_aimg']) && !empty($_POST['f_aimg'])) ? trim($_POST['f_aimg']):'';
		$point = (isset($_POST['f_pid']) && !empty($_POST['f_pid'])) ? (int)$_POST['f_pid']:0;
		$qpath = '';
		$apath = '';

		if ($graid===0 || $subjid===0 || $chapid===0){
			$this->_errmsg(400);
			return;
		}
		switch ($que_type) {
			case 'S'://單選
			case 'D'://複選
			case 'R'://是非
				if ($que_type==="R"){
					$num = 2;
				}else{
					$num = (isset($_POST['option_num']) && (int)$_POST['option_num']>1) ? (int)$_POST['option_num']:2;	
				}
				$ans = (isset($_POST['ans']) && is_array($_POST['ans'])) ? $_POST['ans']:array();
				//複選 => 1↑
				//單選 or 是非 => only 1
				if (($que_type==="D" && count($ans)<2) || ($que_type!=="D" && count($ans)!==1)){
					$this->_errmsg(400);
					return;
				}
				$error = false;
				foreach ($ans as $v) {
					$e = (int)$v;
					if ($e<=0){
						$error = true;
						break;
					}
				}
				if ($error){
					$this->_errmsg(400);
					return;
				}
				$all_ans = implode(",", $ans);
				break;
			case 'M'://選填
				$num = (isset($_POST['num']) && (int)$_POST['num']>0) ? (int)$_POST['num']:1;
				$i = 1;
				$ans = array();
				while ($i<=$num) {
					$each_ans = (isset($_POST['ans'.$i])) ? $_POST['ans'.$i]:-1;
					if ($each_ans===-1 || !preg_match("/^[0-9ab]*$/", $each_ans)){
						$this->_errmsg(400);
						return;
					}
					$ans[] = $each_ans;
					$i++;
				}
				//數量不對
				if ($num!==count($ans)){
					$this->_errmsg(400);
					return;
				}
				$all_ans = implode(",", $ans);
				break;
			default:
				$this->_errmsg(400);
				return;
				break;
		}
		$dir = $_SESSION['gold']->code.'/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir.= 'questions/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir_tmp = $dir.'tmp/';
		if (!is_dir($dir_tmp))mkdir($dir_tmp, 777);

		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'jpg|jpeg|png|mp3|mp4';
		$config['max_size'] = '10485760';//10M
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		
		$qs_src = '';
		$qs_name = '';
		if (!empty($_FILES['qsound']['name'])){
			$this->upload->do_upload('qsound');
			$result = $this->upload->data();
			$qs_src = $dir.$result['file_name'];
			$qs_name = $result['orig_name'];
		}
		$as_src = '';
		$as_name = '';
		if (!empty($_FILES['asound']['name'])){
			$this->upload->do_upload('asound');
			$result = $this->upload->data();
			$as_src = $dir.$result['file_name'];
			$as_name = $result['orig_name'];
		}
		$av_src = '';
		$av_name = '';
		if (!empty($_FILES['avideo']['name'])){
			$this->upload->do_upload('avideo');
			$result = $this->upload->data();
			$av_src = $dir.$result['file_name'];
			$av_name = $result['orig_name'];
		}
		if (!empty($qimg)){
			if (is_file($dir_tmp.$qimg)){
				$ext = pathinfo($qimg, PATHINFO_EXTENSION);
				$old_nam = $dir_tmp.$qimg;
				$new_name = $dir.md5(uniqid(rand(), true)).'.'.$ext;
				rename($old_nam, $new_name);
				$qpath = $new_name;
			}
		}
		if (!empty($aimg)){
			if (is_file($dir_tmp.$aimg)){
				$ext = pathinfo($aimg, PATHINFO_EXTENSION);
				$old_nam = $dir_tmp.$aimg;
				$new_name = $dir.md5(uniqid(rand(), true)).'.'.$ext;
				rename($old_nam, $new_name);
				$apath = $new_name;
			}	
		}
		$this->load->model("QuestionModel");
		$this->QuestionModel->create_que(array(
			'QUE_TYPE' => $que_type,
			'QUETXT' => $quetxt,
			'QIMGSRC' => $qpath,
			'QSOUNDSRC' => $qs_src,
			// 'QS_NAME' => $qs_name,
			'KEYWORD' => '',
			'POINT' => $point,
			'GRA' => $graid,
			'SUBJ' => $subjid,
			'CHAP' => $chapid,
			'DEGREE' => $degree,
			'NUM' => $num,
			'ANS' => $all_ans,
			'OWNER' => $_SESSION['gold']->epno,
			'CREATETIME' => date('Y/m/d H:i:s'),
			'UPDATETIME' => date('Y/m/d H:i:s'),
			'ANSTXT' => $anstxt,
			'AIMGSRC' => $apath,
			'ASOUNDSRC' => $as_src,
			// 'AS_NAME' => $as_name,
			'AVIDEOSRC' => $av_src,
			// 'AV_NAME' => $av_name
		));
		$json['Success'] = true;
		echo json_encode($json);
	}
	//預覽
	public function show($id){
		if ($this->dp_info->dp_type!=="T"){
			echo('很抱歉，權限不足以瀏覽');
			return;
		}
		$id = (int)$id;
		$this->load->model("QuestionModel");
		$this->load->model("BasicModel");
		$que = $this->QuestionModel->view_que($id);
		$data = $this->_que_ans_format($que, 'info');
		$sub_que = array();
		$sub_data = array();
		$Gname = '';
		$Subjname = '';
		$Chapname = '';
		if ($que->QUE_TYPE==="G"){
			$sub_que = $this->QuestionModel->view_que_sub($id);
			foreach ($sub_que as $v) {
				$tmp = $this->_que_ans_format($v, 'info');
				$know = '';
				if ($v->POINT>0){
					$this->load->model("KnowledgeModel");
					$know_data = $this->KnowledgeModel->view_knowledge(array($v->POINT));
					$know_content = array('<strong>'.$know_data->K_NAME.'</strong>');
					if (!empty($know_data->K_CONTENT))$know_content[] = trim($know_data->K_CONTENT);
					if (!empty($know_data->K_PIC) && is_file($know_data->K_PIC)){
						$know_content[] = '<img src="'.base_url($know_data->K_PIC).'" width="80%">';
					}
					$know = implode("<br>", $know_content);
				}
				$tmp->Qid = $v->QID;
				$tmp->Know = $know;
				$grade = $this->BasicModel->get_onegsc(array($v->GRA));
				$tmp->Grade = $grade->NAME;
				$subject = $this->BasicModel->get_onegsc(array($v->SUBJ));
				$tmp->Subj = $subject->NAME;
				$chapter = $this->BasicModel->get_onegsc(array($v->CHAP));	
				$tmp->Chap = $chapter->NAME;

				$sub_data[] = $tmp;
			}
		}else{
			$grade = $this->BasicModel->get_onegsc(array($que->GRA));
			$Gname = $grade->NAME;
			$subject = $this->BasicModel->get_onegsc(array($que->SUBJ));
			$Subjname = $subject->NAME;
			$chapter = $this->BasicModel->get_onegsc(array($que->CHAP));	
			$Chapname = $chapter->NAME;
		}
		

		$know = '';
		if ($que->POINT>0){
			$this->load->model("KnowledgeModel");
			$know_data = $this->KnowledgeModel->view_knowledge(array($que->POINT));
			$know_content = array('<strong>'.$know_data->K_NAME.'</strong>');
			if (!empty($know_data->K_CONTENT))$know_content[] = trim($know_data->K_CONTENT);
			if (!empty($know_data->K_PIC) && is_file($know_data->K_PIC)){
				$know_content[] = '<img src="'.base_url($know_data->K_PIC).'" width="80%">';
			}
			$know = implode("<br>", $know_content);
		}
		
		$this->load->view('_header_sub', array(
			'ident' => $this->dp_info,
			'title' => '題目資訊'
		));
		$this->load->view('question/info', array(
			'Qid' => $id,
			'Owner' => $que->OWNER,
			'Que_type' => $data->QUE_TYPE,
			'Qcont' => $data->QCONT,
			'Acont' => $data->ACONT,
			'Grade' => $Gname,
			'Subj' => $Subjname,
			'Chap' => $Chapname,
			'Qtype' => $que->QUE_TYPE,
			'Ans' => $data->ANS,
			'Degree' => $data->DEGREE,
			'Know' => $know,
			'Sub_que' => $sub_data,
			'Have_sub' => $que->QUE_SUB
		));
	}
	//編輯頁
	public function edit($qid){
		$qid = (int)$qid;
		if ($_SESSION['gold']->ident!=="A" && $_SESSION['gold']->ident!=="T"){
			die('很抱歉，權限不足');
			return;
		}
		$this->load->model("QuestionModel");
		$que = $this->QuestionModel->view_que($qid);
		if ($que==null)die('無此資料');

		$this->load->view('_header_sub', array(
			'title' => '編輯題目'
		));
		$data = array();
		$que_type = new stdClass;
		$que_type->S = '';
		$que_type->D = '';
		$que_type->R = '';
		$que_type->M = '';
		$que_type->G = '';
		$ans_html = '';
		$option_num = '';
		$num = '';
		$data['Qid'] = $qid;
		$data['now_type'] = '';
		$data['Num'] = '';
		$data['Rtype'] = '';
		$data['Correct_ans_math'] = '';
		switch ($que->QUE_TYPE) {
			case 'S': 
			case 'D': 
				//選項個數
		        $num_i = 2;
		        while ($num_i<=12) {
		        	$num_sel = ($num_i===$que->NUM) ? 'selected':'';
		        	$option_num.= '<option '.$num_sel.' value="'.$num_i.'">'.$num_i.'</option>';
		        	$num_i++;
		        }
		        //正確答案
		        $ans_i = 1;
		        if ($que->QUE_TYPE==="S"){
		        	$que_type->S = 'checked';
		        	while ($ans_i<=$que->NUM) {
			        	$ans_sel = ($ans_i===(int)$que->ANS) ? 'checked':'';
			        	$ans_html.= '<label><input name="ans[]" '.$ans_sel.' type="radio" value="'.$ans_i.'"><font id="ans_'.$ans_i.'">'.chr($ans_i+64).'</font></label>';
			        	$ans_i++;
			        }
		        }else{
		        	$que_type->D = 'checked';
		        	$ans = explode(',', $que->ANS);
		        	while ($ans_i<=$que->NUM) {
		        		$ans_sel = '';
			        	foreach ($ans as $v) {
			        		if ((int)$v==$ans_i){
			        			$ans_sel = 'checked';
			        			break;
			        		}
			        	}
			        	$ans_html.= '<label><input name="ans[]" '.$ans_sel.' type="checkbox" value="'.$ans_i.'"><font id="ans_'.$ans_i.'">'.chr($ans_i+64).'</font></label>';
			        	$ans_i++;
			        }
		        }
				break;
			case 'R': 
				$que_type->R = 'checked';
				$data['Rtype'] = 'style="display:none;"';
				$ans_html = '<label><input type="radio" '.(($que->ANS==="1") ? 'checked':'').' name="ans[]" value="1">O</label>  ';
				$ans_html.= '<label><input type="radio" '.(($que->ANS==="2") ? 'checked':'').' name="ans[]" value="2">X</label>';
				break;
			case 'M': 
				$que_type->M = 'checked';
				$data['now_type'] = "change_type('M');";
		        $num_i = 1;
		        while ($num_i<=12) {
		        	$num_sel = ($num_i===$que->NUM) ? 'selected':'';
		        	$num.= '<option '.$num_sel.' value="'.$num_i.'">'.$num_i.'</option>';
		        	$num_i++;
		        }
				$ans_math = '';
				$ans = explode(',', $que->ANS);
				foreach ($ans as $i => $o) {
					$ans_math.= '<div id="a'.($i+1).'"><span>No.'.($i+1).'</span>';

					if (preg_match("/^[0-9]*$/", $o)){
						$now = (int)$o;
					}else{
						if ($o==="a")$now = 10;
						if ($o==="b")$now = 11;
					}
					$each = 1;
					while($each<=9){
						$sel = ($each===$now) ? 'checked':'';
						$ans_math.= '<label><input type="radio" '.$sel.' name="ans'.($i+1).'" value="'.$each.'">'.$each.'</label>';
						$each++;
					}
					$ans_math.= '<label><input type="radio" '.(($now===0) ? 'checked':'').' name="ans'.($i+1).'" value="0">0</label>';
					$ans_math.= '<label><input type="radio" '.(($now===10) ? 'checked':'').' name="ans'.($i+1).'" value="a">-</label>';
					$ans_math.= '<label><input type="radio" '.(($now===11) ? 'checked':'').' name="ans'.($i+1).'" value="b">±</label>';
					$ans_math.= '</div>';
				}
				$data['Correct_ans_math'] = $ans_math;
				break;
		}
		//單複選 選項個數 初始化
		if ($que->QUE_TYPE!=="S" && $que->QUE_TYPE!=="D"){
			$num_i = 2;
	        while ($num_i<=12) {
	        	$num_sel = ($num_i===$que->NUM) ? 'selected':'';
	        	$option_num.= '<option '.$num_sel.' value="'.$num_i.'">'.$num_i.'</option>';
	        	$num_i++;
	        }
		}		
		//選填 題數個數 初始化
		if ($que->QUE_TYPE!=="M"){
	        $num_i = 1;
	        while ($num_i<=12) {
	        	$num.= '<option value="'.$num_i.'">'.$num_i.'</option>';
	        	$num_i++;
	        }
		}
        $data['Option_num'] = $option_num;
        $data['Num'] = $num;
        $data['Ans'] = $ans_html;
		$data['Que_type'] = $que_type;

		$this->load->model("BasicModel");
		$Grade = '';
		$Subject = '';
		$Chapter = '';
        $grade_data = $this->BasicModel->get_grade();
		$subject_data = array();
		$chap_data = array();
		if (!empty($grade_data)){
			foreach ($grade_data as $v) {
				$g_sel = ($que->GRA===$v->ID) ? 'selected':'';
				$Grade.= '<option '.$g_sel.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
			$subject_data = $this->BasicModel->get_subject(array($que->GRA));
		}
		if (!empty($subject_data)){
			foreach ($subject_data as $v) {
				$s_sel = ($que->SUBJ===$v->ID) ? 'selected':'';
				$Subject.= '<option '.$s_sel.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
			$chap_data = $this->BasicModel->get_chapter(array($que->GRA, $que->SUBJ));
		}
		if (!empty($chap_data)){
			foreach ($chap_data as $v) {
				$c_sel = ($que->CHAP===$v->ID) ? 'selected':'';
				$Chapter.= '<option '.$c_sel.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
		}
		$data['Q_Grade'] = $Grade;
        $data['Q_Subject'] = $Subject;
        $data['Q_Chapter'] = $Chapter;
		//題目圖片
		$qimg_html = '';
		$del_qimg = '';
		$data['Qimg'] = '';
		if (!empty($que->QIMGSRC)){
			if (is_file($que->QIMGSRC)){
				$data['Qimg'] = base_url($que->QIMGSRC);
				$del_qimg = '<input type="button" value="刪除圖檔" id="deque" class="btn w100 h25" onClick="uque(this.id)" >   ';
			}
		}
		$qimg_html.= '<input type="button" value="上傳圖檔(裁剪後刪檔)" id="nque" class="btn w160 h25" onClick="uque(this.id)" >   ';
		$qimg_html.= '<input type="button" value="上傳圖檔(裁剪後不刪檔)" id="dnque" class="btn w160 h25" onClick="uque(this.id)" >   ';
		$qimg_html.= $del_qimg;
        $data['Qimgsrc'] = $que->QIMGSRC;
		$data['Qimg_html'] = $qimg_html;

		//題目音訊
		$qsound_html = '';
        if (!empty($que->QSOUNDSRC)){
            if (is_file($que->QSOUNDSRC)){
				$qsound_html.= '<div id="qsound_d"><audio controls preload controlsList="nodownload">
                        <source src="'.base_url($que->QSOUNDSRC).'" type="audio/mpeg">
                        <em>提醒您，您的瀏覽器無法支援此服務的媒體，請更新</em>
                      </audio>';
                $qsound_html.= '<br><input type="button" value="刪除聲音檔"  class="btn w100" name="delqaudio" id="delqaudio" onclick="rem(this.id)"></div>';
                $qsound_html.= '<input type="hidden" name="qsound" id="qsound" value="'.$que->QSOUNDSRC.'">';
            }else{
            	$qsound_html.= '<font color="red">檔案遺失</font>';
            }
        }
		$data['Quetxt'] = $que->QUETXT;
        $data['Qsoundsrc'] = $que->QSOUNDSRC;
        $data['Qsound_html'] = $qsound_html;
        $data['Keyword'] = $que->KEYWORD;
        //詳解圖片
		$aimg_html = '';
		$del_aimg = '';
		$data['Aimg'] = '';
		if (!empty($que->AIMGSRC)){
			if (is_file($que->AIMGSRC)){
				$data['Aimg'] = base_url($que->AIMGSRC);
				$del_aimg = '<input type="button" value="刪除圖檔" id="deans" class="btn w100 h25" onClick="uans(this.id)" >   ';
			}
		}
		$aimg_html.= '<input type="button" value="上傳圖檔(裁剪後刪檔)" id="nans" class="btn w160 h25" onClick="uans(this.id)" >   ';
		$aimg_html.= '<input type="button" value="上傳圖檔(裁剪後不刪檔)" id="dnans" class="btn w160 h25" onClick="uans(this.id)" >   ';
		$aimg_html.= $del_aimg;

		$data['Anstxt'] = $que->ANSTXT;
        $data['Aimgsrc'] = $que->AIMGSRC;
		$data['Aimg_html'] = $aimg_html;
		//詳解音訊
		$asound_html = '';
        if (!empty($que->ASOUNDSRC)){
            if (is_file($que->ASOUNDSRC)){
				$asound_html.= '<div id="asound_d" style="display: inline-block;"><audio controls preload controlsList="nodownload" oncontextmenu="return false;">
                        <source src="'.base_url($que->ASOUNDSRC).'" type="audio/mpeg">
                        <em>提醒您，您的瀏覽器無法支援此服務的媒體，請更新</em>
                      </audio>';
                $asound_html.= '<br><input type="button" value="刪除聲音檔"  class="btn w100" name="delsaudio" id="delsaudio" onclick="rem(this.id)"></div>';
                $asound_html.= '<input type="hidden" name="f_asound" id="f_asound" value="'.$que->ASOUNDSRC.'">';
            }else{
            	$asound_html.= '<font color="red">檔案遺失</font>';
            }
        }
        $data['Asoundsrc'] = $que->ASOUNDSRC;
        $data['Asound_html'] = $asound_html;
        //詳解視訊
		$avideo_html = '';
        if (!empty($que->AVIDEOSRC)){
            if (is_file($que->AVIDEOSRC)){
				$avideo_html.= '<div id="avideo_d"><video controls preload controlsList="nodownload" oncontextmenu="return false;">
                        <source src="'.base_url($que->AVIDEOSRC).'" type="video/mp4">
                        <em>提醒您，您的瀏覽器無法支援此服務的媒體，請更新</em>
                     </video>';
                $avideo_html.= '<br><input type="button" value="刪除影片檔"  class="btn w100" name="delsavideo" id="delsavideo" onclick="rem(this.id)"></div>';
                $avideo_html.= '<input type="hidden" name="f_avideo" id="f_avideo" value="'.$que->AVIDEOSRC.'">';
            }else{
            	$avideo_html.= '<font color="red">檔案遺失</font>';
            }
        }else{
            $avideo_html.= '<br>';
        }
        $data['Avideosrc'] = $que->AVIDEOSRC;
        $data['Avideo_html'] = $avideo_html;

        $data['Know_id'] = $que->POINT;
        if (!empty($que->POINT)){
        	$this->load->model("KnowledgeModel");
	        $know = $this->KnowledgeModel->view_knowledge(array($que->POINT));
	        $data['Know_content'] = '知識點：'.$know->K_NAME.'　<input type="button" class="btn w160 h25" id="clear_know" value="取消知識點">';
        }else{
        	$data['Know_content'] = '';
        }        
        //難度
        $degree = new stdClass;
        $degree->E = '';
        $degree->M = '';
        $degree->H = '';
        switch ($que->DEGREE) {
        	case 'M': $degree->M = 'checked'; break;
        	case 'H': $degree->H = 'checked'; break;
        	case 'E': $degree->E = 'checked'; break;
        	default: $degree->E = 'checked'; break;
        }
        $data['Degree'] = $degree;

		$this->load->view("question/edit", $data);
	}
	//更新
	public function update($qid){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		$que_type = (isset($_POST['f_qus_type']) && !empty($_POST['f_qus_type'])) ? trim($_POST['f_qus_type']):'';
		$quetxt = (isset($_POST['f_quetxt']) && !empty($_POST['f_quetxt'])) ? trim($_POST['f_quetxt']):'';
		// $keyword = (isset($_POST['f_keyword']) && !empty($_POST['f_keyword'])) ? trim($_POST['f_keyword']):'';
		$point = (isset($_POST['f_pid']) && !empty($_POST['f_pid'])) ? (int)$_POST['f_pid']:0;
		$graid = (isset($_POST['f_grade']) && (int)$_POST['f_grade']>0) ? (int)$_POST['f_grade']:0;
		$subjid = (isset($_POST['f_subject']) && (int)$_POST['f_subject']>0) ? (int)$_POST['f_subject']:0;
		$chapid = (isset($_POST['f_chapterui']) && (int)$_POST['f_chapterui']>0) ? (int)$_POST['f_chapterui']:0;
		$degree = (isset($_POST['f_degree']) && !empty($_POST['f_degree'])) ? trim($_POST['f_degree']):"E";
		$anstxt = (isset($_POST['f_anstxt']) && !empty($_POST['f_anstxt'])) ? trim($_POST['f_anstxt']):'';

		$qimg = (isset($_POST['f_qimg']) && !empty($_POST['f_qimg'])) ? trim($_POST['f_qimg']):'';
		$qsound = (isset($_POST['f_qsound']) && !empty($_POST['f_qsound'])) ? trim($_POST['f_qsound']):'';
		$aimg = (isset($_POST['f_aimg']) && !empty($_POST['f_aimg'])) ? trim($_POST['f_aimg']):'';
		$asound = (isset($_POST['f_asound']) && !empty($_POST['f_asound'])) ? trim($_POST['f_asound']):'';
		$qpath = '';
		$apath = '';

		if ($graid===0 || $subjid===0 || $chapid===0){
			$this->_errmsg(400);
			return;
		}
		switch ($que_type) {
			case 'S'://單選
			case 'D'://複選
			case 'R'://是非
				if ($que_type==="R"){
					$num = 2;
				}else{
					$num = (isset($_POST['option_num']) && (int)$_POST['option_num']>1) ? (int)$_POST['option_num']:2;	
				}
				$ans = (isset($_POST['ans']) && is_array($_POST['ans'])) ? $_POST['ans']:array();
				//複選 => 1↑
				//單選 or 是非 => only 1
				if (($que_type==="D" && count($ans)<2) || ($que_type!=="D" && count($ans)!==1)){
					$this->_errmsg(400);
					return;
				}
				$error = false;
				foreach ($ans as $v) {
					$e = (int)$v;
					if ($e<=0){
						$error = true;
						break;
					}
				}
				if ($error){
					$this->_errmsg(400);
					return;
				}
				$all_ans = implode(",", $ans);
				break;
			case 'M'://選填
				$num = (isset($_POST['num']) && (int)$_POST['num']>0) ? (int)$_POST['num']:1;
				$i = 1;
				$ans = array();
				while ($i<=$num) {
					$each_ans = (isset($_POST['ans'.$i])) ? $_POST['ans'.$i]:-1;
					if ($each_ans===-1 || !preg_match("/^[0-9ab]*$/", $each_ans)){
						$this->_errmsg(400);
						return;
					}
					$ans[] = $each_ans;
					$i++;
				}
				//數量不對
				if ($num!==count($ans)){
					$this->_errmsg(400);
					return;
				}
				$all_ans = implode(",", $ans);
				break;
			default:
				$this->_errmsg(400);
				return;
				break;
		}
		$dir = $_SESSION['gold']->code.'/questions/';
		$dir_tmp = $dir.'tmp/';
		$config['upload_path'] = $dir;
		$config['allowed_types'] = 'mp3|mp4';
		$config['max_size'] = '10485760';//10M
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		
		$qs_src = '';
		$qs_name = '';
		if (!empty($_FILES['qsound']['name'])){
			$this->upload->do_upload('qsound');
			$result = $this->upload->data();
			$qs_src = $dir.$result['file_name'];
			$qs_name = $result['orig_name'];
		}
		$as_src = '';
		$as_name = '';
		if (!empty($_FILES['asound']['name'])){
			$this->upload->do_upload('asound');
			$result = $this->upload->data();
			$as_src = $dir.$result['file_name'];
			$as_name = $result['orig_name'];
		}
		$av_src = '';
		$av_name = '';
		if (!empty($_FILES['avideo']['name'])){
			$this->upload->do_upload('avideo');
			$result = $this->upload->data();
			$av_src = $dir.$result['file_name'];
			$av_name = $result['orig_name'];
		}
		if (!empty($qimg)){
			if (is_file($dir_tmp.$qimg)){
				$ext = pathinfo($qimg, PATHINFO_EXTENSION);
				$old_nam = $dir_tmp.$qimg;
				$new_name = $dir.md5(uniqid(rand(), true)).'.'.$ext;
				rename($old_nam, $new_name);
				$qpath = $new_name;
			}else if (is_file($qimg)){
				$qpath = $qimg;
			}
		}
		if (!empty($aimg)){
			if (is_file($dir_tmp.$aimg)){
				$ext = pathinfo($aimg, PATHINFO_EXTENSION);
				$old_nam = $dir_tmp.$aimg;
				$new_name = $dir.md5(uniqid(rand(), true)).'.'.$ext;
				rename($old_nam, $new_name);
				$apath = $new_name;
			}else if (is_file($aimg)){
				$apath = $aimg;
			}
		}
		$this->load->model("QuestionModel");
		$this->QuestionModel->update_que($qid, array(
			'QUE_TYPE' => $que_type,
			'QUETXT' => $quetxt,
			'QIMGSRC' => $qpath,
			'QSOUNDSRC' => $qs_src,
			// 'QS_NAME' => $qs_name,
			// 'KEYWORD' => $keyword,
			'GRA' => $graid,
			'SUBJ' => $subjid,
			'CHAP' => $chapid,
			'DEGREE' => $degree,
			'NUM' => $num,
			'ANS' => $all_ans,
			'OWNER' => $_SESSION['gold']->epno,
			'UPDATETIME' => date('Y/m/d H:i:s'),
			'POINT' => $point,
			'ANSTXT' => $anstxt,
			'AIMGSRC' => $apath,
			'ASOUNDSRC' => $as_src,
			// 'AS_NAME' => $as_name,
			'AVIDEOSRC' => $av_src,
			// 'AV_NAME' => $av_name
		));
		$json['Success'] = true;
		echo json_encode($json);
	}
		//更新
	public function updateg($qid){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		var_dump($_POST);
		exit;
		// 		f_quetxt
		// f_qimg  qimg
		// qsound

		$quetxt = (isset($_POST['f_quetxt']) && !empty($_POST['f_quetxt'])) ? trim($_POST['f_quetxt']):'';

		//f_pid

		// old
		$old_qimg = (isset($_POST['f_qimg']) && !empty($_POST['f_qimg'])) ? trim($_POST['f_qimg']):'';
		$old_qsound = (isset($_POST['f_qsound']) && !empty($_POST['f_qsound'])) ? trim($_POST['f_qsound']):'';
		

		$qimg = (isset($_POST['qimg']) && !empty($_POST['qimg'])) ? trim($_POST['qimg']):'';
		$qsound = (isset($_POST['f_qsound']) && !empty($_POST['f_qsound'])) ? trim($_POST['f_qsound']):'';

		$qpath = '';
		$apath = '';


		$config['upload_path'] = 'questions/';
		$config['allowed_types'] = 'jpg|jpeg|png|mp3|mp4';
		$config['max_size'] = '10485760';//10M
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		
		$qs_src = '';
		$qs_name = '';
		if (!empty($_FILES['qsound']['name'])){
			$this->upload->do_upload('qsound');
			$result = $this->upload->data();
			$qs_src = 'questions/'.$result['file_name'];
			$qs_name = $result['orig_name'];
		}
		$as_src = '';
		$as_name = '';
		if (!empty($_FILES['asound']['name'])){
			$this->upload->do_upload('asound');
			$result = $this->upload->data();
			$as_src = 'questions/'.$result['file_name'];
			$as_name = $result['orig_name'];
		}
		$av_src = '';
		$av_name = '';
		if (!empty($_FILES['avideo']['name'])){
			$this->upload->do_upload('avideo');
			$result = $this->upload->data();
			$av_src = 'questions/'.$result['file_name'];
			$av_name = $result['orig_name'];
		}
		if (!empty($qimg)){
			if (is_file($dir_tmp.$qimg)){
				$ext = pathinfo($qimg, PATHINFO_EXTENSION);
				$old_nam = $dir_tmp.$qimg;
				$new_name = 'questions/'.md5(uniqid(rand(), true)).'.'.$ext;
				rename($old_nam, $new_name);
				$qpath = $new_name;
			}
		}
		if (!empty($aimg)){
			if (is_file($dir_tmp.$aimg)){
				$ext = pathinfo($aimg, PATHINFO_EXTENSION);
				$old_nam = $dir_tmp.$aimg;
				$new_name = 'questions/'.md5(uniqid(rand(), true)).'.'.$ext;
				rename($old_nam, $new_name);
				$apath = $new_name;
			}	
		}
		$this->load->model("QuestionModel");
		$this->QuestionModel->create_que(array(
			'QUE_TYPE' => $que_type,
			'QUETXT' => $quetxt,
			'QIMGSRC' => $qpath,
			'QSOUNDSRC' => $qs_src,
			// 'QS_NAME' => $qs_name,
			'KEYWORD' => $keyword,
			'GRA' => $graid,
			'SUBJ' => $subjid,
			'CHAP' => $chapid,
			'DEGREE' => $degree,
			'NUM' => $num,
			'ANS' => $all_ans,
			'OWNER' => $_SESSION['gold']->epno,
			'CREATETIME' => date('Y/m/d H:i:s'),
			'UPDATETIME' => date('Y/m/d H:i:s'),
			'ANSTXT' => $anstxt,
			'AIMGSRC' => $apath,
			'ASOUNDSRC' => $as_src,
			// 'AS_NAME' => $as_name,
			'AVIDEOSRC' => $av_src,
			// 'AV_NAME' => $av_name
		));
		$json['Success'] = true;
		echo json_encode($json);
	}
	//ajax科目考卷
	public function ajsets(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET"){
			$this->_errmsg(400);
			return;
		}
		$type = (isset($_GET['type']) && !empty($_GET['type'])) ? trim($_GET['type']):'';
		$graid = (isset($_GET['g']) && !empty($_GET['g'])) ? (int)$_GET['g']:0;
		$subjid = (isset($_GET['s']) && !empty($_GET['s'])) ? (int)$_GET['s']:0;
		if ($type!=="sets" || $graid<=0 || $subjid<=0){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("SetsModel");
		$sets_data = $this->SetsModel->gs_getsets(array($graid, $subjid));
		if (empty($sets_data)){
			$sets_data = array(array(
				'ID' => 0,
				'SETS_NAME' => '無考卷'
			));
		}
		echo json_encode($sets_data);
	}
	//題目圖片上傳
	/**********************************************************
    /*  程式名稱：檔案上傳
    /*  作者：Jerry
    /*  其它說明：最新版，捨棄exec-im_convert，改用php imagick。上傳之圖檔統一轉成jpg
    /*********************************************************/
	public function qupload(){
		ini_set('memory_limit', '64M');
		header("Content-Type:text/html; charset=utf-8");
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET"){
			$this->_errmsg(400);
			return;
		}
		$max_file = 8;
		$dir = $_SESSION['gold']->code.'/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir.= 'questions/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir_tmp = $dir.'tmp/';
		if (!is_dir($dir_tmp))mkdir($dir_tmp, 777);

		$type = (isset($_GET['type']) && !empty($_GET['type'])) ? trim($_GET['type']):'';
		if ($type==="dnque"){
			$src = $dir_tmp."dnqr_".$_SESSION['gold']->epno.".jpg";
			if (is_file($src)){
				$thumb_width = "1000";
				$thumb_height = "300";

				$current_width = $this->_getWidth($src);
				$current_height = $this->_getHeight($src);
				///限制只能抓比原圖長寬小的正方形範圍
				//133*179  99*133
				if($current_width<$thumb_width || $current_height<$thumb_height){
					if($current_width<$thumb_width) $thumb_width = $current_width;
			        if($current_height<$thumb_height) $thumb_height = $current_height;
			    	if($current_width<$current_height) $thumb_height = $current_width;
			    	else $thumb_width = $current_height;
				}

				$this->load->view('question/cutpic', array(
					'type' => $type,
					'src' => $src,
					'thumb_w' => $thumb_width,
					'thumb_h' => $thumb_height,
					'current_w' => $current_width,
					'current_h' => $current_height
				));
				return;
			}
		}
		if ($type==="dnans"){
			$src = $dir_tmp."dnar_".$_SESSION['gold']->epno.".jpg";
			if (is_file($src)){
				$thumb_width = "1000";
				$thumb_height = "300";

				$current_width = $this->_getWidth($src);
				$current_height = $this->_getHeight($src);
				///限制只能抓比原圖長寬小的正方形範圍
				//133*179  99*133
				if($current_width<$thumb_width || $current_height<$thumb_height){
					if($current_width<$thumb_width) $thumb_width = $current_width;
			        if($current_height<$thumb_height) $thumb_height = $current_height;
			    	if($current_width<$current_height) $thumb_height = $current_width;
			    	else $thumb_width = $current_height;
				}

				$this->load->view('question/cutpic', array(
					'type' => $type,
					'src' => $src,
					'thumb_w' => $thumb_width,
					'thumb_h' => $thumb_height,
					'current_w' => $current_width,
					'current_h' => $current_height
				));
				return;
			}
		}
		$this->load->view("_header_sub", array(
			'title' => '題目圖片上傳'
		));
		$this->load->view("question/upload_pic", array(
			'max_file' => $max_file,
			'post' => '',
			'type' => $type
		));
	}
	/*
	上傳程式，統一轉jpg
	*/
	public function upload_act(){
		$allowed_types = array(
			'image/jpeg'=>'jpeg',
			'image/jpeg'=>'jpg',
			'image/png'=>'png',
			'application/pdf'=>'pdf'
		);
		$type = (isset($_POST['type']) && !empty($_POST['type'])) ? trim($_POST['type']):'';
		$max_file=8;

		$dir = $_SESSION['gold']->code.'/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir.= 'questions/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir_tmp = $dir.'tmp/';
		if (!is_dir($dir_tmp))mkdir($dir_tmp, 777);

		$epno = $_SESSION['gold']->epno;
		$config['upload_path'] = $dir_tmp;
		$config['allowed_types'] = "jpg|jpeg|png";
		$config['max_size'] = '104857600';//100M
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		if (empty($_FILES['qmg'])){
			$json['code'] = 2;
			$json['msg'] = '請先選擇要上傳之檔案';
			echo json_encode($json);
			exit;
		}
		$q_type = array('dnclque','nclque','nque','dnque');
		$ext = strtolower(pathinfo($_FILES['qmg']['name'], PATHINFO_EXTENSION));
		if ($type==="dnque"){
			$file_name = 'dnqr_'.$epno;	
		}else{
			if (in_array($type, $q_type)){
				$file_name = 'nqr_'.$epno;
			}else{
				if ($type==="dnans"){
					$file_name = 'dnar_'.$epno;	
				}else{
					$file_name = 'nar_'.$epno;
				}
			}
		}
		
		if (!move_uploaded_file($_FILES['qmg']['tmp_name'], $dir_tmp.$file_name.'.'.$ext)){
			$json['code'] = 2;
			$json['msg'] = '上傳錯誤';
			echo json_encode($json);
			exit;
		}
		$img = new Imagick();
		$img->readImage($_SERVER['DOCUMENT_ROOT'].'/gold/'.$dir_tmp.$file_name.'.'.$ext);
		$srcWH = $img->getImageGeometry();//取得長寬
		$outW = 1000;
		$outH = $srcWH['height'] = $srcWH['height']/$srcWH['width']*1000;
		$img->setImageFormat('jpg');
		$img->resizeImage($outW, $outH, imagick::FILTER_UNDEFINED, 1);//改大小
		$img->writeImage($_SERVER['DOCUMENT_ROOT'].'/gold/'.$dir_tmp.$file_name.'.jpg');//轉新圖
		$img->clear();
		$img->destroy();
		$json = new stdClass;
		$json->src = $dir_tmp.$file_name.'.jpg';
		echo json_encode($json);
	}
	/*
	刪圖檔
	編輯的不刪
	新增的暫存檔才刪
	*/
	public function rmpic(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST")exit;
		$type = (isset($_POST['type']) && !empty($_POST['type'])) ? trim($_POST['type']):'';
		$epno = $_SESSION['gold']->epno;
		switch ($type) {
			case 'deque':
			case 'dedque':
			case 'dque':
				if ($type==="dque"){
					$del_file = array('nqr_'.$epno.'.jpg', 'nqrc_'.$epno.'.jpg', 'dnqr_'.$epno.'.jpg', 'dnqrc_'.$epno.'.jpg');
					foreach ($del_file as $v) {
						if (is_file($dir_tmp.$v)){
							if (unlink($dir_tmp.$v)){}
						}
					}
				}
				$btn_html = '<input type="button" value="上傳圖檔" id="nque" class="btn w160 h25" onClick="uque(this.id)" >   ';
				break;
			case 'deans':
			case 'dans':
				if ($type==="dans"){
					$del_file = array('nar_'.$epno.'.jpg', 'narc_'.$epno.'.jpg', 'dnar_'.$epno.'.jpg', 'dnarc_'.$epno.'.jpg');
					foreach ($del_file as $v) {
						if (is_file($dir_tmp.$v)){
							if (unlink($dir_tmp.$v)){}
						}
					}
				}
				$btn_html = '<input type="button" value="上傳圖檔" id="nans" class="btn w160 h25" onClick="uans(this.id)" >   ';
				break;
		}
		$json['html'] = $btn_html;
		echo json_encode($json);
	}
	/*
	使用者裁切介面
	*/
	public function qcutpic(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST")exit;
		$type = (isset($_POST['type']) && !empty($_POST['type'])) ? trim($_POST['type']):'';
		$src = (isset($_POST['src']) && !empty($_POST['src'])) ? trim($_POST['src']):'';

		$thumb_width = "1000";
		$thumb_height = "300";

		$current_width = $this->_getWidth($src);
		$current_height = $this->_getHeight($src);
		///限制只能抓比原圖長寬小的正方形範圍
		//133*179  99*133
		if($current_width<$thumb_width || $current_height<$thumb_height){
			if($current_width<$thumb_width) $thumb_width = $current_width;
	        if($current_height<$thumb_height) $thumb_height = $current_height;
	    	if($current_width<$current_height) $thumb_height = $current_width;
	    	else $thumb_width = $current_height;
		}

		$this->load->view('question/cutpic', array(
			'type' => $type,
			'src' => $src,
			'thumb_w' => $thumb_width,
			'thumb_h' => $thumb_height,
			'current_w' => $current_width,
			'current_h' => $current_height
		));
	}
	private function _getHeight($img){
		$size = getimagesize($img);
		return $size[1];
	}
	private function _getWidth($img){
		$size = getimagesize($img);
		return $size[0];
	}
	/*
	裁切圖片程式
	*/
	private function _resize_img($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		//$imageType = image_type_to_mime_type($imageType);
		
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		
	  	// png透明背景處理
	  	// switch($imageType) {
	  	//     case "image/png":
	  	//     case "image/x-png":
	  	//         imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
	  	//         imagealphablending($newImage,false);
	  	//         imagesavealpha($newImage,true);
	  	// }
	  	$source=imagecreatefromjpeg($image);
	  	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	  	imagejpeg($newImage,$thumb_image_name,90);
		// switch($imageType) {
		//     case "image/pjpeg":
		// 	case "image/jpeg":
		// 	case "image/jpg":
		// 		$source=imagecreatefromjpeg($image); 
		// 		break;
		//     case "image/png":
		// 	case "image/x-png":
		// 		$source=imagecreatefrompng($image); 
		// 		break;
	 //  	}
		// imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		// switch($imageType) {
	 //      	case "image/pjpeg":
		// 	case "image/jpeg":
		// 	case "image/jpg":
		//   		imagejpeg($newImage,$thumb_image_name,90); 
		// 		break;
		// 	case "image/png":
		// 	case "image/x-png":
		// 		imagepng($newImage,$thumb_image_name);
		// 		break;
	 //    }
	}
	/*
	程式背景裁切圖片，更新至介面
	*/
	public function cut_act(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST")exit;
		$x1 = (isset($_POST['x1']) && (int)$_POST['x1']>0) ? (int)$_POST['x1']:0;
		$y1 = (isset($_POST['y1']) && (int)$_POST['y1']>0) ? (int)$_POST['y1']:0;
		$w = (isset($_POST['w']) && (int)$_POST['w']>0) ? (int)$_POST['w']:0;
		$h = (isset($_POST['h']) && (int)$_POST['h']>0) ? (int)$_POST['h']:0;
		$src = (isset($_POST['src']) && !empty($_POST['src'])) ? trim($_POST['src']):'';
		$type = (isset($_POST['type']) && !empty($_POST['type'])) ? trim($_POST['type']):'';
		$dir_tmp = $_SESSION['gold']->code.'/questions/tmp/';
		switch ($type) {
			case 'nans':
				$file_name = 'narc_'.$_SESSION['gold']->epno.'.jpg';
				$path = $dir_tmp.$file_name;
				$this->_resize_img($path, $src,$w,$h,$x1,$y1,1);
				if (is_file($src)){if (unlink($src)){}}
				break;
			case 'dnans':
				$file_name = 'dnarc_'.$_SESSION['gold']->epno.'.jpg';
				$path = $dir_tmp.$file_name;
				$this->_resize_img($path, $src,$w,$h,$x1,$y1,1);
				break;
			case 'nque':
				$file_name = 'nqrc_'.$_SESSION['gold']->epno.'.jpg';
				$path = $dir_tmp.$file_name;
				$this->_resize_img($path, $src,$w,$h,$x1,$y1,1);
				if (is_file($src)){if (unlink($src)){}}
				break;
			case 'dnque':
				$file_name = 'dnqrc_'.$_SESSION['gold']->epno.'.jpg';
				$path = $dir_tmp.$file_name;
				$this->_resize_img($path, $src,$w,$h,$x1,$y1,1);
				break;
		}
		if ($type==="nque" || $type==="dnque"){
			$qimg_html = '<input type="button" value="上傳圖檔(裁剪後刪檔)" id="nque" class="btn w160 h25" onClick="uque(this.id)" >   <input type="button" value="刪除圖檔" id="dque" class="btn w100 h25" onClick="uque(this.id)" >   ';
			if ($type==="dnque"){
				$qimg_html = '<input type="button" value="重新裁切" id="dnque" class="btn w100 h25" onClick="uque(this.id);" >';
				$qimg_html.= '<input type="button" value="刪除圖檔" id="dque" class="btn w100 h25" onClick="uque(this.id)" >   ';
			}
		?>
		<script>
			parent.document.getElementById('qimg').src = '<?=base_url('/').$path?>?'+Math.random();
			parent.document.getElementById('f_qimg').value = '<?=$file_name?>';
			parent.document.getElementById('sets_filed').style.display = "none";
			parent.document.getElementById('qimg_content').innerHTML = '<?=$qimg_html?>';
		</script>
		<?php
		}
		if ($type==="nans" || $type==="dnans"){
			$aimg_html = '<input type="button" value="上傳圖檔(裁剪後刪檔)" id="nans" class="btn w160 h25" onClick="uans(this.id)" >   <input type="button" value="刪除圖檔" id="dans" class="btn w100 h25" onClick="uans(this.id)" >   ';
			if ($type==="dnans"){
				$aimg_html = '<input type="button" value="重新裁切" id="dnans" class="btn w100 h25" onClick="uans(this.id);" >';
				$aimg_html.= '<input type="button" value="刪除圖檔" id="dans" class="btn w100 h25" onClick="uans(this.id)" >   ';
			}
		?>
		<script>
			parent.document.getElementById('aimg').src = '<?=base_url('/').$path?>?'+Math.random();
			parent.document.getElementById('f_aimg').value = '<?=$file_name?>';
			parent.document.getElementById('sets_filed').style.display = "none";
			parent.document.getElementById('aimg_content').innerHTML = '<?=$aimg_html?>';
		</script>
		<?php
		}
	}
	private function _que_ans_format($que, $type = ''){
		$data = new stdClass;
		//題型、答案
		switch ($que->QUE_TYPE) {
			case "S": 
				$data->QUE_TYPE = "單選"; 
				$data->ANS = chr($que->ANS+64);
				break;
			case "D": 
				$data->QUE_TYPE = "複選"; 
				$ans = array();
				$ans = explode(",", $que->ANS);
				$ans_html = array();
				foreach ($ans as $o) {
					$ans_html[] = chr($o+64);
				}
				$data->ANS = implode(", ", $ans_html);
				break;
			case "R": 
				$data->QUE_TYPE = "是非"; 
				$data->ANS = ($que->ANS==="1") ? "O":"X";
				break;
			case "M": 
				$data->QUE_TYPE = '選填'; 
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
				$data->ANS = implode(", ", $ans_html);
				break;
			case "G":
				$data->QUE_TYPE = '題組';
				$data->ANS = '';
				break;
		}
		$qcont =  array();
		//題目文字
		if (!empty($que->QUETXT)) $qcont[] = nl2br(trim($que->QUETXT));
		//題目圖檔
		if (!empty($que->QIMGSRC)){
			if(is_file($que->QIMGSRC))$qcont[] = '<IMG src="'.base_url($que->QIMGSRC).'" width="80%">';
		}
		//題目聲音檔
		if (!empty($que->QSOUNDSRC)){
    		if(is_file($que->QSOUNDSRC)){
    			if ($type==="info"){
    				$qcont[] = '<audio controls preload controlsList="nodownload" oncontextmenu="return false;">
                        <source src="'.base_url($que->QSOUNDSRC).'" type="audio/mpeg">
                        <em>提醒您，您的瀏覽器無法支援此服務的媒體，請更新</em>
                      </audio>';
    			}else{
    				$qcont[] = '<font color="green">題目音訊</font>';	
    			}
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
			if (is_file($que->AIMGSRC))$acont[] = '<IMG  src="'.base_url($que->AIMGSRC).'" width="80%">';
		}
		//詳解聲音檔
		if(!empty($que->ASOUNDSRC)){
			if(is_file($que->ASOUNDSRC)){
				if ($type==="info"){
					$acont[] = '<audio controls preload controlsList="nodownload" oncontextmenu="return false;">
                        <source src="'.base_url($que->ASOUNDSRC).'" type="audio/mpeg">
                        <em>提醒您，您的瀏覽器無法支援此服務的媒體，請更新</em>
                      </audio>';
                  }else{
                	$acont[] = '<font color="green">詳解音訊</font>';  	
                  }        		
        	}else{
        		$acont[] = '<font color="red">詳解音訊遺失</font>';
        	}
		}
		//詳解影片檔
		if(!empty($que->AVIDEOSRC)){
			if(is_file($que->AVIDEOSRC)){
				if ($type==="info"){
					$acont[] = '<video controls preload controlsList="nodownload" oncontextmenu="return false;" style="max-width:100%;">
                        <source src="'.base_url($que->AVIDEOSRC).'" type="video/mp4">
                        <em>提醒您，您的瀏覽器無法支援此服務的媒體，請更新</em>
                     </video>';
				}else{
					$acont[] = '<font color="green">詳解視訊</font>';
				}        		
        	}else{
        		$acont[] = '<font color="red">詳解視訊遺失</font>';
        	}
        }
    	$data->ACONT = implode("<br>", $acont);
		//難度
		switch ($que->DEGREE) {
			case "M": $data->DEGREE = "中等"; break;
			case "H": $data->DEGREE = "困難"; break;
			case "E": $data->DEGREE = "容易"; break;
			default: $data->DEGREE = "容易"; break;
		}
		return $data;
	}
}
