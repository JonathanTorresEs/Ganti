<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 23/06/2015
 * Time: 04:28 PM
 */
class Maquinas_model extends  CI_Model{

    public function insertar($maquina){
        if($this->db->insert('machines',$maquina))
            return true;
        else
            return false;
    }


    public function buscar($term){
        $sql = "SELECT * FROM machines WHERE (machine_id LIKE '%".$term."%'  OR description LIKE '%".$term."%' OR short_number LIKE '%".$term."%') AND deleted_at IS NULL ORDER BY machine_id DESC ";
        $query = $this->db->query($sql);
        return $query->result();
        return false;
    }

    public  function  leer(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('machine_id DESC');
        $query = $this->db->get('machines');
        return $query->result();
    }

    public function consultaNombre($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('machine_id',$id);
        $query = $this->db->get('machines');
        return $query->description;
    }

    public function consultaMaquina($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('machine_id',$id);
        $query = $this->db->get('machines');
        return $query->row();
    }

    public function actualizarMaquina($id, $maquina){
        $this->db->where('machine_id',$id);
        if($this->db->update('machines',$maquina))
            return true;
        else
            return false;
    }

    public function  eliminarMaquina($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('machine_id', $id);

        if ($this->db->update('machines'))
            return true;
        else
            return false;
    }
}