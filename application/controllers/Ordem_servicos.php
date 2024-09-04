<?php
/* 
Tech Service - TGL Solutions
------------------------------
By: Josué Lima  
E-mail: targetlogsolutions@gmail.com
Todos os direitos reservados
Versão do PHP 7.2.30
*/

use Dompdf\dompdf;
use Dompdf\Options;

defined('BASEPATH') OR exit('Ação não permitida');

class Ordem_servicos extends CI_Controller {

    protected $estilos = '<style type="text/css">
            @page {

                margin: 1.5cm;

            }
            body {

                font-family: sans-serif;

                margin: 0.5cm 0;

                text-align: justify;

                font-size: 11px;
            }
            h2 {
                text-align: center;
            }
            #header,
            #footer {
                position: fixed;
                left: 0;
                right: 0;
                color: grey;
                font-size: 0.9em;
            }

            #header {
                top: 0;
                border-bottom: 0.1pt solid #aaa;
                margin-bottom: 50%;

            }
            #footer {
                text-align: center;
                bottom: 16px;
                border-top: 0.1pt solid #aaa;

            }
            #header table,

            #footer table {

                width: 100%;

                border-collapse: collapse;

                border: none;

            }
            #header td,
            #footer td {
                padding: 0;
                width: 50%;
            }
            .text-muted {
                color: grey;
            }
            .page-number {
                text-align: center;
            }
            .page-number:before {

                content: "Página " counter(page);

            }
            hr {

                page-break-after: always;

                border: 0;

            }
            .bg-cinza {
                padding: 5px;
                background-color: #ddd;
            }
            .borda-cinza{
                border: solid 1px #ccc;
                border-radius: 5px;
                padding: 8px;                    
            }
            #tabela-produtos{
                border: solid 1px #ccc;
                border-radius: 5px;                    
            }
            .tabela-cabecalho{
                background-color: #ccc;
            }
        </style>';

    public function __construct() {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('info', 'Sua sessão expirou! Por favor realize seu login novamente');
            redirect('login');
        }

        $this->load->model('ordem_servicos_model');
    }

    public function index() {

        $data = array(
            'titulo' => 'Ordem de serviços cadastradas',
            'styles' => array(
                'vendor/datatables/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'vendor/datatables/jquery.dataTables.min.js',
                'vendor/datatables/dataTables.bootstrap4.min.js',
                'vendor/datatables/app.js'
            ),
            'ordens_servicos' => $this->ordem_servicos_model->get_all(),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('ordem_servicos/index');
        $this->load->view('layout/footer');
    }

    public function add() {

        $this->form_validation->set_rules('ordem_servico_cliente_id', '', 'required');
        $this->form_validation->set_rules('ordem_servico_equipamento', 'Marca', 'trim|required|min_length[2]|max_length[80]');
        $this->form_validation->set_rules('ordem_servico_marca_equipamento', 'Marca', 'trim|required|min_length[2]|max_length[80]');
        $this->form_validation->set_rules('ordem_servico_modelo_equipamento', 'Modelo', 'trim|required|min_length[2]|max_length[80]');
        $this->form_validation->set_rules('ordem_servico_acessorios', 'Acessórios', 'trim|required|max_length[300]');
        $this->form_validation->set_rules('ordem_servico_defeito', 'Defeito', 'trim|required|max_length[700]');

        if ($this->form_validation->run()) {


            $ordem_servico_valor_total = str_replace('R$', "", trim($this->input->post('ordem_servico_valor_total')));

            $data = elements(
                    array(
                'ordem_servico_cliente_id',
                'ordem_servico_status',
                'ordem_servico_equipamento',
                'ordem_servico_marca_equipamento',
                'ordem_servico_modelo_equipamento',
                'ordem_servico_defeito',
                'ordem_servico_acessorios',
                'ordem_servico_obs',
                'ordem_servico_valor_desconto',
                'ordem_servico_valor_total',
                'ordem_servico_termos',
                    ), 
                    $this->input->post()
            );

            $data['ordem_servico_valor_total'] = trim(preg_replace('/\$/', '', $ordem_servico_valor_total));

            $data = html_escape($data);

            $this->core_model->insert('ordens_servicos', $data, TRUE);

            //RECUPERAR ID

            $id_ordem_servico = $this->session->userdata('last_id');

            $servico_id = $this->input->post('servico_id');
            $servico_quantidade = $this->input->post('servico_quantidade');
            $servico_desconto = str_replace('%', '', $this->input->post('servico_desconto'));

            $servico_preco = str_replace('R$', '', $this->input->post('servico_preco'));
            $servico_item_total = str_replace('R$', '', $this->input->post('servico_item_total'));

            $servico_preco = str_replace(',', '', $servico_preco);
            $servico_item_total = str_replace(',', '', $servico_item_total);


            $qty_servico = count($servico_id);

            $ordem_servico_id = $this->input->post('ordem_servico_id');

            for ($i = 0; $i < $qty_servico; $i++) {

                $data = array(
                    'ordem_ts_id_ordem_servico' => $id_ordem_servico,
                    'ordem_ts_id_servico' => $servico_id[$i],
                    'ordem_ts_quantidade' => $servico_quantidade[$i],
                    'ordem_ts_valor_unitario' => $servico_preco[$i],
                    'ordem_ts_valor_desconto' => $servico_desconto[$i],
                    'ordem_ts_valor_total' => $servico_item_total[$i],
                );

                $data = html_escape($data);

                $this->core_model->insert('ordem_tem_servicos', $data);
            }


            //Criar recurso PDF

            redirect('os/imprimir/' . $id_ordem_servico);
        } else {

            //Erro de validação

            $data = array(
                'titulo' => 'Cadastrar ordem de serviço',
                'styles' => array(
                    'vendor/select2/select2.min.css',
                    'vendor/autocomplete/jquery-ui.css',
                    'vendor/autocomplete/estilo.css',
                ),
                'scripts' => array(
                    'vendor/autocomplete/jquery-migrate.js', //Vem primeiro
                    'vendor/calcx/jquery-calx-sample-2.2.8.min.js',
                    'vendor/calcx/os.js',
                    'vendor/select2/select2.min.js',
                    'vendor/select2/app.js',
                    'vendor/sweetalert2/sweetalert2.js',
                    'vendor/autocomplete/jquery-ui.js', //Vem por último
                ),
                'termos' => $this->core_model->get_all('termos'),
                'clientes' => $this->core_model->get_all('clientes', array('cliente_ativo' => 1)),
            );


            $this->load->view('layout/header', $data);
            $this->load->view('ordem_servicos/add');
            $this->load->view('layout/footer');
        }
    }

    public function edit($ordem_servico_id = NULL) {

        if (!$ordem_servico_id || !$this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id))) {
            $this->session->set_flashdata('error', 'Ordem de serviço não encontrada');
            redirect('os');
        } else {

        
            $this->form_validation->set_rules('ordem_servico_cliente_id', '', 'required');

            $ordem_servico_status = $this->input->post('ordem_servico_status');

            if ($ordem_servico_status == 1) {
                $this->form_validation->set_rules('ordem_servico_forma_pagamento_id', '', 'required');
            }

            $this->form_validation->set_rules('ordem_servico_equipamento', 'Marca', 'trim|required|min_length[2]|max_length[80]');
            $this->form_validation->set_rules('ordem_servico_marca_equipamento', 'Marca', 'trim|required|min_length[2]|max_length[80]');
            $this->form_validation->set_rules('ordem_servico_modelo_equipamento', 'Modelo', 'trim|required|min_length[2]|max_length[80]');
            $this->form_validation->set_rules('ordem_servico_acessorios', 'Acessórios', 'trim|required|max_length[300]');
            $this->form_validation->set_rules('ordem_servico_defeito', 'Defeito', 'trim|required|max_length[700]');

                
            if ($this->form_validation->run()) {
                
                $ordem_servico_valor_total = str_replace('R$', "", trim($this->input->post('ordem_servico_valor_total')));

                $data = elements(
                        array(
                    'ordem_servico_cliente_id',
                    'ordem_servico_forma_pagamento_id',
                    'ordem_servico_status',
                    'ordem_servico_equipamento',
                    'ordem_servico_marca_equipamento',
                    'ordem_servico_modelo_equipamento',
                    'ordem_servico_defeito',
                    'ordem_servico_acessorios',
                    'ordem_servico_obs',
                    'ordem_servico_valor_desconto',
                    'ordem_servico_valor_total',
                    'ordem_servico_termos',
                        ), $this->input->post()
                );

                // if ($ordem_servico_status == 0) {
                //     unset($data['ordem_servico_forma_pagamento_id']);
                // }

                $data['ordem_servico_valor_total'] = trim(preg_replace('/\$/', '', $ordem_servico_valor_total));

                $data = html_escape($data);

                $this->core_model->update('ordens_servicos', $data, array('ordem_servico_id' => $ordem_servico_id));

                //Deletando de ordem_tem_servico, os serviços antigos da ordem editada 
                $this->ordem_servicos_model->delete_old_services($ordem_servico_id);

                $servico_id = $this->input->post('servico_id');
                $servico_quantidade = $this->input->post('servico_quantidade');
                $servico_desconto = str_replace('%', '', $this->input->post('servico_desconto'));

                $servico_preco = str_replace('R$', '', $this->input->post('servico_preco'));
                $servico_item_total = str_replace('R$', '', $this->input->post('servico_item_total'));

                $servico_preco = str_replace(',', '', $servico_preco);
                $servico_item_total = str_replace(',', '', $servico_item_total);


                $qty_servico = count($servico_id);

                $ordem_servico_id = $this->input->post('ordem_servico_id');

                for ($i = 0; $i < $qty_servico; $i++) {

                    $data = array(
                        'ordem_ts_id_ordem_servico' => $ordem_servico_id,
                        'ordem_ts_id_servico' => $servico_id[$i],
                        'ordem_ts_quantidade' => $servico_quantidade[$i],
                        'ordem_ts_valor_unitario' => $servico_preco[$i],
                        'ordem_ts_valor_desconto' => $servico_desconto[$i],
                        'ordem_ts_valor_total' => $servico_item_total[$i],
                    );

                    $data = html_escape($data);

                    $this->core_model->insert('ordem_tem_servicos', $data);
                }


                //Criar recurso PDF

                redirect('os/imprimir/' . $ordem_servico_id);

                
                // echo '<pre>';
                // var_dump($_POST);
                // echo '</pre>';
            } else {

                //Erro de validação

                $data = array(
                    'titulo' => 'Atualizar ordem de serviço',
                    'styles' => array(
                        'vendor/select2/select2.min.css',
                        'vendor/autocomplete/jquery-ui.css',
                        'vendor/autocomplete/estilo.css',
                    ),
                    'scripts' => array(
                        'vendor/autocomplete/jquery-migrate.js', //Vem primeiro
                        'vendor/calcx/jquery-calx-sample-2.2.8.min.js',
                        'vendor/calcx/os.js',
                        'vendor/select2/select2.min.js',
                        'vendor/select2/app.js',
                        'vendor/sweetalert2/sweetalert2.js',
                        'vendor/autocomplete/jquery-ui.js', //Vem por último
                    ),
                    'termos' => $this->core_model->get_all('termos'),
                    'clientes' => $this->core_model->get_all('clientes', array('cliente_ativo' => 1)),
                    'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos', array('forma_pagamento_ativa' => 1)),
                    'os_tem_servicos' => $this->ordem_servicos_model->get_all_servicos_by_ordem($ordem_servico_id),
                );

                $ordem_servico = $data['ordem_servico'] = $this->ordem_servicos_model->get_by_id($ordem_servico_id);

//                echo '<pre>';
//                print_r($ordem_servico);
//                exit();

                $this->load->view('layout/header', $data);
                $this->load->view('ordem_servicos/edit');
                $this->load->view('layout/footer');
            }
        }
    }

    public function del($ordem_servico_id = NULL) {
        if (!$ordem_servico_id || !$this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id))) {
            $this->session->set_flashdata('error', 'Ordem de serviço não encontrada');
            redirect('os');
        }

        if ($this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id, 'ordem_servico_status' => 0))) {
            $this->session->set_flashdata('error', 'Não é possível excluir uma ordem de serviço Em aberto');
            redirect('os');
        }

        $this->core_model->delete('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id));
        redirect('os');
    }

    public function imprimir($ordem_servico_id = NULL) {

        if (!$ordem_servico_id || !$this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id))) {
            $this->session->set_flashdata('error', 'Ordem de serviço não encontrada');
            redirect('os');
        } else {

            $data = array(
                'titulo' => 'Escolha uma opção',
                'ordem_servico' => $this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id)),
            );

            $this->load->view('layout/header', $data);
            $this->load->view('ordem_servicos/imprimir');
            $this->load->view('layout/footer');
        }
    }

    /*
    public function pdf($ordem_servico_id = NULL) {

        if (!$ordem_servico_id || !$this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id))) {
            $this->session->set_flashdata('error', 'Ordem de serviço não encontrada');
            redirect('os');
        } else {
            $empresa = $this->core_model->get_by_id('sistema', array('sistema_id' => 1));
            $ordem_servico = $this->ordem_servicos_model->get_by_id($ordem_servico_id);
            $file_name = 'O.S&nbsp;' . $ordem_servico->ordem_servico_id;

            //Início do HTML
            $html = '<html>';


            $html .= '<head>';


            $html .= '<title>' . $empresa->sistema_nome_fantasia . ' | Impressão de ordem de serviço</title>';


            $html .= '</head>';

            $html .= '<body style="font-size: 14px">';

            $html .= '<h4 align="center">
                ' . $empresa->sistema_razao_social . '<br/>
                ' . 'CNPJ: ' . $empresa->sistema_cnpj . '<br/>
                ' . $empresa->sistema_endereco . ', &nbsp;' . $empresa->sistema_numero . '<br/>
                ' . 'CEP: ' . $empresa->sistema_cep . ', &nbsp;' . $empresa->sistema_cidade . ', &nbsp;' . $empresa->sistema_estado . '<br/>
                    ' . 'Telefone: ' . $empresa->sistema_telefone_fixo . '<br/>
                    ' . 'E-mail: ' . $empresa->sistema_email . '<br/>
                    </h4>';

            $html .= '<hr>';

            //Dados do cliente

            $html .= '<p align="right" style="font-size: 12px">O.S Nº&nbsp;' . $ordem_servico->ordem_servico_id . '</p>';

            $html .= '<p>'
                    . '<strong>Cliente: </strong>' . $ordem_servico->cliente_nome_completo . '<br/>'
                    . '<strong>CPF: </strong>' . $ordem_servico->cliente_cpf_cnpj . '<br/>'
                    . '<strong>Celular: </strong>' . $ordem_servico->cliente_celular . '<br/>'
                    . '<strong>Data de emissão: </strong>' . formata_data_banco_com_hora($ordem_servico->ordem_servico_data_emissao) . '<br/>'
                    . '<strong>Forma de pagamento: </strong>' . ($ordem_servico->ordem_servico_status == 1 ? $ordem_servico->forma_pagamento : 'Em aberto') . '<br/>'
                    . '</p>';


            $html .= '<hr>';

            //Dados da ordem


            $html .= '<table width="100%" border: solid #ddd 1px>';

            $html .= '<tr>';

            $html .= '<th>Serviço</th>';
            $html .= '<th>Quantidade</th>';
            $html .= '<th>Valor unitário</th>';
            $html .= '<th>Desconto</th>';
            $html .= '<th>Valor total</th>';

            $html .= '</tr>';




            $ordem_servico_id = $ordem_servico->ordem_servico_id;

            $servicos_ordem = $this->ordem_servicos_model->get_all_servicos($ordem_servico_id);

//            echo '<pre>';
//            print_r($servicos_ordem);
//            exit();

            $valor_final_os = $this->ordem_servicos_model->get_valor_final_os($ordem_servico_id);

//            echo '<pre>';
//            print_r($valor_final_os);
//            exit();

            foreach ($servicos_ordem as $servico):

                $html .= '<tr>';
                $html .= '<td>' . $servico->servico_nome . '</td>';
                $html .= '<td>' . $servico->ordem_ts_quantidade . '</td>';
                $html .= '<td>' . 'R$&nbsp;' . $servico->ordem_ts_valor_unitario . '</td>';
                $html .= '<td>' . '%&nbsp;' . $servico->ordem_ts_valor_desconto . '</td>';
                $html .= '<td>' . 'R$&nbsp;' . $servico->ordem_ts_valor_total . '</td>';
                $html .= '</tr>';

            endforeach;

            $html .= '<th colspan="3">';

            $html .= '<td style="border-top: solid #ddd 1px"><strong>Valor final</strong></td>';
            $html .= '<td style="border-top: solid #ddd 1px">' . 'R$&nbsp;' . $valor_final_os->os_valor_total . '</td>';

            $html .= '</th>';



            $html .= '</table>';



            $html .= '</body>';

            $html .= '</html>';

//            echo '<pre>';
//            print_r($html);
//            exit();
//            
            // False -> Abre PDF no navegador
            // True -> Faz o download



            $this->pdf->createPDF($html, $file_name, false);
        }
    }
    */


    public function pdf($ordem_servico_id = NULL)
    {
        if (!$ordem_servico_id || !$this->core_model->get_by_id('ordens_servicos', array('ordem_servico_id' => $ordem_servico_id))) {
            $this->session->set_flashdata('error', 'Ordem de serviço não encontrada');
            redirect('os');
        } else {
            $empresa = $this->core_model->get_by_id('sistema', array('sistema_id' => 1));
            $ordem_servico = $this->ordem_servicos_model->get_by_id($ordem_servico_id);

            $filename = 'OS'.$ordem_servico->ordem_servico_id. '_' . time();

            $imageUrl = base_url('public/img/uploads/' . $empresa->sistema_logo);

            $html = '
                <!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                <html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
                <head>            
                    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
                    <title>'.$ordem_servico->cliente_nome_completo.'</title>';

            $html .= $this->estilos;


            $html .= '</head>';

            $html .= '
                <body>
                <div id="header" style="position: relative; margin-bottom: 2px;">
                    <table>        
                        <tr>        
                            <td style="width: 100px;" rowspan="4"><img style="display: flex;" src="' . $imageUrl . '" width="80%" height="70" alt="" srcset=""></td>
            
                            <td style="text-align: left;">' . $empresa->sistema_razao_social . '</td>        
                        </tr>        
                        <tr>        
                            <td style="text-align: left;"><span class="text-muted">CNPJ:&nbsp;&nbsp;&nbsp;</span>' . $empresa->sistema_cnpj . '&nbsp;<span class="text-muted">Inscrição Estadual:&nbsp;</span>' . $empresa->sistema_ie . '</td>
                        </tr>        
                        <tr>        
                            <td style="text-align: left;">' . $empresa->sistema_endereco . ', &nbsp;' . $empresa->sistema_numero . ' | ' . $empresa->sistema_cidade . ', &nbsp;' . $empresa->sistema_estado . ' | ' . $empresa->sistema_cep . '</td>        
                        </tr>         
                        <tr>
                            <td style="text-align: left;">' . $empresa->sistema_telefone_fixo . ' ' . $empresa->sistema_email . '</td>        
                        </tr>        
                        <tr>        
                            <td></td>        
                            <td style="text-align: right;">Emitido em: ' . date("d-m-Y", strtotime($ordem_servico->ordem_servico_data_emissao)) . '</td>        
                        </tr>        
                    </table>  
                          
                </div>                
                    <div id="footer">    
                        <p class="text-muted align-center">' . $empresa->sistema_txt_ordem_servico . '</p>
                        <div class="page-number">

                        </div>  
                    </div>  
                                         
                
                    <h2>Dados da Ordem</h2>';

            $html .= '<p align="right" style="font-size: 12px">Ordem nº&nbsp;' . $ordem_servico->ordem_servico_id . '</p>';

            $html .= '<p class="borda-cinza">'
                . '<strong class="text-muted">Cliente: </strong>' . $ordem_servico->cliente_nome_completo . '<br/>'
                . '<strong class="text-muted">CPF: </strong>' . $ordem_servico->cliente_cpf_cnpj . '<br/>'
                . '<strong class="text-muted">Celular: </strong>' . $ordem_servico->cliente_celular . '<br/>'
                // . '<strong class="text-muted">Data de emissão: </strong>' . formata_data_banco_com_hora($ordem_servico->ordem_servico_data_emissao) . '<br/>'
                . '<strong class="text-muted">Forma de pagamento: </strong>' .  ($ordem_servico->ordem_servico_status == 1 ? $ordem_servico->forma_pagamento : 'Em aberto')  . '<br/>'
                . '</p>';

            $html .= '<table id="tabela-produtos" width="100%" border: solid #ddd 1px>';

            $html .= '<thead class="tabela-cabecalho">';
            $html .= '<tr>';

            $html .= '<th>Código</th>';
            $html .= '<th>Serviço</th>';
            $html .= '<th>Quantidade</th>';
            $html .= '<th>Valor unitário</th>';
            $html .= '<th>Desconto</th>';
            $html .= '<th>Valor total</th>';

            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';

            
            $servicos_ordem = $this->ordem_servicos_model->get_all_servicos($ordem_servico_id);
            $valor_final_os = $this->ordem_servicos_model->get_valor_final_os($ordem_servico_id);

            foreach ($servicos_ordem as $servico) :

                $html .= '<tr>';
                $html .= '<td>' . $servico->servico_id . '</td>';
                $html .= '<td>' . $servico->servico_nome . '</td>';
                $html .= '<td>' . $servico->ordem_ts_quantidade . '</td>';
                $html .= '<td>' . 'R$&nbsp;' . $servico->ordem_ts_valor_unitario . '</td>';
                $html .= '<td>' . '%&nbsp;' . $servico->ordem_ts_valor_desconto . '</td>';
                $html .= '<td>' . 'R$&nbsp;' . $servico->ordem_ts_valor_total . '</td>';
                $html .= '</tr>';

            endforeach;
            $html .= '</tbody>';

            $html .= '<th colspan="4">';

            $html .= '<td style="border-top: solid #ddd 1px"><strong>Valor final</strong></td>';
            $html .= '<td style="border-top: solid #ddd 1px">' . 'R$&nbsp;' . $valor_final_os->os_valor_total . '</td>';

            $html .= '</th>';

            $html .= '</table>';

            $html .= '</br><h2>' . $ordem_servico->titulo . '<h2>';
            $html .= '</br><p>' . $ordem_servico->descricao . '<p></br>';
            

            $html .= '</body>
                </html>
                ';

            
            $dompdf = new Dompdf(['enable_remote' => true]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
   
            $dompdf->render();
            $dompdf->stream($filename . ".pdf", array("Attachment" => 1));           
   

            // echo $html;

            
        }
    }

  

}
