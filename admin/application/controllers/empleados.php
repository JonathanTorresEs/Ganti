<?php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 02-Nov-17
 * Time: 11:10 AM
 */

class Empleados extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('empleados_model');
        $this->load->helper(array('url', 'form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }

    public function index()
    {
        $this->load->model('empleados_model');

        $data['titulo'] = 'Empleados';
        $data['main_content'] = 'inicio';
        $data["empleados"] = $this->empleados_model->leer();

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('empleados_view', $data);
    }

    public function agregar_view()
    {
        $data['titulo'] = 'Agregar Empleado';
        $data['main_content'] = 'inicio';

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view', $data);
        $this->load->view('agregar_empleado_view');
    }

    public function agregar_empleado()
    {

        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('empleados_model');

        //Check if Estado Civil is other
        $estado_civil = $this->input->post('Estado_Civil');
        if ($estado_civil == "")
        {
            $estado_civil = $this->input->post('Otro_Estado_Civil');
        }

        //Check if Enfermedad Cronica is "yes"
        $enfermedad_cronica = $this->input->post('Enfermedad_Cronica');
        if ($enfermedad_cronica == "Si")
        {
            $enfermedad_cronica = $this->input->post('Otro_Enfermedad_Cronica');
        }

        $empleado = array(
            'apellido_paterno' => $this->input->post('Apellido_Paterno'),
            'apellido_materno' => $this->input->post('Apellido_Materno'),
            'nombre' => $this->input->post('Nombre'),
            'puesto' => $this->input->post('Puesto'),
            'sueldo' => $this->input->post('Sueldo'),
            'fecha_ingreso' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Fecha_Ingreso')))),
            'edad' => $this->input->post('Edad'),
            'sexo' => $this->input->post('Sexo'),
            'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Fecha_Nacimiento')))),
            'nacimiento_estado' => $this->input->post('Nacimiento_Estado'),
            'nacimiento_municipio' => $this->input->post('Nacimiento_Municipio'),
            'telefono' => $this->input->post('Telefono'),
            'estado_civil' => $estado_civil,
            'curp' => $this->input->post('CURP'),
            'rfc' => $this->input->post('RFC'),
            'imss' => $this->input->post('IMSS'),
            'licencia_tipo' => $this->input->post('Licencia_Tipo'),
            'calle' => $this->input->post('Calle'),
            'calle_no' => $this->input->post('Calle_No'),
            'colonia' => $this->input->post('Colonia'),
            'codigo_postal' => $this->input->post('Codigo_Postal'),
            'estado' => $this->input->post('Estado'),
            'municipio' => $this->input->post('Municipio'),
        );

        $this->empleados_model->insertar($empleado);

        $last_id = $this->empleados_model->lastId();

        $empleado_salud = array(
            'empleado_id' => $last_id,
            'estado_salud' => $this->input->post('Estado_Salud'),
            'enfermedad_cronica' => $enfermedad_cronica,
            'peso' => $this->input->post('Peso'),
            'estatura' => $this->input->post('Estatura'),
            'no_calzado' => $this->input->post('No_Calzado'),
            'talla' => $this->input->post('Talla'),
            'contacto_nombre' => $this->input->post('Contacto_Nombre'),
            'parentesco' => $this->input->post('Parentesco'),
            'contacto_telefono' => $this->input->post('Contacto_Telefono')
        );

        //Check if dates are null to prevent bad data on database
        //If not null, format dates from JQuery Date picker to match data type from BD
        $primaria = $this->input->post('Primaria_Fecha');
            if ($primaria == ''){}
                //do nothing
                else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Primaria_Fecha'))));}

        $secundaria = $this->input->post('Secundaria_Fecha');
            if ($secundaria == ''){}
                //do nothing
                else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Secundaria_Fecha'))));}

        $preparatoria = $this->input->post('Preparatoria_Fecha');
            if ($preparatoria == ''){}
                //do nothing
                else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Preparatoria_Fecha'))));}


        $licenciatura = $this->input->post('Licenciatura_Fecha');
        if ($licenciatura == ''){}
        //do nothing
        else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Licenciatura_Fecha'))));}


        $maestria = $this->input->post('Maestria_Fecha');
        if ($maestria == ''){}
        //do nothing
        else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Maestria_Fecha'))));}


        $doctorado = $this->input->post('Doctorado_Fecha');
        if ($preparatoria == ''){}
        //do nothing
        else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Doctorado_Fecha'))));}

        $empleado_otros = array(
            'empleado_id' => $last_id,
            'primaria_fecha' => $primaria,
            'secundaria_fecha' => $secundaria,
            'preparatoria_fecha' => $preparatoria,
            'licenciatura_fecha' => $licenciatura,
            'maestria_fecha' => $maestria,
            'doctorado_fecha' => $doctorado,
            'referencia_nombre' => $this->input->post('Referencia_Nombre'),
            'referencia_ocupacion' => $this->input->post('Referencia_Ocupacion'),
            'referencia_telefono' => $this->input->post('Referencia_Telefono'),
            'referencia_años' => $this->input->post('Referencia_Años'),
        );

        $empleado_bancario = array(
            'empleado_id' => $last_id,
            'institucion_bancaria' => $this->input->post('Institucion_Bancaria'),
            'tipo_bancario' => $this->input->post('Tipo_Bancario'),
            'no_bancario' => $this->input->post('No_Bancario'),
            'infonavit' => $this->input->post('Infonavit')
        );

        $this->empleados_model->insertar_salud($empleado_salud);
        $this->empleados_model->insertar_otros($empleado_otros);
        $this->empleados_model->insertar_bancario($empleado_bancario);

        redirect('/empleados');

    }

    public function ver_detalles($id)
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('empleados_model');

        $data["empleado"] = $this->empleados_model->traer_detalles($id);
        $data["empleado_otros"] = $this->empleados_model->traer_detalles_otros($id);
        $data["empleado_salud"] = $this->empleados_model->traer_detalles_salud($id);
        $data["empleado_bancario"] = $this->empleados_model->traer_detalles_bancario($id);

        $data['titulo'] = 'Detalles del Empleado';
        $data['main_content'] = 'inicio';

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('detalles_empleado_view', $data);
    }

    public function editar_view($id)
    {
        $this->load->model('empleados_model');

        $data["empleado"] = $this->empleados_model->traer_detalles($id);
        $data["empleado_otros"] = $this->empleados_model->traer_detalles_otros($id);
        $data["empleado_salud"] = $this->empleados_model->traer_detalles_salud($id);
        $data["empleado_bancario"] = $this->empleados_model->traer_detalles_bancario($id);

        $data['titulo'] = 'Editar Empleado';
        $data['main_content'] = 'inicio';

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('editar_empleado_view', $data);
    }

    public function editar_empleado($id)
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('empleados_model');

        //Check if Estado Civil is other
        $estado_civil = $this->input->post('Estado_Civil');
        if ($estado_civil == "")
        {
            $estado_civil = $this->input->post('Otro_Estado_Civil');
        }

        //Check if Enfermedad Cronica is "yes"
        $enfermedad_cronica = $this->input->post('Enfermedad_Cronica');
        if ($enfermedad_cronica == "Si")
        {
            $enfermedad_cronica = $this->input->post('Otro_Enfermedad_Cronica');
        }


        $empleado = array(
            'apellido_paterno' => $this->input->post('Apellido_Paterno'),
            'apellido_materno' => $this->input->post('Apellido_Materno'),
            'nombre' => $this->input->post('Nombre'),
            'puesto' => $this->input->post('Puesto'),
            'sueldo' => $this->input->post('Sueldo'),
            'fecha_ingreso' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Fecha_Ingreso')))),
            'edad' => $this->input->post('Edad'),
            'sexo' => $this->input->post('Sexo'),
            'fecha_nacimiento' => date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Fecha_Nacimiento')))),
            'nacimiento_estado' => $this->input->post('Nacimiento_Estado'),
            'nacimiento_municipio' => $this->input->post('Nacimiento_Municipio'),
            'telefono' => $this->input->post('Telefono'),
            'estado_civil' => $estado_civil,
            'curp' => $this->input->post('CURP'),
            'rfc' => $this->input->post('RFC'),
            'imss' => $this->input->post('IMSS'),
            'licencia_tipo' => $this->input->post('Licencia_Tipo'),
            'calle' => $this->input->post('Calle'),
            'calle_no' => $this->input->post('Calle_No'),
            'colonia' => $this->input->post('Colonia'),
            'codigo_postal' => $this->input->post('Codigo_Postal'),
            'estado' => $this->input->post('Estado'),
            'municipio' => $this->input->post('Municipio'),
        );

        $empleado_salud = array(
            'estado_salud' => $this->input->post('Estado_Salud'),
            'enfermedad_cronica' => $enfermedad_cronica,
            'peso' => $this->input->post('Peso'),
            'estatura' => $this->input->post('Estatura'),
            'no_calzado' => $this->input->post('No_Calzado'),
            'talla' => $this->input->post('Talla'),
            'contacto_nombre' => $this->input->post('Contacto_Nombre'),
            'parentesco' => $this->input->post('Parentesco'),
            'contacto_telefono' => $this->input->post('Contacto_Telefono')
        );

        //Check if dates are null to prevent bad data on database
        //If not null, format dates from JQuery Date picker to match data type from BD

        $primaria = $this->input->post('Primaria_Fecha');
        if ($primaria == ''){}//do nothing
        else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Primaria_Fecha'))));}

        $secundaria = $this->input->post('Secundaria_Fecha');
        if ($secundaria == ''){} //do nothing
        else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Secundaria_Fecha'))));}

        $preparatoria = $this->input->post('Preparatoria_Fecha');
        if ($preparatoria == ''){} //do nothing
        else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Preparatoria_Fecha'))));}


        $licenciatura = $this->input->post('Licenciatura_Fecha');
        if ($licenciatura == ''){} //do nothing
        else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Licenciatura_Fecha'))));}


        $maestria = $this->input->post('Maestria_Fecha');
        if ($maestria == ''){} //do nothing
        else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Maestria_Fecha'))));}


        $doctorado = $this->input->post('Doctorado_Fecha');
        if ($preparatoria == ''){} //do nothing
        else {date('Y-m-d', strtotime(str_replace('-', '/', $this->input->post('Doctorado_Fecha'))));}

        $empleado_otros = array(
            'primaria_fecha' => $primaria,
            'secundaria_fecha' => $secundaria,
            'preparatoria_fecha' => $preparatoria,
            'licenciatura_fecha' => $licenciatura,
            'maestria_fecha' => $maestria,
            'doctorado_fecha' => $doctorado,
            'referencia_nombre' => $this->input->post('Referencia_Nombre'),
            'referencia_ocupacion' => $this->input->post('Referencia_Ocupacion'),
            'referencia_telefono' => $this->input->post('Referencia_Telefono'),
            'referencia_años' => $this->input->post('Referencia_Años'),
        );

        $empleado_bancario = array(
            'institucion_bancaria' => $this->input->post('Institucion_Bancaria'),
            'tipo_bancario' => $this->input->post('Tipo_Bancario'),
            'no_bancario' => $this->input->post('No_Bancario'),
            'infonavit' => $this->input->post('Infonavit')
        );

        $this->empleados_model->actualizarEmpleado($id, $empleado);
        $this->empleados_model->actualizarEmpleadoSalud($id, $empleado_salud);
        $this->empleados_model->actualizarEmpleadoOtros($id, $empleado_otros);
        $this->empleados_model->actualizarEmpleadoBancario($id, $empleado_bancario);

        redirect('empleados/ver_detalles/'.$id);

    }

    public function eliminar_empleado($id)
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $this->load->model('empleados_model');

        if($this->empleados_model->eliminarEmpleado($id))
            if($this->empleados_model->eliminarEmpleadoSalud($id))
                if($this->empleados_model->eliminarEmpleadoBancario($id))
                    if($this->empleados_model->eliminarEmpleadoOtros($id))
                            redirect('/empleados/index');

    }


}