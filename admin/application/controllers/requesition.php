<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: RubenbC
 * Date: 25/7/2017
 * Time: 06:41 PM
 */
class requesition extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('requesition_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }
/* En cuando agregas una nueva requesicion*/

    public function controller_get_mina_clave($mina_id)
    {
        $this->load->model('multipleRequsition_model');
        $clave_mina = $this->multipleRequsition_model->get_mina_clave($mina_id);
        echo $clave_mina;
    }

    public function controller_get_giro_clave($giro_id)
    {
        $this->load->model('multipleRequsition_model');
        $clave_giro = $this->multipleRequsition_model->get_giro_clave($giro_id);
        echo $clave_giro;
    }

    public  function insertar()
    {

            $this->load->model('productos_model');
            $this->load->model('requesition_model');
            $this->load->model('multipleRequsition_model');

            $mina_id = $this->input->post('IDMina');// Localizacion
            $giro_id = $this->input->post('IDGiro'); // Obra

            $clave_mina = $this->multipleRequsition_model->get_mina_clave($mina_id);

            $clave_giro = $this->multipleRequsition_model->get_giro_clave($giro_id);

        $multiple_requsicion = array(
            'mine_id' => $mina_id,// Localizacion
            'clave_mina' => $clave_mina,
            'turn_id' => $giro_id, // Obra
            'clave_giro' => $clave_giro,
            'family_id' => $this->input->post('IDFamilia'), // Familia
            'description' => $this->input->post('Descripcion'),
            'requesition_status' => 'Autorizada',
            'user_id' => $this->input->post('IDUsuario'),
            'created_at' => date("Y-m-d H:i:s"),
             );

        $multiple_requsicion_id = $this->multipleRequsition_model->insertar($multiple_requsicion);
        if($multiple_requsicion_id){
            $products = $this->input->post('items');
            if(!empty($products)){
                $requisition = [];
                $cont = 0;
                foreach ($products as $product){//Cantidad_%%_idproducto_%%_idMaquina ej. 10_%%_23_%%_2
                    $product_info = preg_split("/_%%_/",$product);//$product_info[0]=cantidad, $product_info[1]=idproducto, $product_info[2]= idmaquina
                    $requisition[$cont] = [
                        "machine_id" => $product_info[2],
                        "product_id" => $product_info[1],
                        "quantity" => $product_info[0],
                        "multipleRequesition_id" => $multiple_requsicion_id,
                        "required_date" => date("Y-m-d")
                    ];
                    $this->requesition_model->insertar($requisition[$cont]);

                    $cont++;
                }


            }else{
                print("Ocurrio un error");
                return "error: debe seleccionar por lo menos un producto";
            }
        }
       redirect('requesition');

    }

    /*
    En cuando agregas por primera vez una requesition a una order de compra
        */

    public  function insertar_ordercompra($id_requesition_multiple)
    {
        $this->load->model('productos_model');
        $this->load->model('mine_products_model');
        $this->load->model('order_model');
        $this->load->model('requesition_model');
        $this->load->model('multipleRequsition_model');

        $this->load->library('../controllers/order');
        $this->load->library('../controllers/purchase');
        $cont = 0;


        redirect("ordes/index/");

           }
            /*            $this->agregar_otro($last_orderId);*/




        public  function insertar_otra_purchase()
    {
        $id_requesition = $this->input->get('var1');
        $last_orderId = $this->input->get('var2');
        $this->load->model('productos_model');
        $this->load->model('mine_products_model');
        $this->load->model('order_model');
        $this->load->model('requesition_model');

        $this->load->library('../controllers/order');
        $this->load->library('../controllers/purchase');


        if($this->requesition_model->insertar_purchase($id_requesition,$last_orderId)) /*Agregar un requsicion a una order*/ {
            redirect("purchase/agregar_otro/$last_orderId");
            /*            $this->agregar_otro($last_orderId);*/

        }

    }


    public function index()
    {

        if($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url().'login');
        }
        $this->load->model('requesition_model');
        $this->load->model('multipleRequsition_model');
         if($this->uri->segment(3) == "set"){
              $myVal = $this->uri->segment(4);
              if($myVal == 'Todos'){
                  $myVal = $this->requesition_model->total_registros_requerdio();
              }
              $this->session->set_userdata('pagination', $myVal);
              redirect("requesition");
          }
        $data['titulo'] = 'Requesiciones';
        $data['main_content']='inicio';

        $data['btn'] = '2';
        $pagin = '10';// inicia mostranbdo 10 datos

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }


        $config = array();
        $config["base_url"] = base_url() . "requesition/index/pag";
        $config["total_rows"] = $this->multipleRequsition_model->total_registros_requerdio(); //total de registros con status de
        $config["per_page"] = $pagin;
        $config["uri_segment"] = 2;
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
        $this->session->set_userdata('page', $page);

        $btn_status = $this->input->post('btn_status');


        if($this->uri->segment(3) !='' && $this->uri->segment(3) != 'pag'){
            $id = $this->uri->segment(3);
            if($requesicion = $this->multipleRequsition_model->consultaRequesition($id))

                $btn_status =  $requesicion->requesition_status;
                }


        switch ($btn_status) {
            case NULL:
                $btn_status = "Autorizada";
                $data["btn"] = 2;
                break;
            case "Requerido":
                $btn_status = "Requerido";
                $data["btn"] = 2;
                break;
            case "Autorizados":
                $btn_status = "Autorizada";
                $data["btn"] = 3;
                break;
            case "No Autorizados":
                $btn_status = "No-Autorizados";
                $data["btn"] = 4;
                break;
        }


             $data["requesitionsmultiples_Guardados"] = $this->multipleRequsition_model->traer_requisiciones_requeridas($config["per_page"], $page, $btn_status );


        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;


        if($this->uri->segment(3) !='' && $this->uri->segment(3) != 'pag'){
            $data['actualizarRequesition_1'] = $this->multipleRequsition_model->consultaRequesition($id);
            $data['actualizarRequesition_2'] = $this->requesition_model->traer_requsiciones_order_null($id);
        }
        $this->load->model('giros_model');/*Obras*/
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('minas_model');/*Lugar*/
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();


        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('requesition_view',$data);
    }
    public function autorizar(){
        $this->load->model('multipleRequsition_model');
        $id = $this->uri->segment(3);
        $order = array(
            'id_multipleRequesition' => $id,
            'requesition_status' => "Autorizada"
        );
        $this->multipleRequsition_model->actualizarRequesition($id,$order);

        redirect('requesition/index');

    }
    public function traer_purchase_requesitions(){
        $this->load->model('multipleRequsition_model');
        $this->load->model('requesition_model');
        $this->load->model('productos_model');
        $this->load->model('maquinas_model');


        $id_requesition = $this->input->post('id_requesition');

        $requesition = $this->requesition_model->consultaRequesition($id_requesition);

        $multipleRequesition_id = $requesition->multipleRequesition_id;
        $product = $this->productos_model->consultaProducto($requesition->product_id);
        if ($requesition->machine_id != null){
        $machine = $this->maquinas_model->consultaMaquina($requesition->machine_id);
        }else{
            $machine = null;
        }
        $multipleRequesition = $this->multipleRequsition_model->consultaRequesition($multipleRequesition_id);
        $results["name"] = array (
            $requesition ,
            $multipleRequesition,
            $product,
            $machine );
        echo json_encode($results);

    }
    public function enviados()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Requisiciones';
        $data['main_content']='inicio';

        $data['btn'] = '5';
        $pagin = '10';


        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/enviados/pag";
        $config["total_rows"] = $this->requesition_model->total_enviados();
        $config["per_page"] = $pagin;
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
        $data["requesitionsGuardados"] = $this->requesition_model->
        traer_requesition_enviados($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        if($this->uri->segment(3) !='' && $this->uri->segment(3) != 'pag'){
            $id = $this->uri->segment(3);
            $data['actualizarRequesition'] = $this->requesition_model->consultaRequesition($id);
        }
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();
        $data['page'] = $page;
        $data['perPage'] = $pagin;


        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('requesition_view',$data);
    }

    public function actualizar(){

        $requsicion = array(
            'mine_id' => $this->input->post('IDMina'),// Localizacion
            'turn_id' => $this->input->post('IDGiro'), // Obrea
            'family_id' => $this->input->post('IDFamilia'), // Familia
            'description' => $this->input->post('Descripcion'),
            'requesition_status' => $this->input->post('EstadoDeRequesition'),
            'user_id' => $this->input->post('IDUsuario'),
            );

        $id = $this->input->post('ID');
        $this->load->model('multipleRequsition_model');
        if($this->multipleRequsition_model->actualizarRequesition($id, $requsicion))
            $this->session->set_flashdata('actualizado','La requisición se actualizó correctamente');



        $page = $this->session->userdata('page');
        redirect('requesition/index/pag/'.$page);
    }

    public function listar()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Requisiciones';
        $data['main_content']='inicio';

        $data['btn'] = '0';
        $pagin = '10';


        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/index/pag";
        $config["total_rows"] = $this->requesition_model->total_registros_requerdio();
        $config["per_page"] = $pagin;
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

        $page = $this->uri->segment(4);
        $data["requesitionsGuardados"] = $this->requesition_model->
        traer_requisiciones_requeridas($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['actualizarRequesition'] = $this->requesition_model->consultaRequesition($this->uri->segment(3));

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();
        $data['page'] = $page;
        $data['perPage'] = $pagin;



        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('requesition_view',$data);
    }

    public function eliminar(){
        $id = $this->uri->segment(3);
            $this->load->model('requesition_model');
            $this->load->model('multipleRequsition_model');
        if($this->requesition_model->eliminarRequesition($id) && ($this->multipleRequsition_model->eliminarRequesition($id)))
            redirect('requesition');
    }

    public function delete_single_reuqesitions(){
        $id = $this->uri->segment(3);
        $this->load->model('requesition_model');
        $requesition= $this->requesition_model->consultaRequesition($id);
        $multiplerequsicione_id = $requesition->multipleRequesition_id;
           if($this->requesition_model->delete_single_reuqesitions($id))
        redirect('requesition/index/'.$multiplerequsicione_id);
    }

    public function fetchByInvoice()
    {
        $data['titulo'] = 'requesition';
        $data['main_content']='inicio';

        $data['btn'] = '1';
        $pagin = '10';

        $term = '';

        if($this->input->post('term') != null) {
            $term = $this->input->post('term');
            $this->session->set_userdata('search_term', $term);
        } else if($this->session->userdata('search_term') != null) {
            $term = $this->session->userdata('search_term');
        }

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }


        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/fetchByInvoice/pag";
        $config["per_page"] = $pagin;

        $results = $this->requesition_model->traer_facturas($config['per_page'], $page, $term);
        $config["total_rows"] = $this->requesition_model->total_facturas($term);
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


        $data["requesitionsGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('requesition_view',$data);
    }

    public function fetchByCard()
    {
        $data['titulo'] = 'requesition';
        $data['main_content']='inicio';

        $data['btn'] = '1';
        $pagin = '10';

        $term = '';

        if($this->input->post('term') != null) {
            $term = $this->input->post('term');
            $this->session->set_userdata('search_term', $term);
        } else if($this->session->userdata('search_term')!= null) {
            $term = $this->session->userdata('search_term');
        }

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/fetchByCard/pag";
        $config["per_page"] = $pagin;
        $results = $this->requesition_model->traer_tarjetas($config['per_page'], $page, $term);
        $config["total_rows"] = $this->requesition_model->total_tarjetas($term);
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


        $data["requesitionsGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('requesition_view',$data);

    }

    public function fetchByDate()
    {
        $data['titulo'] = 'requesition';
        $data['main_content']='inicio';

        $data['btn'] = '1';

        $term = '';
        $pagin = '10';

        if($this->input->post('datepicker')!= null) {
            $term = $this->input->post('datepicker');
            $this->session->set_userdata('search_term', $term);
        } else if($this->session->userdata('search_term')!= null) {
            $term = $this->session->userdata('search_term');
        }

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }


        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/fetchByDate/pag";
        $config["per_page"] = $pagin;
        $results = $this->requesition_model->traer_fechaRequerido($config['per_page'], $page, $term);
        $config["total_rows"] = $this->requesition_model->total_fechaRequerido($term);
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


        $data["requesitionsGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('requesition_view',$data);
    }

    public function fetchByProduct()
    {
        $data['titulo'] = 'requesition';
        $data['main_content']='inicio';

        $data['btn'] = '1';

        $term = '';
        $pagin = '10';

        if($this->input->post('term')!= null) {
            $term = $this->input->post('term');
            $this->session->set_userdata('search_term', $term);
        } else if($this->session->userdata('search_term')!= null) {
            $term = $this->session->userdata('search_term');
        }


        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/fetchByProduct/pag";
        $config["per_page"] = $pagin;
        $results = $this->requesition_model->traer_producto($config['per_page'], $page, $term);
        $config["total_rows"] = $this->requesition_model->total_producto($term);
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
        $data["requesitionsGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('requesition_view',$data);
    }

    public function fetchByMine()
    {
        $data['titulo'] = 'requesition';
        $data['main_content'] = 'inicio';

        $data['btn'] = '1';

        $term = '';
        $pagin = '10';

        if ($this->input->post('term')!= null) {
            $term = $this->input->post('term');
            $this->session->set_userdata('search_term', $term);
        } else if ($this->session->userdata('search_term')!= null) {
            $term = $this->session->userdata('search_term');
        }

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/fetchByMine/pag";
        $config["per_page"] = $pagin;
        $results = $this->requesition_model->traer_mina($config['per_page'], $page, $term);
        $config["total_rows"] = $this->requesition_model->total_mina($term);
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


        $data["requesitionGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('requesition_view', $data);
        $this->load->view('partials/footer_view');
    }

    public function fetchByMaquina()
    {
        $data['titulo'] = 'requesition';
        $data['main_content'] = 'inicio';

        $data['btn'] = '1';

        $term = '';
        $pagin = '10';

        if ($this->input->post('term')!= null) {
            $term = $this->input->post('term');
            $this->session->set_userdata('search_term', $term);
        } else if ($this->session->userdata('search_term')!= null) {
            $term = $this->session->userdata('search_term');
        }

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/fetchByMine/pag";
        $config["per_page"] = $pagin;
        $results = $this->requesition_model->traer_maquina($config['per_page'], $page, $term);
        $config["total_rows"] = $this->requesition_model->total_maquina($term);
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


        $data["requesitionsGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('requesition_view', $data);
        $this->load->view('partials/footer_view');
    }

    public function fetchByDeliver()
    {
        $data['btn'] = '1';

        $data['titulo'] = 'requesition';
        $data['main_content']='inicio';

        $term = '';
        $pagin = '10';

        if($this->input->post('datepicker')!= null) {
            $term = $this->input->post('datepicker');
            $this->session->set_userdata('search_term', $term);
        } else if($this->session->userdata('search_term')!= null) {
            $term = $this->session->userdata('search_term');
        }

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/fetchByDeliver/pag";
        $config["per_page"] = $pagin;
        $results = $this->requesition_model->traer_entregado($config['per_page'], $page, $term);
        $config["total_rows"] = $this->requesition_model->total_entregado($term);
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


        $data["requesitionsGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('requesition_view',$data);
    }

    public function fetchByUser()
    {
        $data['btn'] = '1';

        $data['titulo'] = 'requesition';
        $data['main_content'] = 'inicio';

        $term = '';
        $pagin = '10';

        if ($this->input->post('term')!= null) {
            $term = $this->input->post('term');
            $this->session->set_userdata('search_term', $term);
        } else if ($this->session->userdata('search_term')!= null) {
            $term = $this->session->userdata('search_term');
        }

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/fetchByUser/pag";
        $config["per_page"] = $pagin;
        $results = $this->requesition_model->traer_usuario($config['per_page'], $page, $term);
        $config["total_rows"] = $this->requesition_model->total_usuario($term);
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


        $data["requesitionsGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('requesition_view', $data);
        $this->load->view('partials/footer_view');
    }

    public function fetchById()
    {
        $data['titulo'] = 'requesition';
        $data['main_content']='inicio';

        $data['btn'] = '1';

        $term = '';
        $pagin = '10';

        if($this->input->post('term')!= null) {
            $term = $this->input->post('term');
            $this->session->set_userdata('search_term', $term);
        } else if($this->session->userdata('search_term')!= null) {
            $term = $this->session->userdata('search_term');
        }

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('minas_model');
        $data['minasGuardadas'] = $this->minas_model->leer();
        $this->load->model('giros_model');
        $data['girosGuardados'] = $this->giros_model->leer();
        $this->load->model('familias_model');
        $data['familiasGuardadas'] = $this->familias_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $this->load->model('requesition_model');

        $config = array();
        $config["base_url"] = base_url() . "requesition/fetchByCard/pag";
        $config["per_page"] = $pagin;
        $results = $this->requesition_model->traer_id($config['per_page'], $page, $term);
        $config["total_rows"] = $this->requesition_model->total_id($term);
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


        $data["requesitionsGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('requesition_view',$data);
    }

    public function getProducts(){
        $term = $this->input->post('string');
        $familia = $this->input->post('family');
        $this->load->model('productos_model');
        $products = $this->productos_model->buscar($term,$familia);
        $results = [];
        $cont=0;
        foreach ($products as $product){
            $results["items"][$cont] = ["id"=>$product->product_id,"text"=>$product->code." - ".$product->description];
            $cont++;
            /*if($cont >90){
                break;
            }*/

        }
        echo json_encode($results);
        //json_encode(["items" => [["id"=>"1","text"=>"Producto 1"],["id"=>"2","text"=>"Producto 2"],["id"=>"3","text"=>"Producto 3"]]]);
    }
    public function getDescription_machines_products(){
        $this->load->model('productos_model');
        $this->load->model('maquinas_model');

        $machine_id= $this->input->post('machine');
        $product_id = $this->input->post('product');
        if ($machine_id != NULL){
            $machine= $this->maquinas_model->consultaMaquina($machine_id);
            $machine_d = $machine->description;
        }else{
            $machine_d = "NULL";
        }
        $product = $this->productos_model->consultaProducto($product_id);
        $product_d = $product->description;
        $results["names"] = [$product_d,$machine_d];

        echo json_encode($results);

    }


        public function getMaquinas(){
        $term = $this->input->post('string');
        $this->load->model('maquinas_model');
        $maquinas = $this->maquinas_model->buscar($term);
        $results = [];
        $cont=0;
        foreach ($maquinas as $maquina){
            $results["items"][$cont] = ["id"=>$maquina->machine_id,"text"=>$maquina->short_number];
            $cont++;
            /*if($cont >90){
                break;
            }*/
        }
        echo json_encode($results);
        //json_encode(["items" => [["id"=>"1","text"=>"Producto 1"],["id"=>"2","text"=>"Producto 2"],["id"=>"3","text"=>"Producto 3"]]]);
    }


    public function mailer($id){

        $this->load->model('productos_model');
        $this->load->model('maquinas_model');
        $this->load->model('minas_model');

        $requsicion = $this->requesition_model->consultaRequesition($id);
        $producto = $this->productos_model->consultaProducto($requsicion->product_id)->description;
        $maquina = $this->maquinas_model->consultaMaquina($requsicion->machine_id)->description;
        $departamento = $this->minas_model->consultaMina($requsicion->mine_id)->description;
        $num_producto = $requsicion->quantity;
        $clave = $requsicion->id_requesition;
        $comentarios = $requsicion->description;

        $content = '<html>

    <head>
        <title>Ganti Requisicion aprobada</title>


        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <style type="text/css">
            logo {
                color: aqua;
            }
            /* CLIENT-SPECIFIC STYLES */

            body,
            table,
            td,
            a {
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
            }
            /* Prevent WebKit and Windows mobile changing default text sizes */

            table,
            td {
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }
            /* Remove spacing between tables in Outlook 2007 and up */

            img {
                -ms-interpolation-mode: bicubic;
            }
            /* Allow smoother rendering of resized image in Internet Explorer */
            /* RESET STYLES */

            img {
                border: 0;
                height: auto;
                line-height: 100%;
                outline: none;
                text-decoration: none;
            }

            table {
                border-collapse: collapse !important;
            }

            body {
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }
            /* iOS BLUE LINKS */

            a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: none !important;
                font-size: inherit !important;
                font-family: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
            }
            /* MOBILE STYLES */

            @media screen and (max-width: 525px) {
                /* ALLOWS FOR FLUID TABLES */
                .wrapper {
                    width: 100% !important;
                    max-width: 100% !important;
                }
                /* ADJUSTS LAYOUT OF LOGO IMAGE */
                .logo img {
                    margin: 0 auto !important;
                    color: red;
                }
                /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
                .mobile-hide {
                    display: none !important;
                }
                .img-max {
                    max-width: 100% !important;
                    width: 100% !important;
                    height: auto !important;
                }
                /* FULL-WIDTH TABLES */
                .responsive-table {
                    width: 100% !important;
                }
                /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
                .padding {
                    padding: 10px 5% 15px 5% !important;
                }
                .padding-meta {
                    padding: 30px 5% 0px 5% !important;
                    text-align: center;
                }
                .no-padding {
                    padding: 0 !important;
                }
                .section-padding {
                    padding: 50px 15px 50px 15px !important;
                }
                /* ADJUST BUTTONS ON MOBILE */
                .mobile-button-container {
                    margin: 0 auto;
                    width: 100% !important;
                }
                .mobile-button {
                    padding: 15px !important;
                    border: 0 !important;
                    font-size: 16px !important;
                    display: block !important;
                }
            }
            /* ANDROID CENTER FIX */

            div[style*="margin: 16px 0;"] {
                margin: 0 !important;
            }
        </style>
    </head>

    <body style="margin: 0 !important; padding: 0 !important;">

    <!-- HIDDEN PREHEADER TEXT -->
    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        Requisicion aprobada.
    </div>

    <!-- HEADER -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#222" align="center">
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
                    <tr>
                        <td align="center" valign="top" width="500">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="wrapper">
                    <tr>
                        <td align="center" valign="top" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; padding: 15px 0; color: white;" class="logo">

                            GANTI Caminos y Construcciones

                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" align="center" style="padding: 70px 15px 70px 15px;" class="section-padding">
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
                    <tr>
                        <td align="center" valign="top" width="500">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                    <tr>
                        <td>
                            <!-- HERO IMAGE -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="padding" align="center">
                                        <img src="http://admin.ganti.com.mx//public/img/logo1.jpg" border="0" alt="GANTI" style="display: block; color: #666666;  font-family: Helvetica, arial, sans-serif; font-size: 16px;" class="img-max">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <!-- COPY -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding">

                                                    <div>Se autorizó la Requesition de ' . $num_producto . ' ' . $producto . ' con clave ' . $clave .' para la Maquina ' . $maquina .' del departamento ' . $departamento . '.</div>

                                                    <div>Comentarios: '. $comentarios .'</div>

                                                    <div>-Equipo Ganti.</div>


                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <!-- BULLETPROOF BUTTON -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="padding-top: 25px;" class="padding">
                                                    <table border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                                                       <!--
                                                        <tr>
                                                            <td align="center" style="border-radius: 3px;" bgcolor="#222"><a href="https://litmus.com" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; border-radius: 3px; padding: 15px 25px; border: 1px solid #256F9C; display: inline-block;" class="mobile-button">Boton placeholder</a></td>
                                                        </tr>
                                                        -->
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>


        <tr>
            <td bgcolor="#ed1c24" align="center" style=" padding: 20px 0px;">
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
                    <tr>
                        <td align="center" valign="top" width="500">
                <![endif]-->
                <!-- UNSUBSCRIBE COPY -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width: 500px;" class="responsive-table">
                    <tr>
                        <td align="center" style="  font-size: 12px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; " onclick="http://ganti.com.mx">
                            <a style="text-decoration: none; color:white;" href="http://ganti.com.mx">CAMINOS Y CONSTRUCCIONES GANTI - CHIHUAHUA M�XICO</a>




                            <br>
                        </td>
                    </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
    </table>
    </body>

    </html>';

        $this->load->library('email');

        //   $config ['smtp_crypto'] = 'ssl';
        $config ['protocol'] = 'smtp';
        $config ['smtp_host']='mail.ganti.com.mx';
        $config ['smtp_user'] = 'mmartinez@ganti.com.mx';
        $config ['smtp_pass'] = 'sdff22gg';
        $config ['smtp_port'] = '465';
        $config ['mailtype'] = 'html';

        $this->email->initialize($config);



        $this->email->to('mmartinez@ganti.com.mx');
        $this->email->from('mmartinez@ganti.com.mx');

        $this->email->subject('Requisicion aprobada');

        $this->email->message($content);

        $this->email->send();


    }


}