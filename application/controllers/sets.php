<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//試卷 一定會有大題
class Sets extends Gold_Controller {

	public $gold = null;

	function __construct(){
		parent::__construct();
	}
	//老師的
	public function index(){
		$page = (isset($_GET['page']) && (int)$_GET['page']>0) ? (int)$_GET['page']:1;
		$this->_page($page);
		$get_gra = (isset($_GET['gra']) && (int)$_GET['gra']>0) ? (int)$_GET['gra']:0;
		$get_subj = (isset($_GET['subj']) && (int)$_GET['subj']>0) ? (int)$_GET['subj']:0;
		$this->load->model("SetsModel");
		$sets_row = $this->SetsModel->tea_sets_row($_SESSION['gold']->epno, $get_gra, $get_subj);
		$sets_data = $this->SetsModel->tea_sets_data($this->_pstart(), $this->_pend());
		//年級、科目 篩選條件
		$this->load->model("BasicModel");
		$gra_html = '';
		$subj_html = '';
		$grade_data = $this->BasicModel->get_grade();
		if (!empty($grade_data)){
			foreach ($grade_data as $v) {
				$sel_gra = ($get_gra===$v->ID) ? 'selected':'';
				$gra_html.= '<option '.$sel_gra.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
		}
		if ($get_gra>0){
			$subject_data = $this->BasicModel->get_subject(array($get_gra));
			if (!empty($subject_data)){
				foreach ($subject_data as $v) {
					$sel_subj = ($get_subj===$v->ID) ? 'selected':'';
					$subj_html.= '<option '.$sel_subj.' value="'.$v->ID.'">'.$v->NAME.'</option>';
				}
			}
		}
		$pagegroup = ceil($sets_row/$this->_prow());
		$prev_act = ($page>1) ? 'onclick="pg('.($page-1).')"':'style="visibility: hidden;"';
		$next_act = ($pagegroup>$page) ? 'onclick="pg('.($page+1).')"':'style="visibility: hidden;"';
		$prev = '<input type="button" class="btn btn-default" '.$prev_act.' value="上一頁">';
		$next = '<input type="button" class="btn btn-default" '.$next_act.' value="下一頁">';
		$pg = '';
		for ($i = 1; $i<=$pagegroup;$i++){
			$pg.='<option value="'.$i.'">第'.$i.'頁</option>';
		}
		$c_id = array();
		$c_name = array();
		$ca_id = array();
		$ca_name = array();
		$gra_id = array();
		$gra_name = array();
		$subj_id = array();
		$subj_name = array();
		$this->load->model('AuthModel');
		$this->AuthModel->Set_db($_SESSION['gold']->code);
		foreach ($sets_data as $k => $v) {
			//年級
			if (!empty($v->GRA)){
				if(in_array($v->GRA, $gra_id)){
					$sets_data[$k]->GRA = $gra_name[array_search($v->GRA, $gra_id)];
				}else{
					$gra_id[] = $v->GRA;
					$gname = $this->BasicModel->get_onegsc(array($v->GRA));
					$gra_name[] = $gname->NAME;
					$sets_data[$k]->GRA = $gname->NAME;
				}
			}
			//科目
			if (!empty($v->SUBJ)){
				if (in_array($v->SUBJ, $subj_id)){
					$sets_data[$k]->SUBJ = $subj_name[array_search($v->SUBJ, $subj_id)];
				}else{
					$subj_id[] = $v->SUBJ;
					$subjname = $this->BasicModel->get_onegsc(array($v->SUBJ));
					$subj_name[] = $subjname->NAME;
					$sets_data[$k]->SUBJ = $subjname->NAME;
				}
			}
		}
		$this->gold = null;
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '我的考卷'
		));
		$this->load->view('sets/index', array(
			'Grade' => $gra_html,
			'Subject' => $subj_html,
			'Data' => $sets_data,
			'Prev' => $prev,
			'Next' => $next,
			'Pg' => $pg,
			'Num' => $sets_row
		));
	}
	//新增頁
	public function create(){
		//考試時間
        $Time = new stdClass;
        $Time->begdate = date('Y/m/d');
        $Time->enddate = date('Y/m/d');
        $Time->begTimeH = '';
        $Time->endTimeH = '';
		$enh = 23;
		for($i=0;$i<24;$i++){
			$h = str_pad($i,2,0,STR_PAD_LEFT);
			$ehs = ($enh == $i) ? 'selected':'';
			$Time->begTimeH.= '<option value="'.$i.'">'.$h.'</option>';
			$Time->endTimeH.= '<option value="'.$i.'"'.$ehs.'>'.$h.'</option>';
		}
		//考試限時
		$Lim = new stdClass;
		$Lim->limTimeH = 1;
		$Lim->limTimeM = 0;
		$Lim->limTimeS = 0;
		$lh = 1;
		for($i=0;$i<24;$i++){
			$limh = ($lh == $i) ? 'selected':'';
			$Lim->limTimeH.= '<option value="'.$i.'"'.$limh.'>'.$i.'</option>';
		}
		$lm = 0;
		for($i=0;$i<60;$i++){
			$m = str_pad($i,2,0,STR_PAD_LEFT);
			$limm = ($lm == $i) ? 'selected':'';
			$Lim->limTimeM.= '<option value="'.$i.'"'.$limm.'>'.$m.'</option>';
			$Lim->limTimeS.= '<option value="'.$i.'"'.$limm.'>'.$m.'</option>';
		}
		$this->load->model("BasicModel");
		$gra_html = '';
		$subj_html = '';
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
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '新增試卷'
		));
		$this->load->view('sets/create', array(
			'Time' => $Time,
			'Lim' => $Lim,
			'Grade' => $gra_html,
			'Subject' => $subj_html,
			'Sum' => 100,
			'Pass' => 60
		));
	}
	//執行新增
	public function add(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg('404');
			return;
		}
		$data = array();
		//年級
		$data['GRA'] = (isset($_POST['grade']) && !empty($_POST['grade'])) ? (int)$_POST['grade']:0;
		//科目
		$data['SUBJ'] = (isset($_POST['subject']) && !empty($_POST['subject'])) ? (int)$_POST['subject']:0;
		//考卷名稱
		$data['SETS_NAME'] = (isset($_POST['setsname']) && !empty($_POST['setsname'])) ? trim($_POST['setsname']):'';
		if ($data['GRA']===0 || $data['SUBJ']===0 || empty($data['SETS_NAME'])){
			$this->_errmsg(400);
			return;
		}
		//說明
		$data['INTRO'] = (isset($_POST['intro']) && !empty($_POST['intro'])) ? trim($_POST['intro']):'';
		//總分
		$data['SUM'] = (isset($_POST['sum']) && !empty($_POST['sum'])) ? (int)$_POST['sum']:100;
		//及格
		$data['PASS_SCORE'] = (isset($_POST['passscore']) && !empty($_POST['passscore'])) ? (int)$_POST['passscore']:60;
		//翻頁控制
		// $data['PAGE'] = (isset($_POST['control']) && !empty($_POST['control'])) ? trim($_POST['control']):'N';
		// $data['PAGE'] = ($data['PAGE']==="N") ? "N":"Y";
		$p_chkdate = (isset($_POST['chk_date'])) ? (int)$_POST['chk_date']:0;
		//時間
		$data['BEGTIME'] = '';
		$data['ENDTIME'] = '';
		if ($p_chkdate===1){
			$p_begdate = (isset($_POST['begdate']) && !empty($_POST['begdate'])) ? trim($_POST['begdate']):'';
			$p_begTimeH = (isset($_POST['begTimeH']) && !empty($_POST['begTimeH'])) ? (int)$_POST['begTimeH']:0;
			$p_begTimeH = str_pad($p_begTimeH,2,0,STR_PAD_LEFT);

			$p_enddate = (isset($_POST['enddate']) && !empty($_POST['enddate'])) ? trim($_POST['enddate']):'';
			$p_endTimeH = (isset($_POST['endTimeH']) && !empty($_POST['endTimeH'])) ? (int)$_POST['endTimeH']:0;
			$p_endTimeH = str_pad($p_endTimeH,2,0,STR_PAD_LEFT);
			$data['BEGTIME'] = $p_begdate.' '.$p_begTimeH.':00:00';
			$data['ENDTIME'] = $p_enddate.' '.$p_endTimeH.':00:00';
		}
		//限時
		$lim = array();
		$p_limTimeH = (isset($_POST['limTimeH']) && (int)$_POST['limTimeM']>=0) ? (int)$_POST['limTimeH']:1;
		$lim[] = str_pad($p_limTimeH,2,0,STR_PAD_LEFT);
		$p_limTimeM = (isset($_POST['limTimeM']) && (int)$_POST['limTimeM']>=0) ? (int)$_POST['limTimeM']:0;
		$lim[] = str_pad($p_limTimeM,2,0,STR_PAD_LEFT);
		$p_limTimeS = (isset($_POST['limTimeS']) && (int)$_POST['limTimeS']>=0) ? (int)$_POST['limTimeS']:0;
		$lim[] = str_pad($p_limTimeS,2,0,STR_PAD_LEFT);
		$data['LIMTIME'] = implode(":", $lim);
		if ($p_limTimeH<=0 && $p_limTimeM<=0 && $p_limTimeS<=0){
			$this->_errmsg(400);
			return;
		}
		//次數 2=>1次(again=0) 1=>多次
		$p_again = (isset($_POST['f_times']) && (int)$_POST['f_times']>=1) ? (int)$_POST['f_times']:2;
		$data['AGAIN'] = ($p_again===2) ? 0:1;
		$data['OWNER'] = $_SESSION['gold']->epno;
		$time = date('Y/m/d H:i:s');
		$data['CREATETIME'] = $time;
		$data['UPDATETIME'] = $time;

		//大題
		$sub_sort = (isset($_POST['sub_sort']) && !empty($_POST['sub_sort'])) ? $_POST['sub_sort']:array();
		$sub_score = (isset($_POST['sub_score']) && !empty($_POST['sub_score'])) ? $_POST['sub_score']:array();
		$sub_intro = (isset($_POST['sub_intro']) && !empty($_POST['sub_intro'])) ? $_POST['sub_intro']:array();
		if (empty($sub_sort) || empty($sub_score) || empty($sub_intro)){
			$this->_errmsg(400);
			return;
		}
		$data['SUB'] = 1;
		$data['PAGE'] = $sub_control[0];
		$this->load->model("SetsModel");
		$id = $this->SetsModel->create_sets($data);
		foreach ($sub_sort as $sk => $sv) {
			$this->SetsModel->create_sub(array(
				'CREATETIME' => $time,
				'UPDATETIME' => $time,
				'OWNER' => $_SESSION['gold']->epno,
				'INTRO' => $sub_intro[$sk],
				'PERCEN' => $sub_score[$sk],
				'PART' => $sv,
				'PAGE' =>$sub_control[$sk],
				'PID' => $id
			));
		}
		redirect('/sets');
	}
	//預覽
	public function review($sid){
		if ($this->dp_info->dp_type==="S"){
			echo('很抱歉，權限不足以瀏覽');
			return;
		}
		$sid = (int)$sid;
		if ($sid<=0){
			die('無此考卷');
			return;
		}
		$this->load->model("SetsModel");
		$data = $this->SetsModel->review_sets(array($sid));
		//限時
		$lime = explode(":", $data->LIMTIME);
		//大題
		$sub = $this->SetsModel->subofsets($sid);
		$part_button = '';
		$part = '';
		$part_que = '';
		//題目排序用
        $part_array = array();
        $First_que = array();
        $sub_que = array();
        if (!empty($sub)){
			foreach ($sub as $i => $v) {
				$j = $i+1;
	            $now = ($j==1) ? 'now':'';
	            //if ($parent_control!='S')$print_control.= '(考卷控制)';
	            $sub_intro[] = trim($v->INTRO);
	            $display_no = ($j>1) ? 'style="display:none;"':'';
	            $part_button.='<input type="button" class="btn w150 h25 bpart_div '.$now.'>" onclick="view('.$j.')" name="bpart" id="bpart'.$j.'" value="第'.$j.'大題('.$v->PERCEN.'%)">';
	            $part.= '<div name="node" id="'.$v->ID.'">';
	            $part.= '<div class="part_sort">: :</div>';
	            $part.= '<div style="display:inline-block;">';
	            $part.= '第'.$j.'大題('.$v->PERCEN.'%)　';
	            $part.= '</div>';
	            $part.= '<div class="sub_intro" name="intro" id="intro'.$i.'">'.nl2br($v->INTRO).'</div>';
	            $part.= '</div>';
	            //按扭
	            $part_que.= '<input type="button" class="btn w100 partq" data-id="'.$v->ID.'" value="第'.$j.'大題">';
	            //題目排序
	            $part_array[] = $v->ID;

	            $ques = $this->SetsModel->sub_que(array($sid, $v->ID));
	            $sub_que[$i] = $this->_part_que($ques);
	        }
		}else{
			//沒有大題
			$ques = $this->SetsModel->sub_que(array($sid, $sid));
			$First_que = $this->_part_que($ques);
		}
        $qdata = array();
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '【'.$data->SETS_NAME.'】試卷預覽'
		));
		$this->load->view('sets/review', array(
			'SETID' => $sid,
			'Set_name' => $data->SETS_NAME,
			'Finish' => $data->FINISH,
			'Sum' => $data->SUM,
			'Pass' => $data->PASS_SCORE,
			'Limtime' => (int)$lime[0].'時'.(int)$lime[1].'分'.(int)$lime[2].'秒',
			'Sub' => $data->SUB,
			'Sub_que' => $sub_que,
			'Part_btn' => $part_que,
			'Part_cont' => $part,
			'Part' => $sub,
			'First_que' => $First_que,
			'Part_ar' => $part_array,
			'Qdata' => $qdata
		));
	}
	//編輯頁
	public function edit($sid){
		$sid = (int)$sid;
		if ($sid<=0){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("SetsModel");
		$data = $this->SetsModel->view_sets(array($sid));
		if ($data==null)die('無此資料');
		//考試時間
		$Time = new stdClass;
        $Time->begTimeH = '';
        $Time->endTimeH = '';
        $Time->date_Y = '';
        $Time->date_N = '';
		if (!empty($data->BEGTIME) && !empty($data->ENDTIME)){
			$begdate = explode(" ", $data->BEGTIME);
			$enddate = explode(" ", $data->ENDTIME);
			$begtime_H = explode(":", $begdate[1]);
			$endtime_H = explode(":", $enddate[1]);
			$beg_H = (int)$begtime_H[0];
			$end_H = (int)$endtime_H[0];
	        $Time->begdate = $begdate[0];
			$Time->enddate = $enddate[0];
			$Time->date_Y = 'checked';
		}else{
			$beg_H = 0;
        	$end_H = 0;
			$Time->begdate = date('Y/m/d');
			$Time->enddate = date('Y/m/d');
			$Time->date_N = 'checked';
		}
		for($i=0;$i<24;$i++){
			$h = str_pad($i,2,0,STR_PAD_LEFT);
			$bhs = ($beg_H == $i) ? 'selected':'';
			$Time->begTimeH.= '<option value="'.$i.'"'.$bhs.'>'.$h.'</option>';
			$ehs = ($end_H == $i) ? 'selected':'';
			$Time->endTimeH.= '<option value="'.$i.'"'.$ehs.'>'.$h.'</option>';
		}
		//考試限時
		$Lim = new stdClass;
		$limtime = explode(":", $data->LIMTIME);
		$lh = (int)$limtime[0];
		$lm = (int)$limtime[1];
		$ls = (int)$limtime[2];
		$Lim->limTimeH = '';
		$Lim->limTimeM = '';
		$Lim->limTimeS = '';
		for($i=0;$i<24;$i++){
			$h = str_pad($i,2,0,STR_PAD_LEFT);
			$limh = ($lh == $i) ? 'selected':'';
			$Lim->limTimeH.= '<option value="'.$i.'"'.$limh.'>'.$h.'</option>';
		}
		for($i=0;$i<60;$i++){
			$m = str_pad($i,2,0,STR_PAD_LEFT);
			$limm = ($lm == $i) ? 'selected':'';
			$lims = ($ls == $i) ? 'selected':'';
			$Lim->limTimeM.= '<option value="'.$i.'"'.$limm.'>'.$m.'</option>';
			$Lim->limTimeS.= '<option value="'.$i.'"'.$lims.'>'.$m.'</option>';
		}
		//重覆考
		$again = new stdClass;
		$again->Y = ($data->AGAIN) ? 'checked':'';
		$again->N = (!$data->AGAIN) ? 'checked':'';

		$this->load->model("BasicModel");
		$gra_html = '';
		$subj_html = '';
		$grade_data = $this->BasicModel->get_grade();
		if (!empty($grade_data)){
			$g_sel = '';
			if (empty($data->GRA))$data->GRA = $grade_data[0]->ID;
			foreach ($grade_data as $v) {
				$g_sel = ($data->GRA===$v->ID) ? 'selected':'';
				$gra_html.= '<option '.$g_sel.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
			$subject_data = $this->BasicModel->get_subject(array($data->GRA));
			if (!empty($subject_data)){
				$s_sel = '';
				foreach ($subject_data as $v) {
					$s_sel = ($data->SUBJ===$v->ID) ? 'selected':'';
					$subj_html.= '<option '.$s_sel.' value="'.$v->ID.'">'.$v->NAME.'</option>';
				}
			}
		}
		//大題
		$sub = $this->SetsModel->view_sets_sub(array($sid));
		//第一大題
		$fsub = array_shift($sub);
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '編輯試卷'
		));

		$this->load->view("sets/edit", array(
			'Sid' => $sid,
			'Setsname' => $data->SETS_NAME,
			'Intro' => $data->INTRO,
			'Time' => $Time,
			'Lim' => $Lim,
			'Again' => $again,
			'Grade' => $gra_html,
			'Subject' => $subj_html,
			'Sum' => $data->SUM,
			'Pass' => $data->PASS_SCORE,
			'fsub' => $fsub,
			'osub' => $sub
		));
	}
	//執行更新
	public function update($sid){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		$date = date('Y/m/d H:i:s');
		$data = array();
		$sets_name = (isset($_POST['setsname']) && !empty($_POST['setsname'])) ? trim($_POST['setsname']):'';
		if (empty($sets_name)){
			$this->_errmsg(400);
			return;
		}
		$limTimeH = (isset($_POST['limTimeH']) && (int)$_POST['limTimeM']>=0) ? (int)$_POST['limTimeH']:0;
		$limTimeM = (isset($_POST['limTimeM']) && (int)$_POST['limTimeM']>=0) ? (int)$_POST['limTimeM']:0;
		$limTimeS = (isset($_POST['limTimeS']) && (int)$_POST['limTimeS']>=0) ? (int)$_POST['limTimeS']:0;
		if ($limTimeH<=0 && $limTimeM<=0 && $limTimeS<=0){
			$this->_errmsg(400);
			return;
		}
		$chk_date = (isset($_POST['chk_date']) && !empty($_POST['chk_date'])) ? (int)$_POST['chk_date']:0;
		$graid = (isset($_POST['grade']) && (int)$_POST['grade']>=1) ? (int)$_POST['grade']:0;
		$subjid = (isset($_POST['subject']) && (int)$_POST['subject']>=1) ? (int)$_POST['subject']:0;
		$sum = (isset($_POST['sum']) && (int)$_POST['sum']>0) ? (int)$_POST['sum']:0;
		$pass_score = (isset($_POST['passscore']) && (int)$_POST['passscore']>0) ? (int)$_POST['passscore']:0;
		if ($graid===0 || $subjid===0 || $sum===0 || $pass_score===0){
			$this->_errmsg(400);
			return;
		}
		$intro = (isset($_POST['intro']) && !empty($_POST['intro'])) ? trim($_POST['intro']):'';
		$data['BEGTIME'] = '';
		$data['ENDTIME'] = '';
		if ($chk_date===1){
			$begdate = (isset($_POST['begdate']) && !empty($_POST['begdate'])) ? trim($_POST['begdate']):'';
			$enddate = (isset($_POST['enddate']) && !empty($_POST['enddate'])) ? trim($_POST['enddate']):'';
			$begTimeH = (isset($_POST['begTimeH'])) ? (int)$_POST['begTimeH']:0;
			$endTimeH = (isset($_POST['endTimeH'])) ? (int)$_POST['endTimeH']:0;
			if (empty($begdate) || empty($enddate)){
				$this->_errmsg(400);
				return;
			}
			$data['BEGTIME'] = $begdate.' '.$begTimeH.':00:00';
			$data['ENDTIME'] = $enddate.' '.$endTimeH.':00:00';
		}
		$data['SETS_NAME'] = $sets_name;
		$data['INTRO'] = $intro;

		$data['LIMTIME'] = str_pad($limTimeH,2,0,STR_PAD_LEFT).":".str_pad($limTimeM,2,0,STR_PAD_LEFT).":".str_pad($limTimeS,2,0,STR_PAD_LEFT);
		//次數 2=>1次(again=0) 1=>多次
		$again = (isset($_POST['f_times']) && (int)$_POST['f_times']>=1) ? (int)$_POST['f_times']:2;
		$data['AGAIN'] = ($again===2) ? 0:1;
		$data['GRA'] = $graid;
		$data['SUBJ'] = $subjid;
		$data['OWNER'] = $_SESSION['gold']->epno;
		$data['UPDATETIME'] = $date;

		// 大題
		$sub_id = (isset($_POST['sub_id']) && !empty($_POST['sub_id'])) ? $_POST['sub_id']:array();
		$sub_sort = (isset($_POST['sub_sort']) && !empty($_POST['sub_sort'])) ? $_POST['sub_sort']:array();
		$sub_score = (isset($_POST['sub_score']) && !empty($_POST['sub_score'])) ? $_POST['sub_score']:array();
		// $sub_control = (isset($_POST['sub_control']) && !empty($_POST['sub_control'])) ? $_POST['sub_control']:array();
		$sub_intro = (isset($_POST['sub_intro']) && !empty($_POST['sub_intro'])) ? $_POST['sub_intro']:array();
		$delsub = (isset($_POST['delsub']) && !empty($_POST['delsub'])) ? trim($_POST['delsub']):'';
		if (empty($sub_id) || empty($sub_score) || empty($sub_sort) || empty($sub_intro)){
			$this->_errmsg(400);
			return;
		}

		$this->load->model("SetsModel");
		$this->SetsModel->update_sets($data, $sid);
		foreach ($sub_id as $sk => $sv) {
			$sub_data = array(
				'PART' => $sub_sort[$sk],
				'PERCEN' => $sub_score[$sk],
				// 'PAGE' => $sub_control[$sk],
				'INTRO' => $sub_intro[$sk],
				'UPDATETIME' => $date
			);
			if (empty($sv)){
				$sub_data['CREATETIME'] = $date;
				$sub_data['OWNER'] = $_SESSION['gold']->epno;
				$sub_data['PID'] = $sid;
				var_dump($sub_data);
				$this->SetsModel->create_sub($sub_data);
			}else{
				var_dump($sub_data);
				echo $sv;
				$this->SetsModel->update_sub($sub_data, $sv);
			}
		}
		//要刪除的大題
		if (!empty($delsub)){
			$del_id = explode(',', $delsub);
			foreach ($del_id as $dv) {
				if (is_numeric($dv))$this->SetsModel->delete_sub(array($dv, $sid));
			}
		}
		// 題目沒刪，只是關聯拿掉
		redirect('/sets');
	}
	//班級設定頁
	public function vclass($sid){
	}
	//設定班級
	public function uclass($sid = null){
	}
	//ajax大題題目
	public function ajqpart(){
		$method = $_SERVER['REQUEST_METHOD'];
		$que = array();
		$sid = (isset($_GET['sid']) && !empty($_GET['sid'])) ? trim($_GET['sid']):0;
		$part = (isset($_GET['part']) && !empty($_GET['part'])) ? trim($_GET['part']):0;
		$this->load->model("SetsModel");
		if ($sid>0 && $part>=0)$que = $this->SetsModel->sub_que(array($sid, $part));
		$html = '';
		$que = $this->_part_que($que);
		$edit = $this->SetsModel->view_sets(array($sid));
		$edit_open = ($edit->FINISH) ? false:true;
		foreach ($que as $v) {
			$rem = ($edit_open) ? '<a href="javascript:void(0)" onclick="remq('.$part.','.$v->SQ_SORT.')" title="移除"><img height="20" src="'.base_url('/images/icon_op_f.png').'"></a>':'';
        	$html.= '<tr align="center" name="node" id="'.$v->QID.'"><td class="handle">: :</td><td class="qno">'.$v->SQ_SORT.'</td><td class="qno_ans">'.$v->ANS.'</td><td width="1000" align="left" class="que">'.$v->QCONT.'</td><td>'.$rem.'</td></tr>';
		}
		$json['html'] = $html;
		echo json_encode($json);
	}
	//預覽用
	private function _part_que($que){
		foreach ($que as $k => $v) {
			//題型、答案
			switch ($v->QUE_TYPE) {
				case "S": 
					$que[$k]->ANS = chr($v->ANS+64);
					break;
				case "D": 
					$ans = array();
					$ans = explode(",", $v->ANS);
					$ans_html = array();
					foreach ($ans as $o) {
						$ans_html[] = chr($o+64);
					}
					$que[$k]->ANS = implode(", ", $ans_html);
					break;
				case "R": 
					$que[$k]->ANS = ($v->ANS==="1") ? "O":"X";
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
					$que[$k]->ANS = implode(", ", $ans_html);
					break;
			}
			$qcont =  array();
			//題目文字
			if (!empty($v->QUETXT)) $qcont[] = nl2br(trim($v->QUETXT));
			//題目圖檔
			if (!empty($v->QIMGSRC)){
				if(is_file($v->QIMGSRC))$qcont[] = '<IMG src="'.base_url().$v->QIMGSRC.'" width="98%">';
			}
			//題目聲音檔
			if (!empty($v->QSOUNDSRC)){
        		if(is_file($v->QSOUNDSRC)){
        			$qcont[] = '<font color="green">題目音訊</font>';
        		}else{
        			$qcont[] = '<font color="red">題目音訊遺失</font>';
        		}
        	}
        	$que[$k]->QCONT = implode("<br>", $qcont);
		}
		return $que;
	}
	//ajax大題
	public function ajpart($id = null){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET"){
			$this->_errmsg(400);
			return;
		}
		$id = (int)$id;
		if ($id===0){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("SetsModel");
		$sub = $this->SetsModel->subofsets($id);
		$data = array();
		$part_button = '';
		$part = '';
		$part_que = '';
		$print_control = '';
		foreach ($sub as $i => $v) {
			$j = $i+1;
            $now = ($j==1) ? 'now':'';
            // $print_control = ($v->PAGE=='Y')? '可回上頁修改':'不可回上頁修改';
            //if ($parent_control!='S')$print_control.= '(考卷控制)';
            $sub_intro[] = trim($v->INTRO);
            $display_no = ($j>1) ? 'style="display:none;"':'';
            $part_button.='<input type="button" class="btn w150 h25 bpart_div '.$now.'>" onclick="view('.$j.')" name="bpart" id="bpart'.$j.'" value="第'.$j.'大題('.$v->PERCEN.'%)">';
            $part.= '<div name="node" id="'.$v->ID.'">';
            $part.= '<div class="part_sort">: :</div>';
            $part.= '<div style="display:inline-block;">';
            $part.= '第'.$j.'大題('.$v->PERCEN.'%)　'.$print_control;
            $part.= '</div>';
            $part.= '<div class="sub_intro" name="intro" id="intro'.$i.'">'.nl2br($v->INTRO).'</div>';
            $part.= '</div>';
            $part_que.= '<input type="button" class="btn w100" name="esort" id="esort'.$v->ID.'" value="第'.$j.'大題">';
        }
        $json['btn'] = $part_que;
        $json['html'] = $part;
        echo json_encode($json);
	}
	//ajax更新大題排序
	public function upd_psort(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		$node = json_decode($_POST['node']);
		$setsid = (isset($_POST['s']) && !empty($_POST['s'])) ? (int)$_POST['s']:0;
		$type = (isset($_POST['t']) && !empty($_POST['t'])) ? trim($_POST['t']):'';
		if ($setsid===0 || $type!=='p'){
			$this->_errmsg(400);
			return;
		}
		//拖拉變更大題順序
		$this->load->model("SetsModel");
		foreach ($node as $position => $item){ 
			$this->SetsModel->chage_sub_sort(array($position+1, $item, $setsid));
		}
		$json['success'] = true;
		echo json_encode($json);
	}
	//ajax更新題目排序
	public function upd_qsort(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		$node = json_decode($_POST['node']);
		$setsid = (isset($_POST['s']) && !empty($_POST['s'])) ? (int)$_POST['s']:0;
		$type = (isset($_POST['t']) && !empty($_POST['t'])) ? trim($_POST['t']):'';
		if ($setsid===0 || $type!=="q"){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("SetsModel");
		foreach ($node as $position => $item){ 
			$this->SetsModel->chage_que_sort(array($position+1, $item, $setsid));
		}
		$json['success'] = true;
		echo json_encode($json);
	}
	//ajax 考卷清單 我的未完成
	public function ajsets_list(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET"){
			$this->_errmsg(404);
			return;
		}
		$this->load->model("SetsModel");
		$set_data = $this->SetsModel->mysets_nonfinish($_SESSION['gold']->epno);
		$maindata = array();
		foreach ($set_data as $v) {
			$tmp = new stdClass; 
			$tmp->ID = $v->ID;
			$tmp->NAME = $v->SETS_NAME;
			array_push($maindata, $tmp);
		}
		$sub_data = array();
		if (!empty($maindata))$sub_data = $this->SetsModel->mysets_nonfinish_sub($maindata[0]->ID);
		$subdata = array();
		foreach ($sub_data as $k => $v) {
			$tmp = new stdClass; 
			$tmp->ID = $v->ID;
			$tmp->NAME = '第'.($k+1).'大題';
			array_push($subdata, $tmp);
		}
		$return = new stdClass;
		$return->sets = $maindata;
		$return->sub = $subdata;
		echo json_encode($return);
	}
	//ajax 考卷
	public function ajsets_sub(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET"){
			$this->_errmsg(404);
			return;
		}
		$sid = (isset($_GET['sid']) && (int)$_GET['sid']>0) ? (int)$_GET['sid']:0;
		if ($sid<=0){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("SetsModel");
		$data = $this->SetsModel->mysets_nonfinish_sub($sid);
		$json_data = array();
		foreach ($data as $k => $v) {
			$tmp = new stdClass; 
			$tmp->ID = $v->ID;
			$tmp->NAME = '第'.($k+1).'大題';
			$tmp->SCORE = $v->PERCEN;
			array_push($json_data, $tmp);
		}
		echo json_encode($json_data);
	}
	//ajax 考卷加題目
	public function ajsets_add(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(404);
			return;
		}
		$sid = (isset($_POST['sets']) && (int)$_POST['sets']>0) ? (int)$_POST['sets']:0;
		$part = (isset($_POST['spart']) && (int)$_POST['spart']>0) ? (int)$_POST['spart']:0;
		$ques = (isset($_POST['ques']) && !empty($_POST['ques'])) ? trim($_POST['ques']):'';
		if ($sid===0 || $part===0 || empty($ques)){
			$this->_errmsg(400);
			return;
		}
		$qid = explode(",", $ques);
		$this->load->model("SetsModel");
		$time = date('Y/m/d H:i:s');
		foreach ($qid as $q) {
			$v = (int)$q;
			if ($v<1)continue;
			$this->SetsModel->quesadd_sets($v, $sid, $part, $_SESSION['gold']->epno, $time);
		}
		echo true;
	}
	// 開放考試
	public function ajsets_publish(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST")return;
		$sid = (isset($_POST['sid']) && !empty($_POST['sid'])) ? (int)$_POST['sid']:0;
		if ($sid<1){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("SetsModel");
		$check = $this->SetsModel->part_percen_check(array($sid));
		if (!$check){
			$this->_errmsg(406);
			return;
		}
		$this->SetsModel->update_sets(array('FINISH'=>1), $sid);
		echo true;
	}
	public function ajcancell(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST")return;
		$sid = (isset($_POST['sid']) && !empty($_POST['sid'])) ? (int)$_POST['sid']:0;
		if ($sid<1){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("SetsModel");
		$this->SetsModel->destroy($sid);
		echo true;
	}
	// 刪題目
	public function delq(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(404);
			return;
		}
		$p = (isset($_POST['p']) && !empty($_POST['p'])) ? (int)$_POST['p']:0;
		$q = (isset($_POST['q']) && !empty($_POST['q'])) ? (int)$_POST['q']:0;
		if ($p===0 || $q===0){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("SetsModel");
		$this->SetsModel->delete_que(array($p, $q));
		echo 1;
	}
}