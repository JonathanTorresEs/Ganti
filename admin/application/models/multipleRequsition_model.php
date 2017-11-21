<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 6/15/2017
 * Time: 12:33 PM
 */
class multipleRequsition_model extends CI_Model
{

    public function insertar($multiple_requsicion)
    {
        if ($this->db->insert('multiple_requesition', $multiple_requsicion))
            return $this->db->insert_id();//regresa el ultimo id insertado;
        else
            return false;
    }

    public function  leer()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('required_date DESC');
        $query = $this->db->get('multiple_requesition');
        return $query->result();
    }

    public function get_giro_clave($giro_id)
    {
        $this->db->select('clave_giro');
        $this->db->from('turns');
        $this->db->where('deleted_at IS NULL');
        $this->db->where('turn_id =', $giro_id);
        $query = $this->db->get();

        $clave = $query->row()->clave_giro;

        return $clave;
    }

    public function get_mina_clave($mina_id)
    {
        $this->db->select('clave_mina');
        $this->db->from('mines');
        $this->db->where('deleted_at IS NULL');
        $this->db->where('mine_id =', $mina_id);
        $query = $this->db->get();

        $clave = $query->row()->clave_mina;

        return $clave;
    }



    public function consultaRequesition($id)
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->where('id_multipleRequesition', $id);
        $query = $this->db->get('multiple_requesition');
        return $query->row();

            }


    public function total_registros_requerdio()
    {
        $sql = "SELECT * FROM multiple_Requesition WHERE requesition_status = 'Autorizada' AND deleted_at IS NULL ORDER BY 	id_multipleRequesition DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_requisiciones_requeridas($limit, $start, $status)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('requesition_status =', $status );
        $this->db->order_by('id_multipleRequesition DESC');
        $query = $this->db->get('multiple_Requesition');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }


    public function actualizarRequesition($id, $requsicion)
    {
        $this->db->where('id_multipleRequesition', $id);
        if ($this->db->update('multiple_Requesition', $requsicion))
            return true;
        else
            return false;
    }
    public function  eliminarRequesition($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('id_multipleRequesition', $id);
        if ($this->db->update('multiple_Requesition'))
            return true;
        else
            return false;
    }
    public function orden_comrpa($id){
/*        $this->db->set('requesition_status', "orden_compra");*/
        $this->db->where('id_multipleRequesition', $id);
        if ($this->db->update('multiple_Requesition'))
            return true;
        else
            return false;
    }





}