<?php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 30-Oct-17
 * Time: 10:17 AM
 */

class Clientes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('clientes_model');
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

        $this->load->model('clientes_model');

        $data['titulo'] = 'Clientes';
        $data['main_content'] = 'inicio';
        $data["clientes"] = $this->clientes_model->leer();

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('clientes_view', $data);
    }

    public function agregar_cliente()
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('clientes_model');

        $cliente = array(
            'rfc' => $this->input->post('RFC'),
            'razon_social' => $this->input->post('Razon_Social'),
            'direccion' => $this->input->post('Direccion'),
            'ciudad' => $this->input->post('Ciudad'),
            'estado' => $this->input->post('Estado'),
            'codigo_postal' => $this->input->post('Codigo_Postal'),
            'telefono' => $this->input->post('Telefono'),
            'contacto' => $this->input->post('Contacto'),
            'correo' => $this->input->post('Correo'),
            'alias' => $this->input->post('Alias'),
        );

        if ($this->clientes_model->insertar($cliente)) {

            $last_orderId = $this->clientes_model->lastId();

            //return $last_orderId;

        }

        redirect('/clientes');
    }

    public function ver_detalles($id)
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('clientes_model');

        $data["cliente"] = $this->clientes_model->traer_detalles($id);

        $data['titulo'] = 'Detalles del Cliente';
        $data['main_content'] = 'inicio';

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('cliente_detalles_view', $data);

    }

    public function editar_cliente($id)
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('clientes_model');

        $data["cliente"] = $this->clientes_model->traer_detalles($id);

        $data['titulo'] = 'Editar Cliente';
        $data['main_content'] = 'inicio';

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('editar_cliente_view', $data);

    }

    public function agregar_view()
    {
        $data['titulo'] = 'Agregar Cliente';
        $data['main_content'] = 'inicio';

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view', $data);
        $this->load->view('agregar_cliente_view');
    }

    public function actualizar_cliente($id)
    {

        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('clientes_model');

        $cliente = array(
            'rfc' => $this->input->post('RFC'),
            'razon_social' => $this->input->post('Razon_Social'),
            'direccion' => $this->input->post('Direccion'),
            'ciudad' => $this->input->post('Ciudad'),
            'estado' => $this->input->post('Estado'),
            'codigo_postal' => $this->input->post('Codigo_Postal'),
            'telefono' => $this->input->post('Telefono'),
            'contacto' => $this->input->post('Contacto'),
            'correo' => $this->input->post('Correo'),
            'alias' => $this->input->post('Alias'),
            );

        $this->clientes_model->actualizarCliente($id, $cliente);

        redirect('clientes/ver_detalles/'.$id);

    }

    public function eliminar_cliente($id)
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('clientes_model');

        if($this->clientes_model->eliminarCliente($id))
            redirect('/clientes/index');

    }

}