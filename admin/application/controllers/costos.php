<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */

class Costos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('costos_model');
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

        $data['titulo'] = 'Centro de Costos';
        $data['main_content'] = 'inicio';
        $data["costos"] = $this->costos_model->leer();

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('costos_view', $data);
    }

    //Display Create view
    public function agregar_view()
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $data['titulo'] = 'Crear Centro de Costo';
        $data['main_content'] = 'inicio';

        $this->load->model('costos_model');

        $next_id = $this->costos_model->lastId();
            if ($next_id == NULL)
                $next_id = 1;

        //Get all required info from other tables
        $clientes = $this->costos_model->traer_clientes();
        $empleados = $this->costos_model->traer_empleados();
        $giros = $this->costos_model->traer_giros();
        $localidades = $this->costos_model->traer_localidades();

        $data['clientes'] = $clientes;
        $data['empleados'] = $empleados;
        $data['giros'] = $giros;
        $data['localidades'] = $localidades;
        $data['costo_id'] = $next_id + 1;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view', $data);
        $this->load->view('agregar_costo_view');
    }

    //Insert into Costos table
    public function agregar_costo()
    {
        $this->load->model('costos_model');

        $costo = array(
            'giro_id' => $this->input->post('Giro'),
            'clave' => $this->input->post('Clave'),
            'cc' => $this->input->post('CC'),
            'nombre' => $this->input->post('Nombre'),
            'objeto' => $this->input->post('Objeto'),
            'localidad_id' => $this->input->post('Localidad_ID'),
            'localidad' => $this->input->post('Localidad'),
            'municipio' => $this->input->post('Municipio'),
            'estado' => $this->input->post('Estado'),
            'localizacion' => $this->input->post('Localizacion'),

            //Format JQuery Datepicker datatype to MYSQL Date datatype
            'fecha_inicio' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('fecha_inicio')))),
            'fecha_fin' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('fecha_fin')))),

            'plazo' => $this->input->post('Plazo'),
            'importe' => $this->input->post('Importe'),
            'cliente_id' => $this->input->post('Cliente_ID'),
            'cliente_nombre' => $this->input->post('Cliente'),
            'cliente_rfc' => $this->input->post('RFC'),
            'empleado_id' => $this->input->post('Empleado_No'),
            'empleado_nombre' => $this->input->post('Empleado')
        );

        $this->costos_model->insertar($costo);

        redirect('/costos');
    }

    public function ver_detalles($id)
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $costo = $this->costos_model->traer_detalles($id);
        $data["costo"] = $costo;

        $data['titulo'] = 'Detalles';
        $data['main_content'] = 'inicio';

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('detalles_costo_view', $data);
    }

    public function editar_view($id)
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        //Get all required info from other tables
        $clientes = $this->costos_model->traer_clientes();
        $empleados = $this->costos_model->traer_empleados();
        $giros = $this->costos_model->traer_giros();
        $localidades = $this->costos_model->traer_localidades();
        $costo = $this->costos_model->traer_detalles($id);

        $data["costo"] = $costo;
        $data['clientes'] = $clientes;
        $data['empleados'] = $empleados;
        $data['giros'] = $giros;
        $data['localidades'] = $localidades;

        $data['titulo'] = 'Detalles';
        $data['main_content'] = 'inicio';

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('editar_costo_view', $data);
    }

    public function editar_costo($id)
    {
        $this->load->model('costos_model');

        $costo = array(
            'giro_id' => $this->input->post('Giro'),
            'clave' => $this->input->post('Clave'),
            'cc' => $this->input->post('CC'),
            'nombre' => $this->input->post('Nombre'),
            'objeto' => $this->input->post('Objeto'),
            'localidad_id' => $this->input->post('Localidad_ID'),
            'localidad' => $this->input->post('Localidad'),
            'municipio' => $this->input->post('Municipio'),
            'estado' => $this->input->post('Estado'),
            'localizacion' => $this->input->post('Localizacion'),

            //Format JQuery Datepicker datatype to MYSQL Date datatype
            'fecha_inicio' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('fecha_inicio')))),
            'fecha_fin' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('fecha_fin')))),

            'plazo' => $this->input->post('Plazo'),
            'importe' => $this->input->post('Importe'),
            'cliente_id' => $this->input->post('Cliente_ID'),
            'cliente_nombre' => $this->input->post('Cliente'),
            'cliente_rfc' => $this->input->post('RFC'),
            'empleado_id' => $this->input->post('Empleado_No'),
            'empleado_nombre' => $this->input->post('Empleado')
        );

        $this->costos_model->actualizarCosto($id, $costo);

        redirect('/costos/ver_detalles/'.$id);
    }

    public function eliminar_costo($id)
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        if($this->costos_model->eliminarCosto($id))
            redirect('/costos/index');
    }

    //Methods used by Ajax functions to get info regarding Giro, Cliente, and Empleado
    public function get_giro_clave()
    {
        $this->load->model('costos_model');
        $giro_id = $this->input->post('Turn_ID');
        $giro_clave = $this->costos_model->get_giro_clave($giro_id);
        echo $giro_clave;
    }

    public function get_localidad_municipio()
    {
        $this->load->model('costos_model');
        $localidad_nombre = $this->input->post('Localidad');
        $municipio = $this->costos_model->get_localidad_municipio($localidad_nombre);
        echo $municipio;
    }

    public function get_localidad_estado()
    {
        $this->load->model('costos_model');
        $localidad_nombre = $this->input->post('Localidad');
        $estado = $this->costos_model->get_localidad_estado($localidad_nombre);
        echo $estado;
    }

    public function get_cliente_rfc()
    {
        $this->load->model('costos_model');
        $cliente_nombre = $this->input->post('Cliente_Nombre');
        $rfc = $this->costos_model->get_cliente_rfc($cliente_nombre);
        echo $rfc;
    }

    public function get_empleado_no()
    {
        $this->load->model('costos_model');
        $empleado_nombre = $this->input->post('Empleado_Nombre');
        $empleado_apellido_paterno = $this->input->post('Empleado_Apellido_Paterno');
        $empleado_apellido_materno = $this->input->post('Empleado_Apellido_Materno');
        $no = $this->costos_model->get_empleado_no($empleado_nombre, $empleado_apellido_paterno, $empleado_apellido_materno);
        if ($no == NULL)
            print_r("NULL");
        else
            print_r($no);
        return;
        echo $no;
    }

    public function get_giro_nombre()
    {
        $this->load->model('costos_model');
        $giro_id = $this->input->post('Turn_ID');
        $giro_nombre = $this->costos_model->get_giro_nombre($giro_id);
        echo $giro_nombre;
    }

    public function live_search_localidad()
    {
        $nombre = $this->input->post('Localidad_Nombre');
        $localidades = $this->costos_model->live_search_localidades($nombre);
        echo json_encode($localidades);
    }

    public function live_search_cliente()
    {
        $nombre = $this->input->post('Cliente_Nombre');
        $clientes = $this->costos_model->live_search_clientes($nombre);
        echo json_encode($clientes);
    }

    public function live_search_empleado()
    {
        $nombre = $this->input->post('Empleado_Nombre');
        $empleados = $this->costos_model->live_search_empleados($nombre);
        echo json_encode($empleados);
    }

}

