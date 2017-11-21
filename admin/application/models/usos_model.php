<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 3:15 PM
 */
class Usos_model extends  CI_Model{

    public function insertar($uso){
        if($this->db->insert('uses',$uso))
            return true;
        else
            return false;
    }

    public  function  leer(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('use_id DESC');
        $query = $this->db->get('uses');
        return $query->result();
    }

    public function consultaUso($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('use_id',$id);
        $query = $this->db->get('uses');
        return $query->row();
    }

    public function actualizarUso($id, $uso){
        $this->db->where('use_id',$id);
        if($this->db->update('uses',$uso))
            return true;
        else
            return false;
    }

    public function  eliminarUso($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('use_id', $id);

        if ($this->db->update('uses'))
            return true;
        else
            return false;
    }

    public function total_registros()
    {
        return $this->db->count_all('uses');
    }

    public function traer_usos($limit, $start)
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->limit($limit, $start);
        $this->db->order_by('date DESC');
        $query = $this->db->get('uses');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }
}