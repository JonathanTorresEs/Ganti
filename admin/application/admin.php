<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url','form'));
        $this->load->model('productos_model');
        $this->load->database('default');
	}

	public function index()
	{
		if($this->session->userdata('profile') == FALSE)
		{
			redirect(base_url().'login');
		}
        $this->load->model('productos_model');
        $data['titulo'] = 'Bienvenido Administrador';
        $data['restantes'] = $this->productos_model->restantes();
		$data['lowStock'] = $this->productos_model->lowStock();
        $this->load->view('partials/header_view', $data);
		$this->load->view('admin_view',$data);
        $this->load->view('partials/footer_view');
	}
}
