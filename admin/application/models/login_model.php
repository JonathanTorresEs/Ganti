<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 */
class Login_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function login_user($username,$password)
	{
		$this->db->where('username',$username);
		$this->db->where('password',$password);
        $this->db->where('deleted_at IS NULL');
        $query = $this->db->get('users');
		if($query->num_rows() == 1)
		{
			return $query->row();
		}else{
			$this->session->set_flashdata('usuario_incorrecto','Los datos introducidos son incorrectos');
			redirect(base_url().'admin','refresh');
		}
	}

    public  function  leer(){
        $this->db->order_by('username ASC');
        $this->db->where('deleted_at IS NULL');
        $query = $this->db->get('users');
        return $query->result();
    }
}
