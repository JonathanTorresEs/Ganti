<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 06:41 PM
 */
class Compras extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('compras2_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public  function insertar()
    {
        $compra = array(
            'product_id' => $this->input->post('IDProducto'),
            'description' => $this->input->post('Descripcion'),
            'quantity' => $this->input->post('Cantidad'),
/*            'cost' => $this->input->post('Costo'),*/
            'invoice_number' => $this->input->post('NoFactura'),
            'order_number' => $this->input->post('NoOrden'),
            'payment_method' => $this->input->post('MetodoPago'),
            'provider_id' => $this->input->post('IDProveedor'),
            'purchase_status' => $this->input->post('EstadoDeCompra'),
            'user_id' => $this->input->post('IDUsuario'),
            'card_id' => $this->input->post('IDTarjeta'),
            'machine_id' => $this->input->post('IDMaquina'),
            'mine_id' => $this->input->post('IDMina'),
            'created_at' => date("Y-m-d H:i:s"),
            'required_date' => date("Y")."-".date("m")."-".date("d"),
            'request_date' => '',
            'sent_date' => '',
            'received_date' => ''
        );


        $this->load->model('productos_model');
        $producto = $this->productos_model->consultaProducto($compra['product_id']);
        $producto->stock = $producto->stock + $compra['quantity'];
        $this->productos_model->actualizarProducto($compra['product_id'], $producto);

        if($this->compras2_model->insertar($compra))
            redirect('compras');
    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $this->load->model('compras2_model');


        if($this->uri->segment(3) == "set"){
            $myVal = $this->uri->segment(4);
            if($myVal == 'Todos'){
                $myVal = $this->compras2_model->total_todos();
            }
            $this->session->set_userdata('pagination', $myVal);
            redirect("compras");
        }
        $data['titulo'] = 'Requisiciones';
        $data['main_content']='inicio';

        $data['btn'] = '2';
        $pagin = '10';

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }


        //$data['comprasGuardados'] = $this->compras2_model->leer();

        $config = array();
        $config["base_url"] = base_url() . "compras/index/pag";
        $config["total_rows"] = $this->compras2_model->total_registros();
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
        $this->session->set_userdata('page', $page);
        $data["comprasGuardados"] = $this->compras2_model->traer_compras($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;



        if($this->uri->segment(3) !='' && $this->uri->segment(3) != 'pag'){
            $id = $this->uri->segment(3);
            $data['actualizarCompra'] = $this->compras2_model->consultaCompra($id);
        }

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



        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('compras_view',$data);
    }

    public function mailer($id){
        $this->load->model('productos_model');
        $this->load->model('maquinas_model');
        $this->load->model('minas_model');


        $compra = $this->compras2_model->consultaCompra($id);
        $producto = $this->productos_model->consultaProducto($compra->product_id)->description;
        $maquina = $this->maquinas_model->consultaMaquina($compra->machine_id)->description;
        $departamento = $this->minas_model->consultaMina($compra->mine_id)->description;


        $num_producto = $compra->quantity;
        $clave = $compra->purchase_id;
        $comentarios = $compra->description;

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

                                                    <div>Se autorizó la compra de ' . $num_producto . ' ' . $producto . ' con clave ' . $clave .' para la Maquina ' . $maquina .' del departamento ' . $departamento . '.</div>

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
        $config ['smtp_host']='smtp.ipage.com';
        $config ['smtp_user'] = 'rtrevizo@ganti.com.mx';
        $config ['smtp_pass'] = 'Iigibia6*';
        $config ['smtp_port'] = '587';
        $config ['mailtype'] = 'html';

        $this->email->initialize($config);



        $this->email->to('lortiz@ganti.com.mx');
        $this->email->from('noreply-compras@ganti.com.mx');

        $this->email->subject('Requisicion aprobada');

        $this->email->message($content);

        $this->email->send();


    }

    public function recibidos()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Requisiciones';
        $data['main_content']='inicio';

        $data['btn'] = '3';
        $pagin = '10';

        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('compras2_model');
        //$data['comprasGuardados'] = $this->compras2_model->leer();

        $config = array();
        $config["base_url"] = base_url() . "compras/recibidos/pag";
        $config["total_rows"] = $this->compras2_model->total_recibidos();
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
        $data["comprasGuardados"] = $this->compras2_model->
        traer_compras_recibidas($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        if($this->uri->segment(3) !='' && $this->uri->segment(3) != 'pag'){
            $id = $this->uri->segment(3);
            $data['actualizarCompra'] = $this->compras2_model->consultaCompra($id);
        }

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
        $this->load->view('compras_view',$data);
    }

    public function autorizados()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Requisiciones';
        $data['main_content']='inicio';

        $data['btn'] = '4';
        $pagin = '10';


        if($this->input->post('perPage') != null) {
            $pagin = $this->input->post('perPage');
            $this->session->set_userdata('pagination', $pagin);
        } else if($this->session->userdata('pagination') != null) {
            $pagin = $this->session->userdata('pagination');
        }

        $this->load->model('compras2_model');
        //$data['comprasGuardados'] = $this->compras2_model->leer();

        $config = array();
        $config["base_url"] = base_url() . "compras/autorizados/pag";
        $config["total_rows"] = $this->compras2_model->total_autorizados();
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
        $data["comprasGuardados"] = $this->compras2_model->
        traer_compras_autorizados($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        if($this->uri->segment(3) !='' && $this->uri->segment(3) != 'pag'){
            $id = $this->uri->segment(3);
            $data['actualizarCompra'] = $this->compras2_model->consultaCompra($id);
        }

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
        $this->load->view('compras_view',$data);
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

        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/enviados/pag";
        $config["total_rows"] = $this->compras2_model->total_enviados();
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
        $data["comprasGuardados"] = $this->compras2_model->
        traer_compras_enviados($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        if($this->uri->segment(3) !='' && $this->uri->segment(3) != 'pag'){
            $id = $this->uri->segment(3);
            $data['actualizarCompra'] = $this->compras2_model->consultaCompra($id);
        }

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
        $this->load->view('compras_view',$data);
    }

    public function actualizar(){



        $compra = array(
            'product_id' => $this->input->post('IDProducto'),
            'description' => $this->input->post('Descripcion'),
            'quantity' => $this->input->post('Cantidad'),
            'cost' => $this->input->post('Costo'),
            'invoice_number' => $this->input->post('NoFactura'),
            'order_number' => $this->input->post('NoOrden'),
            'payment_method' => $this->input->post('MetodoPago'),
            'provider_id' => $this->input->post('IDProveedor'),
            'purchase_status' => $this->input->post('EstadoDeCompra'),
            'user_id' => $this->input->post('IDUsuario'),
            'card_id' => $this->input->post('IDTarjeta'),
            'machine_id' => $this->input->post('IDMaquina'),
            'mine_id' => $this->input->post('IDMina'),
            'autorized' => $this->input->post('Autorizado'),
            'required_date' => $this->input->post('FechaRequerido'),
            'request_date' => $this->input->post('FechaPedido'),
            'sent_date' => $this->input->post('FechaEnviado'),
            'updated_at' => date("Y-m-d H:i:s"),
            'received_date' => $this->input->post('FechaRecibido')
        );
        if ($compra['purchase_status']=="Pedido"){
            $compra['request_date'] = date("Y")."-".date("m")."-".date("d");
        }elseif($compra['purchase_status']=="Enviado"){
            $compra['sent_date'] = date("Y")."-".date("m")."-".date("d");
        }else{
            $compra['received_date'] = date("Y")."-".date("m")."-".date("d");
        }
        $id = $this->input->post('ID');

        $send = 0;

        if ($compra['autorized'] == 1 &&  $this->compras2_model->consultaCompra($id)->autorized == 0){
            $send = 1;
        }

        $this->load->model('compras2_model');

        if ($send){
            //$this->mailer($id);
        }

        if($this->compras2_model->actualizarCompra($id, $compra))
            $this->session->set_flashdata('actualizado','La requisición se actualizó correctamente');



        if ($compra['purchase_status']=='Recibido'){
            $this->load->model('productos_model');
            $producto = $this->productos_model->consultaProducto($compra['product_id']);
            $producto->stock = $producto->stock + $compra['quantity'];
            $this->productos_model->actualizarProducto($compra['product_id'], $producto);
        }

        $page = $this->session->userdata('page');
        redirect('compras/index/pag/'.$page);
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

        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/index/pag";
        $config["total_rows"] = $this->compras2_model->total_registros();
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
        $data["comprasGuardados"] = $this->compras2_model->
        traer_compras($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['actualizarCompra'] = $this->compras2_model->consultaCompra($this->uri->segment(3));

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
        $this->load->view('compras_view',$data);
    }

    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('compras2_model');
        if($this->compras2_model->eliminarCompra($id))
            redirect('compras');
    }

    public function fetchByInvoice()
    {
        $data['titulo'] = 'Compras';
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
        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/fetchByInvoice/pag";
        $config["per_page"] = $pagin;

        $results = $this->compras2_model->traer_facturas($config['per_page'], $page, $term);
        $config["total_rows"] = $this->compras2_model->total_facturas($term);
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


        $data["comprasGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('compras_view',$data);
    }

    public function fetchByCard()
    {
        $data['titulo'] = 'Compras';
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
        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/fetchByCard/pag";
        $config["per_page"] = $pagin;
        $results = $this->compras2_model->traer_tarjetas($config['per_page'], $page, $term);
        $config["total_rows"] = $this->compras2_model->total_tarjetas($term);
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


        $data["comprasGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('compras_view',$data);

    }

    public function fetchByDate()
    {
        $data['titulo'] = 'Compras';
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
        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/fetchByDate/pag";
        $config["per_page"] = $pagin;
        $results = $this->compras2_model->traer_fechaRequerido($config['per_page'], $page, $term);
        $config["total_rows"] = $this->compras2_model->total_fechaRequerido($term);
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


        $data["comprasGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('compras_view',$data);
    }

    public function fetchByProduct()
    {
        $data['titulo'] = 'Compras';
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
        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/fetchByProduct/pag";
        $config["per_page"] = $pagin;
        $results = $this->compras2_model->traer_producto($config['per_page'], $page, $term);
        $config["total_rows"] = $this->compras2_model->total_producto($term);
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
        $data["comprasGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('compras_view',$data);
    }

    public function fetchByMine()
    {
        $data['titulo'] = 'Compras';
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
        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/fetchByMine/pag";
        $config["per_page"] = $pagin;
        $results = $this->compras2_model->traer_mina($config['per_page'], $page, $term);
        $config["total_rows"] = $this->compras2_model->total_mina($term);
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


        $data["comprasGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('compras_view', $data);
        $this->load->view('partials/footer_view');
    }

    public function fetchByMaquina()
    {
        $data['titulo'] = 'Compras';
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
        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/fetchByMine/pag";
        $config["per_page"] = $pagin;
        $results = $this->compras2_model->traer_maquina($config['per_page'], $page, $term);
        $config["total_rows"] = $this->compras2_model->total_maquina($term);
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


        $data["comprasGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('compras_view', $data);
        $this->load->view('partials/footer_view');
    }

    public function fetchByDeliver()
    {
        $data['btn'] = '1';

        $data['titulo'] = 'Compras';
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
        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/fetchByDeliver/pag";
        $config["per_page"] = $pagin;
        $results = $this->compras2_model->traer_entregado($config['per_page'], $page, $term);
        $config["total_rows"] = $this->compras2_model->total_entregado($term);
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


        $data["comprasGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('compras_view',$data);
    }

    public function fetchByUser()
    {
        $data['btn'] = '1';

        $data['titulo'] = 'Compras';
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
        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/fetchByUser/pag";
        $config["per_page"] = $pagin;
        $results = $this->compras2_model->traer_usuario($config['per_page'], $page, $term);
        $config["total_rows"] = $this->compras2_model->total_usuario($term);
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


        $data["comprasGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('compras_view', $data);
        $this->load->view('partials/footer_view');
    }

    public function fetchById()
    {
        $data['titulo'] = 'Compras';
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
        $this->load->model('compras2_model');

        $config = array();
        $config["base_url"] = base_url() . "compras/fetchByCard/pag";
        $config["per_page"] = $pagin;
        $results = $this->compras2_model->traer_id($config['per_page'], $page, $term);
        $config["total_rows"] = $this->compras2_model->total_id($term);
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


        $data["comprasGuardados"] = !empty($results) ? $results : null;
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        $data['perPage'] = $pagin;

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('compras_view',$data);
    }

    public function getProducts(){
        $term = $this->input->post('string');
        $this->load->model('productos_model');
        $products = $this->productos_model->buscar($term);
        $results = [];
        $cont=0;
        foreach ($products as $product){
            $results["items"][$cont] = ["id"=>$product->product_id,"text"=>$product->code." - ".$product->description];
            $cont++;
            /*if($cont >90){
                break;
            }*/
        }
       echo json_encode($results);//json_encode(["items" => [["id"=>"1","text"=>"Producto 1"],["id"=>"2","text"=>"Producto 2"],["id"=>"3","text"=>"Producto 3"]]]);
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
        echo json_encode($results);//json_encode(["items" => [["id"=>"1","text"=>"Producto 1"],["id"=>"2","text"=>"Producto 2"],["id"=>"3","text"=>"Producto 3"]]]);
    }

}