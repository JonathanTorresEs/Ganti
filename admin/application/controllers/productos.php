<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 25/06/2015
 * Time: 03:02 PM
 */
class Productos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('productos_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public  function insertar()
    {
            $producto = array(
                'clave' => $this->input->post('Clave'),
                'description' => $this->input->post('Descripcion'),
                'familia_id' => $this->input->post('IDFamilia'),
                'code' => $this->input->post('code'),
                'marca' => $this->input->post('Marca'),
                'equipo' => $this->input->post('Equipo'),
                'created_at' => date("Y-m-d H:i:s")
            );
            if($this->productos_model->verifyId($producto["clave"], $producto["familia_id"], null)){
                if ($this->productos_model->insertar($producto))
                    $this->session->set_flashdata('alert','alert-success@El producto se creó correctamente');
            }else{
                $this->session->set_flashdata('alert','alert-danger@El id requerido ya existe');
            }
            redirect('productos');
        }


    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Productos';
        $data['main_content']='inicio';

        $this->load->model('productos_model');


        if($this->uri->segment(3) == "set"){
            $myVal = $this->uri->segment(4);
            if($myVal == 'Todos'){
                $myVal = $this->productos_model->total_registros();
            }
            $this->session->set_userdata('pagination', $myVal);
            redirect("productos");
        }

        $pagin = '10';


        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }


        //$data['productosGuardadas'] = $this->productos_model->leer();
        $config = array();
        $config["base_url"] = base_url() . "productos/index/pag";
        $config["total_rows"] = $this->productos_model->total_registros();
        $config["per_page"] = $pagin;
        $config['use_page_numbers'] = TRUE;
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

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $page = $page - 1;

        $data["productosGuardadas"] = $this->productos_model->
        traer_productos($config["per_page"], $page * $config["per_page"]);
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;


        if($this->uri->segment(3)!='' && $this->uri->segment(3) != 'pag'){
            $id = $this->uri->segment(3);
            $data['actualizarProducto'] = $this->productos_model->consultaProducto($id);
        }
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->view('partials/header_view', $data);
        $this->load->view('productos_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function actualizar(){

                   $producto = array(
                       'clave' => $this->input->post('Clave'),
                       'description' => $this->input->post('Descripcion'),
                       'familia_id' => $this->input->post('IDFamilia'),
                       'code' => $this->input->post('code'),
                       'marca' => $this->input->post('Marca'),
                       'equipo' => $this->input->post('Equipo'),
                       'created_at' => date("Y-m-d H:i:s")

            );
            $id = $this->input->post('ID');
            $this->load->model('productos_model');
            if($this->productos_model->verifyId($producto["clave"], $producto["familia_id"],$id)){
                if($this->productos_model->actualizarProducto($id, $producto))
                    $this->session->set_flashdata('alert','alert-success@El producto se actualizó correctamente');
            }else{
                $this->session->set_flashdata('alert','alert-danger@El id requerido ya existe');
            }
           redirect('productos');
        }

    public function id_disponibles(){
        $family_id = $this->input->post('family');
        $this->load->model('productos_model');
        $min =-1;
        $max =100;
        for($x =0; $x <= 10; $x++){

       if($id_avalible_obj = $this->productos_model->find_id_family($family_id,$min,$max)){
           $id_avalible = $id_avalible_obj->maxid;
           if($id_avalible == 0 || $id_avalible == null){
               $id_avalible = $min + 1;
               $array_id_avalible[$x] = $id_avalible;
           }
           else{
               $id_avalible = $id_avalible + 1;
               $array_id_avalible[$x] = $id_avalible;
           }

       }
       else{
           $array_id_avalible[$x] = $min;

       }
         $min = $min + 100;
         $max = $max + 100;
            }
        echo json_encode($array_id_avalible);

    }

    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('productos_model');
        if($this->productos_model->eliminarProducto($id))
            redirect('productos');
    }
    public function buscar(){
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }

        $data['titulo'] = 'Productos';
        $data['main_content']='inicio';
    $pagin = '10';

    if($this->input->post('perPage') != null) {
        $pagin = $this->input->post('perPage');
        $this->session->set_userdata('pagination', $pagin);
    } else if($this->session->userdata('pagination') != null) {
        $pagin = $this->session->userdata('pagination');
    }

    $term = $this->input->post('term');


        if ($this->uri->segment(3) != '') {
            $term = $this->uri->segment(3);
        }
    if ($this->uri->segment(6) != '') {
        $page = $this->uri->segment(6);
    }
    else{
        $page = 1;
    }
    $page = $page - 1;

        if ($term == null ||  $term  == 'pag'  || trim($term) == "" ){
            redirect("productos");
        }

    if($this->uri->segment(3)== '' ){
        redirect ('productos/buscar/'.$term.'/pag/'.($page+1));
    }
    $data['perPage'] = $pagin;
    $data['myTerm'] = $term;
    $data['page'] = $page;


    $this->load->model('productos_model');



    $config = array();
    $config["total_rows"] = $this->productos_model->totalBusqueda ($term)->Cuenta;
    $config["per_page"] = $pagin;
    $config["base_url"] = base_url() . "productos/buscar/".$term."/pag/".$config["per_page"];

        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();

    $config['use_page_numbers'] = TRUE;
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




if ($config["per_page"] == "Todos"){
    $data["productosGuardadas"] = $this->productos_model->traer_busqueda($term, $config["total_rows"], 0);
}
    else{
        $data["productosGuardadas"] = $this->productos_model->traer_busqueda($term, $config["per_page"], $page * $config["per_page"]);
    }



    $data["links"] = $this->pagination->create_links();
/*
        print("<br>");
        print("dasdsa ");
        print_r($term);
        print(" dasdsa");
        print("<br>");*/




        $this->load->view('partials/header_view', $data);
        $this->load->view('productos_view',$data);
        $this->load->view('partials/footer_view');
    }
}