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

class Termos extends CI_Controller
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
        
        // $this->load->model('termo_model');        
    }

    public function index()
    {
        $data = array(
            'titulo' => 'Editar Termos de Uso',
            'styles' => array(
                'vendor/datatables/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'vendor/datatables/jquery.dataTables.min.js',
                'vendor/datatables/dataTables.bootstrap4.min.js',
                'vendor/datatables/app.js'
            ),
            'termos' => $this->core_model->get_all('termos'),            
        );
      
        $this->load->view('layout/header', $data);
        $this->load->view('termos/index');
        $this->load->view('layout/footer');
    }
    
    public function add() {
        $this->form_validation->set_rules('titulo', 'Título', 'required|max_length[100]');
        $this->form_validation->set_rules('descricao', 'Descrição', 'required|min_length[10]');

        if ($this->form_validation->run()) {
            $data = elements(
                array(
                    'titulo',                    
                    'descricao'
                ),
                $this->input->post()
            );

            // Escapar os dados
            $data = html_escape($data);                        
            
            // Inserir no banco de dados
            $this->core_model->insert('termos', $data);

            // Redirecionar após inserção
            redirect('termos');
        } else {
            

            // Exibir o formulário novamente com erros de             
            $this->load->view('layout/header');
            $this->load->view('termos/add');
            $this->load->view('layout/footer');
        }
    }

    public function edit($termo_id = NULL) {

        // Verificar se o ID do termo é válido e se o termo existe
        if (!$termo_id || !$this->core_model->get_by_id('termos', array('id' => $termo_id))) {
            $this->session->set_flashdata('error', 'Termo não encontrado!');
            redirect('termos');
        } else {
            // Definir as regras de validação do formulário
            $this->form_validation->set_rules('titulo', 'Título', 'required|max_length[100]');
            $this->form_validation->set_rules('descricao', 'Descrição', 'required|min_length[10]');
    
            // Verificar se o formulário foi submetido e se a validação foi bem-sucedida
            if ($this->form_validation->run()) {
                $data = elements(
                    array(
                        'titulo',
                        'descricao'
                    ),
                    $this->input->post()
                );
    
                // Escapar os dados
                //$data = html_escape($data);
    
                // Atualizar o termo no banco de dados
                if ($this->core_model->update('termos', $data, array('id' => $termo_id))) {
                    $this->session->set_flashdata('sucesso', 'Termo atualizado com sucesso!');
                } else {
                    $this->session->set_flashdata('error', 'Falha ao atualizar o termo.');
                }
    
                // Redirecionar após a atualização
                redirect('termos');
            } else {
                // Recuperar o termo do banco de dados
                $data = array(
                    'titulo' => 'Atualizar termos',                    
                    'termo' => $this->core_model->get_by_id('termos', array('id' => $termo_id))
                );
                // Exibir o formulário novamente com erros de validação
              
                $this->load->view('layout/header', $data);
                $this->load->view('termos/edit');
                $this->load->view('layout/footer');
              
                // echo '<pre>';
                // var_dump($data['termo']);
            }
        }
    }

    public function del($termo_id = NULL) {

        if (!$termo_id || !$this->core_model->get_by_id('termos', array('id' => $termo_id))) {
            $this->session->set_flashdata('error', 'Termo não encontrado');
            redirect('termos');
        } else {
            $this->core_model->delete('termos', array('id' => $termo_id));
            redirect('termos');
        }
    }
    
}
