


<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 24-Nov-17
 * Time: 11:38 AM
 */

class Nominas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('nominas_model');
        $this->load->helper(array('url', 'form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public function index()
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $data['titulo'] = 'Nominas';
        $data['main_content'] = 'inicio';
        $data["nominas"] = $this->nominas_model->leer_nominas();
        $data["empleados"] = $this->nominas_model->leer_empleados();

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('nominas_view', $data);
    }

    public function live_search_empleados()
    {
        $nombre = $this->input->post('Empleado_Nombre');
        $empleados = $this->nominas_model->live_search_empleados($nombre);
        echo json_encode($empleados);
    }


}