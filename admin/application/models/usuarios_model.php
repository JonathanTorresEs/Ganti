<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 16/07/2015
 * Time: 3:15 PM
 */
class Usuarios_model extends  CI_Model{

    public function insertar($usuario){
        if($this->db->insert('users',$usuario))
            return true;
        else
            return false;
    }

    public  function  leer(){
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('username ASC');
        $query = $this->db->get('users');
        return $query->result();
    }



    public function consultaUsuario($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('user_id',$id);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function actualizarUsuario($id, $usuario){
        $this->db->where('user_id',$id);
        if($this->db->update('users',$usuario))
            return true;
        else
            return false;
    }

    public function  eliminarUsuario($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('user_id', $id);

        if ($this->db->update('users'))
            return true;
        else
            return false;
    }


}