<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 03:02 PM
 */
class Produccion extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('controles_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public  function d_insertar()
    {
        $newSize = $this->input->post('oil');
        $control = array(
            'date' => $this->input->post('fecha'),
            'place_id' => $this->input->post('diesel'),
            'shift' => $this->input->post('Turno'),
            'supervisor_id' => $this->input->post('IDOperador') ,
            'driller_id' => $this->input->post('IDOperador2') ,
            'advance' => $this->input->post('advance'),

            'cradle_type' => $this->input->post('nonelType') ,
            'nonel_qty' => $this->input->post('nonel') ,
            'cord_qty' => $this->input->post('cordQty') ,
            'canu_qty' => $this->input->post('canuQty') ,

            'alto2_qty' => $this->input->post('alt2Qty') ,
            'alto_qty' => $this->input->post('altQty') ,
            'anfo_qty' => $this->input->post('anfoQty') ,
            'anchor_qty' => $this->input->post('anchorQty'),
            'mesh_qty' => $this->input->post('meshQty'),

            'created_at' => date("Y-m-d H:i:s"),
        );
        $this->load->model('controles_model');
        $oldPlace = $this->controles_model->consultarPlace($control['place_id']);
        $oldPlace->size = $newSize;
        $this->controles_model->actualizarSize($oldPlace->place_id, $oldPlace);



        if($this->controles_model->p_insertar($control))
            redirect(base_url().'admin/index');
    }

    public  function a_insertar()
    {
        $control = array(
            'iron_down' => $this->input->post('diesel'),
            'iron_up' => $this->input->post('oil'),
            'operator_id' => $this->input->post('IDOperador'),
            'date' => $this->input->post('fecha'),
            'type' => $this->input->post('type'),
            'created_at' => date("Y-m-d H:i:s"),
        );
        if($control['iron_down'] == ''){
            $control['iron_down'] = 0;
        }
        if($control['iron_up'] == ''){
            $control['iron_up'] = 0;
        }
        $this->load->model('productos_model');
        if ($control['type'] == '8'){
            $idNum = 782;
        }
        elseif ($control['type'] == '6'){
            $idNum = 858;
        }
        else{
            $idNum = 859;
        }

        $producto = $this->productos_model->consultaProducto($idNum);
        $producto->stock = $producto->stock + $control['iron_up'];
        $producto->stock = $producto->stock - $control['iron_down'];
        $this->productos_model->actualizarProducto($idNum, $producto);

        $this->load->model('controles_model');

        if($this->controles_model->a_insertar($control))
            redirect(base_url().'admin/index');
    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'controles';
        $data['main_content']='inicio';

        $this->load->model('controles_model');
        //$data['usosGuardados'] = $this->usos_model->leer();

        $config = array();
        $config["base_url"] = base_url() . "produccion/index/pag";
        $config["total_rows"] = $this->controles_model->total_registrosProd(); 
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
        $data['controlesGuardados'] = $this->controles_model->leer();
        $data["links"] = $this->pagination->create_links();

        if($this->uri->segment(3)!='' && $this->uri->segment(3)!='pag' ){
            $id = $this->uri->segment(3);
            $data['actualizarProd'] = $this->controles_model->consultaProd($id);
            $placeAux = $this->controles_model->consultaProd($id);

            if($this->session->userdata('proTab') == '2'){
                $placeID = $placeAux->place_id;
                $data['actualizarPlace'] = $this->controles_model->consultarPlace($placeID);
            }


            $data['actualizarAcer'] = $this->controles_model->consultaAcer($id);

        }





        $data['controlesGuardados2'] = $this->controles_model->leer2();
        $data['controlesGuardados3'] = $this->controles_model->leer3();

        $data['controlesExp'] = $this->controles_model->leer4();
        $data['places'] = $this->controles_model->leerPlaces();
        $data['avances'] = $this->controles_model->robArm();

        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();
        $this->load->model('productos_model');
        $data['productosGuardados'] = $this->productos_model->leer();
        $this->load->model('operadores_model');
        $data['operadoresGuardados'] = $this->operadores_model->leer();

        $data['comms'] = $this->controles_model->comms();


        $data['dates3'] = $this->controles_model->traerFechas($config["per_page"], $page, 3);


        $data['dates4'] = $this->controles_model->traerFechas($config["per_page"], $page, 4);
        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('produccion_view',$data);

    }

    public function d_actualizar(){


        $control = array(
            'date' => $this->input->post('fecha'),
            'advance' => null,
            'place_id' => $this->input->post('diesel'),
            'shift' => $this->input->post('Turno'),
            'supervisor_id' => $this->input->post('IDOperador') ,
            'driller_id' => $this->input->post('IDOperador2') ,
            'advance' => $this->input->post('advance'),
            'bar_length' => $this->input->post('lenBar'),
            'barren_given' => $this->input->post('barDad'),
            'barren_used' => $this->input->post('barPeg'),

            'cradle_type' => $this->input->post('nonelType') ,
            'nonel_qty' => $this->input->post('nonel') ,
            'cord_qty' => $this->input->post('cordQty') ,
            'canu_qty' => $this->input->post('canuQty') ,

            'alto2_qty' => $this->input->post('alt2Qty') ,
            'alto_qty' => $this->input->post('altQty') ,
            'anfo_qty' => $this->input->post('anfoQty') ,
            'anchor_qty' => $this->input->post('anchorQty'),
            'mesh_qty' => $this->input->post('meshQty'),

            'updated_at' => date("Y-m-d H:i:s"),
        );

        $newSize = $this->input->post('oil');
        $oldPlace = $this->controles_model->consultarPlace($control['place_id']);
        $oldPlace->size = $newSize;
        $this->controles_model->actualizarSize($oldPlace->place_id, $oldPlace);


//
//        if(!$control['barren_used'] > 0){
//            $control['cradle_type'] = 0;
//            $control['nonel_qty'] = 0;
//            $control['cord_qty'] = 0;
//            $control['canu_qty'] = 0;
//            $control['alto2_qty'] = 0;
//            $control['alto_qty'] = 0;
//            $control['anfo_qty'] = 0;
//            $control['anchor_qty'] = 0;
//            $control['mesh_qty'] = 0;
//        }

        if($this->input->post('advance') != ''){
            $control['advance'] = $this->input->post('advance');
        }


        $id = $this->input->post('ID');
        $this->load->model('controles_model');
        if($this->controles_model->actualizarProd($id, $control))
            $this->session->set_flashdata('actualizado','El control se actualizó correctamente');
        redirect(base_url().'admin/index');
    }

    public function a_actualizar(){
        $control = array(
            'iron_down' => $this->input->post('diesel'),
            'iron_up' => $this->input->post('oil'),
            'operator_id' => $this->input->post('IDOperador'),
            'date' => $this->input->post('fecha'),
            'type' => $this->input->post('type'),
            'updated_at' => date("Y-m-d H:i:s"),
        );

        if ($control['type'] == '8'){
            $idNum = 782;
        }
        elseif ($control['type'] == '6'){
            $idNum = 858;
        }
        else{
            $idNum = 859;
        }


        if($control['iron_down'] == ''){
            $control['iron_down'] = 0;
        }
        if($control['iron_up'] == ''){
            $control['iron_up'] = 0;
        }

        $id = $this->input->post('ID');
        $this->load->model('controles_model');

        $myCont = $this->controles_model->consultaAcer($id);

        if ($myCont->type == '8'){
            $oldId = 782;
        }
        elseif ($myCont->type == '6'){
            $oldId = 858;
        }
        else{
            $oldId = 859;
        }
        $this->load->model('productos_model');

        $oldProduct = $this->productos_model->consultaProducto($oldId);
        $oldProduct->stock = $oldProduct->stock + $myCont->iron_down;
        $oldProduct->stock = $oldProduct->stock - $myCont->iron_up;
        $this->productos_model->actualizarProducto($oldId, $oldProduct);


        $producto = $this->productos_model->consultaProducto($idNum);
        $producto->stock = $producto->stock + $control['iron_up'];
        $producto->stock = $producto->stock - $control['iron_down'];
        $this->productos_model->actualizarProducto($idNum, $producto);





        if($this->controles_model->actualizarAcer($id, $control))
            $this->session->set_flashdata('actualizado','El control se actualizó correctamente');
        redirect(base_url().'admin/index');
    }

    public function d_eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('controles_model');

        $myCont = $this->controles_model->consultaCont($id);


        if($this->controles_model->eliminarProd($id))
            redirect(base_url().'admin/index');
    }

    public function a_eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('controles_model');

        $myCont = $this->controles_model->consultaAcer($id);

        if ($myCont->type == '8'){
            $idNum = 782;
        }
        elseif ($myCont->type == '6'){
            $idNum = 858;
        }
        else{
            $idNum = 859;
        }
        $this->load->model('productos_model');
        $producto = $this->productos_model->consultaProducto($idNum);
        $producto->stock = $producto->stock - $myCont->iron_up;
        $producto->stock = $producto->stock + $myCont->iron_down;
        $this->productos_model->actualizarProducto($idNum, $producto);

        if($this->controles_model->eliminarAcer($id))
            redirect(base_url().'admin/index');
    }

    public function getOperadores(){
        $term = $this->input->post('string');
        $this->load->model('operadores_model');
        $operators = $this->operadores_model->buscar($term);
        $results = [];
        $cont=0;
        foreach ($operators as $operator){
            $results["items"][$cont] = ["id"=>$operator->operator_id,"text"=>$operator->name];
            $cont++;
            /*if($cont >90){
                break;
            }*/
        }
        echo json_encode($results);//json_encode(["items" => [["id"=>"1","text"=>"Producto 1"],["id"=>"2","text"=>"Producto 2"],["id"=>"3","text"=>"Producto 3"]]]);
    }

    public function getPlaces(){
        $term = $this->input->post('string');
        $this->load->model('controles_model');
        $places = $this->controles_model->buscarLugar($term);
        $results = [];
        $cont=0;
        foreach ($places as $place){
            $results["items"][$cont] = ["id"=>$place->place_id,"text"=>$place->name];
            $cont++;
            /*if($cont >90){
                break;
            }*/
        }
        echo json_encode($results);//json_encode(["items" => [["id"=>"1","text"=>"Producto 1"],["id"=>"2","text"=>"Producto 2"],["id"=>"3","text"=>"Producto 3"]]]);
    }

    public function setTab (){
        $tab = $this->input->post('value');
            $this->session->set_userdata('proTab',$tab);
    }

    public function newPlace (){
        $place = $this->input->post('value');

        $toInsert = array(
            'name' => $place,
            'created_at' => date("Y-m-d H:i:s"),
        );
        $this->load->model('controles_model');
        $this->controles_model->newPlace($toInsert);
    }

    public function newComment (){
        $toInsert=array(
            'date' => $this->input->post('date'),
            'department' => $this->input->post('id'),
            'comment' => $this->input->post('text'),
        );
        $this->load->model('controles_model');
        $this->controles_model->actualizarComm( $toInsert );
    }

    public function errorCheck (){
        $debug = true;         //Variable de control para validacion

        $place = $this->input->post('placeCheck');
        $dist = $this->input->post('newDist');
        $date = $this->input->post('newDate');


        $this->load->model('controles_model');
        $exps = $this->controles_model->leer4();

        $index = count($exps);

        $found = 0;

        while($index) {
            if ($exps[--$index]->place_id == $place){
                $lastP = $exps[$index];
                $found = 1;

                break;
            }
        }

        if (!$found or $debug){
            echo '0';
        }
        else {
            $weekDay = date('w', strtotime($lastP->date));


            $preDate = date_create($lastP->date);
            $thisDate = date_create($date);
            $aux = date_diff($preDate, $thisDate);
            $aux = $aux->format('%a');
            $error = 0;

            $maxDays = (($weekDay + 3) % 7) + 1;

            if ($aux > $maxDays){
                if ($dist > 2.5){
                    $error = 1;
                }
            }
            elseif ($dist - $lastP->advance > 2.5) {
                $error = 1;
            }
            elseif($dist - $lastP->advance < 0){
                $error = 1;
            }

            if ($error){
                echo '1';
            }
            else {
                echo '0';
            }
        }


    }

    public function ajaxDIn (){
        $newSize = $this->input->post('oil');
        $control = array(
            'date' => $this->input->post('fecha'),
            'place_id' => $this->input->post('diesel'),
            'shift' => $this->input->post('Turno'),
            'supervisor_id' => $this->input->post('IDOperador') ,
            'driller_id' => $this->input->post('IDOperador2') ,
            'advance' => $this->input->post('advance'),
            'bar_length' => $this->input->post('lenBar'),
            'barren_given' => $this->input->post('barDad'),
            'barren_used' => $this->input->post('barReg'),

            'cradle_type' => $this->input->post('nonelType') ,
            'nonel_qty' => $this->input->post('nonel') ,
            'cord_qty' => $this->input->post('cordQty') ,
            'canu_qty' => $this->input->post('canuQty') ,

            'alto2_qty' => $this->input->post('alt2Qty') ,
            'alto_qty' => $this->input->post('altQty') ,
            'anfo_qty' => $this->input->post('anfoQty') ,
            'anchor_qty' => $this->input->post('anchorQty') ,
            'mesh_qty' => $this->input->post('meshQty') ,

            'created_at' => date("Y-m-d H:i:s"),
        );


//        if(!$control['barren_used'] > 0){
//            $control['cradle_type'] = 0;
//            $control['nonel_qty'] = 0;
//            $control['cord_qty'] = 0;
//            $control['canu_qty'] = 0;
//            $control['alto2_qty'] = 0;
//            $control['alto_qty'] = 0;
//            $control['anfo_qty'] = 0;
//            $control['anchor_qty'] =0;
//            $control['mesh_qty'] =0;
//        }

        $this->load->model('controles_model');
        $oldPlace = $this->controles_model->consultarPlace($control['place_id']);
        $oldPlace->size = $newSize;
        $this->controles_model->actualizarSize($oldPlace->place_id, $oldPlace);



        if($this->controles_model->p_insertar($control)){
            return 'Insercion exitosa';
        }
    }

    public function ajaxPlace(){
        $avances = $this->controles_model->robArm();
        $place_id = $this->input->post('place_id');
        $results = [];
        $cont=0;
        $trueAdv = 'not found';
        $this->load->model('controles_model');
        $query = $this->controles_model->placesFilt($place_id);
        foreach ($query as $row){
            foreach ($avances as $avance){
                if ($avance['id'] == $row->control_exp_id){
                    $trueAdv = $avance['avance'];
                    break;
                }
            }
            $results["items"][$cont] = ["id"=>$row->control_exp_id,"date"=>$row->date, "dist"=>$row->advance, "avance"=>$trueAdv];
            $cont++;
            /*if($cont >90){
                break;
            }*/
        }
        echo json_encode($results);//json_encode(["items" => [["id"=>"1","text"=>"Producto 1"],["id"=>"2","text"=>"Producto 2"],["id"=>"3","text"=>"Producto 3"]]]);
    }


}