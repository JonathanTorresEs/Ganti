<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 3:15 PM
 */
class Operadores_model extends  CI_Model{


    public function fetchByIdentifier($identifier){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('identifier',$identifier);
        $query = $this->db->get('operators');
        return $query->row();
    }

    public function insertar($operador){


        if($this->db->insert('operators',$operador)  )
            return $this->db->insert_id();//regresa el ultimo id insertado;
        else
            return false;
    }

    public  function  leer(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('status DESC');
        $this->db->order_by('operator_id DESC');
        $query = $this->db->get('operators');
        return $query->result();
    }

    public  function  leerRegs(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('in_date DESC');
        $query = $this->db->get('operators_registers');
        return $query->result();
    }

    public function consultaOperador($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('operator_id',$id);
        $query = $this->db->get('operators');
        return $query->row();
    }



    public function actualizarOperador($id, $operador){

        $row = $this->consultaOperador($id);

        if($operador['department'] != $row->department or $operador['sub_department'] != $row->sub_department or $operador['status'] != $row->status ){

            if($row->status == 'Activo') {
                $this->db->where('operator_id', $id);
                $this->db->where('out_date IS NULL');
                $this->db->set('out_date', date("Y-m-d H:i:s"));
                $this->db->update('operators_registers');
            }
            if($operador['status'] == 'Activo') {
                $this->db->set('operator_id', $id);
                $this->db->set('department', $operador['department']);
                $this->db->set('sub_department', $operador['sub_department']);
                $this->db->set('in_date', date("Y-m-d H:i:s"));
                $this->db->set('updated_at', date("Y-m-d H:i:s"));
                $this->db->insert('operators_registers');
            }
        }


        $this->db->where('operator_id',$id);
        if($this->db->update('operators',$operador))
            return true;
        else
            return false;
    }

    public function  eliminarOperador($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('operator_id', $id);
        if ($this->db->update('operators')) {
                return true;
            }
         else
            return false;
    }

    public function total_registros()
    {
        $this->db->where('deleted_at IS NULL');
        return $this->db->count_all('operators');
    }

    public function traer_operadores($limit, $start)
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->limit($limit, $start);
        $this->db->order_by('operator_id DESC');
        $query = $this->db->get('operators');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function buscar($term){
        $this->db->like('name', $term);
//        $this->db->or_like('rfc', $term);
//        $this->db->or_like('curp', $term);
//        $this->db->or_like('imms_number', $term);
        $this->db->or_like('operator_id ', $term);
        $this->db->where('deleted_at IS NULL');
        $query = $this->db->get('operators');
        return $query->result();
    }
    public function buscar_operadores($term){
        $this->db->like('name', $term);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('sub_department', "Operador o Chofer");
        $query = $this->db->get('operators');
        return $query->result();
    }


}