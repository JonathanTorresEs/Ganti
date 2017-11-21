<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: RubenBC
 * Date: 6/15/2017
 * Time: 12:33 PM
 */
class requesition_model extends CI_Model
{

    public function insertar($requsicion)
    {
        if ($this->db->insert('requisitions', $requsicion))
            return $this->db->insert_id();//regresa el ultimo id insertado;
        else
            return false;
    }

    public function insertar_purchase($id_requesition,$last_orderId)
    {


        $this->db->where('deleted_at IS NULL');
        $this->db->where('id_requesition', $id_requesition);
        if($this->db->update("requisitions", array('cost'=>0,'order_id'=>$last_orderId,'requesition_status' => "Orden_Compra")))
            return true;
        else
            return false;
    }

    public function  leer()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('required_date DESC');
        $query = $this->db->get('requisitions');
        return $query->result();
    }

    public function find_product($product_id){
        $this->db->select ('*');
        $this->db->from ( 'lastprice' );
        $this->db->where('product_id', $product_id);
        $query = $this->db->get ();
        return $query->result();

    }
    public function find_requesition_in_order($order_id){
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('requisitions');
        if ($query->num_rows() == 0) {
            return true;
        }
        else{
            return false;
        }

    }
    public function actualizarlastprice($product_id_t, $lastprice){
        {
            $this->db->from ( 'lastprice' );
            $this->db->where('id_lastprice', $product_id_t);
            if ($this->db->update('lastprice', $lastprice))
                return true;
            else
                return false;
        }

    }

    public function insertar_lastprice($last_order)
    {
        if ($this->db->insert('lastprice', $last_order))
            return $this->db->insert_id();//regresa el ultimo id insertado;
        else
            return false;
    }
    public function find_lastprice($product_id){
        $this->db->from ('lastprice');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        return $query->result();

    }
    public function purchase_order($last_orderId)
    {
        $this->db->select  ('*');
        $this->db->from ( 'requisitions' );
        $this->db->where('order_id', $last_orderId);
        /*        $this->db->where('deleted_at IS NULL');*/
        $this->db->join('multiple_requesition', 'requisitions.multipleRequesition_id = multiple_requesition.id_multipleRequesition');
        $query = $this->db->get ();
        return $query->result();
    }

    public function consultaRequesition($id)
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->where('id_requesition', $id);
        $query = $this->db->get('requisitions');
        return $query->row();
    }

    public function actualizarRequesition($id, $requsicion)
    {
        $this->db->where('id_requesition', $id);
        if ($this->db->update('requisitions', $requsicion))
            return true;
        else
            return false;
    }

    public function traer_requsiciones_order($id)
    {
        $this->db->select(['*'] );
        $this->db->join('multiple_Requesition', 'requisitions.multipleRequesition_id = multiple_requesition.id_multipleRequesition');
        $this->db->where('requisitions.deleted_at IS NULL');
        $this->db->where('requisitions.order_id IS NULL');
        $this->db->where('requisitions.multipleRequesition_id', $id);
        $this->db->order_by('id_requesition DESC');
        $query = $this->db->get('requisitions');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }
    public function traer_requsiciones_order_null($id)
    {
        $this->db->select(['requisitions.id_requesition','requisitions.machine_id','requisitions.product_id','requisitions.order_id','requisitions.multipleRequesition_id','requisitions.quantity','products.description as P_Descipcion'] );
        $this->db->join('products', 'products.product_id = requisitions.product_id');
        $this->db->where('requisitions.deleted_at IS NULL');
        $this->db->where('requisitions.multipleRequesition_id', $id);
        $this->db->order_by('id_requesition DESC');
        $query = $this->db->get('requisitions');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }
    public function traer_todas_requsiciones_order()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->where('order_id IS NOT NULL');
        $this->db->order_by('id_requesition DESC');
        $query = $this->db->get('requisitions');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }


    public function  eliminarRequesition($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('multipleRequesition_id', $id);
        if ($this->db->update('requisitions'))
            return true;
        else
            return false;
    }
    public function  delete_single_reuqesitions($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));
        $this->db->where('id_requesition', $id);
        if ($this->db->update('requisitions'))
            return true;
        else
            return false;
    }

    public function  remove_requesition_order($id)
    {
        $this->db->set('order_id', NULL);
        $this->db->where('id_requesition', $id);
        if ($this->db->update('requisitions'))
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

    public function total_registros_requerdio()
    {
        $sql = "SELECT * FROM requisitions WHERE requesition_status = 'Requerido' AND deleted_at IS NULL ORDER BY id_requesition DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function total_recibidos()
    {
        $sql = "SELECT * FROM requisitions WHERE requesition_status = 'Recibido' AND deleted_at IS NULL ORDER BY id_requesition DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function total_autorizados()
    {
        $sql = "SELECT * FROM purchases WHERE autorized = 1 AND deleted_at IS NULL ORDER BY id_requesition DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function total_enviados()
    {
        $sql = "SELECT * FROM purchases WHERE requesition_status = 'Enviado' AND deleted_at IS NULL ORDER BY id_requesition DESC";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_requisiciones_requeridas($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('requesition_status =', 'Requerido');
        $this->db->order_by('id_requesition DESC');
        $query = $this->db->get('requisitions');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }
    public function traer_requisiciones_autorizadas($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('requesition_status =', 'Autorizada');
        $this->db->order_by('id_requesition DESC');
        $query = $this->db->get('requisitions');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function traer_requisiciones_no_autorizadas($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('requesition_status =', 'No_Autorizada');
        $this->db->order_by('id_requesition DESC');
        $query = $this->db->get('requisitions');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function traer_requesition_recibidas($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('requesition_status', 'Recibido');
        $this->db->order_by('id_requesition DESC');
        $query = $this->db->get('purchases');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function traer_requesition_enviados($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('requesition_status', 'Enviado');
        $this->db->order_by('id_requesition DESC');
        $query = $this->db->get('purchases');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function traer_requesition_autorizados($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('autorized', 1);
        $this->db->order_by('id_requesition DESC');
        $query = $this->db->get('purchases');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }
    public function traer_requesition_no_autorizados($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->where('deleted_at IS NULL');
        $this->db->where('no_autorized', 1);
        $this->db->order_by('id_requesition DESC');
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
            $sql = "SELECT * FROM purchases WHERE invoice_number LIKE '%$term%' AND deleted_at IS NULL ORDER BY id_requesition DESC";
        }
        else{
            $sql = "SELECT * FROM purchases WHERE invoice_number LIKE '%$term%' AND deleted_at IS NULL ORDER BY id_requesition DESC LIMIT $start, $limit";
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
          SELECT c.id_requesition, c.product_id, c.description, c.quantity, c.cost, c.invoice_number,
          c.payment_method, c.provider_id, c.requesition_status, c.user_id, c.card_id,
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
          SELECT c.id_requesition, c.product_id, c.description, c.quantity, c.cost, c.invoice_number,
          c.payment_method, c.provider_id, c.requesition_status, c.user_id, c.card_id,
          c.machine_id, c.mine_id, c.required_date, c.request_date, c.sent_date, c.received_date
          FROM purchases as c INNER JOIN cards as t ON c.card_id = t.card_id
          WHERE t.description LIKE '%$term%' AND c.deleted_at IS NULL AND t.deleted_at IS NULL
          ORDER BY id_requesition DESC LIMIT $start, $limit
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
          ORDER BY id_requesition DESC LIMIT $start, $limit
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
          ORDER BY id_requesition DESC LIMIT $start, $limit
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
          ORDER BY id_requesition DESC LIMIT $start, $limit
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
        $sql = "SELECT purchases.id_requesition from purchases join users on purchases.user_id = users.user_id where users.username like '%$term%' AND users.deleted_at IS NULL AND purchases.deleted_at IS NULL ";
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
          ORDER BY id_requesition DESC LIMIT $start, $limit
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
          SELECT * FROM purchases WHERE id_requesition LIKE '%$term%' AND deleted_at IS NULL
        ";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        return $num;
    }

    public function traer_id($limit, $start, $term)
    {
        $sql = "
          SELECT * FROM purchases WHERE id_requesition LIKE '%$term%' AND deleted_at IS NULL
          ORDER BY id_requesition DESC LIMIT $start, $limit
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