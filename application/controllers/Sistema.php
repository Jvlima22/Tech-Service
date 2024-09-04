<?php
/* 
Tech Service - TGL Solutions
------------------------------
By: Josué Lima  
E-mail: targetlogsolutions@gmail.com
Todos os direitos reservados
Versão do PHP 7.2.30
*/
defined('BASEPATH') or exit('Ação não permitida');

class Sistema extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('info', 'Sua sessão expirou! Por favor realize seu login novamente');
            redirect('login');
        }

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', 'Você não tem permissão para acessar o menu Sistema');
            redirect('/');
        }
    }

    public function index()
    {
        $data = array(
            'titulo' => 'Editar informações do sistema',
            'scripts' => array(
                'vendor/mask/jquery.mask.min.js',
                'vendor/mask/app.js',
            ),
            'sistema' => $this->core_model->get_by_id('sistema', array('sistema_id' => 1)),
        );


        $this->form_validation->set_rules('sistema_razao_social', 'Razão social', 'required|max_length[145]');
        $this->form_validation->set_rules('sistema_nome_fantasia', 'Nome fantasia', 'required|min_length[10]|max_length[145]');
        $this->form_validation->set_rules('sistema_cnpj', '', 'required|exact_length[18]');
        $this->form_validation->set_rules('sistema_ie', '', 'required|max_length[25]');
        $this->form_validation->set_rules('sistema_telefone_fixo', '', 'required|max_length[25]');
        $this->form_validation->set_rules('sistema_telefone_movel', '', 'required|max_length[25]');
        $this->form_validation->set_rules('sistema_email', '', 'required|valid_email|max_length[100]');
        $this->form_validation->set_rules('sistema_site_url', 'URL do site', 'required|valid_url|max_length[100]');
        $this->form_validation->set_rules('sistema_cep', 'CEP', 'required|exact_length[9]');
        $this->form_validation->set_rules('sistema_endereco', 'Endereço', 'required|max_length[145]');
        $this->form_validation->set_rules('sistema_numero', 'Número', 'max_length[25]');
        $this->form_validation->set_rules('sistema_cidade', 'Cidade', 'required|max_length[45]');
        $this->form_validation->set_rules('sistema_estado', 'UF', 'required|exact_length[2]');
        $this->form_validation->set_rules('sistema_txt_ordem_servico', 'Texto da ordem de serviço e venda', 'max_length[500]');

        if ($this->form_validation->run()) {

            $data = elements(
                array(
                    'sistema_razao_social',
                    'sistema_nome_fantasia',
                    'sistema_cnpj',
                    'sistema_ie',
                    'sistema_telefone_fixo',
                    'sistema_telefone_movel',
                    'sistema_site_url',
                    'sistema_email',
                    'sistema_endereco',
                    'sistema_cep',
                    'sistema_numero',
                    'sistema_cidade',
                    'sistema_estado',
                    'sistema_txt_ordem_servico',
                    'sistema_logo'
                ),
                $this->input->post()
            );

            $data = html_escape($data);

            $this->core_model->update('sistema', $data, array('sistema_id' => 1));            
           
            if ($_FILES['sistema_logo']['name']) {
                $dir = './public/img/uploads/';

                /*
                $old_logo_path = './public/img/uploads/' . $data['sistema_logo'];
                echo '<pre>';
                var_dump($data);
                echo '</pre>';
                exit();
                */

                // Configurações para o upload da imagem
                $config['upload_path'] = $dir;
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['max_size'] = 2048;
                $config['file_name'] = 'logo_' . $data['sistema_razao_social'];

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('sistema_logo')) {

                    $old_logo_path = './public/img/uploads/' . $data['sistema_logo'];
                    unlink($old_logo_path);                  
                    

                    if (file_exists($dir)) {
                        echo ''; // Diretório existe
                    } else {
                        mkdir('./public/img/uploads/', 0777, TRUE); // Cria o diretório se não existir
                    }                                               

                    $upload_data = $this->upload->data();
                    $data['sistema_logo'] = $upload_data['file_name'];
                    
                  
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('sistema');
                }
            }


            $this->core_model->update('sistema', $data, array('sistema_id' => 1));

            redirect('sistema');
        } else {

            //Erro de validação

            $this->load->view('layout/header', $data);
            $this->load->view('sistema/index');
            $this->load->view('layout/footer');
        }
    }
}
