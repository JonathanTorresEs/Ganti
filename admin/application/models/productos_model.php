<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 3:15 PM
 */
class Productos_model extends  CI_Model{

    public function insertar($producto){
        if($this->db->insert('products',$producto))
            return true;
        else
            return false;
    }

    public  function  leer(){
        $this->db->select(['products.clave','products.description','products.product_id','products.familia_id','products.description','products.code','products.marca','products.equipo','families.name AS family_name'] );
        $this->db->join('families', 'products.familia_id = families.family_id');
        $this->db->order_by('products.familia_id DESC');
        $this->db->where('products.deleted_at IS NULL');
        $this->db->order_by('family_id DESC');
        $this->db->order_by('products.clave DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    public function consultaProducto($id){
        $this->db->where('product_id',$id);
        $this->db->where('deleted_at IS NULL');
        $query = $this->db->get('products');
        return $query->row();
    }

    public function consultaNombre($id){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('product_id',$id);
        $query = $this->db->get('products');
        return $query->description;
    }

    public function actualizarProducto($id, $producto){
        $this->db->where('deleted_at IS NULL');
        $this->db->where('product_id',$id);
        if($this->db->update('products',$producto))
            return true;
        else
            return false;
    }

    public function eliminarProducto($id)
    {
        $this->db->where('deleted_at IS NULL');
        $this->db->where('product_id', $id);

        $this->db->set('deleted_at', date("Y-m-d H:i:s"));

        if ($this->db->update('products'))
            return true;
        else
            return false;
    }
    public function find_id_family($id,$min,$max)
    {
        $sql = "SELECT max(clave) AS maxid from products WHERE familia_id = $id  AND clave > $min AND clave < $max AND deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->row();
    }
    public function total_registros()
    {
        $this->db->where('deleted_at IS NULL');

        return $this->db->count_all('products');
    }

    public function traer_productos($limit, $start)
    {
        $this->db->select(['products.clave','products.description','products.product_id','products.familia_id','products.description','products.code','products.marca','products.equipo','families.name AS family_name'] );
        $this->db->join('families', 'products.familia_id = families.family_id');
        $this->db->where('products.deleted_at IS NULL');
        $this->db->limit($limit, $start);
        $this->db->order_by('family_id DESC');
        $this->db->order_by('products.clave DESC');

        $query = $this->db->get('products');

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function totalBusqueda ($term){
        $sql = "SELECT count(*) as 'Cuenta' FROM products join families on products.familia_id = families.family_id WHERE (product_id LIKE '%".$term."%' OR code LIKE '%".$term."%' OR products.description LIKE '%".$term."%' OR families.name LIKE '%".$term."%') AND products.deleted_at IS NULL";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function traer_busqueda($term, $limit, $start)
    {
        $sql = "SELECT products.clave,products.description,products.product_id,products.familia_id,products.description,products.code,products.marca,products.equipo,families.name AS family_name FROM products join families on products.familia_id = families.family_id WHERE (product_id LIKE '%".$term."%' OR code LIKE '%".$term."%' OR products.description LIKE '%".$term."%' OR families.name LIKE '%".$term."%') AND products.deleted_at IS NULL ORDER BY family_id DESC, clave DESC LIMIT ".$limit." OFFSET ".$start." ";
        $query = $this->db->query($sql);



        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function lowStock(){
        $sql = "SELECT * FROM products WHERE stock < minimum AND deleted_at IS NULL ORDER BY stock ASC";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function buscar($term,$familia){
        $sql = "SELECT * FROM products WHERE (product_id LIKE '%".$term."%' OR code LIKE '%".$term."%' OR description LIKE '%".$term."%') AND familia_id = $familia  AND deleted_at IS NULL ORDER BY familia_id DESC, clave DESC ";
         $query = $this->db->query($sql);
        return $query->result();
    }

    public function verifyId($id,$family,$product_id){
        if($product_id == null){
            $sql = "SELECT * FROM products WHERE familia_id = $family and clave = $id and deleted_at IS NULL";
        } else {
            $sql = "SELECT * FROM products WHERE familia_id = $family and clave = $id and product_id != $product_id and deleted_at IS NULL";
        }
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return false;
        }else{
            return true;
        }
    }
/*OR image LIKE '%".$term."%'*/



    /*  public function restantes(){
         $endArray = [];

          $this->db->where('code', 'control_diesel');
          $query = $this->db->get('products');
          $aux = $query->row();
          $endArray['diesel'] = $aux->stock;

          $this->db->where('code', 'control_oil1');
          $query = $this->db->get('products');
          $aux = $query->row();
          $endArray['oil1'] = $aux->stock;

          $this->db->where('code', 'control_oil2');
          $query = $this->db->get('products');
          $aux = $query->row();
          $endArray['oil2'] = $aux->stock;

          $this->db->where('code', 'control_oil3');
          $query = $this->db->get('products');
          $aux = $query->row();
          $endArray['oil3'] = $aux->stock;

          $this->db->where('code', 'control_oil4');
          $query = $this->db->get('products');
          $aux = $query->row();
          $endArray['oil4'] = $aux->stock;

          $this->db->where('code', 'control_oil5');
          $query = $this->db->get('products');
          $aux = $query->row();
          $endArray['oil5'] = $aux->stock;

          $this->db->where('code', 'control_steel');
          $query = $this->db->get('products');
          $aux = $query->row();
          $endArray['steel1'] = $aux->stock;

          $this->db->where('code', 'control_steel2');
          $query = $this->db->get('products');
          $aux = $query->row();
          $endArray['steel2'] = $aux->stock;

          $this->db->where('code', 'control_steel3');
          $query = $this->db->get('products');
          $aux = $query->row();
          $endArray['steel3'] = $aux->stock;

          return $endArray;
      }*/
}