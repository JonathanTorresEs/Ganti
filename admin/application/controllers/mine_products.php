<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Saul
 * Date: 25/06/2015
 * Time: 03:02 PM
 */
class Mine_products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mine_products_model');
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->database('default');
    }


    public function index()
    {
        if($this->session->userdata('profile') == FALSE)
        {
            redirect(base_url().'login');
        }
        $data['titulo'] = 'Minas_products';
        $data['main_content']='inicio';

        $this->load->model('mine_products_model');
        $data['minasGuardadas'] = $this->mine_products_model->leer();

        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
            $data['actualizarMina'] = $this->mine_products_model->consultaMina($id);
        }

        $this->load->view('partials/header_view', $data);
        $this->load->view('minas_view',$data);
        $this->load->view('partials/footer_view');
    }




}