-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 04/06/2012 às 14h05min
-- Versão do Servidor: 5.1.62
-- Versão do PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `edegr109_edegraca`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador`
--

CREATE TABLE IF NOT EXISTS `administrador` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cpf` varchar(14) DEFAULT NULL,
  `rg` int(7) unsigned DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `sexo` varchar(1) NOT NULL,
  `saldo` float NOT NULL,
  `convites` int(11) NOT NULL,
  `fone` varchar(14) DEFAULT NULL,
  `celular` varchar(14) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `estado` varchar(50) NOT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `nivel` int(11) NOT NULL COMMENT '0 - user normal  1 - admin Geral  2- subadmin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agenda_hotel`
--

CREATE TABLE IF NOT EXISTS `agenda_hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_entrada` date NOT NULL,
  `data_saida` date NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 - livre | 1 - resevada | 2 - Confirmada com pagamento',
  `id_hotel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=211 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bairro`
--

CREATE TABLE IF NOT EXISTS `bairro` (
  `bairro_codigo` int(11) NOT NULL DEFAULT '0',
  `cidade_codigo` int(11) DEFAULT NULL,
  `bairro_descricao` varchar(72) DEFAULT NULL,
  PRIMARY KEY (`bairro_codigo`),
  KEY `cidade_codigo` (`cidade_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `baseemail`
--

CREATE TABLE IF NOT EXISTS `baseemail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `enviado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7905 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE IF NOT EXISTS `cidade` (
  `cidade_codigo` int(11) NOT NULL DEFAULT '0',
  `uf_codigo` int(11) DEFAULT NULL,
  `cidade_descricao` varchar(72) DEFAULT NULL,
  PRIMARY KEY (`cidade_codigo`),
  KEY `uf_codigo` (`uf_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade_oferta`
--

CREATE TABLE IF NOT EXISTS `cidade_oferta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) DEFAULT NULL,
  `uf` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `receber_news` tinyint(4) NOT NULL COMMENT '0 - Sim 1- NÃ£o',
  `cpf` varchar(14) DEFAULT NULL,
  `rg` int(7) unsigned DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `sexo` varchar(1) NOT NULL,
  `fone` varchar(14) DEFAULT NULL,
  `celular` varchar(14) DEFAULT NULL,
  `saldo` float DEFAULT NULL,
  `convites` int(10) unsigned DEFAULT NULL,
  `cep` varchar(8) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(30) NOT NULL,
  `receber_sms` tinyint(4) NOT NULL COMMENT '0 - Sim 1- NÃ£o',
  `hora_cadastro` time NOT NULL,
  `enviado` int(1) NOT NULL DEFAULT '0' COMMENT '0 - nÃ£o enviado 1- enviado',
  `identificador` varchar(5) NOT NULL,
  `pontos` int(11) NOT NULL,
  `jacomprou` int(11) NOT NULL,
  `id_convidou` int(10) unsigned NOT NULL,
  `captcha` varchar(200) NOT NULL,
  `confirmar_cadastro` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8947 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_cidade`
--

CREATE TABLE IF NOT EXISTS `cliente_cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_cidade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7692 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comercial`
--

CREATE TABLE IF NOT EXISTS `comercial` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `fone` varchar(14) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `edegraca_cidade`
--

CREATE TABLE IF NOT EXISTS `edegraca_cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_oferta` int(11) NOT NULL,
  `id_cidade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=170 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `cnpj` varchar(20) NOT NULL,
  `cep` int(10) unsigned DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `uf` varchar(2) NOT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `estado` varchar(50) NOT NULL,
  `complemento` varchar(50) DEFAULT NULL,
  `fone` varchar(14) NOT NULL,
  `descricao` text NOT NULL,
  `data_cadastro` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `num` varchar(10) NOT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  `site` varchar(100) NOT NULL,
  `id_comercial` int(11) NOT NULL,
  `nome_fantasia` varchar(200) NOT NULL,
  `mapa` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE IF NOT EXISTS `endereco` (
  `endereco_codigo` int(11) NOT NULL DEFAULT '0',
  `bairro_codigo` int(11) DEFAULT NULL,
  `endereco_cep` varchar(9) DEFAULT NULL,
  `endereco_logradouro` varchar(72) DEFAULT NULL,
  `endereco_complemento` varchar(72) DEFAULT NULL,
  PRIMARY KEY (`endereco_codigo`),
  KEY `bairro_codigo` (`bairro_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logo_login`
--

CREATE TABLE IF NOT EXISTS `logo_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `dia_hora` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `adm_cliente_comercial_parceiro` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2350 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsletter` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=193 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `oferta`
--

CREATE TABLE IF NOT EXISTS `oferta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_cidade_oferta` int(10) unsigned NOT NULL COMMENT 'Cidade da Oferta',
  `id_empresa` int(10) unsigned NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `valor` varchar(9) DEFAULT NULL,
  `qtd_minima` int(10) unsigned DEFAULT NULL,
  `qtd_maxima` int(10) unsigned DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_final` date DEFAULT NULL,
  `data_validade` date NOT NULL,
  `descricao` text NOT NULL,
  `ativa` int(1) unsigned DEFAULT '2' COMMENT '0 - Desativada | 1 - Ativada | 2 - cadastrada | 3 - invisivel',
  `desconto` varchar(5) NOT NULL,
  `valorpromocao` varchar(9) NOT NULL,
  `valordesconto` varchar(9) NOT NULL,
  `regras` text NOT NULL,
  `titulo` text NOT NULL,
  `ofertabonus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 - bonus 1- comum',
  `limite` int(11) NOT NULL,
  `destaque` int(1) NOT NULL COMMENT '0- não destaque | 1- destaque',
  `id_comercial` int(11) NOT NULL,
  `lucro` varchar(5) NOT NULL,
  `agendado` int(1) NOT NULL DEFAULT '0' COMMENT '0 - normal / 1 - exclusão agendada',
  `posicao` int(11) NOT NULL,
  `novaposicao` int(11) NOT NULL,
  `data_agendamento` date NOT NULL,
  PRIMARY KEY (`id`,`id_cidade_oferta`),
  KEY `oferta_FKIndex1` (`id_empresa`),
  KEY `oferta_FKIndex2` (`id_cidade_oferta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `oferta_cliente`
--

CREATE TABLE IF NOT EXISTS `oferta_cliente` (
  `id_oferta` int(10) unsigned NOT NULL,
  `id_cliente` int(10) unsigned NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher` varchar(8) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT '0' COMMENT '1 - Ativo / 0 - Desativado / 2 - utilizado',
  `comprou` int(1) NOT NULL,
  `data` date NOT NULL COMMENT 'data da utilizacao',
  `id_local` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `oferta_has_cliente_FKIndex1` (`id_oferta`),
  KEY `oferta_has_cliente_FKIndex2` (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4969 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `oferta_image`
--

CREATE TABLE IF NOT EXISTS `oferta_image` (
  `id_oferta_image` int(11) NOT NULL AUTO_INCREMENT,
  `id_oferta` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  PRIMARY KEY (`id_oferta_image`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=398 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `transpagseguro`
--

CREATE TABLE IF NOT EXISTS `transpagseguro` (
  `date` varchar(200) NOT NULL COMMENT 'Data da criação da transação',
  `lastEventDate` varchar(200) NOT NULL COMMENT 'Data do último evento da transação',
  `code` varchar(200) NOT NULL COMMENT 'Código identificador da transação',
  `reference` varchar(200) NOT NULL COMMENT 'Código de referência da transação',
  `type` varchar(200) NOT NULL COMMENT 'Tipo da transação',
  `status` varchar(200) NOT NULL COMMENT 'Status da transação',
  `paymentMethod` varchar(200) NOT NULL COMMENT 'Dados do meio de pagamento escolhido pelo comprador',
  `grossAmount` varchar(255) NOT NULL COMMENT 'Valor bruto da transação',
  `discountAmount` varchar(255) NOT NULL COMMENT 'Valor do desconto',
  `feeAmount` varchar(255) NOT NULL COMMENT 'Valor total das taxas cobradas',
  `netAmount` varchar(255) NOT NULL COMMENT 'Valor líquido da transação',
  `extraAmount` varchar(255) NOT NULL COMMENT 'Valor extra da transação',
  `installmentCount` int(11) NOT NULL COMMENT 'Número de parcelas que o comprador escolheu no pagamento com cartão de crédito',
  `items` varchar(200) NOT NULL COMMENT 'Lista de itens contidos na transação, cada item representa um objeto PagSeguroItem',
  `sender` varchar(200) NOT NULL COMMENT 'Dados do comprador',
  `shipping` varchar(200) NOT NULL COMMENT 'Dados do frete',
  `items_id` varchar(200) NOT NULL,
  `status_code` int(11) NOT NULL COMMENT '1 - Aguardando pagamento 2-Em análise 3-Paga 4-Disponível 5- disputa 6-Devolvida 7-Cancelada  ',
  `item_qtd` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `uf`
--

CREATE TABLE IF NOT EXISTS `uf` (
  `uf_codigo` int(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `uf_sigla` varchar(10) NOT NULL DEFAULT '',
  `uf_descricao` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`uf_codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
