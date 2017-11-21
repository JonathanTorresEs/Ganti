<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 23/06/2015
 * Time: 03:44 PM
 */
class Bitacoras extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('bitacoras_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public  function insertar()
    {
        $bitacora = array(
            'description' => $this->input->post('Texto'),
            'user_id' => $this->input->post('IDUsuario'),
            'created_at' => date("Y-m-d H:i:s"),
            'date' => date("Y-m-d H:i:s"),
        );
       if($this->bitacoras_model->insertar($bitacora))
           redirect('bitacoras');
    }

    public function consultaMes(){
        $mes = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $year = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        if($this->session->userdata('profile') == FALSE || $this->session->userdata('profile') == "Usuario")
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Bitacoras';
        $data['main_content']='inicio';

        $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $config = array();
        $config["per_page"] = 10;
        $config["base_url"] = base_url() . "bitacoras/consultaMes/pag/".$mes."/".$year;
        if($this->session->userdata('profile') == "Compras"){
            $config["total_rows"] = $this->bitacoras_model->numRowsUsr($mes,$year,$this->session->userdata('user_id'));
            $data["bitacorasGuardadas"] = $this->bitacoras_model->traer_bitacoras_usr($config["per_page"], $page,$year,$mes,$this->session->userdata('user_id'));
        }else{
            $config["total_rows"] = $this->bitacoras_model->numRows($mes,$year);
            $data["bitacorasGuardadas"] = $this->bitacoras_model->traer_bitacoras($config["per_page"], $page,$year,$mes);
        }
        $config["uri_segment"] = 6;
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

        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $data['mesSeleccionado'] = $mes;
        $data['yearSelected'] = $year;
        if($this->uri->segment(3) !='' && $this->uri->segment(3) != 'pag'){
            $id = $this->uri->segment(3);
            $data['actualizarBitacora'] = $this->bitacoras_model->consultaBitacora($id);
        }
        $data["links"] = $this->pagination->create_links();
        $this->load->view('partials/header_view', $data);
        $this->load->view('bitacoras_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE || $this->session->userdata('profile') == "Usuario")
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Bitacoras';
        $data['main_content']='inicio';

        $config = array();
        $config["base_url"] = base_url() . "bitacoras/index/pag";
        $config["total_rows"] = $this->bitacoras_model->numRows(date("m"),date("Y"));
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
        $this->load->model('bitacoras_model');
        $data["bitacorasGuardadas"] = $this->bitacoras_model->traer_bitacoras($config["per_page"], $page,date("Y"),date("m"));
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $data['mesSeleccionado'] = date('n');
        $data['yearSelected'] = date('Y');
        if($this->uri->segment(3) !='' && $this->uri->segment(3) != 'pag'){
            $id = $this->uri->segment(3);
            $data['actualizarBitacora'] = $this->bitacoras_model->consultaBitacora($id);
        }
        $data["links"] = $this->pagination->create_links();
        $this->load->view('partials/header_view', $data);
        $this->load->view('bitacoras_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function actualizar(){
        $bitacora = array(
            'description' => $this->input->post('Texto'),
            'user_id' => $this->input->post('IDUsuario'),
            'updated_at' => date("Y-m-d H:i:s"),
            'date' => date("Y-m-d H:i:s"),
        );
        $id = $this->input->post('ID');

        $this->load->model('bitacoras_model');
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        if($this->bitacoras_model->actualizarBitacora($id, $bitacora))
            $this->session->set_flashdata('actualizado','La Bitacora se actualizó correctamente');
            redirect('bitacoras');
    }

    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('bitacoras_model');
        if($this->bitacoras_model->eliminarBitacora($id))
            redirect('bitacoras');
    }
}