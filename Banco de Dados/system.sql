-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/07/2024 às 19:19
-- Versão do servidor: 10.4.11-MariaDB
-- Versão do PHP: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `system`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `categoria_id` int(11) NOT NULL,
  `categoria_nome` varchar(45) NOT NULL,
  `categoria_ativa` tinyint(1) DEFAULT NULL,
  `categoria_data_alteracao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`categoria_id`, `categoria_nome`, `categoria_ativa`, `categoria_data_alteracao`) VALUES
(1, 'Games', 1, '2020-03-31 20:18:35'),
(3, 'Eletrônicos', 1, '2020-03-30 07:16:11'),
(4, 'Acessorios', 0, '2024-07-24 16:50:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `cliente_id` int(11) NOT NULL,
  `cliente_data_cadastro` timestamp NULL DEFAULT current_timestamp(),
  `cliente_tipo` tinyint(1) NOT NULL,
  `cliente_nome` varchar(45) NOT NULL,
  `cliente_sobrenome` varchar(150) NOT NULL,
  `cliente_data_nascimento` date NOT NULL,
  `cliente_cpf_cnpj` varchar(30) NOT NULL,
  `cliente_rg_ie` varchar(20) NOT NULL,
  `cliente_email` varchar(50) NOT NULL,
  `cliente_telefone` varchar(20) NOT NULL,
  `cliente_celular` varchar(20) NOT NULL,
  `cliente_cep` varchar(10) NOT NULL,
  `cliente_endereco` varchar(155) NOT NULL,
  `cliente_numero_endereco` varchar(20) NOT NULL,
  `cliente_bairro` varchar(45) NOT NULL,
  `cliente_complemento` varchar(145) NOT NULL,
  `cliente_cidade` varchar(105) NOT NULL,
  `cliente_estado` varchar(2) NOT NULL,
  `cliente_ativo` tinyint(1) NOT NULL,
  `cliente_obs` tinytext DEFAULT NULL,
  `cliente_data_alteracao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`cliente_id`, `cliente_data_cadastro`, `cliente_tipo`, `cliente_nome`, `cliente_sobrenome`, `cliente_data_nascimento`, `cliente_cpf_cnpj`, `cliente_rg_ie`, `cliente_email`, `cliente_telefone`, `cliente_celular`, `cliente_cep`, `cliente_endereco`, `cliente_numero_endereco`, `cliente_bairro`, `cliente_complemento`, `cliente_cidade`, `cliente_estado`, `cliente_ativo`, `cliente_obs`, `cliente_data_alteracao`) VALUES
(1, '2020-03-31 21:19:50', 1, 'Lucio Santos', 'Solteiro sempre', '2016-03-23', '360.827.730-71', '33.563.720-6', 'lucio@gmail.com', '(41) 9999-9999', '(41) 99999-9999', '80530-000', 'Rua de Curitiba', '200', 'Centro', '', 'Curitiba', 'PR', 1, '', '2021-10-10 00:28:18'),
(2, '2020-03-31 21:21:10', 1, 'Jade', 'Jade', '2020-03-31', '794.749.900-42', '47.961.669-3', 'miriam@gmail.com', '(41) 3333-3232', '(41) 98989-8989', '80530-000', 'Rua de Curitiba', '210', 'Centro', '', 'Curitiba', 'PR', 1, '', '2021-10-10 00:31:07'),
(3, '2020-03-31 21:25:15', 2, 'João Paulo', 'Silva', '2020-03-10', '70.230.264/0001-17', '565.37836-81', 'visaotec.com@gmail.com', '(41) 3232-3232', '(41) 98888-8888', '80330-000', 'Rua de cima', '101', 'Centro', '', 'Curitiba', 'PR', 1, '', '2021-10-10 00:27:33'),
(4, '2021-10-10 00:04:27', 2, 'Tereza Cristina', 'Silveira', '1983-09-11', '60.370.217/0001-15', '443.269.120.318', 'ana.lindari@gmail.com', '', '(34) 99884-2054', '38440-032', 'Rua Florida', '20', 'Beleza', '', 'Araguari', 'MG', 1, '', '2021-10-10 00:04:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas_pagar`
--

CREATE TABLE `contas_pagar` (
  `conta_pagar_id` int(11) NOT NULL,
  `conta_pagar_fornecedor_id` int(11) DEFAULT NULL,
  `conta_pagar_data_vencimento` date DEFAULT NULL,
  `conta_pagar_data_pagamento` datetime DEFAULT NULL,
  `conta_pagar_valor` varchar(15) DEFAULT NULL,
  `conta_pagar_status` tinyint(1) DEFAULT NULL,
  `conta_pagar_obs` tinytext DEFAULT NULL,
  `conta_pagar_data_alteracao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='		';

--
-- Despejando dados para a tabela `contas_pagar`
--

INSERT INTO `contas_pagar` (`conta_pagar_id`, `conta_pagar_fornecedor_id`, `conta_pagar_data_vencimento`, `conta_pagar_data_pagamento`, `conta_pagar_valor`, `conta_pagar_status`, `conta_pagar_obs`, `conta_pagar_data_alteracao`) VALUES
(2, 1, '2024-07-15', NULL, '1,000.00', 0, '', '2024-07-05 19:22:10'),
(3, 1, '2020-03-31', '2020-04-04 03:38:19', '1,000.00', 1, '', '2020-04-04 06:38:19'),
(4, 1, '2021-10-09', NULL, '100.00', 0, '', '2021-10-10 00:48:40');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas_receber`
--

CREATE TABLE `contas_receber` (
  `conta_receber_id` int(11) NOT NULL,
  `conta_receber_cliente_id` int(11) NOT NULL,
  `conta_receber_data_vencimento` date DEFAULT NULL,
  `conta_receber_data_pagamento` datetime DEFAULT NULL,
  `conta_receber_valor` varchar(20) DEFAULT NULL,
  `conta_receber_status` tinyint(1) DEFAULT NULL,
  `conta_receber_obs` tinytext DEFAULT NULL,
  `conta_receber_data_alteracao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `contas_receber`
--

INSERT INTO `contas_receber` (`conta_receber_id`, `conta_receber_cliente_id`, `conta_receber_data_vencimento`, `conta_receber_data_pagamento`, `conta_receber_valor`, `conta_receber_status`, `conta_receber_obs`, `conta_receber_data_alteracao`) VALUES
(1, 1, '2020-02-28', '2020-03-31 07:23:10', '150,226.22', 1, '', '2020-03-31 22:23:10'),
(2, 2, '2020-02-21', '2020-02-28 18:33:19', '350.00', 1, NULL, '2020-02-28 21:33:19'),
(3, 3, '2020-02-28', '2020-02-28 17:22:47', '56.00', 1, NULL, '2020-02-28 20:22:47'),
(4, 2, '2020-03-31', '2020-04-04 02:37:36', '100.00', 1, '', '2020-04-04 05:37:36'),
(5, 1, '2020-04-28', '2020-04-04 02:49:40', '1,000.00', 1, '', '2020-04-04 05:49:40'),
(6, 3, '2020-04-01', '2020-04-04 02:49:47', '5,000.00', 0, '', '2020-04-04 21:11:38'),
(7, 3, '2020-04-01', NULL, '500.00', 0, '', '2020-04-04 21:49:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `formas_pagamentos`
--

CREATE TABLE `formas_pagamentos` (
  `forma_pagamento_id` int(11) NOT NULL,
  `forma_pagamento_nome` varchar(45) DEFAULT NULL,
  `forma_pagamento_aceita_parc` tinyint(1) DEFAULT NULL,
  `forma_pagamento_ativa` tinyint(1) DEFAULT NULL,
  `forma_pagamento_data_alteracao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `formas_pagamentos`
--

INSERT INTO `formas_pagamentos` (`forma_pagamento_id`, `forma_pagamento_nome`, `forma_pagamento_aceita_parc`, `forma_pagamento_ativa`, `forma_pagamento_data_alteracao`) VALUES
(1, 'Cartão de crédito', 1, 1, '2020-04-01 00:57:14'),
(2, 'Dinheiro', 0, 1, '2020-01-29 21:43:54'),
(3, 'Boleto bancário', 1, 1, '2020-04-01 00:57:36'),
(4, 'Boleto', 0, 0, '2020-04-01 01:11:06'),
(5, 'Cartão de débito', 0, 1, '2020-04-01 01:11:49');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `fornecedor_id` int(11) NOT NULL,
  `fornecedor_data_cadastro` timestamp NULL DEFAULT current_timestamp(),
  `fornecedor_razao` varchar(200) DEFAULT NULL,
  `fornecedor_nome_fantasia` varchar(145) DEFAULT NULL,
  `fornecedor_cnpj` varchar(20) DEFAULT NULL,
  `fornecedor_ie` varchar(20) DEFAULT NULL,
  `fornecedor_telefone` varchar(20) DEFAULT NULL,
  `fornecedor_celular` varchar(20) DEFAULT NULL,
  `fornecedor_email` varchar(100) DEFAULT NULL,
  `fornecedor_contato` varchar(45) DEFAULT NULL,
  `fornecedor_cep` varchar(10) DEFAULT NULL,
  `fornecedor_endereco` varchar(145) DEFAULT NULL,
  `fornecedor_numero_endereco` varchar(20) DEFAULT NULL,
  `fornecedor_bairro` varchar(45) DEFAULT NULL,
  `fornecedor_complemento` varchar(45) DEFAULT NULL,
  `fornecedor_cidade` varchar(45) DEFAULT NULL,
  `fornecedor_estado` varchar(2) DEFAULT NULL,
  `fornecedor_ativo` tinyint(1) DEFAULT NULL,
  `fornecedor_obs` tinytext DEFAULT NULL,
  `fornecedor_data_alteracao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `fornecedores`
--

INSERT INTO `fornecedores` (`fornecedor_id`, `fornecedor_data_cadastro`, `fornecedor_razao`, `fornecedor_nome_fantasia`, `fornecedor_cnpj`, `fornecedor_ie`, `fornecedor_telefone`, `fornecedor_celular`, `fornecedor_email`, `fornecedor_contato`, `fornecedor_cep`, `fornecedor_endereco`, `fornecedor_numero_endereco`, `fornecedor_bairro`, `fornecedor_complemento`, `fornecedor_cidade`, `fornecedor_estado`, `fornecedor_ativo`, `fornecedor_obs`, `fornecedor_data_alteracao`) VALUES
(1, '2020-03-29 06:18:03', 'Lucio componentes LTDA', 'Lucio Inc - New', '25.851.950/0001-50', '157.98739-96', '(41) 3333-3333', '(41) 99999-9999', 'lucioinc@contato.com.br', 'Fulano de tal', '80450-000', 'Rua do comércio', '200', 'Centro', 'Bloco A', 'Curitiba', 'PR', 1, 'Fornecedor vende produtos de má qualidade como se fossem de boa qualidade', '2020-03-31 01:30:23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'vendedor', 'Vendedor');

-- --------------------------------------------------------

--
-- Estrutura para tabela `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `marcas`
--

CREATE TABLE `marcas` (
  `marca_id` int(11) NOT NULL,
  `marca_nome` varchar(45) NOT NULL,
  `marca_ativa` tinyint(1) DEFAULT NULL,
  `marca_data_alteracao` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `marcas`
--

INSERT INTO `marcas` (`marca_id`, `marca_nome`, `marca_ativa`, `marca_data_alteracao`) VALUES
(1, 'Multilaser PRO', 1, '2020-03-31 20:17:39'),
(3, 'HP', 1, '2020-03-31 01:24:47'),
(4, 'Xiaomi', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordem_tem_servicos`
--

CREATE TABLE `ordem_tem_servicos` (
  `ordem_ts_id` int(11) NOT NULL,
  `ordem_ts_id_servico` int(11) DEFAULT NULL,
  `ordem_ts_id_ordem_servico` int(11) DEFAULT NULL,
  `ordem_ts_quantidade` int(11) DEFAULT NULL,
  `ordem_ts_valor_unitario` varchar(45) DEFAULT NULL,
  `ordem_ts_valor_desconto` varchar(45) DEFAULT NULL,
  `ordem_ts_valor_total` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabela de relacionamento entre as tabelas servicos e ordem_servico';

--
-- Despejando dados para a tabela `ordem_tem_servicos`
--

INSERT INTO `ordem_tem_servicos` (`ordem_ts_id`, `ordem_ts_id_servico`, `ordem_ts_id_ordem_servico`, `ordem_ts_quantidade`, `ordem_ts_valor_unitario`, `ordem_ts_valor_desconto`, `ordem_ts_valor_total`) VALUES
(11, 3, 3, 1, ' 120.00', '0 ', ' 120.00'),
(12, 1, 1, 1, ' 80.00', '0 ', ' 80.00'),
(20, 1, 4, 1, ' 50.00', '0 ', ' 50.00'),
(23, 2, 2, 4, ' 80.00', '0 ', ' 320.00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordens_servicos`
--

CREATE TABLE `ordens_servicos` (
  `ordem_servico_id` int(11) NOT NULL,
  `ordem_servico_forma_pagamento_id` int(11) DEFAULT NULL,
  `ordem_servico_cliente_id` int(11) DEFAULT NULL,
  `ordem_servico_data_emissao` timestamp NULL DEFAULT current_timestamp(),
  `ordem_servico_data_conclusao` varchar(100) DEFAULT NULL,
  `ordem_servico_equipamento` varchar(80) DEFAULT NULL,
  `ordem_servico_marca_equipamento` varchar(80) DEFAULT NULL,
  `ordem_servico_modelo_equipamento` varchar(80) DEFAULT NULL,
  `ordem_servico_acessorios` tinytext DEFAULT NULL,
  `ordem_servico_defeito` tinytext DEFAULT NULL,
  `ordem_servico_valor_desconto` varchar(25) DEFAULT NULL,
  `ordem_servico_valor_total` varchar(25) DEFAULT NULL,
  `ordem_servico_status` tinyint(1) DEFAULT NULL,
  `ordem_servico_obs` tinytext DEFAULT NULL,
  `ordem_servico_data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ordem_servico_termos` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `ordens_servicos`
--

INSERT INTO `ordens_servicos` (`ordem_servico_id`, `ordem_servico_forma_pagamento_id`, `ordem_servico_cliente_id`, `ordem_servico_data_emissao`, `ordem_servico_data_conclusao`, `ordem_servico_equipamento`, `ordem_servico_marca_equipamento`, `ordem_servico_modelo_equipamento`, `ordem_servico_acessorios`, `ordem_servico_defeito`, `ordem_servico_valor_desconto`, `ordem_servico_valor_total`, `ordem_servico_status`, `ordem_servico_obs`, `ordem_servico_data_alteracao`, `ordem_servico_termos`) VALUES
(1, 3, 1, '2020-02-14 20:30:35', NULL, 'Fone de ouvido', 'Awell', 'AV1801', 'Mouse e carregador', 'Não sai aúdio no lado esquerdo', 'R$ 0.00', '80.00', 1, '', '2021-10-09 22:13:08', NULL),
(2, 1, 2, '2020-02-14 20:48:53', NULL, 'Notebook gamer', 'Awell', 'FONE01', 'Mouse e carregador', 'Não carrega', 'R$ 0.00', '320.00', 0, '', '2024-07-06 02:45:10', 1),
(3, 1, 3, '2020-02-17 23:53:26', NULL, 'Notebook Sony', 'Sony', 'FONE01', 'Mouse e carregador', 'Tela trincada', 'R$ 0.00', '120.00', 0, 'Vem buscar pela manhã', '2020-02-28 22:51:34', NULL),
(4, 3, 2, '2024-07-04 18:32:42', NULL, 'smartphonw', 'Samsung', 'A30', 'fone de ouvido', 'teste teste', 'R$ 0.00', '50.00', 1, 'teste teste', '2024-07-04 19:14:05', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `produto_id` int(11) NOT NULL,
  `produto_codigo` varchar(45) DEFAULT NULL,
  `produto_data_cadastro` datetime DEFAULT NULL,
  `produto_categoria_id` int(11) NOT NULL,
  `produto_marca_id` int(11) NOT NULL,
  `produto_fornecedor_id` int(11) NOT NULL,
  `produto_descricao` varchar(145) DEFAULT NULL,
  `produto_unidade` varchar(25) DEFAULT NULL,
  `produto_preco_custo` varchar(45) DEFAULT NULL,
  `produto_preco_venda` varchar(45) DEFAULT NULL,
  `produto_estoque_minimo` varchar(10) DEFAULT NULL,
  `produto_qtde_estoque` varchar(10) DEFAULT NULL,
  `produto_ativo` tinyint(1) DEFAULT NULL,
  `produto_obs` tinytext DEFAULT NULL,
  `produto_data_alteracao` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`produto_id`, `produto_codigo`, `produto_data_cadastro`, `produto_categoria_id`, `produto_marca_id`, `produto_fornecedor_id`, `produto_descricao`, `produto_unidade`, `produto_preco_custo`, `produto_preco_venda`, `produto_estoque_minimo`, `produto_qtde_estoque`, `produto_ativo`, `produto_obs`, `produto_data_alteracao`) VALUES
(1, '72495380', NULL, 1, 1, 1, 'Notebook gamer', 'UN', '1.800,00', '15.031,00', '2', '1', 1, 'Produto já está auditado', '2024-07-05 21:55:03'),
(2, '50412637', NULL, 3, 3, 1, 'Fone de ouvido gamer', 'UN', '112,00', '125.844,00', '1', '-2', 1, '', '2024-07-05 21:55:03'),
(3, '41697502', NULL, 3, 3, 1, 'Mouse usb', 'UN', '9,99', '15,22', '2', '6', 1, '', '2024-07-04 15:36:10'),
(4, '89614023', NULL, 3, 3, 1, 'Note 12 256GB 8GB Preto', 'un', '1.000,00', '1.250,00', '5', '20', 1, 'Produto do fornecedor Lucio nota certa', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `servico_id` int(11) NOT NULL,
  `servico_nome` varchar(145) DEFAULT NULL,
  `servico_preco` varchar(15) DEFAULT NULL,
  `servico_descricao` tinytext DEFAULT NULL,
  `servico_ativo` tinyint(1) DEFAULT NULL,
  `servico_data_alteracao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`servico_id`, `servico_nome`, `servico_preco`, `servico_descricao`, `servico_ativo`, `servico_data_alteracao`) VALUES
(1, 'Limpeza geral', '50,00', 'Limpeza de equipamentos', 1, '2024-07-02 16:43:33'),
(2, 'Solda elétrica', '80,00', 'Solda elétrica', 1, '2020-04-02 00:21:57'),
(3, 'Restauração de placas', '1.200,00', 'Restauração de componentes', 1, '2024-07-05 19:40:47'),
(4, 'Manutenção Notebook', '15,00', 'Manutenção Notebook', 1, '2024-07-05 19:41:26'),
(5, 'Restauracao placa mae', '180,00', 'placa mãe são restaurada', 1, '2024-07-24 16:53:46');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sistema`
--

CREATE TABLE `sistema` (
  `sistema_id` int(11) NOT NULL,
  `sistema_razao_social` varchar(145) DEFAULT NULL,
  `sistema_nome_fantasia` varchar(145) DEFAULT NULL,
  `sistema_cnpj` varchar(25) DEFAULT NULL,
  `sistema_ie` varchar(25) DEFAULT NULL,
  `sistema_telefone_fixo` varchar(25) DEFAULT NULL,
  `sistema_telefone_movel` varchar(25) NOT NULL,
  `sistema_email` varchar(100) DEFAULT NULL,
  `sistema_site_url` varchar(100) DEFAULT NULL,
  `sistema_cep` varchar(25) DEFAULT NULL,
  `sistema_endereco` varchar(145) DEFAULT NULL,
  `sistema_numero` varchar(25) DEFAULT NULL,
  `sistema_cidade` varchar(45) DEFAULT NULL,
  `sistema_estado` varchar(2) DEFAULT NULL,
  `sistema_txt_ordem_servico` tinytext DEFAULT NULL,
  `sistema_data_alteracao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sistema_logo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `sistema`
--

INSERT INTO `sistema` (`sistema_id`, `sistema_razao_social`, `sistema_nome_fantasia`, `sistema_cnpj`, `sistema_ie`, `sistema_telefone_fixo`, `sistema_telefone_movel`, `sistema_email`, `sistema_site_url`, `sistema_cep`, `sistema_endereco`, `sistema_numero`, `sistema_cidade`, `sistema_estado`, `sistema_txt_ordem_servico`, `sistema_data_alteracao`, `sistema_logo`) VALUES
(1, 'Tech Service', 'S.E.S Marido de Aluguel', '49.983.959/0001-83', '00000000-00', '(41) 3333-3333', '(41) 3333-3333', 'pinturascorreal@gmail.com	', 'https://ssmaridodealuguel.com.br/', '06756-030', 'PARQUE MONTE ALEGRE', '38', 'São Paulo', 'SP', 'S.E.S Marido de Aluguel - Qualidade e preço justo!', '2024-07-05 19:20:34', 'logo_System_OS3.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `termos`
--

CREATE TABLE `termos` (
  `id` bigint(20) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `termos`
--

INSERT INTO `termos` (`id`, `titulo`, `descricao`) VALUES
(1, 'Termo de Garantia', '<p align=\"center\"><b>Prezado cliente</b></p><p align=\"justify\">Este termo tem como objetivo garantir pelo período de 90 (Noventa dias), a contar da data de aquisição do produto e conforme condições descritas abaixo, a qualidade do produto contra defeitos de fabricação que venham a afetar a integridade física do produto. Para a melhor compreensão da abrangência desse termo, ficam descritas abaixo as condições desta garantia e as obrigações do cliente.</p> <p align=\"justify\">1.0 A garantia só tem cobertura para as peças que tenham defeito original de fábrica, e a comprovação será feita no momento de se realizar o reparo. Essa garantia cobre somente os defeitos de funcionamento das peças e componentes. </p> <p align=\"justify\">1.1 Estão cobertos pela garantia as seguintes peças: placa mãe/processador, conector de carga, bateria, câmeras, microfone, auto falante inferior e superior, chip wi-fi/4g/bluetooth/gps, sensor de aproximação, entrada do fone de ouvido.</p> <p align=\"justify\">1.2 Em casos de descarga rápida de bateria, é necessário fazer uma restauração de fábrica no aparelho e um teste de uso de 100% á 0%, para averiguar a duração completa da bateria, sendo considerado o normal, 10 horas de uso, podendo variar dependendo do mHa da bateria ou tempo de uso do aparelho.</p><p></p>');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$12$/K3QCw2uqSlYxvkh1g3lzeA2P6S4aye105JYlv/Qz3.iXHRCxF4fy', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1721833085, 1, 'Visaotec', 'Sistemas', 'ADMIN', '0'),
(2, '::1', 'Mano', '$2y$10$5BmUGHEoHkZR3ydNQGirBe/nc96yojylKMLgsMNuhcJDJTliE8nfa', 'manoel@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1586021957, 1633829123, 1, 'Manoel', 'Souza', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(10, 1, 1),
(20, 2, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `venda_id` int(11) NOT NULL,
  `venda_cliente_id` int(11) DEFAULT NULL,
  `venda_forma_pagamento_id` int(11) DEFAULT NULL,
  `venda_vendedor_id` int(11) DEFAULT NULL,
  `venda_tipo` tinyint(1) DEFAULT NULL,
  `venda_data_emissao` timestamp NULL DEFAULT current_timestamp(),
  `venda_valor_desconto` varchar(25) DEFAULT NULL,
  `venda_valor_total` varchar(25) DEFAULT NULL,
  `venda_data_alteracao` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `venda_termos` bigint(20) DEFAULT NULL,
  `venda_status` varchar(15) NOT NULL DEFAULT 'ABERTA'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`venda_id`, `venda_cliente_id`, `venda_forma_pagamento_id`, `venda_vendedor_id`, `venda_tipo`, `venda_data_emissao`, `venda_valor_desconto`, `venda_valor_total`, `venda_data_alteracao`, `venda_termos`, `venda_status`) VALUES
(2, 1, 3, 1, 1, '2020-04-03 06:18:56', 'R$ 0.00', '15,031.00', '2024-07-04 15:21:54', 3, 'FATURADA'),
(3, 3, 2, 1, 1, '2020-04-03 06:52:46', 'R$ 0.00', '251,688.00', '2024-07-04 15:22:02', NULL, 'FATURADA'),
(4, 1, 2, 1, 1, '2020-04-04 20:22:13', 'R$ 0.00', '266,719.00', '2024-07-05 21:55:03', 1, 'ABERTA'),
(5, 3, 2, 1, 1, '2024-07-02 16:57:35', 'R$ 751.55', '14,279.45', '2024-07-05 21:42:05', 9, 'ABERTA'),
(6, 2, 2, 1, 1, '2024-07-03 21:18:18', 'R$ 0.00', '125,844.00', '2024-07-04 13:58:55', 3, 'FATURADA');

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda_produtos`
--

CREATE TABLE `venda_produtos` (
  `id_venda_produtos` int(11) NOT NULL,
  `venda_produto_id_venda` int(11) DEFAULT NULL,
  `venda_produto_id_produto` int(11) DEFAULT NULL,
  `venda_produto_quantidade` varchar(15) DEFAULT NULL,
  `venda_produto_valor_unitario` varchar(20) DEFAULT NULL,
  `venda_produto_desconto` varchar(10) DEFAULT NULL,
  `venda_produto_valor_total` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `venda_produtos`
--

INSERT INTO `venda_produtos` (`id_venda_produtos`, `venda_produto_id_venda`, `venda_produto_id_produto`, `venda_produto_quantidade`, `venda_produto_valor_unitario`, `venda_produto_desconto`, `venda_produto_valor_total`) VALUES
(92, 6, 2, '1', ' 125,844.00', '0 ', ' 125844.00'),
(93, 3, 2, '2', ' 125,844.00', '0 ', ' 251688.00'),
(94, 2, 1, '1', ' 15,031.00', '0 ', ' 15031.00'),
(119, 5, 1, '1', ' 15031.00', '5 ', ' 14279.45'),
(120, 4, 2, '2', ' 125844.00', '0 ', ' 251688.00'),
(121, 4, 1, '1', ' 15031.00', '0 ', ' 15031.00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendedores`
--

CREATE TABLE `vendedores` (
  `vendedor_id` int(11) NOT NULL,
  `vendedor_codigo` varchar(10) NOT NULL,
  `vendedor_data_cadastro` timestamp NULL DEFAULT current_timestamp(),
  `vendedor_nome_completo` varchar(145) NOT NULL,
  `vendedor_cpf` varchar(25) NOT NULL,
  `vendedor_rg` varchar(25) NOT NULL,
  `vendedor_telefone` varchar(20) DEFAULT NULL,
  `vendedor_celular` varchar(20) DEFAULT NULL,
  `vendedor_email` varchar(45) DEFAULT NULL,
  `vendedor_cep` varchar(15) DEFAULT NULL,
  `vendedor_endereco` varchar(45) DEFAULT NULL,
  `vendedor_numero_endereco` varchar(25) DEFAULT NULL,
  `vendedor_complemento` varchar(45) DEFAULT NULL,
  `vendedor_bairro` varchar(45) DEFAULT NULL,
  `vendedor_cidade` varchar(45) DEFAULT NULL,
  `vendedor_estado` varchar(2) DEFAULT NULL,
  `vendedor_ativo` tinyint(1) DEFAULT NULL,
  `vendedor_obs` tinytext DEFAULT NULL,
  `vendedor_data_alteracao` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `vendedores`
--

INSERT INTO `vendedores` (`vendedor_id`, `vendedor_codigo`, `vendedor_data_cadastro`, `vendedor_nome_completo`, `vendedor_cpf`, `vendedor_rg`, `vendedor_telefone`, `vendedor_celular`, `vendedor_email`, `vendedor_cep`, `vendedor_endereco`, `vendedor_numero_endereco`, `vendedor_complemento`, `vendedor_bairro`, `vendedor_cidade`, `vendedor_estado`, `vendedor_ativo`, `vendedor_obs`, `vendedor_data_alteracao`) VALUES
(1, '09842571', '2020-01-28 01:24:17', 'Lucio Antonio de Souza', '946.873.070-00', '36.803.319-3', '(41) 3333-3232', '(41) 99999-9999', 'vendedor@gmail.com', '80530-000', 'Rua das vendas', '45', '', 'Centro', 'Curitiba', 'PR', 1, '', '2020-04-03 03:31:08');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cliente_id`);

--
-- Índices de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD PRIMARY KEY (`conta_pagar_id`),
  ADD KEY `fk_conta_pagar_id_fornecedor` (`conta_pagar_fornecedor_id`);

--
-- Índices de tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD PRIMARY KEY (`conta_receber_id`),
  ADD KEY `fk_conta_receber_id_cliente` (`conta_receber_cliente_id`);

--
-- Índices de tabela `formas_pagamentos`
--
ALTER TABLE `formas_pagamentos`
  ADD PRIMARY KEY (`forma_pagamento_id`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`fornecedor_id`);

--
-- Índices de tabela `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`marca_id`);

--
-- Índices de tabela `ordem_tem_servicos`
--
ALTER TABLE `ordem_tem_servicos`
  ADD PRIMARY KEY (`ordem_ts_id`),
  ADD KEY `fk_ordem_ts_id_servico` (`ordem_ts_id_servico`),
  ADD KEY `fk_ordem_ts_id_ordem_servico` (`ordem_ts_id_ordem_servico`);

--
-- Índices de tabela `ordens_servicos`
--
ALTER TABLE `ordens_servicos`
  ADD PRIMARY KEY (`ordem_servico_id`),
  ADD KEY `fk_ordem_servico_id_cliente` (`ordem_servico_cliente_id`),
  ADD KEY `fk_ordem_servico_id_forma_pagto` (`ordem_servico_forma_pagamento_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`produto_id`),
  ADD KEY `produto_categoria_id` (`produto_categoria_id`,`produto_marca_id`,`produto_fornecedor_id`),
  ADD KEY `fk_produto_marca_id` (`produto_marca_id`),
  ADD KEY `fk_produto_forncedor_id` (`produto_fornecedor_id`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`servico_id`);

--
-- Índices de tabela `sistema`
--
ALTER TABLE `sistema`
  ADD PRIMARY KEY (`sistema_id`);

--
-- Índices de tabela `termos`
--
ALTER TABLE `termos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Índices de tabela `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`venda_id`),
  ADD KEY `fk_venda_cliente_id` (`venda_cliente_id`),
  ADD KEY `fk_venda_forma_pagto_id` (`venda_forma_pagamento_id`),
  ADD KEY `fk_venda_vendedor_id` (`venda_vendedor_id`);

--
-- Índices de tabela `venda_produtos`
--
ALTER TABLE `venda_produtos`
  ADD PRIMARY KEY (`id_venda_produtos`),
  ADD KEY `fk_venda_produtos_id_produto` (`venda_produto_id_produto`),
  ADD KEY `fk_venda_produtos_id_venda` (`venda_produto_id_venda`);

--
-- Índices de tabela `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`vendedor_id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cliente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `contas_pagar`
--
ALTER TABLE `contas_pagar`
  MODIFY `conta_pagar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `contas_receber`
--
ALTER TABLE `contas_receber`
  MODIFY `conta_receber_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `formas_pagamentos`
--
ALTER TABLE `formas_pagamentos`
  MODIFY `forma_pagamento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `fornecedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `marcas`
--
ALTER TABLE `marcas`
  MODIFY `marca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `ordem_tem_servicos`
--
ALTER TABLE `ordem_tem_servicos`
  MODIFY `ordem_ts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `ordens_servicos`
--
ALTER TABLE `ordens_servicos`
  MODIFY `ordem_servico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `produto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `servico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `sistema`
--
ALTER TABLE `sistema`
  MODIFY `sistema_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `termos`
--
ALTER TABLE `termos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `venda_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `venda_produtos`
--
ALTER TABLE `venda_produtos`
  MODIFY `id_venda_produtos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de tabela `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `vendedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `contas_pagar`
--
ALTER TABLE `contas_pagar`
  ADD CONSTRAINT `fk_conta_pagar_id_fornecedor` FOREIGN KEY (`conta_pagar_fornecedor_id`) REFERENCES `fornecedores` (`fornecedor_id`);

--
-- Restrições para tabelas `contas_receber`
--
ALTER TABLE `contas_receber`
  ADD CONSTRAINT `fk_conta_receber_id_cliente` FOREIGN KEY (`conta_receber_cliente_id`) REFERENCES `clientes` (`cliente_id`);

--
-- Restrições para tabelas `ordem_tem_servicos`
--
ALTER TABLE `ordem_tem_servicos`
  ADD CONSTRAINT `fk_ordem_ts_id_ordem_servico` FOREIGN KEY (`ordem_ts_id_ordem_servico`) REFERENCES `ordens_servicos` (`ordem_servico_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ordem_ts_id_servico` FOREIGN KEY (`ordem_ts_id_servico`) REFERENCES `servicos` (`servico_id`);

--
-- Restrições para tabelas `ordens_servicos`
--
ALTER TABLE `ordens_servicos`
  ADD CONSTRAINT `fk_ordem_servico_id_cliente` FOREIGN KEY (`ordem_servico_cliente_id`) REFERENCES `clientes` (`cliente_id`),
  ADD CONSTRAINT `fk_ordem_servico_id_forma_pagto` FOREIGN KEY (`ordem_servico_forma_pagamento_id`) REFERENCES `formas_pagamentos` (`forma_pagamento_id`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produto_cat_id` FOREIGN KEY (`produto_categoria_id`) REFERENCES `categorias` (`categoria_id`),
  ADD CONSTRAINT `fk_produto_forncedor_id` FOREIGN KEY (`produto_fornecedor_id`) REFERENCES `fornecedores` (`fornecedor_id`),
  ADD CONSTRAINT `fk_produto_marca_id` FOREIGN KEY (`produto_marca_id`) REFERENCES `marcas` (`marca_id`);

--
-- Restrições para tabelas `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Restrições para tabelas `vendas`
--
ALTER TABLE `vendas`
  ADD CONSTRAINT `fk_venda_cliente_id` FOREIGN KEY (`venda_cliente_id`) REFERENCES `clientes` (`cliente_id`),
  ADD CONSTRAINT `fk_venda_forma_pagto_id` FOREIGN KEY (`venda_forma_pagamento_id`) REFERENCES `formas_pagamentos` (`forma_pagamento_id`),
  ADD CONSTRAINT `fk_venda_vendedor_id` FOREIGN KEY (`venda_vendedor_id`) REFERENCES `vendedores` (`vendedor_id`);

--
-- Restrições para tabelas `venda_produtos`
--
ALTER TABLE `venda_produtos`
  ADD CONSTRAINT `fk_venda_produtos_id_produto` FOREIGN KEY (`venda_produto_id_produto`) REFERENCES `produtos` (`produto_id`),
  ADD CONSTRAINT `fk_venda_produtos_id_venda` FOREIGN KEY (`venda_produto_id_venda`) REFERENCES `vendas` (`venda_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
