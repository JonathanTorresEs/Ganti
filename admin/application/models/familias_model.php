<?php
/**
 * Created by PhpStorm.
 * User: maclen
 * Date: 2/7/17
 * Time: 1:02 PM
 */

class Familias_model extends  CI_Model{

    public function insertar($familia){
        if($this->db->insert('families',$familia))
            return true;
        else
            return false;
    }

    public function buscar($term){
        $this->db->like('name', $term);
        $this->db->or_like('description', $term);
        $this->db->where('deleted_at IS NULL');
        $query = $this->db->get('families');
        return $query->result();
    }

    public  function  leer(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('family_id DESC');
        $query = $this->db->get('families');
        return $query->result();
    }

    public function consultaFamilia($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('family_id',$id);
        $query = $this->db->get('families');
        return $query->row();
    }

    public function consultaNombre($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('family_id',$id);
        $query = $this->db->get('families');
        return $query->name;
    }

    public function actualizarFamilia($id, $familia){
        $this->db->where('family_id',$id);
        if($this->db->update('families',$familia))
            return true;
        else
            return false;
    }

    public function  eliminarFamilia($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('family_id', $id);
        if ($this->db->update('families'))
            return true;
        else
            return false;
    }
}