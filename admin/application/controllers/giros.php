<?php
/**
 * Created by PhpStorm.
 * User: maclen
 * Date: 2/3/17
 * Time: 3:46 PM
 */

class Giros extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('giros_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->database('default');
    }

    public  function insertar()
    {
        $giro = array(
            'clave_giro' => $this->input->post('Clave'),
            'name' => $this->input->post('Nombre'),
            'created_at' => date("Y-m-d H:i:s"),
            'description' => $this->input->post('Descripcion'));
        if($this->giros_model->insertar($giro))
            redirect('giros');
    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Giros';
        $data['main_content']='inicio';

        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();

        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarGiro'] = $this->giros_model->consultaGiro($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('giros_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function actualizar(){
        $giro = array(
            'clave_giro' => $this->input->post('Clave'),
            'name' => $this->input->post('Nombre'),
            'updated_at' => date("Y-m-d H:i:s"),
            'description' => $this->input->post('Descripcion')
        );
        $id = $this->input->post('ID');

        $this->load->model('giros_model');
        if($this->giros_model->actualizarGiro($id, $giro))
            $this->session->set_flashdata('actualizado','El giro se actualizó correctamente');
        redirect('giros');
    }

    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('giros_model');
        if($this->giros_model->eliminarGiro($id))
            redirect('giros');
    }

    public function getDeps(){
        $term = $this->input->post('string');
        $this->load->model('giros_model');
        $deps = $this->giros_model->buscar($term);
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