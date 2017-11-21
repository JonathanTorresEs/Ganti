<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 03:02 PM
 */
class Operadores extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('operadores_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public  function insertar()
    {

            $mon = $this->input->post('weekday-mon');
            $tue = $this->input->post('weekday-tue');
            $wed = $this->input->post('weekday-wed');
            $thu = $this->input->post('weekday-thu');
            $fri = $this->input->post('weekday-fri');
            $sat = $this->input->post('weekday-sat');
            $sun = $this->input->post('weekday-sun');
            $Foreign = $this->input->post('Foreign');

           if($tue == "on"){$tue = 1;}
               if($wed == "on"){$wed = 1;}
               if($thu == "on"){$thu = 1;}
               if($fri == "on"){$fri = 1;}
               if($sat == "on"){$sat = 1;}
               if($sun == "on"){$sun = 1;}
               if($Foreign == "on"){$Foreign = 1;}

        $operador = array(
            'name' => $this->input->post('Name'),
            'lastNameP' => $this->input->post('LastNameP'),
            'lastNameM' => $this->input->post('LastNameM'),
            'date_B' => $this->input->post('date_B'),
            'residency' => $this->input->post('Residency'),
            'foreign_r' => $Foreign,
            'address' => $this->input->post('Address'),
            'phone' => $this->input->post('Phone'),
            'rfc' => $this->input->post('RFC'),
            'curp' => $this->input->post('CURP'),
            'imms_number' => $this->input->post('IMMS'),
            'department' => $this->input->post('Deparment'),
            'sub_department' => $this->input->post('Sub-Dep'),
            'date_S' => $this->input->post('date_S'),
            'mon' => $mon,
            'tue' => $tue,
            'wed' => $wed,
            'thu' => $thu,
            'fri' => $fri,
            'sat' => $sat,
            'sun' => $sun,
            'base_salary' => $this->input->post('Salary'),
            'viatics' => $this->input->post('Viatics'),
            'bonus' => $this->input->post('bonus'),
            'status' => 'Activo',
            'created_at' => date("Y-m-d H:i:s"),
        );

            if($this->operadores_model->insertar($operador))
   redirect('operadores');
    }

    public function index()
    {
        if($this->session->userdata('profile') == FALSE or ($this->session->userdata('profile') != "Administrador" and $this->session->userdata('username') != "amontes@ganti.com.mx" ))
        {
            redirect(base_url().'login');
        }

        $data['titulo'] = 'operadores';
        $data['main_content']='inicio';

        $this->load->model('operadores_model');
        //$data['usosGuardados'] = $this->usos_model->leer();

        $config = array();
        $config["base_url"] = base_url() . "operadores/index/pag";
        $config["total_rows"] = $this->operadores_model->total_registros();
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
        $data['operadoresGuardados'] = $this->operadores_model->
        traer_operadores($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        $data['opeRegs'] = $this->operadores_model->leerRegs();

        if($this->uri->segment(3)!='' && $this->uri->segment(3)!='pag'){
            $id = $this->uri->segment(3);
            $data['actualizarOperadores'] = $this->operadores_model->consultaOperador($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('operadores_view',$data);
    }



    public function actualizar(){

        $mon = $this->input->post('weekday-mon');
        $tue = $this->input->post('weekday-tue');
        $wed = $this->input->post('weekday-wed');
        $thu = $this->input->post('weekday-thu');
        $fri = $this->input->post('weekday-fri');
        $sat = $this->input->post('weekday-sat');
        $sun = $this->input->post('weekday-sun');
        $Foreign = $this->input->post('Foreign');
        if($mon == "on"){$mon = 1;}
        if($tue == "on"){$tue = 1;}
        if($wed == "on"){$wed = 1;}
        if($thu == "on"){$thu = 1;}
        if($fri == "on"){$fri = 1;}
        if($sat == "on"){$sat = 1;}
        if($sun == "on"){$sun = 1;}
        if($Foreign == "on"){$Foreign = 1;}

        $operador = array(
            'name' => $this->input->post('Name'),
            'lastNameP' => $this->input->post('LastNameP'),
            'lastNameM' => $this->input->post('LastNameM'),
            'date_B' => $this->input->post('date_B'),
            'residency' => $this->input->post('Residency'),
            'foreign_r' => $Foreign,
            'address' => $this->input->post('Address'),
            'phone' => $this->input->post('Phone'),
            'rfc' => $this->input->post('RFC'),
            'curp' => $this->input->post('CURP'),
            'imms_number' => $this->input->post('IMMS'),
            'department' => $this->input->post('Deparment'),
            'sub_department' => $this->input->post('Sub-Dep'),
            'date_S' => $this->input->post('date_S'),
            'mon' => $mon,
            'tue' => $tue,
            'wed' => $wed,
            'thu' => $thu,
            'fri' => $fri,
            'sat' => $sat,
            'sun' => $sun,
            'base_salary' => $this->input->post('Salary'),
            'viatics' => $this->input->post('Viatics'),
            'bonus' => $this->input->post('bonus'),
            'rehireable' => $this->input->post('Recon'),
            'status' => $this->input->post('status'),

        );
        if($operador['rehireable'] == ''){
            unset ($operador['rehireable']);
        }
        $id = $this->input->post('ID');

        $this->load->model('operadores_model');



        if($this->operadores_model->actualizarOperador($id, $operador))
            $this->session->set_flashdata('actualizado','El operador se actualizó correctamente');
        redirect('operadores');
    }

    public function eliminar(){
        $id = $this->uri->segment(3);
        $this->load->model('operadores_model');
        if($this->operadores_model->eliminarOperador($id))
            redirect('operadores');
    }
}

?>