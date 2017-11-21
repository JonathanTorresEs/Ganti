<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');/** * Created by PhpStorm. * User: Saul * Date: 25/06/2015 * Time: 3:15 PM */class Controles_model extends CI_Model{    public function insertar($control){        if ($this->db->insert('controls', $control))            return $this->db->insert_id();//regresa el ultimo id insertado;        else            return false;    }    public function actualizarComm($control)    {        $this->db->where('date', $control['date']);        $this->db->where('deleted_at IS NULL');        $this->db->where('department', $control['department']);        $query = $this->db->get('control_comments');        $query = $query->result();        if (empty($query)) {            $control['created_at'] = date("Y-m-d H:i:s");            if ($this->db->insert('control_comments', $control)) return true; else return false;        } else {            $control['updated_at'] = date("Y-m-d H:i:s");            $this->db->where('date', $control['date']);            $this->db->where('deleted_at IS NULL');            $this->db->where('department', $control['department']);            if ($this->db->update('control_comments', $control)) return true; else return false;        }    }    public function leer()    {        $this->db->where('deleted_at IS NULL');        $this->db->order_by('date DESC');        $this->db->order_by('shift ASC');        $this->db->order_by('control_id DESC');        $query = $this->db->get('controls');        return $query->result();    }    public function read_join_machine()    {        $this->db->where('controls.deleted_at IS NULL');        $this->db->join('machines', 'controls.machine_id = machines.machine_id');        $this->db->order_by('controls.date DESC');        $this->db->order_by('controls.shift ASC');        $this->db->order_by('controls.control_id DESC');        $query = $this->db->get('controls');        return $query->result();    }    public function leer7()    {        $this->db->order_by('controls_id DESC');        $query = $this->db->get('controls_oil_type');        return $query->result();    }    public function fetchByMachine($machine_id)    {        $this->db->where('deleted_at IS NULL');        $this->db->where('machine_id', $machine_id);        $this->db->order_by('date DESC');        $this->db->order_by('shift DESC');        $this->db->order_by('control_id DESC');        $query = $this->db->get('controls');        return $query->result();    }    public function leer2()    {        $this->db->where('deleted_at IS NULL');        $this->db->order_by('date DESC');        $this->db->order_by('control_daily_id DESC');        $query = $this->db->get('control_daily');        return $query->result();    }    public function leer5()    {        $this->db->order_by('control_daily_id DESC');        $query = $this->db->get('control_daily_oil_type');        return $query->result();    }    public function leer6()    {        $this->db->order_by('controls_id DESC');        $query = $this->db->get('controls_oil_type');        return $query->result();    }    public function leer4()    {        $this->db->where('deleted_at IS NULL');        $this->db->order_by('place_id DESC');        $this->db->order_by('date ASC');        $this->db->order_by('shift ASC');        $this->db->order_by('control_exp_id DESC');        $query = $this->db->get('control_exp');        return $query->result();    }    public function robArm()    {        $myQueryRes = $this->leer4();        $resProc = [];        $i = 0;        $avance = 0;        $place = '';        $lastDate = '';        foreach ($myQueryRes as $row) {            $resProc[$i]['id'] = $row->control_exp_id;            $weekDay = date('w', strtotime($row->date));        if(($place != '' AND $place != $row->place_id)){            //si NO es la primera iteracion Y el lugar cambia            $avance = 0;        } elseif (($lastDate != '' AND $place == $row->place_id)) {            $preDate = date_create($lastDate);            $thisDate = date_create($row->date);            $aux = date_diff($preDate, $thisDate);            $aux = $aux->format('%a');            $maxDays = (($weekDay + 3) % 7) + 1;            if ($aux > $maxDays) {                $avance = 0;            }        }            $avance = $row->advance - $avance;            if ($avance < 0) {                $avance = 0;            }            if (($weekDay == 4 AND $row->shift == 1)) {                $avance = $row->advance;            }            $resProc[$i]['avance'] = $avance;            $avance = $row->advance;            $place = $row->place_id;            $lastDate = $row->date;            $i += 1;        }        return $resProc;    }    public function leer3()    {        $this->db->where('deleted_at IS NULL');        $this->db->order_by('date DESC');        $this->db->order_by('control_steel_id DESC');        $query = $this->db->get('control_steel');        return $query->result();    }    public function placesFilt($id)    {        $this->db->where('deleted_at IS NULL');        $this->db->order_by('date DESC');        $this->db->order_by('shift DESC');        $this->db->where('place_id', $id);        $query = $this->db->get('control_exp');        return $query->result();    }    public function leerAcer()    {        $this->db->where('deleted_at IS NULL');        $this->db->order_by('control_steel_id DESC');        $query = $this->db->get('control_steel');        return $query->result();    }    public function comms()    {        $this->db->where('deleted_at IS NULL');        $this->db->order_by('control_comment_id DESC');        $query = $this->db->get('control_comments');        return $query->result();    }    public function leerPlaces()    {        $this->db->where('deleted_at IS NULL');        $this->db->order_by('place_id DESC');        $query = $this->db->get('places');        return $query->result();    }    public function consultaControl($id)    {        $this->db->where('deleted_at IS NULL');        $this->db->where('control_id', $id);        $query = $this->db->get('controls');        return $query->row();    }    public function actualizarControl($id, $control)    {        $this->db->where('control_id', $id);        if ($this->db->update('controls', $control))            return true;        else return false;    }    public function eliminarControl($id)    {        $this->db->set('deleted_at', date("Y-m-d H:i:s"));        $this->db->where('control_id', $id);        if ($this->db->update('controls')) return true; else return false;    }    public function total_registros()    {        return $this->db->count_all('controls');    }    public function total_registrosProd()    {        return $this->db->count_all('control_exp');    }    public function traer_controles($limit, $start)    {        $this->db->where('deleted_at IS NULL');        $this->db->limit($limit, $start);        $this->db->order_by('date DESC');        $this->db->order_by('shift ASC');        $query = $this->db->get('controls');        if ($query->num_rows() > 0) {            foreach ($query->result() as $row) {                $data[] = $row;            }            return $data;        }        return false;    }    public function traercontrolers()    {    }     public function traerFechas($limit, $start, $table)    {        $this->db->where('deleted_at IS NULL');        $this->db->limit($limit, $start);        $this->db->order_by('date DESC');        $this->db->group_by('date');        $this->db->group_by('shift');        switch ($table) {            case 1:                $query = $this->db->get('controls');                break;            case 2:                $query = $this->db->get('controls');                break;            case 3:                $query = $this->db->get('control_steel');                break;            case 4:                $this->db->order_by('shift DESC');                $this->db->group_by('shift');                $query = $this->db->get('control_exp');                break;        } if ($query->num_rows() > 0) {            foreach ($query->result() as $row) {                $data[] = $row;            }            return $data;        }        return false;    }    public function buscarLugar($term)    {        $this->db->like('name', $term);        $this->db->where('deleted_at IS NULL');        $query = $this->db->get('places');        return $query->result();    }    public function traer_controles_daily($limit, $start)    {        $this->db->where('deleted_at IS NULL');        $this->db->limit($limit, $start);        $this->db->order_by('date DESC');        $this->db->group_by('date');        $query = $this->db->get('control_comments');        if ($query->num_rows() > 0) {            foreach ($query->result() as $row) {                $data[] = $row;            }            return $data;        }        return false;    }}