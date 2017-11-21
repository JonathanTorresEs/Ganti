<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 03:02 PM
 */
class Usos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usos_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public  function insertar()
    {
        $uso = array(
            'mine_id' => $this->input->post('IDMina'),
            'product_id' => $this->input->post('IDProducto'),
            'quantity' => $this->input->post('Cantidad'),
            'user_id' => $this->input->post('IDUsuario'),
            'created_at' => date("Y-m-d H:i:s"),
            'received_by' => $this->input->post('RecibidoPor'),
            'date' => $this->input->post('Fecha'),
        );

            $this->load->model('productos_model');
            $producto = $this->productos_model->consultaProducto($uso['product_id']);
            $producto->stock = $producto->stock - $uso['quantity'];
            $this->productos_model->actualizarProducto($uso['product_id'], $producto);

        if($this->usos_model->insertar($uso))
            redirect('usos');
    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Usos';
        $data['main_content']='inicio';

        $this->load->model('usos_model');
        //$data['usosGuardados'] = $this->usos_model->leer();

        $config = array();
        $config["base_url"] = base_url() . "usos/index/pag";
        $config["total_rows"] = $this->usos_model->total_registros();
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
        $data['usosGuardados'] = $this->usos_model->
        traer_usos($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        if($this->uri->segment(3)!='' && $this->uri->segment(3)!='pag'){
            $id = $this->uri->segment(3);
            $data['actualizarUso'] = $this->usos_model->consultaUso($id);
        }

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();


        $this->load->view('partials/header_view', $data);
        $this->load->view('usos_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function actualizar(){
        $uso = array(
            'mine_id' => $this->input->post('IDMina'),
            'product_id' => $this->input->post('IDProducto'),
            'quantity' => $this->input->post('Cantidad'),
            'updated_at' => date("Y-m-d H:i:s"),
            'user_id' => $this->input->post('IDUsuario'),
            'received_by' => $this->input->post('RecibidoPor'),
            'date' => $this->input->post('Fecha'),
        );
        $id = $this->input->post('ID');

        $this->load->model('usos_model');
        if($this->usos_model->actualizarUso($id, $uso))
            $this->session->set_flashdata('actualizado','El uso se actualizó correctamente');
        redirect('usos');
    }

    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('usos_model');
        if($this->usos_model->eliminarUso($id))
            redirect('usos');
    }
}