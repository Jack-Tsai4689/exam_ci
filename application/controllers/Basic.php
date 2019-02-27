<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//基本設定
class Basic extends Gold_Controller {

	function __construct(){
		parent::__construct();
	}
	public function index(){
		$page = (isset($_GET['p']) && (int)$_GET['p']>0) ? (int)$_GET['p']:1;
		$this->_page($page);

		$this->load->model("BasicModel");
		$grade_data = array();
		$subject_data = array();
		$chapter_data = array();
		$grade_data = $this->BasicModel->get_grade();
		$this->load->view('_header', array(
			'ident' => $this->dp_info,
			'title' => '基本設定'
		));
		//index_better
		$this->load->view('basic/index_better', array(
			'Grade' => $grade_data
		));
	}
	//ajax建立
	public function cont(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		$type = (isset($_POST['type']) && !empty($_POST['type'])) ? trim($_POST['type']):'';
		$graname = (isset($_POST['graname']) && !empty($_POST['graname'])) ? trim($_POST['graname']):'';
		$subjname = (isset($_POST['subjname']) && !empty($_POST['subjname'])) ? trim($_POST['subjname']):'';
		$chapname = (isset($_POST['chapname']) && !empty($_POST['chapname'])) ? trim($_POST['chapname']):'';
		$graid = (isset($_POST['graid']) && !empty($_POST['graid'])) ? (int)$_POST['graid']:0;
		$subjid = (isset($_POST['subjid']) && !empty($_POST['subjid'])) ? (int)$_POST['subjid']:0;

		var_dump($_POST);
		exit;
		$error = false;
		$data = array(
			'OWNER' => $_SESSION['gold']->epno,
			'CREATETIME' => date('Y/m/d H:i:s'),
			'UPDATETIME' => date('Y/m/d H:i:s')
		);
		switch ($type) {
			case 'gra':
				if (empty($graname)){
					$error = true;
				}else{
					$data['NAME'] = $graname;
				}
				break;
			case 'subj':
				if (empty($subjname) || $graid<=0){
					$error = true;
				}else{
					$data['GRAID'] = $graid;
					$data['NAME'] = $subjname;
				}				
				break;
			case 'chap':
				if (empty($chapname) || $graid<=0 || $subjid<=0){
					$error = true;
				}else{
					$data['GRAID'] = $graid;
					$data['SUBJID'] = $subjid;
					$data['NAME'] = $chapname;
				}
				break;
			default:
				$error = true;
				break;
		}
		if ($error){
			unset($data);
			$this->_errmsg(400);
			return;
		}
		// $this->load->model("BasicModel");
		// $rs = $this->BasicModel->add_gsc($data);
		// if ($rs){
		// 	switch ($type) {
		// 		case 'gra': $json = $this->BasicModel->get_grade(); break;
		// 		case 'subj': $json = $this->BasicModel->get_subject(array($data['GRAID'])); break;
		// 		case 'chap': $json = $this->BasicModel->get_chapter(array($data['GRAID'], $data['SUBJID'])); break;
		// 	}
		// 	echo json_encode($json);
		// }
	}
	//ajax查詢
	public function gsclist(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="GET"){
			$this->_errmsg(400);
			return;
		}
		$type = (isset($_GET['type']) && !empty($_GET['type'])) ? trim($_GET['type']):'';
		$graid = (isset($_GET['g']) && !empty($_GET['g'])) ? (int)$_GET['g']:0;
		$subjid = (isset($_GET['s']) && !empty($_GET['s'])) ? (int)$_GET['s']:0;
		$error = false;
		if ($graid===0)$error = true;
		if ($type==="chap"){
			if ($subjid===0)$error = true;
		}else if ($type==="subj"){
		}else{
			$error = true;
		}
		if ($error){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("BasicModel");
		if ($type==="subj")$json = $this->BasicModel->get_subject(array($graid));
		if ($type==="chap")$json = $this->BasicModel->get_chapter(array($graid, $subjid));
		if (empty($json)){
			$this->_errmsg(406);
		}else{
			echo json_encode($json);	
		}		
	}
	//ajax更新
	public function ucont(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			$this->_errmsg(400);
			return;
		}
		$type = (isset($_POST['type']) && !empty($_POST['type'])) ? trim($_POST['type']):'';
		$error = false;
		switch ($type) {
			case 'gra':
				$name = (isset($_POST['ugraname']) && !empty($_POST['ugraname'])) ? trim($_POST['ugraname']):'';
				$id = (isset($_POST['ugraid']) && !empty($_POST['ugraid'])) ? (int)$_POST['ugraid']:0;
				if (empty($name) || $id<=0)$error = true;
				break;
			case 'subj':
				$graid = (isset($_POST['subjgra']) && !empty($_POST['subjgra'])) ? (int)$_POST['subjgra']:0;
				$name = (isset($_POST['usubjname']) && !empty($_POST['usubjname'])) ? trim($_POST['usubjname']):'';
				$id = (isset($_POST['usubjid']) && !empty($_POST['usubjid'])) ? (int)$_POST['usubjid']:0;
				if (empty($name) || $id<=0 || $graid<=0)$error = true;
				break;
			case 'chap':
				$graid = (isset($_POST['chapgra']) && !empty($_POST['chapgra'])) ? (int)$_POST['chapgra']:0;
				$subjid = (isset($_POST['chapsubj']) && !empty($_POST['chapsubj'])) ? (int)$_POST['chapsubj']:0;
				$name = (isset($_POST['uchapname']) && !empty($_POST['uchapname'])) ? trim($_POST['uchapname']):'';
				$id = (isset($_POST['uchapid']) && !empty($_POST['uchapid'])) ? (int)$_POST['uchapid']:0;
				if (empty($name) || $id<=0 || $graid<=0 || $subjid<=0)$error = true;
				break;
			default: $error = true; break;
		}
		if ($error){
			$this->_errmsg(400);
			return;
		}
		$this->load->model("BasicModel");
		$this->BasicModel->upd_gsc(array($name, $id));
		if ($type==="gra")$json = $this->BasicModel->get_grade();
		if ($type==="subj")$json = $this->BasicModel->get_subject(array($graid));
		if ($type==="chap")$json = $this->BasicModel->get_chapter(array($graid, $subjid));
		echo json_encode($json);
	}
}
