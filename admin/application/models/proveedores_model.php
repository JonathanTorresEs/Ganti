<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 25/06/2015
 * Time: 3:26 PM
 */
class Proveedores_model extends  CI_Model{

    public function insertar($proveedor){
        if($this->db->insert('providers',$proveedor))
            return true;
        else
            return false;
    }

    public  function  leer(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('provider_id DESC');
        $query = $this->db->get('providers');
        return $query->result();
    }

    public function consultaNombre($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('provider_id',$id);
        $query = $this->db->get('providers');
        return $query->name;
    }

    public function consultaProveedor($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('provider_id',$id);
        $query = $this->db->get('providers');
        return $query->row();
    }

    public function actualizarProveedor($id, $proveedor){
        $this->db->where('provider_id',$id);
        if($this->db->update('providers',$proveedor))
            return true;
        else
            return false;
    }

    public function  eliminarProveedor($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('provider_id', $id);

        if ($this->db->update('providers'))
            return true;
        else
            return false;
    }
}