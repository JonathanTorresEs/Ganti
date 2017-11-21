<?php
/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 7/31/2017
 * Time: 10:35 AM
 */

class Oper_machines_model extends  CI_Model
{

    public function insertar($oper_machine)
    {
        if ($this->db->insert('oper_machines', $oper_machine))
            return true;
        else
            return false;
    }


    public function actualizar_oper_machine($id, $oper_machines)
    {
        $this->db->where('oper_machines_id', $id);
        if ($this->db->update('oper_machines', $oper_machines))
            return true;
        else
            return false;
    }



    public function leer()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('oper_machines_id DESC');
        $query = $this->db->get('oper_machines');
        return $query->result();
    }

    public function consultar_oper_machine($id)
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->where('oper_machines_id', $id);
        $query = $this->db->get('oper_machines');
        return $query->row();
    }
    public function total_registros(){
        $sql = "SELECT * FROM oper_machines WHERE deleted_at IS NULL";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;

    }
    public function traer_oper_machines($limit, $start)
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->limit($limit, $start);
        $this->db->order_by('oper_machines_id DESC');
        $query = $this->db->get('oper_machines');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }
    public function  eliminarOperador($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('oper_machines_id', $id);
        if ($this->db->update('oper_machines')) {
            $this->db->set('deleted_at', date("Y-m-d H:i:s"));
            $this->db->where('oper_machines_id', $id);
            if ($this->db->update('oper_machines')) {
                return true;
            }
        }
        else
            return false;
    }
}