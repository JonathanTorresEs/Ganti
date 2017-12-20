<?php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 02-Nov-17
 * Time: 11:13 AM
 */

class Empleados_model extends  CI_Model{

    public function leer(){
        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('apellido_paterno ASC');
        $query = $this->db->get();
        return $query->result();
    }

    //INSERT METHODS

    public function insertar($employee)
    {
        if ($this->db->insert('empleados', $employee))
            return true;
        else
            return false;
    }

    public function insertar_bancario($employee)
    {
        if ($this->db->insert('empleados_bancario', $employee))

            return true;
        else
            return false;
    }

    public function insertar_otros($employee)
    {
        if ($this->db->insert('empleados_otros', $employee))
            return true;
        else
            return false;
    }

    public function insertar_salud($employee)
    {
        if ($this->db->insert('empleados_salud', $employee))
            return true;
        else
            return false;
    }

    public function insertar_nomina($employee)
    {
        if ($this->db->insert('empleados_nomina', $employee))
            return true;
        else
            return false;
    }

    public function insertar_expediente($employee)
    {
        if ($this->db->insert('empleados_expediente', $employee))
            return true;
        else
            return false;
    }

    public function lastId()
    {
        $maxid = $this->db->query('SELECT MAX(empleado_id) AS maxid FROM empleados')->row()->maxid;
        return $maxid;
    }

    //GET METHODS

    public function traer_detalles($empleado_id){
        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->where('empleado_id', $empleado_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function traer_detalles_nomina($empleado_id){
        $this->db->select('*');
        $this->db->from('empleados_nomina');
        $this->db->where('empleado_id', $empleado_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function traer_detalles_otros($empleado_id){
        $this->db->select('*');
        $this->db->from('empleados_otros');
        $this->db->where('empleado_id', $empleado_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function traer_detalles_salud($empleado_id){
        $this->db->select('*');
        $this->db->from('empleados_salud');
        $this->db->where('empleado_id', $empleado_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function traer_detalles_bancario($empleado_id){
        $this->db->select('*');
        $this->db->from('empleados_bancario');
        $this->db->where('empleado_id', $empleado_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function traer_detalles_expediente($empleado_id){
        $this->db->select('*');
        $this->db->from('empleados_expediente');
        $this->db->where('empleado_id', $empleado_id);
        $query = $this->db->get();
        return $query->row();
    }

    //For Editing user's nomina: bring user nomina
    public function traer_nomina($grupo, $dias, $ahorro){
        $this->db->select('*');
        $this->db->from('nominas');
        $where = array('grupo' => $grupo, 'dias' => $dias, 'fondo_ahorro' => $ahorro);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }

    //Used to bring all Nomina Grupos when loading nomina_cliente_view for selectbox
    public function traer_nomina_grupos()
    {
        $this->db->select('grupo');
        $this->db->from('nominas');
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }

    //Used to bring all Nomina DIAS when loading nomina_cliente_view for select box
    public function traer_nomina_dias()
    {
        $this->db->select('dias');
        $this->db->from('nominas');
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }

    //AJAX: Used to bring corresponding nomina after user selects grupo and dias
    public function traer_nomina_ajax($grupo, $dias)
    {
        $this->db->select('*');
        $this->db->from('nominas');
        $where = array('grupo' => $grupo, 'dias' => $dias);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row();
    }

    public function traer_nomina_ahorros()
    {
        $this->db->select('fondo_ahorro');
        $this->db->from('nominas');
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();
    }

    //AJAX: Used to bring fondo_ahorro if Dias is not 7
    public function traer_nomina_ahorros_ajax($grupo, $dias)
    {
        $this->db->select('fondo_ahorro');
        $this->db->from('nominas');
        $where = array('grupo' => $grupo, 'dias' => $dias);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }


    //UPDATE METHODS
    public function actualizarEmpleado($id, $empleado)
    {
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados', $empleado))
            return true;
        else
            return false;
    }

    public function actualizarEmpleadoSalud($id, $empleado)
    {
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados_salud', $empleado))
            return true;
        else
            return false;
    }

    public function actualizarEmpleadoOtros($id, $empleado)
    {
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados_otros', $empleado))
            return true;
        else
            return false;
    }

    public function actualizarEmpleadoBancario($id, $empleado)
    {
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados_bancario', $empleado))
            return true;
        else
            return false;
    }

    public function actualizarEmpleadoNomina($id, $empleado)
    {
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados_nomina', $empleado))
            return true;
        else
            return false;
    }

    public function actualizarEmpleadoExpediente($id, $empleado)
    {
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados_expediente', $empleado))
            return true;
        else
            return false;
    }

    //DELETE METHODS
    public function eliminarEmpleado($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados'))
            return true;
        else
            return false;
    }

    public function eliminarEmpleadoSalud($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados_salud'))
            return true;
        else
            return false;
    }

    public function eliminarEmpleadoBancario($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados_bancario'))
            return true;
        else
            return false;
    }

    public function eliminarEmpleadoOtros($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados_otros'))
            return true;
        else
            return false;
    }

    public function eliminarEmpleadoExpediente($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('empleado_id', $id);
        if ($this->db->update('empleados_expediente'))
            return true;
        else
            return false;
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
            $queryPartial = "(apellido_paterno LIKE '%$nombre%' OR nombre LIKE '%$nombre%'  OR apellido_materno LIKE '%$nombre%') AND empleados.deleted_at IS NULL";
        }

        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->where($queryPartial);
        $query = $this->db->get();
        return $query->result();
    }

}