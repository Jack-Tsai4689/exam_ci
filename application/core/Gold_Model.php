<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Gold_Model extends CI_Model {

    protected $admin = array(
        'hostname' => '',
        'username' => '',
        'password' => '',
        'dbdriver' => 'sqlsrv',
        'dbprefix' => '',
        'pconnect' => FALSE,
        'db_debug' => FALSE,
        'cache_on' => FALSE,
        'cachedir' => '',
        'char_set' => 'utf8',
        'dbcollat' => 'utf8_general_ci'
    );
    protected $top_db = "gnew";
    function __construct()
    {
        parent::__construct();
    }
    function Set_db($code){
        if ($this->db->database===$this->top_db){
            $this->db->close();
            $this->admin['database'] = "".$code;
            $this->db = $this->load->database($this->admin, TRUE);
        }else{
            $connect = $this->db->initialize();
            if (!$connect)
                $this->db = $this->load->database($this->admin, TRUE);
        }
    }
    function Set_cram(){
        if ($this->db->database===$this->top_db){
            $connect = $this->db->initialize();
            if (!$connect)
                $this->db = $this->load->database($this->admin, TRUE);
        }else{
            $this->db->close();
            $this->admin['database'] = $this->top_db;
            $this->db = $this->load->database($this->admin, TRUE);
        }
    }
    function sqlinsert($table, $data){
        $col = array();
        $set = array();
        $val = array();
        foreach ($data as $k => $v) {
            $col[] = $k;
            $set[] = "?";
            $val[] = trim($v);
        }
        $query = new stdClass;
        $query->sql = "INSERT INTO ".$table."(".implode(",", $col).") VALUES(".implode(",", $set).")";
        $query->value = $val;
        return $query;
    }
}