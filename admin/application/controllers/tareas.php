<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 02:38 PM
 */
class Tareas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tareas_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->database('default');
    }

    public  function insertar()
    {

        if ($this->input->post('Recurrent') == 1){
            $Recurrente = $this->input->post('Recurrent');
        }
        else{
            $Recurrente = 0;
        }


        $error = false;

        $tarea = array(
            'title' => $this->input->post('Titulo'),
            'description' => $this->input->post('Descripcion'),
            'deadline' => $this->input->post('Fecha_limite'),
            'finished' => $this->input->post('Terminada'),
            'recurring' => $Recurrente,
            'created_at' => date("Y-m-d H:i:s"),
            'user_id' => $this->input->post('user_ID'));



        if($tarea['title'] == '' || $tarea['description'] == '' || ($tarea['deadline'] == '' AND $tarea['recurring'] == 0 ) ){
            $error = true;
        }
        if($tarea['recurring'] == 1){
            $tarea['deadline'] = date("Y-m-d", strtotime("Next Saturday"));
        }

        if ($error == false){
            $this->load->model('usuarios_model');
            if ($tarea['user_id'] == '') {
                $data['usuariosGuardados'] = $this->usuarios_model->leer() ;
                foreach ($data['usuariosGuardados'] as $usuario) {
                    if ($usuario->user_id > 3) {
                        $tarea['user_id'] = $usuario->user_id;
                        $this->tareas_model->insertar($tarea);
                    }
                }
            }
            else{
                $this->tareas_model->insertar($tarea);
            }





            redirect('tareas');
        }

        else {
            redirect('tareas/error');
        }


    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Tareas';
        $data['main_content']='inicio';

        $this->load->model('tareas_model');

        $this->tareas_model->deleteDupes();

        $data['tareasGuardadas'] = $this->tareas_model->leer();
        $this->load->model('login_model');
        $data['error'] = '';
        $data['btn'] = '0';





        //bloque de regeneracion
            $tareasRec = $this->tareas_model->leerRecurrentes();

            foreach ($tareasRec as $tareaRec){
                $done = 0;
                $myTarea = array(
                    'title' => $tareaRec->title,
                    'description' => $tareaRec->description,
                    'deadline' => date("Y-m-d", strtotime("Next Saturday")),
                    'finished' => '0',
                    'recurring' => '1',
                    'created_at' => date("Y-m-d H:i:s"),
                    'user_id' => $tareaRec->user_id);

                foreach ($data['tareasGuardadas'] as $tarea){
                    if ($tareaRec->title == $tarea->title AND $tareaRec->description == $tarea->description AND $tareaRec->user_id == $tarea->user_id){
                        $done = 1;
                    }
                }

                if($done == 0){
                    $this->tareas_model->insertar($myTarea);
                }
            }

        //bloque de regeneracion


        $data['tareasGuardadas'] = $this->tareas_model->leer();

        $data['usuariosGuardados'] = $this->login_model->leer() ;



        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarTarea'] = $this->tareas_model->consultaTarea($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('tareas_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function error()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Tareas';
        $data['main_content']='inicio';

        $this->load->model('tareas_model');
        $data['tareasGuardadas'] = $this->tareas_model->leer();
        $this->load->model('login_model');

        $data['error'] = 'Asegurate de llenar todos los campos';
        $data['btn'] = '0';



        $data['usuariosGuardados'] = $this->login_model->leer() ;



        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarTarea'] = $this->tareas_model->consultaTarea($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('tareas_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function timeout()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Tareas';
        $data['main_content']='inicio';

        $this->load->model('tareas_model');
        $data['tareasGuardadas'] = $this->tareas_model->leer();
        $this->load->model('login_model');

        $data['error'] = 'Hubo un error en la conexi&oacute;n, favor de volver a intentar en un par de minutos.';


        $data['usuariosGuardados'] = $this->login_model->leer() ;



        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarTarea'] = $this->tareas_model->consultaTarea($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('tareas_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function actualizar(){

        if ($this->input->post('Recurrent')){
            $Recurrente = $this->input->post('Recurrent');
        }
        else{
            $Recurrente = 0;
        }

        if ($this->input->post('Terminada')){
            $Terminada = $this->input->post('Terminada');
        }
        else{
            $Terminada = 0;
        }

        $tarea = array(
            'title' => $this->input->post('Titulo'),
            'description' => $this->input->post('Descripcion'),
            'deadline' => $this->input->post('Fecha_limite'),
            'finished' => $Terminada,
            'recurring' => $Recurrente,
            'updated_at' => date("Y-m-d H:i:s"),
            'user_id' => $this->input->post('user_ID'),
            'finished_at' => $this->input->post('Terminada_en'));


        $id = $this->input->post('ID');




        $this->load->model('tareas_model');

        $myVar = $this->tareas_model->consultaTarea($id);

        if($tarea['finished'] == 1 && $myVar->finished == 0){
            //$this->mailer($tarea['Titulo'], $tarea['Descripcion'], ['cgarcia@ganti.com.mx', 'lortiz@ganti.com.mx']);

            if ($this->session->userdata('profile') != 'Administrador' or $tarea['finished_at'] == 0){
                $tarea['finished_at'] = date('Y-m-d');
            }
        }
        if($tarea['finished'] == 0){
            $tarea['finished_at'] = NULL;
        }



        if($this->tareas_model->actualizarTarea($id, $tarea)) {
            $this->session->set_flashdata('actualizado', 'La tarea se actualizó correctamente');
            redirect('tareas');
        }
    }

    public function doing()
    {
        if($this->session->userdata('profile') == FALSE or $this->session->userdata('profile') != 'Administrador')
        {
            redirect(base_url().'login');
        }


        $data['titulo'] = 'Tareas';
        $data['main_content']='inicio';

        $this->load->model('tareas_model');
        $data['tareasGuardadas'] = $this->tareas_model->leerDoing();
        $this->load->model('usuarios_model');

        $data['btn'] = '2';

        if($this->input->post('all')){
            redirect('tareas/doing/all/null');
        }
        if($this->input->post('histMRep')){
            $dateId = $this->input->post('histMRep');
            redirect('tareas/doing/mes/'.$dateId);
        }
        if($this->input->post('histRep')){
            $dateId = $this->input->post('histRep');
            redirect('tareas/doing/sem/'.$dateId);
        }

        if($this->uri->segment(5)!=''){
            $id = $this->uri->segment(5);
            if($id != 'null') {
                $data['usuarioFiltro'] = $this->usuarios_model->consultaUsuario($id);
                $data['btn'] = 'progFilt';
            }
        }

        if($this->uri->segment(3)!=''){
            $dateId = $this->uri->segment(4);
            $selection = $this->uri->segment(3);


            if($selection == 'sem') {
                $data['tareasGuardadas'] = $this->tareas_model->leerDoingBySemana($dateId);
                $data['view'] = 's';
            }
            elseif ($selection == 'mes'){
                $data['tareasGuardadas'] = $this->tareas_model->leerDoingByMes($dateId);
                $data['view'] = 'm';

            }
            elseif ($selection == 'all'){
                $data['tareasGuardadas'] = $this->tareas_model->leerDoing();
                $data['view'] = 'a';
            }
        }

            $data['usuariosGuardados'] = $this->usuarios_model->leer() ;




        $data['error'] = '';




        $this->load->view('partials/header_view', $data);
        $this->load->view('tareas_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function done()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }

        $data['titulo'] = 'Tareas';
        $data['main_content']='inicio';

        $this->load->model('tareas_model');
        $data['tareasGuardadas'] = $this->tareas_model->leerDoneBySemana(0);
        $this->load->model('usuarios_model');

        $data['btn'] = '5';

        if($this->input->post('all')){
            redirect('tareas/done/all/null');
        }
        if($this->input->post('histMRep')){
            $dateId = $this->input->post('histMRep');
            redirect('tareas/done/mes/'.$dateId);
        }
        if($this->input->post('histRep')){
            $dateId = $this->input->post('histRep');
            redirect('tareas/done/sem/'.$dateId);
        }

        if($this->uri->segment(5)!=''){
            $id = $this->uri->segment(5);
            if($id != 'null') {
                $data['usuarioFiltro'] = $this->usuarios_model->consultaUsuario($id);
                $data['btn'] = 'termFilt';
            }
        }

        if($this->uri->segment(3)!=''){
            $dateId = $this->uri->segment(4);
            $selection = $this->uri->segment(3);


            if($selection == 'sem') {
                $data['tareasGuardadas'] = $this->tareas_model->leerDoneBySemana($dateId);
                $data['view'] = 's';
            }
            elseif ($selection == 'mes'){
                $data['tareasGuardadas'] = $this->tareas_model->leerDoneByMes($dateId);
                $data['view'] = 'm';

            }
            elseif ($selection == 'all'){
                $data['tareasGuardadas'] = $this->tareas_model->leerDone();
                $data['view'] = 'a';
            }
        }

        $data['usuariosGuardados'] = $this->usuarios_model->leer() ;


        $data['error'] = '';


        $this->load->view('partials/header_view', $data);
        $this->load->view('tareas_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function fetchById() {

        $url = $this->input->post("myUrl");
        if($this->input->post('prog') == 1){
            $term = $this->input->post('search');
            redirect('tareas/doing/'.$url."/".$term);
        }
        if($this->input->post('termi') == 1){
            $term = $this->input->post('search');
            redirect('tareas/done/'.$url."/".$term);
        }
        $comb = $this->input->post('helper');


        $data['titulo'] = 'Tareas';
        $data['main_content']='inicio';
        $data['error'] = '';

        $data['btn'] = '1';



        $term = '';

        if($this->input->post('search')) {
            $term = $this->input->post('search');
            $this->session->set_userdata('search_term', $term);
        } else if($this->session->userdata('search_term')) {
            $term = $this->session->userdata('search_term');
        }

        if($term == 'null'){
            $term = "all";
        }

        if ($comb == '1'){
            redirect('tareas/doing/'.$term);
        }



        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();


        $this->load->model('tareas_model');

        $config = array();
        $config["base_url"] = base_url() . "tareas/fetchById";
        $results = $this->tareas_model->fetchById($term);

        if($term == "all"){
            $data['tareasGuardadas'] = $this->tareas_model->leer();
        }
        else{
            $data["tareasGuardadas"] = !empty($results) ? $results : null;

        }



        $this->load->view('partials/header_view', $data);
        $this->load->view('tareas_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function eliminar(){
        if($this->session->userdata('profile') != 'Administrador'){
            redirect (base_url());
        }
        $id = $this->uri->segment(3);
        $this->load->model('tareas_model');

        if($this->tareas_model->eliminarTarea($id)) {
            redirect('tareas');
        }

    }

    public function eliminarRec(){
        if($this->session->userdata('profile') != 'Administrador'){
            redirect (base_url());
        }
        $Titulo = $this->uri->segment(3);
        $Descripcion = $this->uri->segment(4);

        $this->load->model('tareas_model');

        if($this->tareas_model->eliminarRec($Titulo, $Descripcion)) {
            redirect('tareas');
        }

    }

    public function mailer($titulo, $descripcion, $to){

        if(count($to) > 1){
            $message = '

                                                    <div>Se ha completado la tarea:</div>
                                                    <div style = "font-weight: 900;">'.$titulo.'</div>

                                                    <div >Descripci&oacute;n: <span style = "font-weight: 900;">'. $descripcion .'</span></div>

                                                    <div>-Equipo Ganti.</div>
                                                ';
            $subject = 'Se ha completado una tarea';
        }
        else{
            $message = '

                                                    <div>Se te ha sido asignada una tarea:</div>
                                                    <div style = "font-weight: 900;">'.$titulo.'</div>

                                                    <div >Descripci&oacute;n: <span style = "font-weight: 900;">'. $descripcion .'</span></div>

                                                    <div>-Equipo Ganti.</div>
                                                ';
            $subject = 'Se te ha asignado un tarea';
        }

        $content = '<html>

    <head>
        <title>Ganti</title>


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
        ' . $titulo . '
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
                                                '.$message.'

<a  href="http://admin.ganti.com.mx/tareas" target="_blank"  style="font-size: 15px; border-radius: 3px; font-family: Helvetica, Arial, sans-serif;  text-decoration: none; background-color: #222; color: #fff;  padding: 10px 20px; border: 1px solid #256F9C; display: inline-block;" class="mobile-button">Ver tarea</a>

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
                            <a style="text-decoration: none; color:white;" href="http://ganti.com.mx">CAMINOS Y CONSTRUCCIONES GANTI - CHIHUAHUA M&Eacute;XICO</a>




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



        $this->email->to($to);
        $this->email->from('noreply-tareas@ganti.com.mx');

        $this->email->subject($subject);

        $this->email->message($content);

        try{
            $this->email->send();
        }
        catch(Exception $e){
            redirect('tareas/timeout');
        }


    }

    public function reportes()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }

        if($this->session->userdata('profile') != 'Administrador'){
            redirect (base_url());
        }




        $data['titulo'] = 'Tareas';
        $data['main_content']='inicio';

        $data['btn'] = '3';

        $this->load->model('tareas_model');
        $this->load->model('login_model');

        if($this->input->post('all') == "Ver"){
            $data['reportes'] = $this->tareas_model->generarReporteTodo();
            $data['tareasGuardadas'] = $this->tareas_model->leerTodo();
            $data['view'] = 'a';

        }
        elseif (($this->input->post('histRep') == 'null' or $this->input->post('histRep') == NULL) AND $this->input->post('histMRep') == NULL){
            $data['reportes'] = $this->tareas_model->generarReporte();
            $data['tareasGuardadas'] = $this->tareas_model->leerBySemana(0);
            $data['view'] = 's';

        }
        elseif($this->input->post('histRep') != NULL){
            $myDate = $this->input->post('histRep');
            $data['reportes'] = $this->tareas_model->reporteBySemana($myDate);
            $data['tareasGuardadas'] = $this->tareas_model->leerBySemana($myDate);
            $data['view'] = 's';

        }
        elseif($this->input->post('histMRep') != NULL){
            $myDate = $this->input->post('histMRep');
            $data['reportes'] = $this->tareas_model->reporteByMes($myDate);
            $data['view'] = 'm';
            $data['tareasGuardadas'] = $this->tareas_model->leerByMes($myDate);

        }
        else{
            $data['tareasGuardadas'] = $this->tareas_model->leer();
        }



        $data['error'] = '';


        $data['usuariosGuardados'] = $this->login_model->leer() ;




        $this->load->view('partials/header_view', $data);
        $this->load->view('tareas_view',$data);
        $this->load->view('partials/footer_view');
    }

    public function recurrentes()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Tareas';
        $data['main_content']='inicio';

        $this->load->model('tareas_model');
        $mytasks = $this->tareas_model->DBRec();

        $count = 0;
        foreach ($mytasks as $tarea){
            if ($tarea['Usuario'] == 'Varios'){
                $myVar = $this->tareas_model->usersForTask($tarea['title'],$tarea['description']);
                $users=[];
                foreach ($myVar as $row){
                    array_push($users, $row->username);
                }
                $mytasks[$count]['multUsers'] = $users;
            }
            $count = $count + 1;
        }



        $data['tareasGuardadas'] = $mytasks;
        $this->load->model('login_model');

        $data['error'] = '';
        $data['btn'] = '4';



        $data['usuariosGuardados'] = $this->login_model->leer() ;



        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarTarea'] = $this->tareas_model->consultaTarea($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('tareas_view',$data);
        $this->load->view('partials/footer_view');
    }

}