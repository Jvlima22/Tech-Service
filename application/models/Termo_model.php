<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Termo_model extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();        
        $this->load->model('termo_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function insert($data)
    {
        return $this->db->insert('termos', $data);
    }
}
