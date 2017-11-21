<?php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 1/12/17
 * Time: 7:02 PM
 */
class Costos_model extends  CI_Model{

    public function insertar($costo)
    {
        if ($this->db->insert('costos', $costo))
            return true;
        else
            return false;
    }

    public function leer()
    {
        $this->db->select('*');
        $this->db->from('costos');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('costo_id ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function traer_detalles($costo_id){
        $this->db->select('*');
        $this->db->from('costos');
        $this->db->where('costo_id', $costo_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function traer_clientes()
    {
        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('razon_social ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function traer_empleados()
    {
        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('apellido_paterno ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function traer_giros()
    {
        $this->db->select('*');
        $this->db->from('turns');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('turn_id ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function traer_localidades()
    {
        $this->db->select('*');
        $this->db->from('localidades');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('localidad ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function actualizarCosto($id, $costo)
    {
        $this->db->where('costo_id', $id);
        if ($this->db->update('costos', $costo))
            return true;
        else
            return false;
    }

    public function eliminarCosto($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('costo_id', $id);
        if ($this->db->update('costos'))
            return true;
        else
            return false;
    }


    public function get_giro_clave($id)
    {
        $this->db->select('clave_giro');
        $this->db->from('turns');
        $this->db->where('turn_id =', $id);
        $query = $this->db->get();

        $clave = $query->row()->clave_giro;
        return $clave;
    }

    public function get_giro_nombre($id)
    {
        $this->db->select('name');
        $this->db->from('turns');
        $this->db->where('turn_id =', $id);
        $query = $this->db->get();

        $nombre = $query->row()->name;
        return $nombre;
    }

    public function get_localidad_municipio($nombre)
    {
        $this->db->select('municipio');
        $this->db->from('localidades');
        $this->db->where('localidad =', $nombre);
        $query = $this->db->get();

        $municipio = $query->row()->municipio;
        return $municipio;
    }

    public function get_localidad_estado($nombre)
    {
        $this->db->select('estado');
        $this->db->from('localidades');
        $this->db->where('localidad =', $nombre);
        $query = $this->db->get();

        $estado = $query->row()->estado;
        return $estado;
    }

    public function get_cliente_rfc($nombre)
    {
        $this->db->select('rfc');
        $this->db->from('clientes');
        $this->db->where('razon_social =', $nombre);
        $query = $this->db->get();

        $rfc = $query->row()->rfc;
        return $rfc;
    }

    public function get_empleado_no($empleado_nombre, $empleado_apellido_paterno, $empleado_apellido_materno)
    {
        $this->db->select('empleado_id');
        $this->db->from('empleados');
        $this->db->where('nombre =', $empleado_nombre);
        $this->db->where('apellido_paterno=', $empleado_apellido_paterno);
        $this->db->where('apellido_materno=', $empleado_apellido_materno);
        $query = $this->db->get();

        $empleado_id = $query->row()->empleado_id;
        return $empleado_id;
    }


    public function live_search_localidades($nombre)
    {
        $this->db->select('*');
        $this->db->like('localidad', $nombre);
        $this->db->from('localidades');
        $this->db->where('deleted_at IS NULL');
        $query = $this->db->get();

        return $query->result();
    }

    public function live_search_clientes($nombre)
    {
        $this->db->select('*');
        $this->db->like('razon_social', $nombre);
        $this->db->from('clientes');
        $this->db->where('deleted_at IS NULL');
        $query = $this->db->get();

        return $query->result();
    }

    public function live_search_empleados($nombre)
    {
        $string = $nombre;
        $pos = strpos($string, " ");
        $queryPartial = '';
        if($pos !== false){
            $e = explode(" ",$string);
            $queryPartial = "(nombre LIKE \"%$e[0]%\" and apellido_paterno LIKE \"%$e[1]%\") AND deleted_at IS NULL";
            if(isset($e[3])) {
                $queryPartial = "(nombre LIKE \"%".$e[0].' '.$e[1]."%\" and apellido_paterno LIKE \"%".$e[2].'%" and apellido_materno LIKE "%'.$e[3]."%\") AND deleted_at IS NULL";
            } else if(isset($e[2])) {
                $queryPartial = "(nombre LIKE \"%".$e[0].' '.$e[1]."%\" and apellido_paterno LIKE \"%$e[2]%\") OR (nombre LIKE \"%$e[0]%\" and apellido_paterno LIKE \"%".$e[1].'%" and apellido_materno LIKE "%'.$e[2]."%\") AND deleted_at IS NULL";
            }
        } else {
            $queryPartial = "(apellido_paterno LIKE '%$nombre%' OR nombre LIKE '%$nombre%'  OR apellido_materno LIKE '%$nombre%') AND deleted_at IS NULL";
        }

        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->where($queryPartial);
        $query = $this->db->get();

        return $query->result();
    }

    public function lastId()
    {
        $maxid = $this->db->query('SELECT MAX(costo_id) AS maxid FROM costos')->row()->maxid;
        return $maxid;
    }

}
