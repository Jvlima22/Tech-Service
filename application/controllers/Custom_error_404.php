<?php
/* 
Tech Service - TGL Solutions
------------------------------
By: Josué Lima  
E-mail: targetlogsolutions@gmail.com
Todos os direitos reservados
Versão do PHP 7.2.30
*/
defined('BASEPATH') OR exit('Ação não permitida');

class Custom_error_404 extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $data = array(
            'titulo' => 'Página não encontrada',
        );

        $this->load->view('custom_error_404', $data);
    }

}
