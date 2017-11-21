<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 02:38 PM
 */
class Minas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('minas_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->database('default');
    }

    public  function insertar()
    {
        $mina = array(
            'clave_mina' => $this->input->post('Clave'),
            'name' => $this->input->post('Nombre'),
            'created_at' => date("Y-m-d H:i:s"),
            'description' => $this->input->post('Descripcion'));
        if($this->minas_model->insertar($mina))
            redirect('minas');
    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Minas';
        $data['main_content']='inicio';

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();

        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarMina'] = $this->minas_model->consultaMina($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('minas_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function actualizar(){
        $mina = array(
            'clave_mina' => $this->input->post('Clave'),
            'name' => $this->input->post('Nombre'),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => $this->input->post('Descripcion')
        );
        $id = $this->input->post('ID');

        $this->load->model('minas_model');
        if($this->minas_model->actualizarMina($id, $mina))
            $this->session->set_flashdata('actualizado','La mina se actualizó correctamente');
        redirect('minas');
    }

    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('minas_model');
        if($this->minas_model->eliminarMina($id))
            redirect('minas');
    }

    public function getDeps(){
        $term = $this->input->post('string');
        $this->load->model('minas_model');
        $deps = $this->minas_model->buscar($term);
        $results = [];
        $cont=0;
        foreach ($deps as $dep){
            $results["items"][$cont] = ["id"=>$dep->name,"text"=>$dep->name];
            $cont++;
            /*if($cont >90){
                break;
            }*/
        }
        echo json_encode($results);//json_encode(["items" => [["id"=>"1","text"=>"Producto 1"],["id"=>"2","text"=>"Producto 2"],["id"=>"3","text"=>"Producto 3"]]]);
    }
}