<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 02:19 PM
 */
class Tarjetas_model extends  CI_Model{

    public function insertar($tarjeta){
        if($this->db->insert('cards',$tarjeta))
            return true;
        else
            return false;
    }

    public  function  leer(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('card_id DESC');
        $query = $this->db->get('cards');
        return $query->result();
    }

    public function consultaNombre($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('card_id',$id);
        $query = $this->db->get('cards');
        return $query->description;
    }

    public function consultaTarjeta($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('card_id',$id);
        $query = $this->db->get('cards');
        return $query->row();
    }

    public function actualizarTarjeta($id, $tarjeta){
        $this->db->where('card_id',$id);
        if($this->db->update('cards',$tarjeta))
            return true;
        else
            return false;
    }

    public function  eliminarTarjeta($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('card_id', $id);

        if ($this->db->update('cards'))
            return true;
        else
            return false;
    }
}