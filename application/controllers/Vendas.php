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

defined('BASEPATH') or exit('Ação não permitida');

class Vendas extends CI_Controller
{
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
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            $this->session->set_flashdata('info', 'Sua sessão expirou! Por favor realize seu login novamente');
            redirect('login');
        }

        $this->load->model('vendas_model');
        $this->load->model('produtos_model');
    }

    public function index()
    {

        $data = array(
            'titulo' => 'Vendas cadastradas',
            'styles' => array(
                'vendor/datatables/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'vendor/datatables/jquery.dataTables.min.js',
                'vendor/datatables/dataTables.bootstrap4.min.js',
                'vendor/datatables/app.js'
            ),
            'vendas' => $this->vendas_model->get_all(),
        );

        //        echo '<pre>';
        //        print_r($data['vendas']);
        //        exit();

        $this->load->view('layout/header', $data);
        $this->load->view('vendas/index');
        $this->load->view('layout/footer');
    }

    public function add()
    {
        $this->form_validation->set_rules('venda_cliente_id', '', 'required');
        $this->form_validation->set_rules('venda_tipo', '', 'required');
        $this->form_validation->set_rules('venda_forma_pagamento_id', '', 'required');
        $this->form_validation->set_rules('venda_vendedor_id', '', 'required');
        $this->form_validation->set_rules('venda_termos', '', 'required');


        if ($this->form_validation->run()) {

            $venda_valor_total = str_replace('R$', "", trim($this->input->post('venda_valor_total')));

            $data = elements(
                array(
                    'venda_cliente_id',
                    'venda_forma_pagamento_id',
                    'venda_tipo',
                    'venda_vendedor_id',
                    'venda_valor_desconto',
                    'venda_valor_total',
                    'venda_termos'
                ),
                $this->input->post()
            );

            $data['venda_valor_total'] = trim(preg_replace('/\$/', '', $venda_valor_total));

            $data = html_escape($data);

            $this->core_model->insert('vendas', $data, TRUE);

            $id_venda = $this->session->userdata('last_id');

            $produto_id = $this->input->post('produto_id');
            $produto_quantidade = $this->input->post('produto_quantidade');
            $produto_desconto = str_replace('%', '', $this->input->post('produto_desconto'));

            $produto_preco_venda = str_replace('R$', '', $this->input->post('produto_preco_venda'));
            $produto_item_total = str_replace('R$', '', $this->input->post('produto_item_total'));

            $produto_preco = str_replace(',', '', $produto_preco_venda);
            $produto_item_total = str_replace(',', '', $produto_item_total);


            $qty_produto = count($produto_id);




            for ($i = 0; $i < $qty_produto; $i++) {

                $data = array(
                    'venda_produto_id_venda' => $id_venda,
                    'venda_produto_id_produto' => $produto_id[$i],
                    'venda_produto_quantidade' => $produto_quantidade[$i],
                    'venda_produto_valor_unitario' => $produto_preco_venda[$i],
                    'venda_produto_desconto' => $produto_desconto[$i],
                    'venda_produto_valor_total' => $produto_item_total[$i],
                );

                $data = html_escape($data);

                $this->core_model->insert('venda_produtos', $data);

                /* Início atualização estoque */

                $produto_qtde_estoque = 0;

                $produto_qtde_estoque += intval($produto_quantidade[$i]);

                $produtos = array(
                    'produto_qtde_estoque' => $produto_qtde_estoque,
                );

                $this->produtos_model->update($produto_id[$i], $produto_qtde_estoque);

                /* Fim atualização estoque */
            } //Fim for
            redirect('vendas/imprimir/' . $id_venda);
        } else {

            //Erro de validação

            $data = array(
                'titulo' => 'Cadastrar venda',
                'styles' => array(
                    'vendor/select2/select2.min.css',
                    'vendor/autocomplete/jquery-ui.css',
                    'vendor/autocomplete/estilo.css',
                ),
                'scripts' => array(
                    'vendor/autocomplete/jquery-migrate.js', //Vem primeiro
                    'vendor/calcx/jquery-calx-sample-2.2.8.min.js',
                    'vendor/calcx/venda.js',
                    'vendor/select2/select2.min.js',
                    'vendor/select2/app.js',
                    'vendor/sweetalert2/sweetalert2.js',
                    'vendor/autocomplete/jquery-ui.js', //Vem por último
                ),
                'termos' => $this->core_model->get_all('termos'),
                'clientes' => $this->core_model->get_all('clientes', array('cliente_ativo' => 1)),
                'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos', array('forma_pagamento_ativa' => 1)),
                'vendedores' => $this->core_model->get_all('vendedores', array('vendedor_ativo' => 1)),
            );

            //                echo '<pre>';
            //                print_r($venda_produtos);
            //                exit();

            // echo '<pre>';
            // var_dump($data['termos']);

            $this->load->view('layout/header', $data);
            $this->load->view('vendas/add');
            $this->load->view('layout/footer');
        }
    }

    public function view($venda_id = NULL)
    {

        if (!$venda_id || !$this->core_model->get_by_id('vendas', array('venda_id' => $venda_id))) {
            $this->session->set_flashdata('error', 'Venda não encontrada');
            redirect('vendas');
        } else {

            $this->form_validation->set_rules('venda_cliente_id', '', 'required');
            $this->form_validation->set_rules('venda_tipo', '', 'required');
            $this->form_validation->set_rules('venda_forma_pagamento_id', '', 'required');
            $this->form_validation->set_rules('venda_vendedor_id', '', 'required');


            if ($this->form_validation->run()) {

                $venda_valor_total = str_replace('R$', "", trim($this->input->post('venda_valor_total')));

                $data = elements(
                    array(
                        'venda_cliente_id',
                        'venda_forma_pagamento_id',
                        'venda_tipo',
                        'venda_vendedor_id',
                        'venda_valor_desconto',
                        'venda_valor_total',
                    ),
                    $this->input->post()
                );

                $data['venda_valor_total'] = trim(preg_replace('/\$/', '', $venda_valor_total));

                $data = html_escape($data);

                $this->core_model->update('vendas', $data, array('venda_id' => $venda_id));

                /* Deletando de venda os produtos antigos da venda editada */
                $this->vendas_model->delete_old_products($venda_id);

                $produto_id = $this->input->post('produto_id');
                $produto_quantidade = $this->input->post('produto_quantidade');
                $produto_desconto = str_replace('%', '', $this->input->post('produto_desconto'));

                $produto_preco_venda = str_replace('R$', '', $this->input->post('produto_preco_venda'));
                $produto_item_total = str_replace('R$', '', $this->input->post('produto_item_total'));

                $produto_preco = str_replace(',', '', $produto_preco_venda);
                $produto_item_total = str_replace(',', '', $produto_item_total);


                $qty_produto = count($produto_id);

                for ($i = 0; $i < $qty_produto; $i++) {

                    $data = array(
                        'venda_produto_id_venda' => $venda_id,
                        'venda_produto_id_produto' => $produto_id[$i],
                        'venda_produto_quantidade' => $produto_quantidade[$i],
                        'venda_produto_valor_unitario' => $produto_preco_venda[$i],
                        'venda_produto_desconto' => $produto_desconto[$i],
                        'venda_produto_valor_total' => $produto_item_total[$i],
                    );

                    $data = html_escape($data);

                    $this->core_model->insert('venda_produtos', $data);
                }

                redirect('vendas');
            } else {

                //Erro de validação

                $data = array(
                    'titulo' => 'Atualizar venda',
                    'styles' => array(
                        'vendor/select2/select2.min.css',
                        'vendor/autocomplete/jquery-ui.css',
                        'vendor/autocomplete/estilo.css',
                    ),
                    'scripts' => array(
                        'vendor/autocomplete/jquery-migrate.js', //Vem primeiro
                        'vendor/calcx/jquery-calx-sample-2.2.8.min.js',
                        'vendor/calcx/venda.js',
                        'vendor/select2/select2.min.js',
                        'vendor/select2/app.js',
                        'vendor/sweetalert2/sweetalert2.js',
                        'vendor/autocomplete/jquery-ui.js', //Vem por último
                    ),
                    'termos' => $this->core_model->get_all('termos'),
                    'clientes' => $this->core_model->get_all('clientes', array('cliente_ativo' => 1)),
                    'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos', array('forma_pagamento_ativa' => 1)),
                    'vendedores' => $this->core_model->get_all('vendedores', array('vendedor_ativo' => 1)),
                    'venda' => $this->vendas_model->get_by_id($venda_id),
                    'venda_produtos' => $this->vendas_model->get_all_produtos_by_venda($venda_id),
                    'desabilitar' => TRUE, //Desabilita botão de submit
                );

                //                echo '<pre>';
                //                print_r($venda_produtos);
                //                exit();

                $this->load->view('layout/header', $data);
                $this->load->view('vendas/view');
                $this->load->view('layout/footer');
            }
        }
    }

    public function edit($venda_id = NULL)
    {
        if (!$venda_id || !$this->core_model->get_by_id('vendas', array('venda_id' => $venda_id))) {
            $this->session->set_flashdata('error', 'Venda não encontrada');
            redirect('vendas');
        } else {

            $this->form_validation->set_rules('venda_cliente_id', '', 'required');
            $this->form_validation->set_rules('venda_tipo', '', 'required');
            $this->form_validation->set_rules('venda_forma_pagamento_id', '', 'required');
            $this->form_validation->set_rules('venda_vendedor_id', '', 'required');
            $this->form_validation->set_rules('venda_termos', '', 'required');


            if ($this->form_validation->run()) {

                $venda_valor_total = str_replace('R$', "", trim($this->input->post('venda_valor_total')));

                $data = elements(
                    array(
                        'venda_cliente_id',
                        'venda_forma_pagamento_id',
                        'venda_tipo',
                        'venda_vendedor_id',
                        'venda_valor_desconto',
                        'venda_valor_total',
                        'venda_termos'
                    ),
                    $this->input->post()
                );

                $data['venda_valor_total'] = trim(preg_replace('/\$/', '', $venda_valor_total));
                $data = html_escape($data);

                $result = $this->core_model->update('vendas', $data, array('venda_id' => $venda_id));
                if ($result) {
                    $this->session->set_flashdata('successo', 'Venda atualizada com sucesso!');
                } else {
                    $this->session->set_flashdata('error', 'Erro ao atualizar venda.');
                }

                // Atualizar produtos da venda
                $produto_id = $this->input->post('produto_id');
                $produto_quantidade = $this->input->post('produto_quantidade');
                $produto_desconto = str_replace('%', '', $this->input->post('produto_desconto'));
                $produto_preco_venda = str_replace('R$', '', $this->input->post('produto_preco_venda'));
                $produto_item_total = str_replace('R$', '', $this->input->post('produto_item_total'));

                $produto_preco_venda = array_map(function ($value) {
                    return str_replace(',', '', $value);
                }, $produto_preco_venda);

                $produto_item_total = array_map(function ($value) {
                    return str_replace(',', '', $value);
                }, $produto_item_total);

                // Deletar produtos antigos
                $this->core_model->delete('venda_produtos', array('venda_produto_id_venda' => $venda_id));

                // Adicionar produtos atualizados
                foreach ($produto_id as $key => $id) {
                    $data_produto = array(
                        'venda_produto_id_venda' => $venda_id,
                        'venda_produto_id_produto' => $id,
                        'venda_produto_quantidade' => $produto_quantidade[$key],
                        'venda_produto_valor_unitario' => $produto_preco_venda[$key],
                        'venda_produto_desconto' => $produto_desconto[$key],
                        'venda_produto_valor_total' => $produto_item_total[$key],
                    );

                    $data_produto = html_escape($data_produto);

                    $this->core_model->insert('venda_produtos', $data_produto);

                    // Atualização de estoque
                    $produto_qtde_estoque = intval($produto_quantidade[$key]);

                    $produtos = array(
                        'produto_qtde_estoque' => $produto_qtde_estoque,
                    );

                    $this->produtos_model->update($id, $produto_qtde_estoque);
                }

                redirect('vendas');
            } else {
                // Erro de validação
                $data = array(
                    'titulo' => 'Atualizar venda',
                    'styles' => array(
                        'vendor/select2/select2.min.css',
                        'vendor/autocomplete/jquery-ui.css',
                        'vendor/autocomplete/estilo.css',
                    ),
                    'scripts' => array(
                        'vendor/autocomplete/jquery-migrate.js', //Vem primeiro
                        'vendor/calcx/jquery-calx-sample-2.2.8.min.js',
                        'vendor/calcx/venda.js',
                        'vendor/select2/select2.min.js',
                        'vendor/select2/app.js',
                        'vendor/sweetalert2/sweetalert2.js',
                        'vendor/autocomplete/jquery-ui.js', //Vem por último
                    ),
                    'termos' => $this->core_model->get_all('termos'),
                    'clientes' => $this->core_model->get_all('clientes', array('cliente_ativo' => 1)),
                    'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos', array('forma_pagamento_ativa' => 1)),
                    'vendedores' => $this->core_model->get_all('vendedores', array('vendedor_ativo' => 1)),
                    'venda' => $this->vendas_model->get_by_id($venda_id),
                    'venda_produtos' => $this->vendas_model->get_all_produtos_by_venda($venda_id),
                    'desabilitar' => TRUE, //Desabilita botão de submit
                );

                $this->load->view('layout/header', $data);
                $this->load->view('vendas/edit');
                $this->load->view('layout/footer');
            }
        }
    }


    public function faturar($venda_id = NULL)
    {

        if (!$venda_id || !$this->core_model->get_by_id('vendas', array('venda_id' => $venda_id))) {
            $this->session->set_flashdata('error', 'Venda não encontrada');
            redirect('vendas');
        } else {

            $data = elements(
                array(
                    'venda_status',
                ),
                $this->input->post()
            );

            $data['venda_status'] = 'FATURADA';

            $this->core_model->update('vendas', $data, array('venda_id' => $venda_id));

            redirect('vendas');
        }
    }

    public function del($venda_id = NULL)
    {
        if (!$venda_id || !$this->core_model->get_by_id('vendas', array('venda_id' => $venda_id))) {
            $this->session->set_flashdata('error', 'Venda não encontrada');
            redirect('vendas');
        } else {

            $this->core_model->delete('vendas', array('venda_id' => $venda_id));
            redirect('vendas');
        }
    }

    public function imprimir($venda_id = NULL)
    {

        if (!$venda_id || !$this->core_model->get_by_id('vendas', array('venda_id' => $venda_id))) {
            $this->session->set_flashdata('error', 'Venda não encontrada');
            redirect('vendas');
        } else {

            $data = array(
                'titulo' => 'Escolha uma opção',
                'venda' => $this->core_model->get_by_id('vendas', array('venda_id' => $venda_id)),
            );

            $this->load->view('layout/header', $data);
            $this->load->view('vendas/imprimir');
            $this->load->view('layout/footer');
        }
    }

    public function pdf($venda_id = NULL)
    {
        if (!$venda_id || !$this->core_model->get_by_id('vendas', array('venda_id' => $venda_id))) {
            $this->session->set_flashdata('error', 'Venda não encontrada');
            redirect('vendas');
        } else {
            $empresa = $this->core_model->get_by_id('sistema', array('sistema_id' => 1));
            $venda = $this->vendas_model->get_by_id($venda_id);
            $filename = $venda->cliente_nome_completo . '_' . time();
            $imageUrl = base_url('public/img/uploads/' . $empresa->sistema_logo);
            $html = '
                <!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                <html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="pt-br">
                <head>            
                    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
                    <title>' . $venda->cliente_nome_completo . '</title>';

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
                            <td style="text-align: left;">' . $empresa->sistema_endereco . ', &nbsp;' . $empresa->sistema_numero . ' | ' . $empresa->sistema_cidade . ', &nbsp;' . $empresa->sistema_estado . ' | <span class="text-muted">CEP:&nbsp;</span> ' . $empresa->sistema_cep . '</td>        
                        </tr>         
                        <tr>
                            <td style="text-align: left;">' . $empresa->sistema_telefone_fixo . ' ' . $empresa->sistema_email . '</td>        
                        </tr>        
                        <tr>        
                            <td></td>        
                            <td style="text-align: right;">Emitido em: ' . date("d-m-Y", strtotime($venda->venda_data_emissao)) . '</td>        
                        </tr>        
                    </table>  
                          
                </div>                
                    <div id="footer"> 
                         
                        <p class="text-muted align-center">' . $empresa->sistema_txt_ordem_servico . '</p>
                        <div class="page-number">
                        

                        </div>  
                    </div>  
                                         
                
                    <h2>Dados da Venda</h2>';

            $html .= '<p align="right" style="font-size: 12px">Venda nº&nbsp;' . $venda->venda_id . '</p>';

            $html .= '<p class="borda-cinza">'
                . '<strong class="text-muted">Cliente: </strong>' . $venda->cliente_nome_completo . '<br/>'
                . '<strong class="text-muted">CPF: </strong>' . $venda->cliente_cpf_cnpj . '<br/>'
                . '<strong class="text-muted">Celular: </strong>' . $venda->cliente_celular . '<br/>'
                . '<strong class="text-muted">Data de emissão: </strong>' . formata_data_banco_com_hora($venda->venda_data_emissao) . '<br/>'
                . '<strong class="text-muted">Forma de pagamento: </strong>' . $venda->forma_pagamento . '<br/>'
                . '</p>';

            $html .= '<table id="tabela-produtos" width="100%" border: solid #ddd 1px>';

            $html .= '<thead class="tabela-cabecalho">';
            $html .= '<tr>';

            $html .= '<th>Código</th>';
            $html .= '<th>Descrição</th>';
            $html .= '<th>Quantidade</th>';
            $html .= '<th>Valor unitário</th>';
            $html .= '<th>Desconto</th>';
            $html .= '<th>Valor total</th>';

            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';

            $produtos_venda = $this->vendas_model->get_all_produtos($venda_id);

            $valor_final_venda = $this->vendas_model->get_valor_final_venda($venda_id);

            foreach ($produtos_venda as $produto) :

                $html .= '<tr>';
                $html .= '<td>' . $produto->venda_produto_id_produto . '</td>';
                $html .= '<td>' . $produto->produto_descricao . '</td>';
                $html .= '<td>' . $produto->venda_produto_quantidade . '</td>';
                $html .= '<td>' . 'R$&nbsp;' . $produto->venda_produto_valor_unitario . '</td>';
                $html .= '<td>' . '%&nbsp;' . $produto->venda_produto_desconto . '</td>';
                $html .= '<td>' . 'R$&nbsp;' . $produto->venda_produto_valor_total . '</td>';
                $html .= '</tr>';

            endforeach;
            $html .= '</tbody>';

            $html .= '<th colspan="4">';

            $html .= '<td style="border-top: solid #ddd 1px"><strong>Valor final</strong></td>';
            $html .= '<td style="border-top: solid #ddd 1px">' . 'R$&nbsp;' . $valor_final_venda->venda_valor_total . '</td>';

            $html .= '</th>';

            $html .= '</table>';

            $html .= '</br><h2>' . $venda->titulo . '<h2>';
            $html .= '</br><p>' . $venda->descricao . '<p></br>';


            $html .= '</body>
                </html>
                ';



            $dompdf = new Dompdf(['enable_remote' => true]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');

            $dompdf->render();
            $dompdf->stream($filename . ".pdf", array("Attachment" => 1));


            // echo '<pre>';
            // var_dump($venda);
        }
    }
}
