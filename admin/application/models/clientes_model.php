<?php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 30-Oct-17
 * Time: 10:25 AM
 */

class Clientes_model extends CI_Model
{

    public function insertar($client)
    {
        if ($this->db->insert('clientes', $client))
            return true;
        else
            return false;
    }

    public function leer(){
        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('cliente_id ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function traer_detalles($cliente_id){
        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('cliente_id', $cliente_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function actualizarCliente($id, $cliente)
    {
        $this->db->where('cliente_id', $id);
        if ($this->db->update('clientes', $cliente))
            return true;
        else
            return false;
    }

    public function eliminarCliente($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('cliente_id', $id);
        if ($this->db->update('clientes'))
            return true;
        else
            return false;
    }

    public function lastId()
    {
        $maxid = $this->db->query('SELECT MAX(cliente_id) AS maxid FROM clientes')->row()->maxid;
        return $maxid;
    }

}