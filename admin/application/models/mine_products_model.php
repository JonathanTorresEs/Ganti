<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 3:15 PM
 */
class Mine_products_model extends CI_Model
{

    public function insertar($mine_products)
    {
        if ($this->db->insert('mine_products', $mine_products))
            return true;
        else
            return false;
    }

    public function  leer()
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->order_by('required_date DESC');
        $query = $this->db->get('mine_products');
        return $query->result();
    }

    public function consultaMineProduct($product_id,$id_localicacion){

        $this->db->where('product_id',$product_id);
        $this->db->where('mine_id',$id_localicacion);
        $this->db->where('product_id',$product_id);

        $this->db->where('deleted_at IS NULL');
        $query = $this->db->get('mine_products');
        return $query->row();
    }

    public function actualizarMineProduct($id, $Localicacion_prodcuto)
    {
        $this->db->where('id_mine_product', $id);
        if ($this->db->update('mine_products', $Localicacion_prodcuto))
            return true;
        else
            return false;
    }

    public function  eliminarCompra($id)
    {
        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        $this->db->where('id_mine_products', $id);

        if ($this->db->update('mine_products'))
            return true;
        else
            return false;
    }


}