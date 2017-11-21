<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 20/09/2015
 * Time: 04:28 PM
 */
class Bitacoras_model extends  CI_Model{

    public function insertar($bitacora){
        if($this->db->insert('logs',$bitacora))
            return true;
        else
            return false;
    }

    public  function  leer(){
        $this->db->order_by('log_id DESC');
        $query = $this->db->get('logs');
        return $query->result();
    }

    public function numRows($mes,$año){
        $sql = "SELECT * FROM logs WHERE deleted_at IS NULL
 AND date BETWEEN '".$año."/".$mes."/00 00:00:00' and '".$año."/".$mes."/".(date("d",(mktime(0,0,0,$mes+1,1,$año)-1)))." 23:59:59'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function numRowsUsr($mes,$año,$id){
        $sql = "SELECT * FROM logs WHERE user_id = ".$id." AND deleted_at IS NULL
 and date BETWEEN '".$año."/".$mes."/00 00:00:00' and '".$año."/".$mes."/".(date("d",(mktime(0,0,0,$mes+1,1,$año)-1)))." 23:59:59'";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_bitacoras($limit, $start,$year,$mes)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where("date BETWEEN '".$year."/".$mes."/00 00:00:00' and '".$year."/".$mes."/".(date("d",(mktime(0,0,0,$mes+1,1,$year)-1)))." 23:59:59'");
        $this->db->order_by('date DESC');
        $query = $this->db->get('logs');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function traer_bitacoras_usr($limit, $start,$year,$mes,$id)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where("date BETWEEN '".$year."/".$mes."/00 00:00:00' and '".$year."/".$mes."/".(date("d",(mktime(0,0,0,$mes+1,1,$year)-1)))." 23:59:59'");
        $this->db->where("user_id = ".$id);
        $this->db->order_by('date DESC');
        $query = $this->db->get('logs');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function consultaNombre($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('log_id',$id);
        $query = $this->db->get('logs');
        return $query->description;
    }

    public function consultaBitacora($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('log_id',$id);
        $query = $this->db->get('logs');
        return $query->row();
    }

    public function actualizarBitacora($id, $bitacora){
        $this->db->where('log_id',$id);
        if($this->db->update('logs',$bitacora))
            return true;
        else
            return false;
    }

    public function  eliminarBitacora($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('log_id', $id);

        if ($this->db->update('logs'))
            return true;
        else
            return false;
    }
}