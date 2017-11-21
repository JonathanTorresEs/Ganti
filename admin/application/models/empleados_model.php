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

    public function lastId()
    {
        $maxid = $this->db->query('SELECT MAX(empleado_id) AS maxid FROM empleados')->row()->maxid;
        return $maxid;
    }

    public function traer_detalles($empleado_id){
        $this->db->select('*');
        $this->db->from('empleados');
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

}