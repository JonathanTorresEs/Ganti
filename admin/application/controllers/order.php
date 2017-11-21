<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 6/9/2017
 * Time: 2:05 PM
 */

class order extends CI_Controller
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

    public function insertar()
    {
        $this->load->model('order_model');

        $order = array(
            'order_status' => "Agregandose",
            'payment_method' => "pendiente",
            'user_id' => $this->session->userdata('user_id'),
            'date' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'provider_id' => "NULL",
            'pdf_name' => "NULL"
        );


        if ($this->order_model->insertar($order)) {

            $last_orderId = $this->order_model->lastId();

            return $last_orderId;

        }

    }

    public function index()
    {

        $POST_orden_stat = $this->input->post('orden_stat');

        if(($POST_orden_stat != ""))
        {
            $status_order = $POST_orden_stat;
        }
        else
        {
            $status_order = $this->input->post('status_order');
        }

        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('order_model');
        $this->load->model('requesition_model');

        if ($this->uri->segment(3) == "set") {
            $myVal = $this->uri->segment(4);
            if ($myVal == 'Todos') {
                $myVal = $this->order_model->total_registros_requerdio();
            }
            $this->session->set_userdata('pagination', $myVal);
            redirect("order");
        }
        $data['titulo'] = 'Órdenes de Compra';
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

        if ($status_order == "todos" || $status_order == Null) {
            $data["ordenesGuardadas"] = $this->order_model->leer();
        } else {
            $data["ordenesGuardadas"] = $this->order_model->traer_ordenes_status($status_order);
            $data["orden_status"] = $status_order;

        }
        $config["total_rows"] = $this->order_model->traer_ordenes_status($status_order);

        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;
       

        if ($this->uri->segment(3) != '') {
            $id = $this->uri->segment(3);
            $data["orderGuardada"] = $this->order_model->consultaOrder($id);
        } else {
            $data["orderGuardada"] = NULL;
        }
        /*        $data['ordenesGuardadas'] = $this->order_model->leer();*/

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('order_view', $data);

    }

    public function actualizar()
    {
        $this->load->model('order_model');

        $order = array(
            'id_order' => $this->input->post('ID'),
            'order_status' => $this->input->post('order_status'),
            'provider_id' => $this->input->post('IDproviders'),
            'payment_method' => $this->input->post('payment_method'),
            'pdf_name' => $this->input->post('pdf_name'),
        );

        $id = $this->input->post('ID');
        if ($this->order_model->actualizarOrder($id, $order))
            $this->session->set_flashdata('actualizado', 'La requisición se actualizó correctamente');


        $page = $this->session->userdata('page');
        redirect('purchase?var1='.$id);
    }

    public function do_upload()
    {
        //Set up config parameters
        $config['upload_path'] = 'public/uploads';
        $config['allowed_types'] = 'pdf|png|jpeg';
        $config['max_size']     = '0';

        //Load uploading file library
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload', $config);

        //Get variables to redirect user to same page after file is uploaded
        $id_order = $this->input->post('ID');
        $var2 = $this->input->post('Var2');
        $orden_stat = $this->input->post('Var3');
        $username = $this->input->post('Var4');

        //If a file was not set, do nothing and redirect to the same page
        if ( ! $this->upload->do_upload('pdf_name'))
        {
            //File not set
            redirect('purchase?var1='.$id_order.'&var2=ocultado'.'&var3='.$orden_stat.'&var4='.$username);
        }
        else
        {

            //File set
            $this->load->model('order_model');

            //Upload the file
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            //Place order ID and file name in array
            $order = array(
                'id_order' => $this->input->post('ID'),
                'pdf_name' => $file_name,
            );

            //Update order with chosen file
            $id = $this->input->post('ID');
            if ($this->order_model->actualizarOrder($id, $order))
                $this->session->set_flashdata('actualizado', 'La requisición se actualizó correctamente');

            //Load the email library
            $this->load->library('email');

            //Configure email to use sendmail
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['mailtype'] = 'html';
            $config['charset']    = 'utf-8';

            //Initialize the email with the configuration
            $this->email->initialize($config);

            //Get provider email
            $provider_id = $this->input->post('Var5');
            $provider_email = $this->order_model->get_provider_email($provider_id);

            //Get full email details
            $productos =  $this->order_model->get_order_products($id_order);
            $string_productos = "<table> <tr> <th> Descripcion </th> <th> Cantidad </th> <th> Costo </th> </tr>";

            $i = 0;

            //Add every product of the order to the email content
            foreach($productos as $producto)
            {
                $object_description = $productos[$i]->description;
                $object_quantity = $productos[$i]->quantity;
                $object_cost = $productos[$i]->cost;
                $string_productos = $string_productos."<tr> <td>". $object_description . "</td> <td>" . $object_quantity . "</td> <td>" . $object_cost . "</td> </tr>";

                $i++;
            }

            $string_productos = $string_productos . "</table> 
            <br>
            <div style=\"max-width:500px\">
            <small> © Ganti, Chihuahua, México, 2017. Este mensaje es automatizado. 
            El contenido de este mensaje de datos es confidencial y se entiende dirigido y para uso exclusivo del destinatario, 
            por lo que no podrá distribuirse y/o difundirse por ningún medio sin la previa autorización del emisor original. </small>
            </div>";

            //Set email addresses
            $this->email->from('compras@ganti.com.mx', 'Compras');
            $this->email->to($provider_email, $username);
            //$this->email->to('jonathan.torres.es@gmail.com');

            //Set email content
            $this->email->subject('Orden de compra - Transferencia enviada');
            $this->email->message('<img src="https://ganti.com.mx/admin/public/img/firma.png">'.' <br> Orden de Compra #'.$id_order.'<br> <br>'.$string_productos);

            //Attach pdf to email
            $this->email->attach($_SERVER["DOCUMENT_ROOT"].'/admin/public/uploads/'.$file_name);

            //Send email if everything is ok
            if ($this->email->send())
            {
                //print_r("EMAIL SENT");
                //print_r($this->email->print_debugger(array()));
            } else
            {
                // print_r("ERROR - EMAIL NOT SENT");
                //print_r($this->email->print_debugger(array()));
            }

            //Redirect user to same page after file is uploaded
            $page = $this->session->userdata('page');
            redirect('purchase?var1='.$id_order.'&var2=ocultado'.'&var3='.$orden_stat.'&var4='.$username);
        }

    }

    public function aprobar_gerencia(){
        $this->load->model('order_model');
        $this->load->model('requesition_model');

        $order_id = $this->uri->segment(3);
        $order = array(
            'id_order' => $order_id,
            'Gerencia' => 1,
            'order_status' => "comprando"
        );
        $requesitions = $this->requesition_model->purchase_order($order_id);
        foreach ($requesitions as $requesition) {
            $product_id = $requesition->product_id;
            if($this->requesition_model->find_product($product_id)) {
                $product_t =  $this->requesition_model->find_product($product_id);
                foreach ($product_t as $product_t_s) {
                    $product_id_t = $product_t_s->id_lastprice;
                }

                $lastprice = array(
                    'product_id' => $product_id,
                    'lastprice' => $requesition->cost
                );
                $this->requesition_model->actualizarlastprice($product_id_t, $lastprice);
            }
            else{
                $lastorder = array(
                    'product_id' => $product_id,
                    'lastprice' => $requesition->cost
                );
                $this->requesition_model->insertar_lastprice($lastorder);

            }
        }

        if ($this->order_model->actualizarOrder($order_id, $order)){
            redirect('order');

        }

    }

    public function aprobar_comprando(){
        $this->load->model('order_model');
        $this->load->model('requesition_model');
        $order_id = $this->uri->segment(3);

        $order_objeto = $this->order_model->consultaOrder($order_id);

        $order_payment = $order_objeto->payment_method;
        $order_provider = $order_objeto->provider_id;

            $order = array(
                'id_order' => $order_id,
                'Gerencia' => 1,
                'order_status' => "comprado"
            );
            $requesitions = $this->requesition_model->purchase_order($order_id);
            foreach ($requesitions as $requesition) {
                $product_id = $requesition->product_id;
                if($this->requesition_model->find_product($product_id)) {
                    $product_t =  $this->requesition_model->find_product($product_id);
                    foreach ($product_t as $product_t_s) {
                        $product_id_t = $product_t_s->id_lastprice;
                    }

                    $lastprice = array(
                        'product_id' => $product_id,
                        'lastprice' => $requesition->cost
                    );
                    $this->requesition_model->actualizarlastprice($product_id_t, $lastprice);
                }
                else{
                    $lastorder = array(
                        'product_id' => $product_id,
                        'lastprice' => $requesition->cost
                    );
                    $this->requesition_model->insertar_lastprice($lastorder);

                }
            }

            if ($this->order_model->actualizarOrder($order_id, $order)) {
                redirect('order');

            }

    }


    public function aprobar_envio(){
        $this->load->model('order_model');
        $this->load->model('requesition_model');
        $this->load->model('mine_products_model');
        $localtiation_product_array ="";
        $order_id = $this->uri->segment(3);
        $order = array(
            'id_order' => $order_id,
            'order_status' => "recibido" // Obrea

        );
        $requesition_A = $this->requesition_model->purchase_order($order_id);

        if ($this->order_model->actualizarOrder($order_id, $order))
            foreach ($requesition_A as $requesition_A_s) {

                $localtiation_product_array = $this->mine_products_model->consultaMineProduct($requesition_A_s->product_id,$requesition_A_s->mine_id);

                if($localtiation_product_array != null){
                    $p_stock = $localtiation_product_array->stock;
                 $id_p_l = $localtiation_product_array->id_mine_product;
                   $Localicacion_prodcuto = array(
                     'mine_id' => $requesition_A_s->mine_id,
                     'product_id' => $requesition_A_s->product_id,
                     'stock' => $p_stock + $requesition_A_s->quantity,
                     'updated_at' => date("Y-m-d H:i:s")

                 );
                    $this->mine_products_model->actualizarMineProduct($id_p_l,$Localicacion_prodcuto);
                }

                 else{
                    $Localicacion_prodcuto = array(
                        'mine_id' => $requesition_A_s->mine_id,
                        'product_id' => $requesition_A_s->product_id,
                        'stock' => $requesition_A_s->quantity,
                        'updated_at' => date("Y-m-d H:i:s")

                    );
                    $this->mine_products_model->insertar($Localicacion_prodcuto);

                }

        }

            redirect('order');

    }

    public function order_print_view()
    {
        $this->load->model('order_model');
        $this->load->model('requesition_model');

        $order_id = $this->uri->segment(3);
        $order = $this->order_model->consultaOrder($order_id);
        $data['titulo'] = 'Imprimir Orden';
        $data['requesition_A'] = $this->requesition_model->purchase_order($order_id);
        $data["order"] = $order;
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('order_print_view', $data);
}
    public function order_print_pdf_view()
    {
        $this->load->model('order_model');
        $this->load->model('requesition_model');

        $order_id = $this->uri->segment(3);
        $data['titulo'] = 'Imprimir Orden';
        $order = $this->order_model->consultaOrder($order_id);
        $data['requesition_A'] = $this->requesition_model->purchase_order($order_id);
        $data["order"] = $order;
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('order_print_pdf_view', $data);
    }
    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('order_model');
        if($this->order_model->eliminarOrder($id))
         redirect('order');
    }
    public function delete_requesition(){
        $id = $this->uri->segment(3);
        $this->load->model('requesition_model');

        if($this->requesition_model->delete_single_reuqesitions($id))
            redirect('purchase');

    }

      public function remove_requesition_order()
      {
          $id = $this->uri->segment(3);
          $this->load->model('requesition_model');
          $this->load->model('order_model');
          $requesition = $this->requesition_model->consultaRequesition($id);
          $order_id = $requesition->order_id;

           $this->requesition_model->remove_requesition_order($id);


          if ($this->requesition_model->find_requesition_in_order($order_id)){
              $this->order_model->eliminarOrder($order_id);
             redirect('order');

          }
          else{
          redirect('purchase?var1='.$order_id);
          }
      }
}