<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 3:15 PM
 */
class Compras_model extends CI_Model
{

    public function insertar($compra)
    {
        if ($this->db->insert('purchases', $compra))
            return true;
        else
            return false;
    }

    public function  leer()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('required_date DESC');
        $query = $this->db->get('purchases');
        return $query->result();
    }

    public function consultaCompra($id)
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->where('purchase_id', $id);
        $query = $this->db->get('purchases');
        return $query->row();
    }

    public function actualizarCompra($id, $compra)
    {
        $this->db->where('purchase_id', $id);
        if ($this->db->update('purchases', $compra))
            return true;
        else
            return false;
    }

    public function  eliminarCompra($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('purchase_id', $id);

        if ($this->db->update('purchases'))
            return true;
        else
            return false;
    }


    public function total_todos(){
        $sql = "SELECT * FROM purchases WHERE deleted_at IS NULL";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;

    }

    public function total_registros()
    {
        $sql = "SELECT * FROM purchases WHERE purchase_status != 'Recibido' AND deleted_at IS NULL ORDER BY purchase_id DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function total_recibidos()
    {
        $sql = "SELECT * FROM purchases WHERE purchase_status = 'Recibido' AND deleted_at IS NULL ORDER BY purchase_id DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function total_autorizados()
    {
        $sql = "SELECT * FROM purchases WHERE autorized = 1 AND deleted_at IS NULL ORDER BY purchase_id DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function total_enviados()
    {
        $sql = "SELECT * FROM purchases WHERE purchase_status = 'Enviado' AND deleted_at IS NULL ORDER BY purchase_id DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_compras($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('purchase_status !=', 'Recibido');
        $this->db->order_by('purchase_id DESC');
        $query = $this->db->get('purchases');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function traer_compras_recibidas($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('purchase_status', 'Recibido');
        $this->db->order_by('purchase_id DESC');
        $query = $this->db->get('purchases');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function traer_compras_enviados($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('purchase_status', 'Enviado');
        $this->db->order_by('purchase_id DESC');
        $query = $this->db->get('purchases');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function traer_compras_autorizados($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('autorized', 1);
        $this->db->order_by('purchase_id DESC');
        $query = $this->db->get('purchases');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function total_facturas($term)
    {
        $sql = "SELECT * FROM purchases WHERE invoice_number LIKE '%$term%' AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_facturas($limit, $start, $term)
    {
        if ($limit == "Todos"){
            $sql = "SELECT * FROM purchases WHERE invoice_number LIKE '%$term%' AND deleted_at IS NULL ORDER BY purchase_id DESC";
        }
        else{
            $sql = "SELECT * FROM purchases WHERE invoice_number LIKE '%$term%' AND deleted_at IS NULL ORDER BY purchase_id DESC LIMIT $start, $limit";
        }

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;


    }

    public function total_tarjetas($term)
    {
        $sql = "
          SELECT c.purchase_id, c.product_id, c.description, c.quantity, c.cost, c.invoice_number,
          c.payment_method, c.provider_id, c.purchase_status, c.user_id, c.card_id,
          c.machine_id, c.mine_id, c.required_date, c.request_date, c.sent_date, c.received_date
          FROM purchases as c INNER JOIN cards as t ON c.card_id = t.card_id
          WHERE t.description LIKE '%$term%' AND c.deleted_at IS NULL AND t.deleted_at IS NULL
        ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_tarjetas($limit, $start, $term)
    {
        $sql = "
          SELECT c.purchase_id, c.product_id, c.description, c.quantity, c.cost, c.invoice_number,
          c.payment_method, c.provider_id, c.purchase_status, c.user_id, c.card_id,
          c.machine_id, c.mine_id, c.required_date, c.request_date, c.sent_date, c.received_date
          FROM purchases as c INNER JOIN cards as t ON c.card_id = t.card_id
          WHERE t.description LIKE '%$term%' AND c.deleted_at IS NULL AND t.deleted_at IS NULL
          ORDER BY purchase_id DESC LIMIT $start, $limit
          ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function total_fechaRequerido($term)
    {
        $sql = "
          SELECT * FROM purchases WHERE required_date LIKE '%$term%' AND deleted_at IS NULL
        ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_fechaRequerido($limit, $start, $term)
    {
        $sql = "
          SELECT * FROM purchases WHERE required_date LIKE '%$term%' AND deleted_at IS NULL
          ORDER BY purchase_id DESC LIMIT $start, $limit
          ";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function total_producto($term)
    {
        $sql = "SELECT * FROM purchases inner JOIN products on purchases.product_id = products.id WHERE (products.code LIKE '%$term%' OR products.description LIKE '%$term%') AND purchases.deleted_at IS NULL AND products.deleted_at IS NULL ORDER BY purchases.id DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_producto($limit, $start, $term)
    {
        $sql = "SELECT * FROM purchases inner JOIN products on purchases.product_id = products.id WHERE (products.code LIKE '%$term%' OR products.description LIKE '%$term%') AND purchases.deleted_at IS NULL AND products.deleted_at IS NULL ORDER BY purchases.id DESC
                LIMIT $start, $limit";

        $query = $this->db->query($sql);


        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }

    public function total_mina($term)
    {
        $sql = "SELECT mine_id FROM mines WHERE name LIKE '%$term%' AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function total_maquina($term)
    {
        $sql = "SELECT machine_id FROM machines WHERE machine_id LIKE '%$term%' AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }


    public function traer_mina($limit, $start, $term)
    {
        $sql = "SELECT mine_id FROM mines WHERE name LIKE '%$term%' AND deleted_at IS NULL";

        $query = $this->db->query($sql);

        $obj = $query->row();
        if (!empty($obj)) {
            $sql = "
          SELECT * FROM purchases WHERE mine_id = '$obj->mine_id'
          ORDER BY mine_id DESC LIMIT $start, $limit AND deleted_at IS NULL
          ";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                return $data;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function traer_maquina($limit, $start, $term)
    {
        $sql = "SELECT machine_id FROM machines WHERE machine_id LIKE '%$term%' AND deleted_at IS NULL";

        $query = $this->db->query($sql);

        $obj = $query->row();
        if (!empty($obj)) {
            $sql = "
          SELECT * FROM purchases WHERE machine_id = '$obj->machine_id' AND deleted_at IS NULL
          ORDER BY purchase_id DESC LIMIT $start, $limit
          ";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                return $data;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }


    public function total_entregado($term)
    {
        $sql = "
          SELECT * FROM purchases WHERE received_date LIKE '%$term%' AND deleted_at IS NULL
        ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_entregado($limit, $start, $term)
    {
        $sql = "
          SELECT * FROM purchases WHERE received_date LIKE '%$term%' AND deleted_at IS NULL
          ORDER BY purchase_id DESC LIMIT $start, $limit
          ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function total_usuario($term)
    {
        $sql = "SELECT purchases.purchase_id from purchases join users on purchases.user_id = users.user_id where users.username like '%$term%' AND users.deleted_at IS NULL AND purchases.deleted_at IS NULL ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_usuario($limit, $start, $term)
    {
        $term = "'%".$term."%'";
        $sql = "SELECT user_id FROM users WHERE username LIKE ".$term." AND deleted_at IS NULL ";   //this

        $query = $this->db->query($sql);

        $obj = $query->row();
        if (!empty($obj)) {
            $sql = "
          SELECT * FROM purchases WHERE user_id = '$obj->user_id' AND deleted_at IS NULL
          ORDER BY purchase_id DESC LIMIT $start, $limit
          ";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }
                return $data;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function total_id($term)
    {
        $sql = "
          SELECT * FROM purchases WHERE purchase_id LIKE '%$term%' AND deleted_at IS NULL
        ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_id($limit, $start, $term)
    {
        $sql = "
          SELECT * FROM purchases WHERE purchase_id LIKE '%$term%' AND deleted_at IS NULL
          ORDER BY purchase_id DESC LIMIT $start, $limit
          ";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return false;
        }
    }
}