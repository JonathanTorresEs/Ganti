<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */


    class Test extends CI_Controller {

    public function index() {
        echo "Hello World!";
    }
}


/**
class Test extends CI_Controller {



	public function __construct() {
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url','form'));
        $this->load->model('productos_model');
        $this->load->database('default');
	}

	public function index()
	{
		phpinfo();
	}

}
 */
