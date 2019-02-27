<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//登入用
class Main extends CI_Controller {

	function __construct(){
		parent::__construct();
		if (!isset($_SESSION)) session_start();
	}
	public function index(){
		if (!isset($_SESSION['gold']->code) || empty($_SESSION['gold']->code)){
			$tmp_cookie = $this->_cookie_check();
			$this->load->view('login', array(
				'msg' => '',
				'tmp_acc' => $tmp_cookie->p_acc,
				'tmp_code' => $tmp_cookie->p_code,
				'save_acc' => $tmp_cookie->r_acc,
				'save_ucode' => $tmp_cookie->r_code
			));
			return;
		}
		if ($_SESSION['gold']->ident==="T")redirect('/sets');
		if ($_SESSION['gold']->ident==="S")redirect('/exam');
	}
	private function _login_ip(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		  $ip = $_SERVER['HTTP_CLIENT_IP'];
		}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
		  $ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	//cookie確認
	private function _cookie_check(){
		$cookie = new stdClass;
		$cookie->p_acc = '';
		$cookie->r_acc = '';
		$cookie->p_code = '';
		$cookie->r_code = '';
		//記住帳號
		if (isset($_COOKIE['id']) && !empty($_COOKIE['id'])){
			$cookie->p_acc = trim($_COOKIE['id']);
			$cookie->r_acc = 'checked';
		}
		//記住代碼
		if (isset($_COOKIE['code']) && !empty($_COOKIE['code'])){
			$cookie->p_code = (string)trim($_COOKIE['code']);
			$cookie->r_code = 'checked';
		}
		return $cookie;
	}
	private function _curl_get($url){
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $file_in = curl_exec($ch);
	    return json_decode($file_in);
	}
	//登入
	public function login(){
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method!=="POST"){
			redirect();
			return;
		}
		$post_acc = (isset($_POST['accname']) && !empty($_POST['accname'])) ? strtolower(trim($_POST['accname'])):'';
		$post_pwd = (isset($_POST['pwd']) && !empty($_POST['pwd'])) ? trim($_POST['pwd']):'';
		$post_code = (isset($_POST['code']) && !empty($_POST['code'])) ? (string)trim($_POST['code']):'';
		$post_identity = (isset($_POST['identity']) && !empty($_POST['identity'])) ? (string)trim($_POST['identity']):'';

		$error = false;
		$msg = '';
		if ($post_identity !=="S" && $post_identity !=="T"){
			$msg = '登入失敗';
			$error = true;
		}
		if (empty($post_acc) || empty($post_pwd) ||
			!preg_match("/^[0-9a-zA-Z]*$/", $post_acc)){
			$msg = '帳號或密碼錯誤';
			$error = true;
		}
		if (empty($post_code) || strlen($post_code)!=4 || !preg_match("/^[0-9]*$/", $post_code)){
			$msg = '代碼錯誤';
			$error = true;
		}
		if ($error){
			$tmp_cookie = $this->_cookie_check();
			$this->load->view('login', array(
				'msg' => $msg,
				'tmp_acc' => $post_acc,
				'tmp_code' => $post_code,
				'save_acc' => $tmp_cookie->r_acc,
				'save_ucode' => $tmp_cookie->r_code
			));
			return;
		}

		$this->load->model("AuthModel");
		$this->AuthModel->Set_db($post_code);
			$check = $this->AuthModel->user_check($post_acc, $post_identity, $post_pwd);
		if ($check){
			$_SESSION['gold'] = new stdClass;
			$_SESSION['gold']->code = $post_code;
			$_SESSION['gold']->epno = $post_acc;
			$_SESSION['gold']->type = $cram->CRAM_TYPE;
			$_SESSION['gold']->ident = $post_identity;
			$_SESSION['gold']->epname = $check->EPNAME;
			redirect('/');
		}else{
			$msg = $web_data->Message;
			$tmp_cookie = $this->_cookie_check();
			$this->load->view('login', array(
				'msg' => $msg,
				'tmp_acc' => $post_acc,
				'tmp_code' => $post_code,
				'save_acc' => $tmp_cookie->r_acc,
				'save_ucode' => $tmp_cookie->r_code
			));
		}
	}
	//登出
	public function logout(){
		unset($_SESSION['gold']);
		session_destroy();
		redirect('/');
	}
}
