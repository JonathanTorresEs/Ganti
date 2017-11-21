<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 02:36 PM
 */
class Minas_model extends  CI_Model{

    public function insertar($mina){
        if($this->db->insert('mines',$mina))
            return true;
        else
            return false;
    }

    public function buscar($term){

        $this->db->where('deleted_at IS NULL');
        $this->db->like('name', $term);
        $query = $this->db->get('mines');
        return $query->result();
    }

    public  function  leer(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('clave_mina ASC');
        $query = $this->db->get('mines');
        return $query->result();
    }

    public function consultaMina($id){
        $this->db->where('deleted_at IS NULL');


        $this->db->where('mine_id',$id);
        $query = $this->db->get('mines');
        return $query->row();
    }

    public function consultaNombre($id){
        $this->db->where('deleted_at IS NULL');

        $this->db->where('mine_id',$id);
        $query = $this->db->get('mines');
        return $query->name;
    }

    public function actualizarMina($id, $mina){
        $this->db->where('mine_id',$id);
        if($this->db->update('mines',$mina))
            return true;
        else
            return false;
    }

    public function  eliminarMina($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('mine_id', $id);

        if ($this->db->update('mines'))
            return true;
        else
            return false;
    }
}