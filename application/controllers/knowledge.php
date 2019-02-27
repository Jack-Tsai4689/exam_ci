<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//知識點
class Knowledge extends Gold_Controller {

	function __construct(){
		parent::__construct();
	}
	//老師的
	public function index(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET")return;
		$data = $this->_knowledge_list();
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '知識點管理'
		));
		$this->load->view('knowledge/index', $data);
	}
	//加入頁
	public function join(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET")return;
		$data = $this->_knowledge_list();
		$this->load->view('_header_sub', array(
			'ident' => $this->dp_info,
			'title' => '加入知識點'
		));
		$this->load->view('knowledge/join', $data);
	}
	//知識點清單
	private function _knowledge_list(){
		$page = (isset($_GET['p']) && (int)$_GET['p']>0) ? (int)$_GET['p']:1;
		$this->_page($page);
		$this->load->model("KnowledgeModel");

		$search = array();
		$p_gra = 0;
		$p_subj = 0;
		$p_chap = 0;
		$p_keyword = '';
		if (!empty($_GET)){
			$p_gra = (isset($_GET['gra']) && (int)$_GET['gra']>0) ? (int)$_GET['gra']:0;
			$p_subj = (isset($_GET['subj']) && (int)$_GET['subj']>0) ? (int)$_GET['subj']:0;
			$p_chap = (isset($_GET['chap']) && (int)$_GET['chap']>0) ? (int)$_GET['chap']:0;
			$p_keyword = (isset($_GET['q']) && !empty($_GET['q'])) ? trim($_GET['q']):'';
			if ($p_gra>0)$search['K_GRA'] = $p_gra;
			if ($p_subj>0)$search['K_SUBJ'] = $p_subj;
			if ($p_chap>0)$search['K_CHAP'] = $p_chap;
		}
		$know_row = $this->KnowledgeModel->knowledge_rows($search, $p_keyword);
		$know_data = $this->KnowledgeModel->knowledge_data($this->_pstart(), $this->_pend());
		$prev = '';
		$next = '';
		$pagegroup = ceil($know_row/$this->_prow());
		if ($page>1)$prev = '<input type="button" class="btn btn-default" onclick="page('.($page-1).')" value="上一頁">';
		if ($pagegroup>$page)$next = '<input type="button" class="btn btn-default" onclick="page('.($page+1).')" value="下一頁">';
		$pg = '';
		for ($i = 1; $i<=$pagegroup;$i++){
			$pg.='<option value="'.$i.'">第'.$i.'頁</option>';
		}
		//年級、科目 篩選條件
		$this->load->model("BasicModel");
		$gra_html = '';
		$subj_html = '';
		$chap_html = '';
		$subject_data = array();
		$chapter_data = array();
		$grade_data = $this->BasicModel->get_grade();
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
		$gra_id = array();
		$gra_name = array();
		$subj_id = array();
		$subj_name = array();
		$chap_id = array();
		$chap_name = array();
		foreach ($know_data as $k => $v) {
			//知識點
        	$kcont = array();
        	//文字
        	$kcont[] = '<label class="knowtitle" id="K'.$v->KID.'">'.trim($v->K_NAME).'</label>';
        	if (!empty($v->K_CONTENT)) $kcont[] = nl2br(trim($v->K_CONTENT));
        	//圖檔
        	if(!empty($v->K_PIC)){
				if (is_file($v->K_PIC))$kcont[] = '<IMG class="know" src="'.base_url($v->K_PIC).'" width="98%">';
			}
        	$know_data[$k]->K_CONTENT = implode("<br>", $kcont);
			//年級
			if (!empty($v->K_GRA)){
				if(in_array($v->K_GRA, $gra_id)){
					$know_data[$k]->K_GRA = $gra_name[array_search($v->K_GRA, $gra_id)];
				}else{
					$gra_id[] = $v->K_GRA;
					$gname = $this->BasicModel->get_onegsc(array($v->K_GRA));
					$gra_name[] = $gname->NAME;
					$know_data[$k]->K_GRA = $gname->NAME;
				}
			}
			//科目
			if (!empty($v->K_SUBJ)){
				if (in_array($v->K_SUBJ, $subj_id)){
					$know_data[$k]->K_SUBJ = $subj_name[array_search($v->K_SUBJ, $subj_id)];
				}else{
					$subj_id[] = $v->K_SUBJ;
					$subjname = $this->BasicModel->get_onegsc(array($v->K_SUBJ));
					$subj_name[] = $subjname->NAME;
					$know_data[$k]->K_SUBJ = $subjname->NAME;
				}
			}
			//科目
			if (!empty($v->K_CHAP)){
				if (in_array($v->K_CHAP, $chap_id)){
					$know_data[$k]->K_CHAP = $chap_name[array_search($v->K_CHAP, $chap_id)];
				}else{
					$chap_id[] = $v->K_CHAP;
					$chapname = $this->BasicModel->get_onegsc(array($v->K_CHAP));
					$chap_name[] = $chapname->NAME;
					$know_data[$k]->K_CHAP = $chapname->NAME;
				}
			}
		}
		return array(
			'Grade' => $gra_html,
			'Subject' => $subj_html,
			'Chapter' => $chap_html,
			'Keyword' => $p_keyword,
			'Data' => $know_data,
			'Prev' => $prev,
			'Next' => $next,
			'Pg' => $pg,
			'Num' => $know_row
		);
	}
	//新增頁
	public function create(){
		$sets_message = '';//'<div id="sets_title"><label class="17">'.$msg.'</label></div>';
		$data = array();
		//年級、科目 篩選條件
		$this->load->model("BasicModel");
		$grade_html = '<option value="0">無年級</option>';
		$subject_html = '<option value="0">無科目</option>';
		$chapter_html = '<option value="0">無章節</option>';
		$grade_data = $this->BasicModel->get_grade();
		$subject_data = array();
		$chap_data = array();
		if (!empty($grade_data)){
			$grade_html = '';
			foreach ($grade_data as $v) {
				$grade_html.= '<option value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
			$subject_data = $this->BasicModel->get_subject(array($grade_data[0]->ID));
		}
		if (!empty($subject_data)){
			$subject_html = '';
			foreach ($subject_data as $v) {
				$subject_html.= '<option value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
			$chap_data = $this->BasicModel->get_chapter(array($grade_data[0]->ID, $subject_data[0]->ID));
		}
		if (!empty($chap_data)){
			$chapter_html = '';
			foreach ($chap_data as $v) {
				$chapter_html.= '<option value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
		}
		//題目圖片
		//不刪檔
		$kimg_html = '';
		$data['Kimg'] = '';
		$data['Kimgsrc'] = '';
		$kimg_html.= '<input type="button" value="上傳圖檔" id="nknow" class="btn w160 h25" onClick="uknow(this.id)" >   ';
		$data['Kimg_html'] = $kimg_html;

		$data['Owner'] = $_SESSION['gold']->epno;
		$data['Grade'] = $grade_html;
		$data['Subject'] = $subject_html;
		$data['Chapter'] = $chapter_html;

        $this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '新增知識點'
		));
		$this->load->view('knowledge/create', $data);
	}
	//執行新增
	public function add(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		$k_name = (isset($_POST['f_kname']) && !empty($_POST['f_kname'])) ? trim($_POST['f_kname']):'';
		$k_content = (isset($_POST['f_kcont']) && !empty($_POST['f_kcont'])) ? trim($_POST['f_kcont']):'';
		// $k_keyword = (isset($_POST['f_kw']) && !empty($_POST['f_kw'])) ? trim($_POST['f_kw']):'';
		$graid = (isset($_POST['f_grade']) && (int)$_POST['f_grade']>0) ? (int)$_POST['f_grade']:0;
		$subjid = (isset($_POST['f_subject']) && (int)$_POST['f_subject']>0) ? (int)$_POST['f_subject']:0;
		$chapid = (isset($_POST['f_chapter']) && (int)$_POST['f_chapter']>0) ? (int)$_POST['f_chapter']:0;

		if ($graid===0 || $subjid===0 || $chapid===0){
			$this->_errmsg(400);
			return;
		}
		$kimg = (isset($_POST['f_kimg']) && !empty($_POST['f_kimg'])) ? trim($_POST['f_kimg']):'';
		$kname = '';
		$dir = $_SESSION['gold']->code.'/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir.= 'know/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir_tmp = $dir.'tmp/';
		if (!is_dir($dir_tmp))mkdir($dir_tmp, 777);

		if (!empty($kimg)){
			if (is_file($dir_tmp.$kimg)){
				$ext = pathinfo($kimg, PATHINFO_EXTENSION);
				$old_nam = $dir_tmp.$kimg;
				$new_name = $dir.md5(uniqid(rand(), true)).'.'.$ext;
				rename($old_nam, $new_name);
				$kname = $new_name;
			}
		}

		$this->load->model("KnowledgeModel");
		$this->KnowledgeModel->create_knowledge(array(
			'K_NAME' => $k_name,
			'K_PIC' => $kname,
			'K_GRA' => $graid,
			'K_SUBJ' => $subjid,
			'K_CHAP' => $chapid,
			'K_CONTENT' => $k_content,
			'K_OWNER' => $_SESSION['gold']->epno,
			// 'K_KEYWORD' => $k_keyword,
			'K_CREATETIME' => date('Y/m/d H:i:s'),
			'K_UPDATETIME' => date('Y/m/d H:i:s')
		));
		redirect('/knowledge');
		// $json['Success'] = true;
		// echo json_encode($json);
	}
	//編輯頁
	public function edit($kid){
		$kid = (int)$kid;
		if ($kid<=0){
			$this->_errmsg(400);
			return;
		}
		if ($_SESSION['gold']->ident!=="A" && $_SESSION['gold']->ident!=="T"){
			die('很抱歉，權限不足');
			return;
		}
		$this->load->model("KnowledgeModel");
		$know = $this->KnowledgeModel->view_knowledge($kid);
		if ($know==null)die('無此資料');
		$this->load->model("BasicModel");
		$grade_html = '';
		$subject_html = '';
		$chapter_html = '';
		$grade_data = $this->BasicModel->get_grade();
		$subject_data = array();
		$chap_data = array();
		if (!empty($grade_data)){
			foreach ($grade_data as $v) {
				$g_sel = ($v->ID===$know->K_GRA) ? 'selected':'';
				$grade_html.= '<option '.$g_sel.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
			$subject_data = $this->BasicModel->get_subject(array($know->K_GRA));
		}
		if (!empty($subject_data)){
			foreach ($subject_data as $v) {
				$s_sel = ($v->ID===$know->K_SUBJ) ? 'selected':'';
				$subject_html.= '<option '.$s_sel.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
			$chap_data = $this->BasicModel->get_chapter(array($know->K_GRA, $know->K_SUBJ));
		}
		if (!empty($chap_data)){
			foreach ($chap_data as $v) {
				$c_sel = ($v->ID===$know->K_CHAP) ? 'selected':'';
				$chapter_html.= '<option '.$c_sel.' value="'.$v->ID.'">'.$v->NAME.'</option>';
			}
		}
		//題目圖片
		$kimg_html = '';
		$del_qimg = '';
		$data['Kimg'] = '';
		$data['Kimg_src'] = '';
		if (!empty($know->K_PIC)){
			if (is_file($know->K_PIC)){
				$data['Kimg'] = base_url($know->K_PIC);
				$data['Kimg_src'] = $know->K_PIC;
				$del_qimg = '<input type="button" value="刪除圖檔" id="deknow" class="btn w100 h25" onClick="uknow(this.id)" >   ';
			}
		}
		$kimg_html.= '<input type="button" value="上傳圖檔" id="nknow" class="btn w160 h25" onClick="uknow(this.id)" >   ';
		$kimg_html.= $del_qimg;
        $data['Kimgsrc'] = $know->K_PIC;
		$data['Kimg_html'] = $kimg_html;

		$data['Kid'] = $kid;
		$data['Owner'] = $know->K_OWNER;
		$data['Kname'] = $know->K_NAME;
		$data['Kcontent'] = $know->K_CONTENT;
		// $data['Kkeword'] = $know->K_KEYWORD;
		$data['Grade'] = $grade_html;
		$data['Subject'] = $subject_html;
		$data['Chapter'] = $chapter_html;
       
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '編輯知識點'
		));
		$this->load->view("knowledge/edit", $data);
	}
	//執行更新
	public function update($kid){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		$kid = (int)$kid;
		if ($kid<=0){
			$this->_errmsg(400);
			return;
		}
		if ($_SESSION['gold']->ident!=="A" && $_SESSION['gold']->ident!=="T"){
			die('很抱歉，權限不足');
			return;
		}
		$k_name = (isset($_POST['f_kname']) && !empty($_POST['f_kname'])) ? trim($_POST['f_kname']):'';
		$k_content = (isset($_POST['f_kcont']) && !empty($_POST['f_kcont'])) ? trim($_POST['f_kcont']):'';
		// $k_keyword = (isset($_POST['f_kw']) && !empty($_POST['f_kw'])) ? trim($_POST['f_kw']):'';
		$k_pic = (isset($_POST['f_kpic']) && !empty($_POST['f_kpic'])) ? trim($_POST['f_kpic']):'';
		$graid = (isset($_POST['f_grade']) && (int)$_POST['f_grade']>0) ? (int)$_POST['f_grade']:0;
		$subjid = (isset($_POST['f_subject']) && (int)$_POST['f_subject']>0) ? (int)$_POST['f_subject']:0;
		$chapid = (isset($_POST['f_chapter']) && (int)$_POST['f_chapter']>0) ? (int)$_POST['f_chapter']:0;

		if ($graid===0 || $subjid===0 || $chapid===0){
			$this->_errmsg(400);
			return;
		}
		$kimg = (isset($_POST['f_kimg']) && !empty($_POST['f_kimg'])) ? trim($_POST['f_kimg']):'';
		$k_picname = '';
		$this->load->model("KnowledgeModel");
		$know = $this->KnowledgeModel->view_knowledge($kid);

		$dir = $_SESSION['gold']->code.'/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir.= 'know/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir_tmp = $dir.'tmp/';
		if (!is_dir($dir_tmp))mkdir($dir_tmp, 777);


		if (!empty($kimg)){
			if (is_file($dir_tmp.$kimg)){
				$ext = pathinfo($kimg, PATHINFO_EXTENSION);
				$old_nam = $dir_tmp.$kimg;
				$new_name = $dir.md5(uniqid(rand(), true)).'.'.$ext;
				rename($old_nam, $new_name);
				$k_picname = $new_name;
				if (is_file($know->K_PIC)){
					if (unlink($know->K_PIC)){}
				}
			}else if (is_file($kimg)){
				$k_picname = $kimg;
			}
		}

		$this->KnowledgeModel->update_knowledge(array(
			'K_NAME' => $k_name,
			'K_PIC' => $k_picname,
			'K_GRA' => $graid,
			'K_SUBJ' => $subjid,
			'K_CHAP' => $chapid,
			'K_CONTENT' => $k_content,
			'K_OWNER' => $_SESSION['gold']->epno,
			// 'K_KEYWORD' => $k_keyword,
			'K_UPDATETIME' => date('Y/m/d H:i:s')
		), $kid);
		redirect('/knowledge');
		// $json['Success'] = true;
		// echo json_encode($json);
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
    /*  程式名稱：檔案上傳(圖片、pdf、word)
    /*  作者：Jerry
    /*  程式目的/問題描述：新版檔案上傳
    /*  其它說明：最新版，捨棄exec-im_convert，改用php imagick。上傳之圖檔統一轉成jpg
    /*********************************************************/
	public function kupload(){
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
		$dir.= 'know/';
		if (!is_dir($dir))mkdir($dir, 777);
		$dir_tmp = $dir.'tmp/';
		if (!is_dir($dir_tmp))mkdir($dir_tmp, 777);

		$type = (isset($_GET['type']) && !empty($_GET['type'])) ? trim($_GET['type']):'';
		if ($type==="dnknow"){
			$src = $dir_tmp."dnkr_".$_SESSION['gold']->epno.".jpg";
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

				$this->load->view('knowledge/cutpic', array(
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

				$this->load->view('knowledge/cutpic', array(
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
			'title' => '知識點圖片上傳'
		));
		$this->load->view("knowledge/upload_pic", array(
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
		$dir.= 'know/';
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
		$q_type = array('dnclknow','nclknow','nknow','dnknow');
		$ext = strtolower(pathinfo($_FILES['qmg']['name'], PATHINFO_EXTENSION));
		if ($type==="dnknow"){
			$file_name = 'dnkr_'.$epno;	
		}else{
			if (in_array($type, $q_type)){
				$file_name = 'nkr_'.$epno;
			}else{
				if ($type==="dnknow"){
					$file_name = 'dnkr_'.$epno;	
				}else{
					$file_name = 'nkr_'.$epno;
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
	public function rmpic(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST")exit;
		$type = (isset($_POST['type']) && !empty($_POST['type'])) ? trim($_POST['type']):'';
		$epno = $_SESSION['gold']->epno;
		$dir = $_SESSION['gold']->code.'/know/';
		$dir_tmp = $dir.'tmp/';
		

		switch ($type) {
			case 'deknow':
			case 'dknow':
				if ($type==="dknow"){
					$del_file = array('nkr_'.$epno.'.jpg', 'nkrc_'.$epno.'.jpg', 'dnkr_'.$epno.'.jpg', 'dnkrc_'.$epno.'.jpg');
					foreach ($del_file as $v) {
						if (is_file($dir_tmp.$v)){
							if (unlink($dir_tmp.$v)){}
						}
					}
				}
				$btn_html = '<input type="button" value="上傳圖檔" id="nknow" class="btn w160 h25" onClick="uknow(this.id)" >   ';
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

		$this->load->view('knowledge/cutpic', array(
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

		$dir_tmp = $_SESSION['gold']->code.'/know/tmp/';

		switch ($type) {
			case 'nknow':
				$file_name = 'nkrc_'.$_SESSION['gold']->epno.'.jpg';
				$path = $dir_tmp.$file_name;
				$this->_resize_img($path, $src,$w,$h,$x1,$y1,1);
				if (is_file($src)){if (unlink($src)){}}
				break;
			case 'dnknow':
				$file_name = 'dnkrc_'.$_SESSION['gold']->epno.'.jpg';
				$path = $dir_tmp.$file_name;
				$this->_resize_img($path, $src,$w,$h,$x1,$y1,1);
				break;
		}
		$kimg_html = '<input type="button" value="上傳圖檔(裁剪後刪檔)" id="nknow" class="btn w160 h25" onClick="uknow(this.id)" >   <input type="button" value="刪除圖檔" id="dknow" class="btn w100 h25" onClick="uknow(this.id)" >   ';
		if ($type==="dnknow"){
			$kimg_html = '<input type="button" value="重新裁切" id="dnknow" class="btn w100 h25" onClick="uknow(this.id);" >';
			$kimg_html.= '<input type="button" value="刪除圖檔" id="dknow" class="btn w100 h25" onClick="uknow(this.id)" >   ';
		}
		?>
		<script>
			parent.document.getElementById('kimg').src = '<?=base_url('/').$path?>?'+Math.random();
			parent.document.getElementById('f_kimg').value = '<?=$file_name?>';
			parent.document.getElementById('sets_filed').style.display = "none";
			parent.document.getElementById('kimg_content').innerHTML = '<?=$kimg_html?>';
		</script>
		<?php
	}
}
