<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 7/14/2017
 * Time: 1:15 PM
 */
class Mantenimiento extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();
        $this->load->model('mantenimiento_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }
        public function index()
        {
            if($this->session->userdata('profile') == FALSE)
            {
                redirect(base_url().'login');
            }
            $data['titulo'] = 'Mantenimiento';

            $data['main_content']='inicio';

            $this->load->model('mantenimiento_model');

            //$data['usosGuardados'] = $this->usos_model->leer();

            $config = array();
            $config["base_url"] = base_url() . "controles/index/pag";
            $config["total_rows"] = $this->mantenimiento_model->total_registros();
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
            $data['controlesGuardados'] = $this->controles_model->leer();
            $data["links"] = $this->pagination->create_links();
            if($this->uri->segment(3)!='' && $this->uri->segment(3)!='pag' ){
                $id = $this->uri->segment(3);

                $data['actualizarControles'] = $this->controles_model->consultaControl($id);
                $data['actualizarConts'] = $this->controles_model->consultaCont($id);
                $data['actualizarAcer'] = $this->controles_model->consultaAcer($id);
            }
            $data['comms'] = $this->controles_model->comms();
            $this->load->model('maquinas_model');
            $data['maquinasGuardadas'] = $this->maquinas_model->leer();
            $this->load->model('productos_model');
            $data['productosGuardados'] = $this->productos_model->leer();
            /*        $data['restantes'] = $this->productos_model->restantes();*/

            $this->load->model('operadores_model');
            $data['operadoresGuardados'] = $this->operadores_model->leer();

            $this->load->model('login_model');
            $data['usuariosGuardados'] = $this->login_model->leer();

            $data['dates1'] = $this->controles_model->traerFechas($config["per_page"], $page, 1);
            $data['dates2'] = $this->controles_model->traerFechas($config["per_page"], $page, 2);

            $this->load->view('partials/header_view', $data);
            $this->load->view('partials/footer_view');
            $this->load->view('controles_view',$data);



        }

}