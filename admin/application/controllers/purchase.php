<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 6/9/2017
 * Time: 2:05 PM
 */
class purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
        $this->load->helper(array('url', 'form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public function index()
    {
        $id_order = $this->input->get('var1');
        if ($data['ocultar'] = $this->input->get('var2')) ;

        $orden_stat = $this->input->get('var3');
        $data['estatus_orden'] = $orden_stat;

        $username = $this->input->get('var4');
        $data['username'] = $username;

        $data['pdf_name'] = 'pdf_name';

        $id_requesition = "";
        $last_price = "";
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }
        $this->load->model('order_model');
        $this->load->model('requesition_model');
        $this->load->model('multipleRequsition_model');

        if ($this->uri->segment(3) == "set") {
            $myVal = $this->uri->segment(4);
            if ($myVal == 'Todos') {
                $myVal = $this->order_model->total_registros_requerdio();
            }
            $this->session->set_userdata('pagination', $myVal);
            redirect("order");
        }
        $data['titulo'] = 'order';
        $data['main_content'] = 'inicio';

        $data['btn'] = '2';
        $pagin = '10';// inicia mostranbdo 10 datos

        if ($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if ($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        //$data['ordersGuardados'] = $this->order_model->leer();
// datos mostrados paginascion
        $config = array();
        $config["base_url"] = base_url() . "order/index/pag";
        $config["total_rows"] = $this->order_model->total_registros_requerdio(); //total de registros con status de
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
        $count = 0;
        // tarer Todas requesiciones multiples que estan Autorizadas
        $id_requesitionsMultiple_order = $this->multipleRequsition_model->traer_requisiciones_requeridas($config["per_page"], $page, "Autorizada");
        // si encontro requesiciones entonces
        if (is_array($id_requesitionsMultiple_order) || is_object($id_requesitionsMultiple_order))
            foreach ($id_requesitionsMultiple_order as $id_requesitionMultiple_order) {
            // Trae todas las requsiciones adentro de la requsicion multiple
                $id_requesitions_m = $this->requesition_model->traer_requsiciones_order($id_requesitionMultiple_order->id_multipleRequesition);
                if (is_array($id_requesitions_m) || is_object($id_requesitions_m)) {
                    foreach ($id_requesitions_m as $id_requesition_s) {
                      $id_requesition[] = $id_requesition_s;
                        $count++;
                    }

                }/* else {

                    $id_requesitionMultiple_order_cambio = array(
                        'requesition_status' => "autorizada",
                    );
                    $this->multipleRequsition_model->actualizarRequesition($id_requesitionMultiple_order->id_multipleRequesition, $id_requesitionMultiple_order_cambio);
                }*/

            }
        if (is_array($id_requesition) || is_object($id_requesition))
            $data["ordenesGuardadas"] = $id_requesition;

        else{
            $data["ordenesGuardadas"] = NULL;
        }
        if ($id_requesition == 0) {
            $data["ordenesGuardadas"] = NULL;
        }
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $requesition_A = "";
        if ($this->uri->segment(3) != '' && $this->uri->segment(3) != 'pag') {
            $id = $this->uri->segment(3);
        }

        /*        $data['ordenesGuardadas'] = $this->order_model->leer();*/
        $data['actualizarorder'] = $this->order_model->consultaOrder($id_order);

        if ($id_order != null) {
            $data['id_lastorder'] = $id_order;
/*            $data['Ordenes_guardadas'] = $this->order_model->leer($id_order);*/
/*            $data['actualizarorder'] = $this->order_model->consultaOrder($id);*/
            $requesition_A = $this->requesition_model->purchase_order($id_order);
                $data['requesition_A'] = $requesition_A;
                   foreach ($requesition_A as $requesition_A_s) {
                       $product_id = $requesition_A_s->product_id;
                       $products_price = $this->requesition_model->find_lastprice($product_id);
                             foreach ($products_price as $products_price_s) {
                           $last_price[] = $products_price_s;

                       }
                   }

                if (is_array($last_price) || is_object($last_price)) {
                    $data["lastpriceGuardadas"] = $last_price;
                } else {
                    $data["lastpriceGuardadas"] = NULL;


            }
        }

        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('usuarios_model');
        $data['usuarios'] = $this->usuarios_model->leer();


        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        if (is_array($requesition_A) || is_object($requesition_A)) {
        $this->load->view('order2_view', $data);
        }else{
            $this->load->view('purchase_view', $data);

        }

    }


    public function agregar_order()
    {
        $this->load->model('requesition_model');
        $this->load->model('multipleRequsition_model');
        $this->load->model('order_model');

        $requesitions = $this->input->post('items');

        $order = array(
            'order_status' => "Agregandose",
            'payment_method' => "pendiente",
            'user_id' => $this->session->userdata('user_id'),
            'date' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'provider_id' => "NULL",
        );
        $last_orderId = $this->order_model->insertar($order);
        if ($last_orderId != NULL) {
            $last_orderId = $this->order_model->lastId();

            foreach ($requesitions as $id_requesition) {
                $purchase = array(
                    'id_requesition' => $id_requesition,
                    'order_id' => $last_orderId
                );
                $this->requesition_model->actualizarRequesition($id_requesition, $purchase);
            }
              redirect("purchase");

        }
    }


    public function eliminar()
    {
        $this->load->model('requesition_model');
        $this->load->model('order_model');
        $this->load->model('multipleRequsition_model');

        $last_orderId = $this->uri->segment(3);

        $this->order_model->eliminarOrder($last_orderId);
        $requesitions = $this->requesition_model->purchase_order($last_orderId);
        foreach($requesitions as $requesition){
            $id_requesition = $requesition->id_requesition;
            $s_requesition = array(
                'id_requesition' => $id_requesition,
                'order_id' => NULL
            );
            $id_requesition_m = $requesition->id_multipleRequesition;
            $m_requesition = array(
                'id_multipleRequesition' => $id_requesition_m,
                'requesition_status' => 'Autorizada'
            );
            $this->requesition_model->actualizarRequesition($id_requesition, $s_requesition);
            $this->multipleRequsition_model->actualizarRequesition($id_requesition_m, $m_requesition);

        }
        redirect("purchase");
    }



    public function update(){
        $this->load->model('requesition_model');
        $this->load->model('order_model');
        $id_requesition = $this->input->get('id');
        $requesition_price = $this->input->get('val');
        $requesition_quantity = $this->input->get('val1');
        print_r($requesition_quantity);

        if($requesition_price != null){
            print("entre al primer if");

            $purchase = array(
            'id_requesition' => $id_requesition,
            'cost' => $requesition_price
        );
        }
        if($requesition_quantity != null){
            print("entre al segundo if");
            $purchase = array(
                'id_requesition' => $id_requesition,
                'quantity' => $requesition_quantity
            );
        }
        $this->requesition_model->actualizarRequesition($id_requesition, $purchase);
        $requesition = $this->requesition_model->consultaRequesition($id_requesition);
          $order_id = $requesition->order_id;
            $requesitions_orders = $this->requesition_model->purchase_order($order_id);
            foreach($requesitions_orders as $req_ord){
                if($req_ord->cost != null) {
                    $key = True ;
                 }
                 else{
                     $key = False ;
                     break;
                }
            }
            if ($key){

        $order = array(
            'id_order' => $order_id,
            'order_status' => "gerencia"
                );
        $this->order_model->actualizarOrder($order_id,$order);
            }

         return;
}


}