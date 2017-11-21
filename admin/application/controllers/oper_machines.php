<?php
/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 7/31/2017
 * Time: 10:34 AM
 */

class oper_machines extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('oper_machines_model');
        $this->load->helper(array('url', 'form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public function insertar()
    {
        $this->load->model('oper_machines_model');

        $IDMaquina = $this->input->post('IDMaquina');
        $IDOperador = $this->input->post('IDOperador');
         $turno = $this->input->post('turno');

            $oper_machine = array(
            'machine_id' => $this->input->post('IDMaquina'),
            'operador_id' =>  $this->input->post('IDOperador'),
            'turno' =>  $this->input->post('turno')
        );

        if ($this->oper_machines_model->insertar($oper_machine))
            redirect('oper_machines');
    }

    public function index()
    {
        $this->load->model('oper_machines_model');

        if ($this->session->userdata('profile') == FALSE or ($this->session->userdata('profile') != "Administrador" and $this->session->userdata('username') != "amontes@ganti.com.mx")) {
            redirect(base_url() . 'login');
        }

        $data['titulo'] = 'Maquinas';
        $data['main_content'] = 'inicio';

        //$data['usosGuardados'] = $this->usos_model->leer();

        $config = array();
        $config["base_url"] = base_url() . "oper_machines/index/pag";
        $config["total_rows"] = $this->oper_machines_model->total_registros();
        $config["per_page"] = 10;
        $config["uri_segment"] = 4;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><span>';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['maquinas_operator_Guardadas'] = $this->oper_machines_model->traer_oper_machines($config["per_page"], $page);
        if ( $data['maquinas_operator_Guardadas'] <= 0){
            $data['maquinas_operator_Guardadas'] = null;
        }
        $data["links"] = $this->pagination->create_links();

        if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'pag') {
            $id = $this->uri->segment(3);
            $data['actualizarOperadores'] = $this->oper_machines_model->consultar_oper_machine($id);
        }

        $this->load->model('operadores_model');
        $data['operadoresGuardados'] = $this->operadores_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('oper_machines_view', $data);
    }

    public function actualizar(){

        $operador = array(
            'machine_id' => $this->input->post('IDMaquina'),
            'operador_id' => $this->input->post('IDOperador'),
            'turno' => $this->input->post('turno'),
                    );
        $id = $this->input->post('ID');
        $this->load->model('oper_machines_model');

        if($this->oper_machines_model->actualizar_oper_machine($id, $operador))
            $this->session->set_flashdata('actualizado','El operador se actualizó correctamente');
        redirect('oper_machines');

    }
    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('oper_machines_model');
        if($this->oper_machines_model->eliminarOperador($id))
            redirect('oper_machines');
    }
}