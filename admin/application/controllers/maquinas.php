<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 23/06/2015
 * Time: 03:44 PM
 */
class Maquinas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('maquinas_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->database('default');
    }
    public  function insertar()
    {
        $this->load->model('maquinas_model');

        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
        $limite_kb = 100;
            if (($_FILES['imagen']['error']) == 0) {
                if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024) {
                    $extencion = explode(".", $_FILES['imagen']['name']);
                    $nombre = $this->input->post('numeroEconomico') . "." . $extencion[1];
                    $nombre = str_replace(' ', '_', $nombre);
                    $nombre = str_replace('/', '_', $nombre);
                    copy($_FILES['imagen']['tmp_name'], "./public/pictures/maquina/" . $nombre);
                    $maquina = array(
                        'description' => $this->input->post('Descripcion'),
                        'created_at' => date("Y-m-d H:i:s"),
                        'short_number' => $this->input->post('numeroEconomico'),
                        'serial_number' => $this->input->post('serial_number'),
                        'machine_type' => $this->input->post('machine_type'),
                        'location' => $this->input->post('location'),
                        'capacidad_c' => $this->input->post('capacidad_c'),
                        'image' => $nombre
                    );

                    if ($this->maquinas_model->insertar($maquina)) {
                       redirect('maquinas');
                    } else {
                        $this->session->set_flashdata('actualizado', 'Introduce un formato imagen correcto (jpg, png, gif)  **' . $_FILES['imagen']['error'] . "**");
                         redirect('maquinas');
                    }
                }

            } else {

            $nombre = "default.png";
                $maquina = array(
                    'description' => $this->input->post('Descripcion'),
                    'short_number' => $this->input->post('numeroEconomico'),
                    'serial_number' => $this->input->post('serial_number'),
                    'machine_type' => $this->input->post('machine_type'),
                    'location' => $this->input->post('location'),
                    'capacidad_c' => $this->input->post('capacidad_c'),
                    'image' => $nombre,
                );
                if ($this->maquinas_model->insertar($maquina)){
                    redirect('maquinas');
                    print("no pude entrar auqi");
            }
        }
    }
    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Maquinas';
        $data['main_content']='inicio';

        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarMaquina'] = $this->maquinas_model->consultaMaquina($id);
        }
        $this->load->model('minas_model');/*Lugar*/
        $data['minasGuardadas'] = $this->minas_model->leer();

        $this->load->view('partials/header_view', $data);
        $this->load->view('maquinas_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function actualizar(){
        $this->load->model('maquinas_model');

        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
        $limite_kb = 100;
        if (($_FILES['imagen']['error']) == 0) {
            if (in_array($_FILES['imagen']['type'], $permitidos) && $_FILES['imagen']['size'] <= $limite_kb * 1024) {
                $extencion = explode(".", $_FILES['imagen']['name']);
                $nombre = $this->input->post('numeroEconomico') . "." . $extencion[1];
                $nombre = str_replace(' ', '_', $nombre);
                $nombre = str_replace('/', '_', $nombre);
                copy($_FILES['imagen']['tmp_name'], "./public/pictures/maquina/" . $nombre);
            }
        }
       else{
           $nombre = "default.png";
       }


        $maquina = array(
                    'description' => $this->input->post('Descripcion'),
                    'short_number' => $this->input->post('numeroEconomico'),
                    'serial_number' => $this->input->post('serial_number'),
                    'machine_type' => $this->input->post('machine_type'),
                    'location' => $this->input->post('location'),
                    'capacidad_c' => $this->input->post('capacidad_c'),
                    'image' => $nombre
                );
                $id = $this->input->post('ID');
             if ($this->maquinas_model->actualizarMaquina($id,$maquina))
              $this->session->set_flashdata('actualizado', 'La Maquina se actualizó correctamente');
                redirect('maquinas');

  }


    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('maquinas_model');
        if($this->maquinas_model->eliminarMaquina($id))
            redirect('maquinas');
    }
}