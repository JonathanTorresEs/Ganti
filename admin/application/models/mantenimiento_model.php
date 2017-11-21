<?php
/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 7/14/2017
 * Time: 1:19 PM
 */
class mantenimiento_model extends CI_Model
{

    public function leer()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('date DESC');
        $this->db->order_by('shift ASC');
        $this->db->order_by('control_id DESC');
        $query = $this->db->get('controls');
        return $query->result();
    }

    public function insertar($control, $control2)
    {
        $this->db->insert('controls', $control);
        $query = $this->db->query("SELECT * FROM controls ORDER BY control_id DESC;");
        $num = 0;
        foreach ($query->result() as $user) {
            if ($num <= $user->control_id) {
                $num = $user->control_id;
            }
        }
        for ($i = 0; $i < 5; $i++) {
            $pass = array('controls_id' => $num, 'oil_type_id' => ($i + 1), 'count' => $control2['oil_' . ($i + 1) . ''],);
            $this->db->insert('controls_oil_type', $pass);
        }
        return true;
    }
    public function total_registros()
    {
        return $this->db->count_all('controls');
    }
}