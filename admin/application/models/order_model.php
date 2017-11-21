<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 6/9/2017
 * Time: 2:18 PM
 */
class order_model extends CI_Model
{

    public function insertar($order)
    {
        if ($this->db->insert('orders', $order))
            return true;
        else
            return false;
    }

    public  function  leer(){
        $this->db->select('id_order, order_status, payment_method, orders.user_id, provider_id, Gerencia, date, orders.created_at AS order_created_at, orders.deleted_at, users.username');
        $this->db->from('orders');
        $this->db->where('orders.deleted_at IS NULL');
        $this->db->where('order_status !=', 'recibido');
        $this->db->join('users','users.user_id = orders.user_id', 'left');
        $this->db->order_by('id_order DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function consultaOrder($id)
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->where('id_order', $id);
        $query = $this->db->get('orders');
        return $query->row();
    }

    public function actualizarOrder($id, $order)
    {
        $this->db->where('id_order', $id);
        if ($this->db->update('orders', $order))
            return true;
        else
            return false;
    }

    public function  eliminarOrder($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('id_order', $id);
        if ($this->db->update('orders'))
            return true;
        else
            return false;
    }


    public function traer_ordenes_status($status)
    {
        $this->db->select('id_order, order_status, payment_method, orders.user_id, provider_id, Gerencia, date, orders.created_at AS order_created_at, orders.deleted_at, users.username');
        $this->db->from('orders');
        $this->db->where('orders.deleted_at IS NULL');
        $this->db->where('order_status =', $status );
        $this->db->join('users','users.user_id = orders.user_id', 'left');
        $this->db->order_by('id_order DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function get_provider_email($provider_id)
    {
        $this->db->select('providers.correo');
        $this->db->from('providers');
        $this->db->where('provider_id =', $provider_id);
        $query = $this->db->get();

        $email = $query->row()->correo;

        return $email;
    }

    public function get_order_products($order_id)
    {
        $this->db->select('products.description, requisitions.quantity, requisitions.cost');
        $this->db->from('requisitions');
        $this->db->where('requisitions.deleted_at IS NULL');
        $this->db->where('requisitions.order_id =', $order_id);
        $this->db->join('products','products.product_id = requisitions.product_id', 'left');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else
            return "ERROR: No se encontraron productos en la orden.";
    }

    public function lastId()
    {
        $maxid = $this->db->query('SELECT MAX(id_order) AS `maxid` FROM `orders`')->row()->maxid;
          return $maxid;
    }

    public function total_registros_requerdio()
    {
        $sql = "SELECT * FROM orders";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_ordenes($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('id_order ASC');
        $query = $this->db->get('orders');

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
        $sql = "SELECT * FROM orders WHERE invoice_number LIKE '%$term%' AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_facturas($limit, $start, $term)
    {
        if ($limit == "Todos"){
            $sql = "SELECT * FROM orders WHERE invoice_number LIKE '%$term%' AND deleted_at IS NULL ORDER BY id_order DESC";
        }
        else{
            $sql = "SELECT * FROM orders WHERE invoice_number LIKE '%$term%' AND deleted_at IS NULL ORDER BY id_order DESC LIMIT $start, $limit";
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
          SELECT c.id_order, c.product_id, c.description, c.quantity, c.cost, c.invoice_number,
          c.payment_method, c.provider_id, c.order_status, c.user_id, c.card_id,
          c.machine_id, c.mine_id, c.required_date, c.request_date, c.sent_date, c.received_date
          FROM orders as c INNER JOIN cards as t ON c.card_id = t.card_id
          WHERE t.description LIKE '%$term%' AND c.deleted_at IS NULL AND t.deleted_at IS NULL
        ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_tarjetas($limit, $start, $term)
    {
        $sql = "
          SELECT c.id_order, c.product_id, c.description, c.quantity, c.cost, c.invoice_number,
          c.payment_method, c.provider_id, c.order_status, c.user_id, c.card_id,
          c.machine_id, c.mine_id, c.required_date, c.request_date, c.sent_date, c.received_date
          FROM orders as c INNER JOIN cards as t ON c.card_id = t.card_id
          WHERE t.description LIKE '%$term%' AND c.deleted_at IS NULL AND t.deleted_at IS NULL
          ORDER BY id_order DESC LIMIT $start, $limit
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
          SELECT * FROM orders WHERE required_date LIKE '%$term%' AND deleted_at IS NULL
        ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_fechaRequerido($limit, $start, $term)
    {
        $sql = "
          SELECT * FROM orders WHERE required_date LIKE '%$term%' AND deleted_at IS NULL
          ORDER BY id_order DESC LIMIT $start, $limit
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
        $sql = "SELECT * FROM orders inner JOIN products on orders.product_id = products.id WHERE (products.code LIKE '%$term%' OR products.description LIKE '%$term%') AND orders.deleted_at IS NULL AND products.deleted_at IS NULL ORDER BY orders.id DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_producto($limit, $start, $term)
    {
        $sql = "SELECT * FROM orders inner JOIN products on orders.product_id = products.id WHERE (products.code LIKE '%$term%' OR products.description LIKE '%$term%') AND orders.deleted_at IS NULL AND products.deleted_at IS NULL ORDER BY orders.id DESC
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
          SELECT * FROM orders WHERE mine_id = '$obj->mine_id'
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
          SELECT * FROM orders WHERE machine_id = '$obj->machine_id' AND deleted_at IS NULL
          ORDER BY id_order DESC LIMIT $start, $limit
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
          SELECT * FROM orders WHERE received_date LIKE '%$term%' AND deleted_at IS NULL
        ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_entregado($limit, $start, $term)
    {
        $sql = "
          SELECT * FROM orders WHERE received_date LIKE '%$term%' AND deleted_at IS NULL
          ORDER BY id_order DESC LIMIT $start, $limit
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
        $sql = "SELECT orders.id_order from orders join users on orders.user_id = users.user_id where users.username like '%$term%' AND users.deleted_at IS NULL AND orders.deleted_at IS NULL ";
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
          SELECT * FROM orders WHERE user_id = '$obj->user_id' AND deleted_at IS NULL
          ORDER BY id_order DESC LIMIT $start, $limit
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
          SELECT * FROM orders WHERE id_order LIKE '%$term%' AND deleted_at IS NULL
        ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_id($limit, $start, $term)
    {
        $sql = "
          SELECT * FROM orders WHERE id_order LIKE '%$term%' AND deleted_at IS NULL
          ORDER BY id_order DESC LIMIT $start, $limit
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