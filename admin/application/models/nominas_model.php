<?php
/**
 * Created by PhpStorm.
 * User: JonathanTorres
 * Date: 24-Nov-17
 * Time: 11:43 AM
 */

    class Nominas_model extends CI_Model
    {
        public function leer_empleados()
        {
            $this->db->select('*');
            $this->db->from('empleados_nomina');
            $this->db->join('empleados_expediente','empleados_expediente.empleado_id = empleados_nomina.empleado_id', 'left');
            $this->db->join('empleados','empleados.empleado_id = empleados_nomina.empleado_id', 'left');
            $this->db->join('nominas','nominas.grupo = empleados_nomina.nomina_grupo AND nominas.dias = empleados_nomina.nomina_dias', 'left');
            $query = $this->db->get();
            return $query->result();
        }

        public function leer_nominas()
        {
            $this->db->select('*');
            $this->db->from('nominas');
            $this->db->order_by('nomina_id ASC');
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
                $queryPartial = "(apellido_paterno LIKE '%$nombre%' OR nombre LIKE '%$nombre%'  OR apellido_materno LIKE '%$nombre%') AND empleados.deleted_at IS NULL AND empleados_nomina.empleado_id IS NOT NULL";
            }

            $this->db->select('*');
            $this->db->from('empleados');
            $this->db->where($queryPartial);
            $this->db->join('empleados_nomina','empleados_nomina.empleado_id = empleados.empleado_id', 'left');
            $this->db->join('empleados_expediente','empleados_expediente.empleado_id = empleados.empleado_id', 'left');
            $this->db->join('nominas','nominas.grupo = empleados_nomina.nomina_grupo AND nominas.dias = empleados_nomina.nomina_dias', 'left');
            $query = $this->db->get();
            return $query->result();
        }


    }