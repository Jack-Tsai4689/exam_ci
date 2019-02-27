<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class  Gold_Controller  extends  CI_Controller  {

	protected $pstart = 1;
	protected $pend = 0;
	protected $row_per_page = 10;
	protected $page;
	protected $dp_info = null;
	function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION)) session_start();
		$this->dp_info = new stdClass;
		if (isset($_SESSION['gold']->ident)){
			$dpname = '';
			switch ($_SESSION['gold']->ident) {
				case 'S': $dpname = '同學'; break;
				case 'T': $dpname = '老師'; break;
			}
			$this->dp_info->dp_type = $_SESSION['gold']->ident;
			$this->dp_info->dp_name = $dpname;
		}else{
			redirect('/');
		}
	}
	protected function _errmsg($status){
    	$protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
		switch ($status) {
			case 400: header($protocol.' 400 Bad Request'); break;
			case 401: header($protocol.' 401 Unauthorized'); break;
			case 403: header($protocol.' 403 Forbidden'); break;
			case 404: header($protocol.' 404 Not Found'); break;
			case 406: header($protocol.' 406 Not Acceptable'); break;
		}
    }
	protected function _page($p, $row = 10)	{
		$this->row_per_page = $row;
		if ($p<1){
			$this->page = 1;
		}else{
			$this->page = $p;
		}
		if ($this->page===1){
			$this->pstart = 1;
		}else{
			$this->pstart = ($this->page-1)*$this->row_per_page+1;
		}
		$this->pend = $this->page * $this->row_per_page;
	}
	protected function _pstart(){
		return $this->pstart;
	}
	protected function _pend(){
		return $this->pend;
	}
	protected function _prow(){
		return $this->row_per_page;
	}
}
