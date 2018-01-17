<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 24-Nov-17
 * Time: 11:38 AM
 */

require 'C:\xampp\htdocs\ganti\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Nominas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('nominas_model');
        $this->load->helper(array('url', 'form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
        $this->load->helper('download');
    }

    //Method that displays all empleado's nominas and Grupos IMSS information
    public function index()
    {
        if ($this->session->userdata('profile') == FALSE)// comprueba que este loggiado
        {
            redirect(base_url() . 'login');
        }

        $data['titulo'] = 'Nominas';
        $data['main_content'] = 'inicio';
        $data["nominas"] = $this->nominas_model->leer_nominas();
        $data["empleados"] = $this->nominas_model->leer_empleados();

        $this->load->view('partials/header_view', $data);
        $this->load->view('partials/footer_view');
        $this->load->view('nominas_view', $data);
    }

    //Method that searches an empleado and gets its nomina information using AJAX
    public function live_search_empleados()
    {
        $nombre = $this->input->post('Empleado_Nombre');
        $empleados = $this->nominas_model->live_search_empleados($nombre);
        echo json_encode($empleados);
    }

    //Method that downloads the whole nominas information as an Excel spreadsheet
    public function download_excel_nominas()
    {
        //Create a new spreadsheet
        $spreadsheet = new Spreadsheet();

        //Get nominas from all empleados
        $empleados = $this->nominas_model->leer_empleados();
        $row = 2;

        //
        // Percepciones sheet
        //

        //Add Percepciones sheet to spreadsheet and set it as the active sheet
        $percepciones_sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Percepciones');
        $spreadsheet->addSheet($percepciones_sheet, 0);
        $spreadsheet->setActiveSheetIndex(0);

        //Set table headers of Percepciones sheet
        if ($spreadsheet)
        {
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Nombre');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Apellido Paterno');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Apellido Materno');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Puesto');
            $spreadsheet->getActiveSheet()->setCellValue('E1', 'Grupos IMSS');
            $spreadsheet->getActiveSheet()->setCellValue('F1', 'Dias');
            $spreadsheet->getActiveSheet()->setCellValue('G1', 'Salario Diario Integrado');
            $spreadsheet->getActiveSheet()->setCellValue('H1', 'Salario Diario');
            $spreadsheet->getActiveSheet()->setCellValue('I1', 'Importe');
            $spreadsheet->getActiveSheet()->setCellValue('J1', 'Premio Asistencia');
            $spreadsheet->getActiveSheet()->setCellValue('K1', 'Premio Puntualidad');
            $spreadsheet->getActiveSheet()->setCellValue('L1', 'Subsudio al Empleo');
            $spreadsheet->getActiveSheet()->setCellValue('M1', 'Subtotal');

            //Set automatic width to columns
            for($k = 65; $k < 78; $k++){
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($k))->setAutoSize(true);
            }
        }

        //Fill Percepciones spreadsheet with the information
        foreach ($empleados as $empleado)
        {
            //Create a new, specific Empleado object with only the required information
            //The reason for creating this specific object instead of using the ones in possession
            //is so we can iterate more easily
            $excel_empleado = $this->create_excel_empleado_percepciones($empleado);

            $letter = 65;      //Letter A in ASCII - Letter M is 77 in ASCII
            $i = 0;            //First array value of excel_empleado

            //Fill the entire row with excel_empleado information
            for($letter; $letter < 78; $letter++)
            {
                $spreadsheet->getActiveSheet()->setCellValue(chr($letter).$row, $excel_empleado[$i]);
                $i++;
            };

            //Finished with filling entire row so advance to next empleado
            $row++;
        }

        //
        // Deducibles sheet
        //

        //Add Deducibles sheet to spreadsheet and set it as the active sheet
        $deducibles_sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Deducibles');
        $spreadsheet->addSheet($deducibles_sheet, 1);
        $spreadsheet->setActiveSheetIndex(1);

        //Reset row
        $row = 2;

        //Set table headers of Deducibles sheet
        if ($spreadsheet)
        {
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Nombre');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Apellido Paterno');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Apellido Materno');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Puesto');
            $spreadsheet->getActiveSheet()->setCellValue('E1', 'Grupos IMSS');
            $spreadsheet->getActiveSheet()->setCellValue('F1', 'Dias');
            $spreadsheet->getActiveSheet()->setCellValue('G1', 'Fondo Ahorro');
            $spreadsheet->getActiveSheet()->setCellValue('H1', 'Infonavit');
            $spreadsheet->getActiveSheet()->setCellValue('I1', 'IMSS');
            $spreadsheet->getActiveSheet()->setCellValue('J1', 'Pension Alimenticia');
            $spreadsheet->getActiveSheet()->setCellValue('K1', 'ISPT');
            $spreadsheet->getActiveSheet()->setCellValue('L1', 'Total Deducciones');
            $spreadsheet->getActiveSheet()->setCellValue('M1', 'Neto a Pagar IMSS');

            //Set automatic width to columns
            for($k = 65; $k < 78; $k++){
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($k))->setAutoSize(true);
            }
        }

        //Fill Deducibles spreadsheet with the information
        foreach ($empleados as $empleado)
        {
            //Create a new, specific Empleado object with only the required information
            $excel_empleado = $this->create_excel_empleado_deducibles($empleado);

            $letter = 65;      //Letter A in ASCII - Letter M is 77 in ASCII
            $i = 0;            //First array value of excel_empleado

            //Fill the entire row with excel_empleado information
            for($letter; $letter < 78; $letter++)
            {
                $spreadsheet->getActiveSheet()->setCellValue(chr($letter).$row, $excel_empleado[$i]);
                $i++;
            };

            //Finished with filling entire row so advance to next empleado
            $row++;
        }

        //
        // Sueldos sheet
        //

        //Add Sueldos sheet to spreadsheet and set it as the active sheet
        $sueldos_sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Sueldos');
        $spreadsheet->addSheet($sueldos_sheet, 2);
        $spreadsheet->setActiveSheetIndex(2);

        //Set table headers of Sueldos sheet
        if ($spreadsheet)
        {
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Nombre');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Apellido Paterno');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Apellido Materno');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Puesto');
            $spreadsheet->getActiveSheet()->setCellValue('E1', 'Sueldo Semanal');
            $spreadsheet->getActiveSheet()->setCellValue('F1', 'Total Deducciones');
            $spreadsheet->getActiveSheet()->setCellValue('G1', 'Total Percibido');
            $spreadsheet->getActiveSheet()->setCellValue('H1', 'Neto a pagar en efectivo');
            $spreadsheet->getActiveSheet()->setCellValue('I1', 'Total Semanal');

            //Set automatic width to columns
            for($k = 65; $k < 74; $k++){
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($k))->setAutoSize(true);
            }
        }

        //Reset row
        $row = 2;

        //Fill Sueldos spreadsheet with the information
        foreach ($empleados as $empleado)
        {
            //Create a new, specific Empleado object with only the required information
            $excel_empleado = $this->create_excel_empleado_sueldos($empleado);

            $letter = 65;      //Letter A in ASCII - Letter I is 73 in ASCII
            $i = 0;            //First array value of excel_empleado

            //Fill the entire row with excel_empleado information
            for($letter; $letter < 74; $letter++)
            {
                $spreadsheet->getActiveSheet()->setCellValue(chr($letter).$row, $excel_empleado[$i]);
                $i++;
            };

            //Finished with filling entire row so advance to next empleado
            $row++;
        }

        //
        // Expedientes sheet
        //

        //Add Expedientes sheet to spreadsheet and set it as the active sheet
        $expedientes_sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Expedientes');
        $spreadsheet->addSheet($expedientes_sheet, 3);
        $spreadsheet->setActiveSheetIndex(3);

        //Set table headers of Expedientes sheet
        if ($spreadsheet){
            $spreadsheet->getActiveSheet()->setCellValue('A1', 'Nombre');
            $spreadsheet->getActiveSheet()->setCellValue('B1', 'Apellido Paterno');
            $spreadsheet->getActiveSheet()->setCellValue('C1', 'Apellido Materno');
            $spreadsheet->getActiveSheet()->setCellValue('D1', 'Puesto');
            $spreadsheet->getActiveSheet()->setCellValue('E1', 'Grupos IMSS');
            $spreadsheet->getActiveSheet()->setCellValue('F1', 'Dias');
            $spreadsheet->getActiveSheet()->setCellValue('G1', 'Solicitud');
            $spreadsheet->getActiveSheet()->setCellValue('H1', 'Acta');
            $spreadsheet->getActiveSheet()->setCellValue('I1', 'INE');
            $spreadsheet->getActiveSheet()->setCellValue('J1', 'CURP');
            $spreadsheet->getActiveSheet()->setCellValue('K1', 'RFC');
            $spreadsheet->getActiveSheet()->setCellValue('L1', 'Domicilio');
            $spreadsheet->getActiveSheet()->setCellValue('M1', 'Estudios');
            $spreadsheet->getActiveSheet()->setCellValue('N1', 'Recomendacion');
            $spreadsheet->getActiveSheet()->setCellValue('O1', 'Antidoping');
            $spreadsheet->getActiveSheet()->setCellValue('P1', 'Antecedentes');

            //Set automatic width to columns
            for($k = 65; $k < 81; $k++){
                $spreadsheet->getActiveSheet()->getColumnDimension(chr($k))->setAutoSize(true);
            }
        }

        //Reset row
        $row = 2;

        //Fill Expedientes spreadsheet with the information
        foreach ($empleados as $empleado)
        {
            //Create a new, specific Empleado object with only the required information
            $excel_empleado = $this->create_excel_empleado_expedientes($empleado);

            $letter = 65;      //Letter A in ASCII - Letter P is 80 in ASCII
            $i = 0;            //First array value of excel_empleado

            //Fill the entire row with excel_empleado information
            for($letter; $letter < 81; $letter++)
            {
                $spreadsheet->getActiveSheet()->setCellValue(chr($letter).$row, $excel_empleado[$i]);
                $i++;
            };

            //Finished with filling entire row so advance to next empleado
            $row++;
        }

        //Create writer object that will write in the Excel file
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->setOffice2003Compatibility(true);

        //Download the Excel file
        $writer->save("nominas.xlsx");

        redirect('nominas.xlsx');

    }


    public function create_excel_empleado_percepciones($empleado)
    {
        $excel_empleado = [
            $empleado->nombre,
            $empleado->apellido_paterno,
            $empleado->apellido_materno,
            $empleado->puesto,
            $empleado->nomina_grupo,
            $empleado->nomina_dias,
            $empleado->salario_integrado,
            $empleado->salario_diario,
            $empleado->importe,
            $empleado->premio_asistencia,
            $empleado->premio_puntualidad,
            $empleado->subsidio,
            $empleado->subtotal
        ];

        return $excel_empleado;
    }


    public function create_excel_empleado_deducibles($empleado)
    {

        $total_deduccion = ($empleado->fondo_ahorro + $empleado->infonavit + $empleado->imss + $empleado->pension_alimenticia + $empleado->ispt);

        $excel_empleado = [
            $empleado->nombre,
            $empleado->apellido_paterno,
            $empleado->apellido_materno,
            $empleado->puesto,
            $empleado->nomina_grupo,
            $empleado->nomina_dias,
            $empleado->fondo_ahorro,
            $empleado->infonavit,
            $empleado->imss,
            $empleado->pension_alimenticia,
            $empleado->ispt,
            $total_deduccion,
            $empleado->neto
        ];

        return $excel_empleado;
    }


    public function create_excel_empleado_sueldos($empleado)
    {
        //This total deduccion is different to the one in empleado_deducible method
        $total_deduccion = ($empleado->fondo_ahorro + $empleado->infonavit + $empleado->pension_alimenticia);

        $total_percepcion = ($empleado->sueldo - ($empleado->fondo_ahorro + $empleado->infonavit + $empleado->pension_alimenticia));
        $neto_pagar = ($empleado->sueldo - ($empleado->fondo_ahorro + $empleado->infonavit + $empleado->pension_alimenticia + $empleado->neto));
        $total_semanal = ($empleado->fondo_ahorro + $empleado->infonavit + $empleado->pension_alimenticia + $empleado->neto);

        $excel_empleado = [
            $empleado->nombre,
            $empleado->apellido_paterno,
            $empleado->apellido_materno,
            $empleado->puesto,
            $empleado->sueldo,
            $total_deduccion,
            $total_percepcion,
            $neto_pagar,
            $total_semanal
        ];

        return $excel_empleado;
    }


    public function create_excel_empleado_expedientes($empleado)
    {

        $excel_empleado = [
            $empleado->nombre,
            $empleado->apellido_paterno,
            $empleado->apellido_materno,
            $empleado->nomina_grupo,
            $empleado->nomina_dias,
            $empleado->solicitud,
            $empleado->acta,
            $empleado->ine,
            $empleado->curp_expediente,
            $empleado->rfc_expediente,
            $empleado->domicilio,
            $empleado->estudios,
            $empleado->recomendacion,
            $empleado->antidoping,
            $empleado->antecedentes
        ];

        return $excel_empleado;
    }
}