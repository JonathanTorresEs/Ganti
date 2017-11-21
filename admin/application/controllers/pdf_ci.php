<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf_ci extends CI_Controller 
{
 
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form'));
        $this->load->helper('url');
        $this->load->database('default');
        $this->load->library('html2pdf');
    }
 
    private function createFolder()
    {
        if(!is_dir("./files"))
        {
            mkdir("./files", 0777);
            mkdir("./files/pdfs", 0777);
        }
    }
 
 
    public function index()
    {
    
        //establecemos la carpeta en la que queremos guardar los pdfs,
        //si no existen las creamos y damos permisos
        $this->createFolder();
 
        //importante el slash del final o no funcionará correctamente
        $this->html2pdf->folder('./files/pdfs/');
        
        //establecemos el nombre del archivo
        $this->html2pdf->filename('compra.pdf');
        
        //establecemos el tipo de papel
        $this->html2pdf->paper('a4', 'portrait');
        $id=5;
        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
        }
        //datos que queremos enviar a la vista, lo mismo de siempre
        $data['title'] = 'Compras';
        $this->load->model('minas_model');
        $this->load->model('productos_model');
        $this->load->model('login_model');
        $data['usuariosGuardados'] = $this->login_model->leer();
        $this->load->model('proveedores_model');
        $data['proveedoresGuardados'] = $this->proveedores_model->leer();
        $this->load->model('tarjetas_model');
        $data['tarjetasGuardadas'] = $this->tarjetas_model->leer();
        $this->load->model('maquinas_model');
        $data['maquinasGuardadas'] = $this->maquinas_model->leer();
        //hacemos que coja la vista como datos a imprimir
        //importante utf8_decode para mostrar bien las tildes, ñ y demás
        $this->html2pdf->html(utf8_decode($this->load->view('pdf_view', $data, true)));
        
        //si el pdf se guarda correctamente lo mostramos en pantalla
        if($this->html2pdf->create('save')) 
        {
            $this->show();
        }
    } 
 
    //funcion que ejecuta la descarga del pdf
    public function downloadPdf()
    {
        //si existe el directorio
        if(is_dir("./files/pdfs"))
        {
            //ruta completa al archivo
            $route = "./files/pdfs/compra.pdf";
            //nombre del archivo
            $filename = "compra.pdf";
            //si existe el archivo empezamos la descarga del pdf
            if(file_exists("./files/pdfs/".$filename))
            {
                header("Cache-Control: public"); 
                header("Content-Description: File Transfer"); 
                header('Content-disposition: attachment; filename='.basename($route)); 
                header("Content-Type: application/pdf"); 
                header("Content-Transfer-Encoding: binary"); 
                header('Content-Length: '. filesize($route)); 
                readfile($route);
            }
        }    
    }
 
 
    //esta función muestra el pdf en el navegador siempre que existan
    //tanto la carpeta como el archivo pdf
    public function show()
    {
        if(is_dir("./files/pdfs"))
        {
            $filename = "compra.pdf";
            $route = "./files/pdfs/compra.pdf";
            if(file_exists("./files/pdfs/".$filename))
            {
                header('Content-type: application/pdf'); 
                //echo "<SCRIPT>window.location='$route';</SCRIPT>";
                readfile($route);
            }
        }
    }
    
    //función para crear y enviar el pdf por email
    //ejemplo de la libreria sin modificar
    public function mail_pdf()
    {
        
        //establecemos la carpeta en la que queremos guardar los pdfs,
        //si no existen las creamos y damos permisos
        $this->createFolder();
 
        //importante el slash del final o no funcionará correctamente
        $this->html2pdf->folder('./files/pdfs/');
        
        //establecemos el nombre del archivo
        $this->html2pdf->filename('compra.pdf');
        
        //establecemos el tipo de papel
        $this->html2pdf->paper('a4', 'portrait');
        $id=5;
        if($this->uri->segment(3)!=''){
            $id = $this->uri->segment(3);
        }
        //datos que queremos enviar a la vista, lo mismo de siempre
        $data['title'] = 'Compras';

        //hacemos que coja la vista como datos a imprimir
        //importante utf8_decode para mostrar bien las tildes, ñ y demás
        $this->html2pdf->html(utf8_decode($this->load->view('pdf_view', $data, true)));


        //Check that the PDF was created before we send it
        if($path = $this->html2pdf->create('save')) 
        {

            $this->load->library('email');
 
            $this->email->from('pdf@ganti.com.mx', 'Pdf');
            $this->email->to('rixtrevizo@gmail.com');
            
            $this->email->subject('Email PDF Test');
            $this->email->message('Testing the email a freshly created PDF');    
 
            $this->email->attach($path);
 
            $this->email->send();
            
            echo "El email ha sido enviado correctamente";
                        
        }
        
    } 
}
/* End of file pdf_ci.php */
/* Location: ./application/controllers/pdf_ci.php */