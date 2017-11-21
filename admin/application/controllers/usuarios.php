<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Usuarios extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->database('default');
	}

    public  function insertar()
    {
        $usuario = array(
            'profile' => $this->input->post('perfil'),
            'created_at' => date("Y-m-d H:i:s"),
            'username' => $this->input->post('username'),
            'password' => sha1($this->input->post('password')),
        );
        if($this->usuarios_model->insertar($usuario))
            redirect('usuarios');
    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Usuarios';
        $data['main_content']='inicio';

        $this->load->model('usuarios_model');
        $data['usuariosGuardadas'] = $this->usuarios_model->leer();

        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarUsuario'] = $this->usuarios_model->consultaUsuario($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('usuarios_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function actualizar(){
        $usuario = array(
            'profile' => $this->input->post('perfil'),
            'updated_at' => date("Y-m-d H:i:s"),
            'username' => $this->input->post('username'),
            'password' => sha1($this->input->post('password')),
        );
        $id = $this->input->post('ID');

        $this->load->model('usuarios_model');
        if($this->usuarios_model->actualizarUsuario($id, $usuario))
            $this->session->set_flashdata('actualizado','El usuario se actualizó correctamente');
        redirect('usuarios');
    }

    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('usuarios_model');
        if($this->usuarios_model->eliminarUsuario($id))
            redirect('usuarios');
    }
}
