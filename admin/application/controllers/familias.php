<?php
/**
 * Created by PhpStorm.
 * User: maclen
 * Date: 2/7/17
 * Time: 12:55 PM
 */

class Familias extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('familias_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->database('default');
    }

    public  function insertar()
    {
        $familia = array(
            'name' => $this->input->post('Nombre'),
            'created_at' => date("Y-m-d H:i:s"),
            'description' => $this->input->post('Descripcion'));
        if($this->familias_model->insertar($familia))
            redirect('familias');
    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Familias';
        $data['main_content']='inicio';

        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();

        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarFamilia'] = $this->familias_model->consultaFamilia($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('familias_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function actualizar(){
        $familia = array(
            'name' => $this->input->post('Nombre'),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => $this->input->post('Descripcion')
        );
        $id = $this->input->post('ID');

        $this->load->model('familias_model');
        if($this->familias_model->actualizarFamilia($id, $familia))
            $this->session->set_flashdata('actualizado','El giro se actualizó correctamente');
        redirect('familias');
    }

    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('familias_model');
        if($this->familias_model->eliminarFamilia($id))
            redirect('familias');
    }

    public function getDeps(){
        $term = $this->input->post('string');
        $this->load->model('familias_model');
        $deps = $this->familias_model->buscar($term);
        $results = [];
        $cont=0;
        foreach ($deps as $dep){
            $results["items"][$cont] = ["id"=>$dep->name,"text"=>$dep->name];
            $cont++;

        }
        echo json_encode($results);
    }
}