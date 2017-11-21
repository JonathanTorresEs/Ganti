<?php
/**
 * Created by PhpStorm.
 * User: maclen
 * Date: 2/3/17
 * Time: 3:50 PM
 */

class Giros_model extends  CI_Model{

    public function insertar($giro){
        if($this->db->insert('turns',$giro))
            return true;
        else
            return false;
    }

    public function buscar($term){
        $this->db->like('name', $term);
        $this->db->or_like('description', $term);
        $this->db->where('deleted_at IS NULL');
        $query = $this->db->get('turns');
        return $query->result();
    }

    public  function  leer(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('clave_giro ASC');
        $query = $this->db->get('turns');
        return $query->result();
    }

    public function consultaGiro($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('turn_id',$id);
        $query = $this->db->get('turns');
        return $query->row();
    }

    public function consultaNombre($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('turn_id',$id);
        $query = $this->db->get('turns');
        return $query->name;
    }

    public function actualizarGiro($id, $giro){
        $this->db->where('turn_id',$id);
        if($this->db->update('turns',$giro))
            return true;
        else
            return false;
    }

    public function  eliminarGiro($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('turn_id', $id);
        if ($this->db->update('turns'))
            return true;
        else
            return false;
    }
}