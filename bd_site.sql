-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Jul-2026 às 19:41
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_site`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `datahora` datetime NOT NULL,
  `preco_total_carrinho` decimal(10,2) NOT NULL,
  `utilizador_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `carrinho`
--

INSERT INTO `carrinho` (`id`, `estado`, `datahora`, `preco_total_carrinho`, `utilizador_id`) VALUES
(3, 1, '2022-03-07 09:02:01', 315.36, 1),
(6, 1, '2022-03-07 09:05:06', 912.59, 1),
(7, 1, '2022-03-07 09:13:02', 435.35, 1),
(9, 1, '2025-12-15 12:51:39', 75.40, 11),
(10, 1, '2025-12-15 12:51:54', 150.80, 11),
(12, 1, '2025-12-15 12:53:22', 448.59, 11),
(18, 1, '2026-03-04 12:55:59', 29.99, 1),
(19, 1, '2026-03-20 23:36:26', 139.97, 1),
(20, 0, '0000-00-00 00:00:00', 334.91, 13),
(21, 1, '2026-03-21 00:20:35', 209.96, 1),
(23, 1, '2026-03-21 00:29:45', 69.98, 1),
(24, 1, '2026-03-21 01:56:14', 174.96, 1),
(25, 1, '2026-03-21 01:57:31', 39.99, 1),
(26, 1, '2026-03-21 01:58:06', 29.99, 1),
(27, 1, '2026-03-21 02:01:49', 29.99, 1),
(28, 1, '2026-03-21 02:04:41', 69.99, 1),
(29, 1, '2026-03-21 02:08:00', 29.99, 1),
(30, 1, '2026-03-21 02:10:23', 29.99, 1),
(31, 1, '2026-03-21 02:11:21', 29.99, 1),
(32, 1, '2026-03-21 02:12:18', 29.99, 1),
(33, 1, '2026-03-21 02:13:25', 29.99, 1),
(34, 1, '2026-03-21 02:15:37', 29.99, 1),
(35, 1, '2026-03-21 02:25:46', 29.99, 1),
(36, 1, '2026-03-21 02:25:58', 29.99, 1),
(37, 1, '2026-03-21 02:27:48', 29.99, 1),
(38, 1, '2026-03-21 02:28:46', 29.99, 1),
(39, 1, '2026-03-21 02:30:55', 29.99, 1),
(40, 1, '2026-03-21 02:44:10', 29.99, 1),
(41, 1, '2026-03-21 11:00:03', 29.99, 1),
(42, 1, '2026-03-21 11:06:08', 29.99, 1),
(43, 1, '2026-03-21 11:10:30', 29.99, 1),
(44, 1, '0000-00-00 00:00:00', 779.74, 1),
(45, 1, '2026-03-21 22:06:20', 29.99, 1),
(46, 1, '2026-03-21 22:08:57', 29.99, 1),
(47, 1, '2026-03-21 22:14:07', 29.99, 1),
(48, 1, '2026-03-21 22:17:54', 29.99, 1),
(49, 1, '2026-03-21 22:25:25', 29.99, 1),
(50, 1, '2026-03-22 19:25:08', 204.95, 1),
(51, 1, '2026-03-22 19:25:24', 39.99, 1),
(52, 1, '2026-03-22 19:25:36', 29.99, 1),
(53, 1, '2026-03-22 19:25:58', 29.99, 1),
(54, 1, '2026-03-22 21:10:07', 39.99, 1),
(55, 1, '2026-03-22 22:40:35', 59.99, 1),
(56, 1, '2026-03-22 22:40:58', 39.99, 1),
(57, 1, '2026-04-22 01:15:29', 39.99, 1),
(58, 1, '2026-03-22 22:44:17', 39.99, 37),
(59, 1, '2026-03-23 23:29:35', 59.99, 37),
(60, 1, '2026-03-24 09:31:43', 143.07, 37),
(61, 1, '2026-04-08 21:33:09', 39.99, 37),
(62, 1, '2026-04-08 21:33:59', 39.99, 37),
(63, 1, '2026-04-10 02:54:13', 39.99, 37),
(64, 1, '2026-04-11 01:37:03', 69.99, 37),
(65, 1, '2026-04-11 01:37:23', 69.99, 37),
(66, 1, '2026-04-22 01:17:03', 139.98, 37),
(67, 1, '2026-04-22 01:19:07', 104.98, 37),
(68, 1, '2026-07-11 00:06:45', 34.99, 37),
(69, 1, '2026-07-11 00:08:44', 39.99, 37),
(70, 1, '2026-07-11 00:27:51', 0.00, 37),
(71, 1, '2026-07-11 00:33:53', 69.99, 37),
(72, 1, '2026-07-11 00:35:29', 34.99, 37),
(73, 1, '2026-07-11 00:49:55', 34.99, 37),
(74, 1, '2026-07-11 00:53:53', 75.40, 37),
(75, 1, '2026-07-11 15:25:49', 75.40, 37),
(76, 1, '0000-00-00 00:00:00', 0.00, 37),
(77, 1, '0000-00-00 00:00:00', 0.00, 37),
(78, 1, '0000-00-00 00:00:00', 0.00, 37),
(79, 1, '0000-00-00 00:00:00', 0.00, 37),
(80, 1, '2026-07-11 16:05:32', 34.99, 37),
(81, 1, '2026-07-11 16:07:21', 135.39, 37),
(82, 1, '2026-07-11 16:11:53', 34.99, 37),
(83, 1, '2026-07-11 16:16:59', 110.39, 37),
(84, 0, '0000-00-00 00:00:00', 49.99, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho_itens`
--

CREATE TABLE `carrinho_itens` (
  `id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_total_itens` decimal(10,2) NOT NULL,
  `carrinho_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `carrinho_itens`
--

INSERT INTO `carrinho_itens` (`id`, `quantidade`, `preco_total_itens`, `carrinho_id`, `produto_id`) VALUES
(26, 1, 49.99, 84, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico_itens`
--

CREATE TABLE `historico_itens` (
  `id` int(11) NOT NULL,
  `carrinho_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `designacao` varchar(100) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_unit` decimal(10,2) NOT NULL,
  `preco_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `historico_itens`
--

INSERT INTO `historico_itens` (`id`, `carrinho_id`, `produto_id`, `designacao`, `imagem`, `quantidade`, `preco_unit`, `preco_total`) VALUES
(1, 82, 4, 'Sweater y2k', '', 1, 34.99, 34.99),
(2, 83, 4, 'Sweater y2k', '', 1, 34.99, 34.99),
(3, 83, 5, 'Sapatilhas Urban', '', 1, 75.40, 75.40);

-- --------------------------------------------------------

--
-- Estrutura da tabela `newsletter_campanhas`
--

CREATE TABLE `newsletter_campanhas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `data_criacao` datetime DEFAULT current_timestamp(),
  `enviada` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `newsletter_campanhas`
--

INSERT INTO `newsletter_campanhas` (`id`, `titulo`, `mensagem`, `data_criacao`, `enviada`) VALUES
(1, 'Promoção Teste', '20% desconto em todos os produtos até domingo!', '2026-03-02 14:50:09', 1),
(2, 'teste', 'testea', '2026-03-02 15:31:32', 1),
(3, 'teste', 'teste', '2026-03-02 15:34:52', 1),
(5, 'teste', 'teste', '2026-03-02 15:42:15', 1),
(6, 'tes', 'tes', '2026-03-02 15:45:31', 1),
(7, 'tes', 'tes', '2026-03-02 15:46:22', 1),
(8, 'teste', 'teste', '2026-03-02 15:55:03', 1),
(9, 'teste', 'teste', '2026-03-02 17:08:05', 1),
(10, '25% desconto', 'desconto exclusivo', '2026-03-02 21:22:50', 1),
(11, '25% de desconto em todas as camisolas', '25% de desconto em todas as camisolas', '2026-03-03 08:50:29', 1),
(12, 'teste', 'teste', '2026-03-03 09:52:19', 1),
(13, 'teste', 'teste', '2026-03-03 10:02:51', 1),
(14, 'teSte', 'teSte', '2026-03-03 10:05:53', 1),
(15, 'teste', 'teste', '2026-03-03 10:08:18', 1),
(16, 'teste', 'teste', '2026-03-03 10:09:10', 1),
(17, 'teste', 'teste', '2026-03-04 09:39:20', 1),
(18, '25% de promoção em todos os artigos!', 'Limite ao stock já existente.', '2026-03-04 09:45:06', 1),
(19, 'teste19', 'teste19', '2026-03-18 00:17:05', 1),
(20, 'teste20', 'qew', '2026-03-18 00:23:37', 1),
(21, 'teste21', 'rqaw', '2026-03-18 00:24:32', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `newsletter_subscritores`
--

CREATE TABLE `newsletter_subscritores` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ativo` tinyint(4) DEFAULT 1,
  `data_subscricao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `newsletter_subscritores`
--

INSERT INTO `newsletter_subscritores` (`id`, `email`, `ativo`, `data_subscricao`) VALUES
(1, 'alexandre.moreira.paulino@gmail.com', 1, '2026-02-22 17:36:43'),
(6, 'sigma67@gmail.com', 1, '2026-02-27 22:42:21'),
(7, 'aaaa@gmail.com', 1, '2026-03-02 15:57:24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `designacao` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `tamanho` varchar(100) DEFAULT NULL,
  `composicao` varchar(100) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `detalhes` varchar(100) DEFAULT NULL,
  `tipo_desenho` varchar(100) DEFAULT NULL,
  `estilo` varchar(100) DEFAULT NULL,
  `elasticidade` varchar(50) DEFAULT NULL,
  `tipo_ajuste` varchar(50) DEFAULT NULL,
  `comprimento_manga` varchar(50) DEFAULT NULL,
  `vendidos` int(11) DEFAULT 0,
  `stock` int(11) DEFAULT 10,
  `descricao_en` varchar(500) DEFAULT NULL,
  `designacao_en` varchar(50) DEFAULT NULL,
  `categoria_en` varchar(50) DEFAULT NULL,
  `composicao_en` varchar(100) DEFAULT NULL,
  `cor_en` varchar(50) DEFAULT NULL,
  `material_en` varchar(100) DEFAULT NULL,
  `estilo_en` varchar(100) DEFAULT NULL,
  `elasticidade_en` varchar(50) DEFAULT NULL,
  `tipo_ajuste_en` varchar(50) DEFAULT NULL,
  `comprimento_manga_en` varchar(50) DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `designacao`, `descricao`, `imagem`, `preco`, `categoria`, `tamanho`, `composicao`, `cor`, `material`, `detalhes`, `tipo_desenho`, `estilo`, `elasticidade`, `tipo_ajuste`, `comprimento_manga`, `vendidos`, `stock`, `descricao_en`, `designacao_en`, `categoria_en`, `composicao_en`, `cor_en`, `material_en`, `estilo_en`, `elasticidade_en`, `tipo_ajuste_en`, `comprimento_manga_en`, `genero`) VALUES
(1, 'Hoodie Oversized \"Pocket Money\"', 'Hoodie streetwear em preto com um design gráfico de grande dimensão nas costas. A ilustração apresenta um urso de peluche com traços de graffiti (olhos em \'X\' e \'@\'), a usar uma coroa dourada, correntes e a segurar notas. À volta do urso, destacam-se letras em estilo \"hype\" com as palavras \"MUMAN\", um diamante, um símbolo de cifrão ($) e a frase \"POCKET MONEY - NO FRIENDS NO DREAMS NO POCKET MONEY SO I\'M GONNA KEEP MOVIN\" em tons vibrantes de amarelo, vermelho e branco.', 'sweaterstreetindex.png', 39.99, 'camisas', 'XS, S, M, L, XL, XXL', '70% Algodão, 30% Poliéster', 'Preto', 'Misturas de Algodão', 'Nenhum', 'Impressão Completa', 'Casual', 'Stretch Médio', 'Oversized', 'Manga Comprida', 41, 22, 'Black streetwear hoodie featuring a large graphic design on the back. The illustration shows a teddy bear with graffiti-style features (\'X\' and \'@\' eyes), wearing a golden crown, chains, and holding cash. Surrounding the bear are hype-style text elements with the words \"MUMAN\", a diamond, a dollar sign ($), and the quote \"POCKET MONEY - NO FRIENDS NO DREAMS NO POCKET MONEY SO I\'M GONNA KEEP MOVIN\" in vibrant yellow, red, and white tones.', '\"Pocket Money\" Oversized Hoodie', 'camisas', '70% Cotton, 30% Polyester', 'Black', 'Cotton Blends', 'Casual', 'Medium Stretch', 'Oversized', 'Long Sleeve', 'Homem'),
(2, 'Calças de Ganga Baggy \"Cyber Flame\"', 'Calças de ganga streetwear com corte baggy e lavagem clara estonada. O grande destaque vai para a perna esquerda, que apresenta um bordado detalhado e estilizado de chamas em tons de vermelho escuro e contornos tribais a branco, conferindo uma estética retro Y2K e cyberpunk. Inclui detalhes ligeiramente rasgados nos bolsos frontais.', 'indexcalcas.png', 49.99, 'Braceletes', 'X', '100% Algodão', 'Preto', 'Algodão', 'Rasgado', 'Padrão Texturizado', 'Casual', 'Não Estirável', 'Solto', 'Nenhum', 18, 15, 'Streetwear baggy denim jeans in a light washed colorway. The main feature is on the left leg, showcasing a detailed, stylized flame embroidery in dark red tones alongside white tribal outlines, bringing a strong retro Y2K and cyberpunk aesthetic. Includes subtle distressed detailing on the front pockets.', '\"Cyber Flame\" Baggy Denim Jeans', 'calças', '100% Cotton', 'Blue', 'Cotton', 'Casual', 'Non-Stretch', 'Loose', 'None', 'Homem'),
(3, 'Hoodie Full-Zip \"Star Dynamic\"', 'Hoodie streetwear premium de corte oversized em preto, totalmente estampado com um padrão dinâmico de estrelas e relâmpagos em branco contrastante. Inclui fecho central completo (full-zip) que sobe até ao capuz, bolsos frontais estilo canguru e acabamentos elásticos nos punhos e cintura. Perfeito para um look urbano arrojado e moderno.', 'sweaterindex2.png', 44.99, 'sweaters', 'XS', '80% Algodão, 20% Poliéster', 'Preto e Branco', 'Algodão Premium', 'Padrão total de estrelas, fecho completo até ao capuz', 'Estampa Total (All-over Print)', 'Streetwear / Hype', 'Stretch Ligeiro', 'Oversized', 'Manga Comprida', 19, 15, 'Premium oversized black streetwear hoodie, fully printed with a dynamic contrasting white star and lightning bolt pattern. Features a full-zip closure that goes all the way up the hood, front kangaroo pockets, and ribbed cuffs and hem. Perfect for a bold, modern urban look.', '\"Star Dynamic\" Full-Zip Hoodie', 'sweaters', '80% Cotton, 20% Polyester', 'Black and White', 'Premium Cotton', 'Streetwear / Hype', 'Slight Stretch', 'Oversized', 'Long Sleeve', 'Homem'),
(4, 'Jeans Baggy Distressed \"Spider Grunge\"', 'Calças de ganga streetwear em tom cinzento-escuro com lavagem desgastada (acid wash) e corte ultra-baggy. O grande destaque vai para os detalhes frontais desfiados em camadas que remetem a uma teia de aranha com acabamento \"raw edge\". Conta com bolsos profundos, perna larga e caimento pesado, ideal para a estética underground.', 'calcasbaddyindex.png', 49.99, 'calcas', 'S', '100% Algodão', 'Cinzento Escuro', 'Ganga Denim', 'Detalhes desfiados frontais estilo teia de aranha, lavagem acid wash, corte baggy', 'Texturado / Desfiado', 'Streetwear / Grunge', 'Sem Elasticidade', 'Baggy', 'Não Aplicável', 21, 12, 'Dark grey acid-washed streetwear denim jeans with an ultra-baggy fit. Features heavy front distressing with layered frayed details mimicking a spider web with a raw-edge finish. Built with deep pockets, wide leg, and a heavy drop, perfect for the underground aesthetic.', '\"Spider Grunge\" Distressed Baggy Jeans', 'pants', '100% Cotton', 'Dark Grey', 'Denim', 'Streetwear / Grunge', 'Non-Stretch', 'Baggy', 'Not Applicable', 'Homem'),
(5, 'T-Shirt Oversized \"Metal Chrome\"', 'T-shirt streetwear em preto de corte oversized, com ombro descaído e gola redonda fechada. Apresenta uma estampa gráfica frontal de estilo metal underground com efeito cromado e metalizado tridimensional em tons de prata. Confeccionada em algodão pesado de alta qualidade para um caimento perfeito e estruturado.', 'camisolaindex.png', 29.99, 'camisas', 'M', '100% Algodão Heavyweight', 'Preto', 'Algodão Premium', 'Gráfico frontal cromado, ombros descaídos, gola redonda grossa', 'Estampa Frontal (Efeito Cromado)', 'Streetwear / Cyberpunk / Metal', 'Stretch Ligeiro', 'Oversized', 'Manga Curta', 6, 25, 'Black oversized streetwear t-shirt featuring a dropped shoulder and a tight crew neck. Displays a front metal-underground style graphic print with a three-dimensional metallic chrome effect in silver tones. Crafted from high-quality heavy cotton for a perfect, structured drape.', '\"Metal Chrome\" Oversized T-Shirt', 'camisas', '100% Heavyweight Cotton', 'Black', 'Premium Cotton', 'Streetwear / Cyberpunk / Metal', 'Slight Stretch', 'Oversized', 'Short Sleeve', 'Homem'),
(6, 'Top Assimétrico Grunge Rock \"Guitar Graphic\"', 'Top feminino cinzento com lavagem texturada e corte assimétrico com ombro descaído e alça dupla preta. Destaca-se pelo padrão gráfico frontal de uma guitarra com tipografia gótica texturada e estrelas. Tecido leve, confortável e com caimento ajustado, ideal para um visual alt-rock ou Y2K underground.', 'roupamulher1.png', 24.99, 'tshirts-tops', 'S', '95% Poliéster, 5% Elastano', 'Cinzento / Preto', 'Malha Texturada', 'Ombro assimétrico descaído, alças duplas integradas, estampado gráfico frontal de guitarra e estrela', 'Estampado Gráfico / Rock', 'Casual', 'Elasticidade Ligeira', 'Ajustado', 'Manga Curta', 3, 15, 'Womens grey textured top featuring an asymmetric cold-shoulder cut with double black straps. Stands out with its front graphic print of a guitar, gothic typography, and star details. Lightweight, comfortable fabric with a slim fit, perfect for an alt-rock or Y2K underground look.', '\"Guitar Graphic\" Asymmetric Grunge Rock Top', 'tshirts-tops', '95% Polyester, 5% Spandex', 'Grey / Black', 'Textured Knit', 'Casual', 'Slight Stretch', 'Slim Fit', 'Short Sleeve', 'Mulher'),
(7, 'T-shirt Oversized Grunge \"Barbed Wire Heart\"', 'T-shirt feminina preta com corte largo (oversized) e caimento descontraído. Apresenta um estampado gráfico central em destaque com um coração envolvido por arame farpado e tipografia de estilo gótico/grunge. Conecionada em algodão macio, ideal para compor looks urbanos e alternativos.', 'roupamulher2.png', 22.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto / Branco', 'Algodão', 'Corte oversized largo, gola redonda, estampado frontal de coração com arame farpado', 'Estampado Gráfico / Escuro', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Curta', 1, 20, 'Womens black oversized t-shirt with a loose, relaxed fit. Features a prominent center graphic print of a heart wrapped in barbed wire and gothic/grunge style typography. Made from soft cotton, perfect for building urban and alternative outfits.', '\"Barbed Wire Heart\" Grunge Oversized T-shirt', 'tshirts-tops', '100% Cotton', 'Black / White', 'Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Short Sleeve', 'Mulher'),
(8, 'Hoodie Oversized Heavy Grunge \"Metalcore Graphic\"', 'Sweater com capuz masculina em tom preto opaco com corte ultra-baggy e ombros caídos. Destaca-se pelo grande estampado frontal gráfico abstrato de inspiração metalcore/heavy grunge com detalhes de ramificações espinhosas e tipografia underground. Confecionado em algodão pesado com interior cardado, ideal para o inverno.', 'roupahomem3.png', 44.99, 'casacos-hoodies', 'XL', '80% Algodão, 20% Poliéster', 'Preto / Cinzento', 'Algodão Pesado Cardado', 'Corte oversized com ombro descaído, capuz integrado sem cordões, estampado frontal abstrato estilo m', 'Estampado Gráfico / Heavy Grunge', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Comprida', 0, 10, 'Mens black hooded sweatshirt featuring an ultra-baggy fit and dropped shoulders. It stands out with its large abstract front graphic print inspired by metalcore/heavy grunge aesthetics, with thorny details and underground typography. Made from heavy fleece-lined cotton, perfect for colder seasons.', '\"Metalcore Graphic\" Heavy Grunge Oversized Hoodie', 'jackets-hoodies', '80% Cotton, 20% Polyester', 'Black / Grey', 'Heavyweight Fleece Denim', 'Casual', 'Slight Stretch', 'Oversized', 'Long Sleeve', 'Homem'),
(9, 'Hoodie 2-em-1 Pastel Goth \"Trick or Treat\"', 'Hoodie feminino preto com design de sobreposição falso 2-em-1, apresentando mangas compridas com padrão de riscas roxas e pretas. Destaca-se pelo estampado frontal vibrante de estilo anime/kawaii com a frase \"Trick or Treat\", fantasmas e uma personagem com chapéu de bruxa. Confecionado em malha confortável, ideal para a estética e-girl e J-fashion alternada.', 'roupamulher4.png', 39.99, 'casacos-hoodies', 'XXL', '65% Algodão, 35% Poliéster', 'Preto / Roxo', 'Algodão / Poliéster', 'Mangas duplas sobrepostas às riscas roxas e pretas, capuz integrado com cordão roxo, estampado front', 'Estampado Gráfico / Anime / Halloween', 'Casual', 'Elasticidade Ligeira', 'Largo', 'Manga Comprida', 0, 14, 'Womens black hoodie with a faux 2-in-1 layered design, featuring purple and black striped long sleeves. Stands out with its vibrant front anime/kawaii style graphic print with the phrase \"Trick or Treat\", ghosts, and a witch-hat character. Made from comfortable knit fabric, perfect for e-girl and alternative J-fashion aesthetics.', '\"Trick or Treat\" Pastel Goth 2-in-1 Hoodie', 'jackets-hoodies', '65% Cotton, 35% Polyester', 'Black / Purple', 'Cotton / Polyester', 'Casual', 'Slight Stretch', 'Loose Fit', 'Long Sleeve', 'Mulher'),
(10, 'Calças Cargo Streetwear \"Cyber Utility\"', 'Calças cargo femininas em tom preto opaco com corte descontraído estilo jogger. Destacam-se pelos múltiplos bolsos utilitários nas laterais, fechos de correr decorativos prateados e cintura elástica ajustável com cordão. Os punhos elásticos nos tornozelos criam um caimento perfeito para destacar as botas ou sapatilhas, ideal para a estética techwear urbana.', 'roupamulher5.png', 34.99, 'calcas', 'L', '100% Poliéster', 'Preto', 'Poliéster / Tecido Técnico', 'Bolsos cargo laterais com lapela, fechos prateados funcionais, cintura e punhos elásticos', 'Liso com Detalhes Metálicos', 'Casual', 'Sem Elasticidade', 'Corte Regular / Jogger', 'Não Aplicável', 0, 18, 'Womens black cargo pants with a relaxed jogger-style fit. Features multiple utility pockets on the sides, decorative silver zippers, and an adjustable elastic waistband with a drawstring. The elastic ankle cuffs provide a perfect fit to showcase boots or sneakers, ideal for a techwear and urban aesthetic.', '\"Cyber Utility\" Streetwear Cargo Pants', 'pants', '100% Polyester', 'Black', 'Polyester / Technical Fabric', 'Casual', 'Non-Stretch', 'Regular Fit / Jogger', 'Not Applicable', 'Mulher'),
(11, 'Top Falso 2-em-1 Grunge \"Lace-Up Cold Shoulder\"', 'Top feminino com design de sobreposição falso 2-em-1, composto por uma base interior branca e uma camada exterior preta de ombros descaídos. Destaca-se pelos atacadores cruzados na zona do decote, cordões ajustáveis nas bainhas laterais e estampados gráficos de estilo urbano alternativo com laços e grafites abstratos.', 'camisolamulher6.png', 29.99, 'tshirts-tops', 'M', '90% Poliéster, 10% Elastano', 'Preto / Branco', 'Malha Fina Confortável', 'Design sobreposto falso 2-em-1, ombros descobertos, decote com atacadores cruzados, cordões de ajust', 'Estampado Gráfico / Urbano Alternativo', 'Casual', 'Elasticidade Ligeira', 'Corte Regular / Ajustável', 'Manga Curta', 0, 16, 'Womens faux 2-in-1 layered top featuring a white inner tank layer and a black cold-shoulder outer layer. It stands out with its front lace-up detailing, adjustable side drawstrings, and alternative urban graphic prints with bows and abstract graffiti elements.', '\"Lace-Up Cold Shoulder\" Faux 2-in-1 Grunge Top', 'tshirts-tops', '90% Polyester, 10% Spandex', 'Black / White', 'Soft Fine Knit', 'Casual', 'Slight Stretch', 'Regular Fit / Adjustable', 'Short Sleeve', 'Mulher'),
(12, 'Calças de Ganga Baggy \"Distressed Star Patches\"', 'Calças de ganga femininas em tom cinzento-escuro com lavagem desgastada e corte ultra-baggy com perna larga. Destacam-se pelas aplicações frontais em formato de estrela com acabamento desfiado (raw edge) em relevo. Conta com cintura elástica confortável e caimento pesado, perfeitas para a estética streetwear Y2K.', 'roupamulher7.png', 45.99, 'calcas', 'M', '100% Algodão', 'Cinzento Escuro / Preto', 'Ganga Denim', 'Corte largo baggy, aplicações desfiadas em formato de estrela, cintura elástica, lavagem acid wash', 'Texturado / Aplicações de Estrelas', 'Casual', 'Sem Elasticidade', 'Baggy', 'Não Aplicável', 0, 12, 'Womens dark grey acid-washed denim jeans with an ultra-baggy wide-leg fit. Features front star patches with a raw-edge frayed finish. Built with a comfortable elastic waistband and a heavy drop, perfect for the Y2K streetwear aesthetic.', '\"Distressed Star Patches\" Baggy Denim Jeans', 'pants', '100% Cotton', 'Dark Grey / Black', 'Denim', 'Casual', 'Non-Stretch', 'Baggy', 'Not Applicable', 'Mulher'),
(13, 'Sweater Jacquard Tapestry \"Kirara Anime Graphic\"', 'Sweater feminina preta de gola redonda com mangas lisas e um painel frontal exclusivo confecionado em tapeçaria jacquard tecida. Apresenta um design gráfico texturado de inspiração anime e manga underground com uma personagem marcante em tons quentes. Uma peça pesada e artística, ideal para destacar qualquer visual streetwear.', 'roupamulher8.png', 49.99, 'casacos-hoodies', 'XXL', '70% Algodão, 30% Poliéster', 'Preto / Multicolor', 'Algodão / Painel de Tapeçaria Tecida', 'Painel frontal em tapeçaria texturada jacquard, gola redonda elástica, punhos ajustados', 'Tapeçaria Tecida / Gráfico Anime', 'Casual', 'Elasticidade Ligeira', 'Corte Regular / Confortável', 'Manga Comprida', 0, 8, 'Womens black crewneck sweatshirt featuring smooth sleeves and an exclusive front panel made from woven jacquard tapestry. Displays a textured graphic design inspired by underground anime and manga aesthetics with a bold character in warm tones. A heavy, artistic piece perfect for standing out in streetwear.', '\"Kirara Anime Graphic\" Jacquard Tapestry Sweater', 'jackets-hoodies', '70% Cotton, 30% Polyester', 'Black / Multi-color', 'Cotton / Woven Tapestry Panel', 'Casual', 'Slight Stretch', 'Regular Fit / Comfortable', 'Long Sleeve', 'Mulher'),
(14, 'T-shirt Streetwear \"Uzumaki Horror Manga\"', 'T-shirt masculina preta com corte regular e caimento pesado de estilo urbano. Destaca-se pelo grande estampado gráfico frontal detalhado com painéis de manga de terror, tipografia japonesa e fortes contrastes em tons de vermelho, branco e preto. Confecionada em algodão macio de alta qualidade, ideal para os fãs da estética underground e anime obscuro.', 'roupahomem11.png', 26.99, 'tshirts-tops', 'L', '100% Algodão', 'Preto / Vermelho', 'Algodão', 'Estampado gráfico frontal integral estilo painel de manga, gola redonda elástica, etiqueta na manga', 'Estampado Gráfico / Manga de Terror', 'Casual', 'Elasticidade Ligeira', 'Corte Regular / Streetwear', 'Manga Curta', 0, 15, 'Mens black t-shirt with a regular fit and a heavy streetwear drop. Features a large, detailed front graphic print with horror manga panels, Japanese typography, and sharp contrasts in red, white, and black tones. Made from high-quality soft cotton, perfect for fans of underground and dark anime aesthetics.', '\"Uzumaki Horror Manga\" Streetwear T-shirt', 'tshirts-tops', '100% Cotton', 'Black / Red', 'Cotton', 'Casual', 'Slight Stretch', 'Regular Fit / Streetwear', 'Short Sleeve', 'Homem'),
(15, 'T-shirt Oversized Heavy Metal \"Misfit Skull\"', 'T-shirt masculina com lavagem escura desgastada (washed black) e corte largo estilo oversized com perna e mangas amplas. Destaca-se pelo estampado gráfico frontal marcante com uma caveira repleta de picos metálicos, estrelas pontiagudas e tipografia com estética heavy metal e grunge. Confecionada em algodão pesado de caimento estruturado e confortável.', 'roupahomem12.png', 28.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto Desgastado', 'Algodão Pesado Desgastado', 'Lavagem acid wash/desgastada, corte oversized com ombro descaído, estampado frontal de caveira e pic', 'Estampado Gráfico / Heavy Metal / Grunge', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Curta', 0, 12, 'Mens washed black t-shirt featuring a heavy oversized fit with loose sleeves. It stands out with its bold front graphic print of a skull covered in metallic spikes, sharp stars, and heavy metal grunge typography. Made from heavyweight cotton with a structured and comfortable drop.', '\"Misfit Skull\" Heavy Metal Oversized T-shirt', 'tshirts-tops', '100% Cotton', 'Washed Black', 'Washed Heavyweight Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Short Sleeve', 'Homem'),
(16, 'T-shirt Oversized Grunge \"Winged Skeleton\"', 'T-shirt masculina preta com corte oversized e caimento descontraído de estilo urbano. Apresenta um estampado gráfico frontal de alto contraste a branco com um esqueleto alado detalhado. Confecionada em algodão macio, ideal para compor looks alternativos, grunge ou streetwear underground com forte impacto visual.', 'roupahomem13.png', 24.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto / Branco', 'Algodão', 'Corte oversized largo, gola redonda elástica, estampado frontal de esqueleto com asas em serigrafia ', 'Estampado Gráfico / Grunge / Esqueleto', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Curta', 0, 14, 'Mens black oversized t-shirt with a loose, relaxed fit. Features a high-contrast white front graphic print of a detailed winged skeleton. Made from soft cotton, perfect for building alternative, grunge, or underground streetwear outfits with a bold visual impact.', '\"Winged Skeleton\" Grunge Oversized T-shirt', 'tshirts-tops', '100% Cotton', 'Black / White', 'Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Short Sleeve', 'Homem'),
(17, 'T-shirt Oversized Gothic Anime \"Loretta Graphic\"', 'T-shirt feminina com lavagem escura desgastada (washed black) e corte largo estilo oversized com mangas amplas. Destaca-se pelo marcante estampado gráfico frontal de estilo anime gótico (gothcore), apresentando uma personagem com asas de morcego e moldura ornamentada acompanhada da tipografia \"loretta oh loretta\". Confecionada em algodão pesado de toque macio e caimento estruturado.', 'roupamulher14.png', 27.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto Desgastado', 'Algodão Pesado Desgastado', 'Lavagem acid wash/desgastada, corte oversized com ombro descaído, estampado frontal estilo anime gót', 'Estampado Gráfico / Anime Gótico / Gothcore', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Curta', 0, 16, 'Womens washed black t-shirt featuring a relaxed oversized fit and wide sleeves. Stands out with its striking front gothic anime (gothcore) graphic print, displaying a character with bat wings and an ornate frame accompanied by \"loretta oh loretta\" typography. Made from heavy, soft cotton providing a structured drape.', '\"Loretta Graphic\" Gothic Anime Oversized T-shirt', 'tshirts-tops', '100% Cotton', 'Washed Black', 'Washed Heavyweight Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Short Sleeve', 'Mulher'),
(18, 'T-shirt Slim Fit Anime \"Goth Halftone\"', 'T-shirt feminina branca com corte ajustado estilo baby tee. Apresenta um impressionante estampado gráfico frontal em contraste preto com efeito halftone (linhas de meio-tom), destacando uma personagem de anime gótico com estética Y2K, detalhes de caveira e tipografia vertical clássica. Confecionada em malha de algodão macio de toque confortável.', 'roupamulher16.png', 22.99, 'tshirts-tops', 'S', '95% Algodão, 5% Elastano', 'Branco / Preto', 'Algodão / Malha Elástica', 'Corte baby tee ajustado, gola redonda fina, estampado frontal estilo manga gótica com efeito de linh', 'Estampado Gráfico / Anime / Halftone', 'Casual', 'Elasticidade Ligeira', 'Ajustado / Slim Fit', 'Manga Curta', 0, 15, 'Womens white slim-fit t-shirt in a baby tee style. Features a striking black front graphic print with a halftone line effect, showcasing a gothic anime character with a Y2K aesthetic, skull details, and vertical gothic typography. Made from soft and comfortable cotton knit.', '\"Goth Halftone\" Anime Slim Fit T-shirt', 'tshirts-tops', '95% Cotton, 5% Spandex', 'White / Black', 'Cotton / Stretch Knit', 'Casual', 'Slight Stretch', 'Slim Fit', 'Short Sleeve', 'Mulher'),
(19, 'T-shirt Oversized Grunge \"Red Angel\"', 'T-shirt feminina preta com corte largo estilo oversized e caimento descontraído de estética streetwear. Destaca-se pelo estampado gráfico frontal em tom vermelho intenso com a palavra \"angel\" em tipografia grunge/metal de efeito derretido e uma auréola linear. Confecionada em malha de algodão macio, ideal para compor visuais urbanos e alternativos.', 'camisolamulher17.png', 23.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto / Vermelho', 'Algodão', 'Corte oversized largo, gola redonda clássica, estampado frontal texturado em serigrafia de alto cont', 'Estampado Gráfico / Metal / Grunge', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Curta', 0, 18, 'Womens black oversized t-shirt featuring a loose, relaxed fit and streetwear aesthetic. Stands out with its vibrant red front graphic print displaying the word \"angel\" in a melting grunge metal typography topped with a linear halo. Made from soft cotton knit, perfect for alternative urban outfits.', '\"Red Angel\" Grunge Oversized T-shirt', 'tshirts-tops', '100% Cotton', 'Black / Red', 'Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Short Sleeve', 'Mulher'),
(20, 'T-shirt Oversized Gothic \"Afraid of Death\"', 'T-shirt masculina preta com corte largo estilo oversized e caimento pesado de estética streetwear. Destaca-se pelo estampado gráfico frontal centralizado em tom vermelho escuro, apresentando uma ilustração texturada de uma caveira encapuzada acompanhada da frase gótica \"Dont live life being afraid of death\". Confecionada em malha de algodão macio de alta qualidade.', 'camisolahomem19.png', 25.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto / Vermelho', 'Algodão Pesado', 'Corte oversized com ombro descaído, gola redonda elástica, estampado frontal em serigrafia de alto c', 'Estampado Gráfico / Gótico / Caveira', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Curta', 0, 15, 'Mens black oversized t-shirt featuring a loose fit and a heavy streetwear drop. Stands out with its dark red center front graphic print, displaying a textured illustration of a hooded skull accompanied by the gothic phrase \"Dont live life being afraid of death\". Made from high-quality soft cotton knit.', '\"Afraid of Death\" Gothic Oversized T-shirt', 'tshirts-tops', '100% Cotton', 'Black / Red', 'Heavyweight Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Short Sleeve', 'Homem'),
(21, 'T-shirt Oversized Pastel Goth \"Demon Anime Girl\"', 'T-shirt feminina preta com corte largo estilo oversized e caimento descontraído de estética urbana. Destaca-se pelo grande estampado gráfico frontal de estilo anime alternativo e pastel goth, apresentando uma personagem demoníaca com cornos em tons suaves de rosa, lilás e preto, rodeada por nuvens estilizadas e estrelas. Confecionada em malha de algodão macio e confortável.', 'roupamulher21.png', 24.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto / Rosa / Lilás', 'Algodão', 'Corte oversized largo, gola redonda clássica, estampado frontal durável em serigrafia de tons pastel', 'Estampado Gráfico / Anime / Pastel Goth', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Curta', 0, 14, 'Womens black oversized t-shirt featuring a loose fit and relaxed streetwear aesthetic. Stands out with its large front anime and pastel goth style graphic print, displaying a demon girl character with horns in soft pink, purple, and black tones, surrounded by stylized clouds and stars. Made from soft and comfortable cotton knit.', '\"Demon Anime Girl\" Pastel Goth Oversized T-shirt', 'tshirts-tops', '100% Cotton', 'Black / Pink / Purple', 'Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Short Sleeve', 'Mulher'),
(22, 'T-shirt Streetwear \"Cyberpunk Anime Girl\"', 'T-shirt masculina preta com lavagem ligeiramente desgastada e corte regular de estilo urbano. Destaca-se pelo estampado gráfico frontal de estilo anime underground e cyberpunk, apresentando uma personagem feminina com detalhes e mechas em rosa vibrante, envolvida em fumo estilizado e carateres japoneses verticais. Confecionada em malha de algodão macio e caimento estruturado.', 'roupahomem22.png', 26.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto Desgastado / Rosa', 'Algodão Desgastado', 'Corte regular streetwear, gola redonda elástica, estampado frontal em serigrafia de alta durabilidad', 'Estampado Gráfico / Anime / Cyberpunk', 'Casual', 'Elasticidade Ligeira', 'Corte Regular / Streetwear', 'Manga Curta', 0, 14, 'Mens black t-shirt with a slight washed effect and a regular streetwear fit. Features a front graphic print in an underground anime and cyberpunk style, displaying a female character with vibrant pink highlights, surrounded by stylized smoke and vertical Japanese characters. Made from soft cotton knit with a structured drape.', '\"Cyberpunk Anime Girl\" Streetwear T-shirt', 'tshirts-tops', '100% Cotton', 'Washed Black / Pink', 'Washed Cotton', 'Casual', 'Slight Stretch', 'Regular Fit / Streetwear', 'Short Sleeve', 'Homem'),
(23, 'T-shirt Casual Pop-Anime \"Cyber Neon Beast\"', 'T-shirt feminina preta com corte regular e caimento confortável. Destaca-se pelo marcante e colorido estampado gráfico frontal em formato retangular, misturando a estética pop-art underground com anime psicadélico. Apresenta uma personagem de cabelos azul-turquesa e olhos expressivos sob um adereço de criatura estilizada em tons rosa-neon e amarelo, acompanhada por carateres tipográficos urbanos.', 'roupamulher23.png', 24.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto / Rosa Neon / Azul Turquesa', 'Algodão', 'Corte regular confortável, gola redonda fina, estampado frontal retangular em serigrafia digital de ', 'Estampado Gráfico / Anime Psicadélico / Pop-Art', 'Casual', 'Elasticidade Ligeira', 'Corte Regular / Confortável', 'Manga Curta', 0, 16, 'Womens black t-shirt with a regular fit and comfortable drape. Features a striking, colorful rectangular front graphic print, blending underground pop-art with psychedelic anime aesthetics. Displays a turquoise-haired character with expressive eyes under a pink-neon and yellow stylized beast headpiece, accompanied by urban typography.', '\"Cyber Neon Beast\" Pop-Anime Casual T-shirt', 'tshirts-tops', '100% Cotton', 'Black / Neon Pink / Turquoise', 'Cotton', 'Casual', 'Slight Stretch', 'Regular Fit', 'Short Sleeve', 'Mulher'),
(24, 'T-shirt Streetwear Gothic \"Succubus\"', 'T-shirt feminina preta com corte regular e caimento estruturado de estilo urbano alternativo. Destaca-se pelo impactante estampado gráfico frontal de estética dark anime e metal, ilustrando uma figura mitológica de uma súcubo com asas e capuz, rodeada por efeitos de salpicos em vermelho vivo e a palavra \"SUCCUBUS\" numa tipografia gótica agressiva. Confecionada em malha de algodão macio de alta qualidade.', 'roupamulher24.png', 25.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto / Vermelho', 'Algodão', 'Corte regular streetwear, gola redonda clássica, estampado frontal texturado em serigrafia de alto c', 'Estampado Gráfico / Dark Anime / Gótico / Metal', 'Casual', 'Elasticidade Ligeira', 'Corte Regular', 'Manga Curta', 0, 15, 'Womens black t-shirt with a regular streetwear fit and structured drape. Stands out with its striking front graphic print in a dark anime and metal aesthetic, displaying a mythological succubus figure with wings and a hood, surrounded by bright red splatter effects and the word \"SUCCUBUS\" in an aggressive gothic typography. Made from high-quality soft cotton knit.', '\"Succubus\" Gothic Streetwear T-shirt', 'tshirts-tops', '100% Cotton', 'Black / Red', 'Cotton', 'Casual', 'Slight Stretch', 'Regular Fit', 'Short Sleeve', 'Mulher'),
(25, 'T-shirt Casual Gothic \"Occult Horned Figure\"', 'T-shirt feminina preta com corte regular e caimento confortável de estilo urbano alternativo. Destaca-se pelo marcante estampado gráfico frontal de estética oculta e metal, ilustrando uma figura feminina com grandes cornos texturados e traços esqueléticos abstratos, sobreposta a um pentagrama vermelho de linhas geométricas. Confecionada em malha de algodão macio de alta durabilidade.', 'roupamulher25.png', 26.99, 'tshirts-tops', 'S', '100% Algodão', 'Preto / Vermelho / Branco', 'Algodão', 'Corte regular confortável, gola redonda clássica, estampado frontal centralizado em serigrafia com f', 'Estampado Gráfico / Gótico / Oculto / Metal', 'Casual', 'Elasticidade Ligeira', 'Corte Regular', 'Manga Curta', 0, 12, 'Womens black t-shirt with a regular fit and comfortable drape in an alternative urban aesthetic. Stands out with its striking front graphic print in an occult and metal aesthetic, displaying a female figure with large textured horns and abstract skeletal details, layered over a sharp red pentagram. Made from high-quality durable soft cotton knit.', '\"Occult Horned Figure\" Gothic Casual T-shirt', 'tshirts-tops', '100% Cotton', 'Black / Red / White', 'Cotton', 'Casual', 'Slight Stretch', 'Regular Fit', 'Short Sleeve', 'Mulher'),
(26, 'T-shirt Casual Gothic Anime \"Spiked Halo\"', 'T-shirt masculina branca com corte regular e caimento confortável de estilo urbano alternativo. Destaca-se pelo detalhado estampado gráfico frontal de estética dark anime e gothcore, ilustrando o retrato de uma personagem com grandes cornos texturados, choker de picos e uma marcante coroa pontiaguda em tons escuros. Confecionada em malha de algodão macio e de excelente caimento.', 'roupahomem26.png', 24.99, 'tshirts-tops', 'S', '100% Algodão', 'Branco / Preto', 'Algodão', 'Corte regular confortável, gola redonda clássica, estampado frontal centralizado em serigrafia de al', 'Estampado Gráfico / Dark Anime / Gótico', 'Casual', 'Elasticidade Ligeira', 'Corte Regular', 'Manga Curta', 0, 14, 'Mens white t-shirt with a regular fit and comfortable drape in an alternative urban aesthetic. Stands out with its detailed front graphic print in a dark anime and gothcore style, displaying a character portrait with large textured horns, a spiked choker, and a striking pointed crown in dark tones. Made from high-quality soft cotton knit.', '\"Spiked Halo\" Gothic Anime Casual T-shirt', 'tshirts-tops', '100% Cotton', 'White / Black', 'Cotton', 'Casual', 'Slight Stretch', 'Regular Fit', 'Short Sleeve', 'Homem'),
(27, 'Casaco Zip-Up Hoodie \"Y2K Cyber Wings\"', 'Casaco masculino preto com capuz e fecho de correr (zip-up) em corte regular com caimento pesado e confortável. Destaca-se pelo grande estampado gráfico frontal de estética Y2K, cyber-grunge e tribal, exibindo asas detalhadas em tons de cinza e tipografia estilizada que se estende pelo peito e ombros. Confecionado em algodão pesado com interior macio, ideal para um estilo streetwear marcante.', 'roupahomem28.png', 44.99, 'casacos-hoodies', 'S', '80% Algodão, 20% Poliéster', 'Preto / Cinzento', 'Algodão Pesado / Interior Desgastado', 'Fecho de correr frontal metálico, capuz com cordões de ajuste, bolsos estilo canguru divididos, esta', 'Estampado Gráfico / Cyber-Grunge / Y2K / Tribal', 'Casual', 'Elasticidade Ligeira', 'Corte Regular / Streetwear', 'Manga Comprida', 0, 10, 'Mens black zip-up hoodie with a regular fit and heavyweight comfortable drape. It stands out with a large front graphic print in a Y2K, cyber-grunge, and tribal aesthetic, displaying detailed wings in grey tones and stylized typography across the chest and shoulders. Made from heavyweight cotton with a soft interior, perfect for bold streetwear styles.', '\"Y2K Cyber Wings\" Zip-Up Hoodie', 'jackets-hoodies', '80% Cotton, 20% Polyester', 'Black / Grey', 'Heavyweight Cotton / Fleece Lining', 'Casual', 'Slight Stretch', 'Regular Fit / Streetwear', 'Long Sleeve', 'Homem'),
(28, 'Hoodie Streetwear Gothic \"Metal Thorns\"', 'Hoodie masculino preto com capuz e corte descontraído (oversize). Destaca-se pelo marcante estampado branco em linha de estética gótica, dark metal e tribal, formando padrões simétricos abstratos semelhantes a espinhos nas costas e ao longo de ambas as mangas. Confecionado em malha grossa de algodão com interior peluciado para máximo conforto e afirmação de estilo alternativo.', 'roupahomem29.png', 45.99, 'casacos-hoodies', 'S', '80% Algodão, 20% Poliéster', 'Preto / Branco', 'Algodão Pesado / Interior Peluciado', 'Corte descontraído oversize, capuz clássico sem cordões visíveis, bolso canguru frontal, estampado g', 'Estampado Gráfico / Gótico / Dark Metal / Tribal', 'Casual', 'Elasticidade Ligeira', 'Corte Descontraído / Oversize', 'Manga Comprida', 0, 12, 'Mens black pullover hoodie with a relaxed (oversized) fit. Stands out with its striking white line-art print in a gothic, dark metal, and tribal aesthetic, forming abstract symmetrical thorn-like patterns on the back and along both sleeves. Made from thick cotton knit with a fleece interior for maximum comfort and a bold alternative style statement.', '\"Metal Thorns\" Gothic Streetwear Hoodie', 'jackets-hoodies', '80% Cotton, 20% Polyester', 'Black / White', 'Heavyweight Cotton / Fleece Lining', 'Casual', 'Slight Stretch', 'Relaxed / Oversized Fit', 'Long Sleeve', 'Homem'),
(29, 'Hoodie Oversized Grunge \"Sketch Bat\"', 'Hoodie masculino preto com capuz e corte largo estilo oversized com caimento pesado e descontraído. Destaca-se pelo estampado gráfico frontal centralizado com uma ilustração detalhada em estilo sketch e line-art de um morcego com asas abertas em tom branco de alto contraste. Confecionada em malha grossa de algodão de toque macio e confortável.', 'roupahomem30.png', 44.99, 'casacos-hoodies', 'S', '80% Algodão, 20% Poliéster', 'Preto / Branco', 'Algodão Pesado', 'Corte oversized com ombro descaído, capuz com cordões de ajuste ocultos, bolso canguru frontal, esta', 'Estampado Gráfico / Grunge / Gótico / Line-Art', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Comprida', 0, 12, 'Mens black pullover hoodie with a relaxed oversized fit and a heavy drop. Stands out with its center front graphic print featuring a detailed sketch line-art illustration of a bat with spread wings in a high-contrast white tone. Made from thick, soft cotton knit for maximum comfort.', '\"Sketch Bat\" Grunge Oversized Hoodie', 'jackets-hoodies', '80% Cotton, 20% Polyester', 'Black / White', 'Heavyweight Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Long Sleeve', 'Homem'),
(30, 'Casaco Zip-Up Hoodie \"Washed Cyber Skull\"', 'Casaco masculino cinzento-escuro com lavagem desgastada (washed grey), capuz e fecho de correr (zip-up) em corte largo estilo oversized. Destaca-se pelo marcante estampado gráfico frontal centralizado de estética grunge e Y2K, apresentando uma ilustração detalhada de uma caveira com grandes asas texturadas e arabescos abstratos. Confecionado em algodão pesado com interior macio e confortável.', 'roupahomem31.png', 46.99, 'casacos-hoodies', 'S', '80% Algodão, 20% Poliéster', 'Cinzento Escuro Desgastado', 'Algodão Pesado Desgastado', 'Fecho de correr frontal integral, lavagem acid wash estonada, capuz com forro, bolsos frontais divid', 'Estampado Gráfico / Cyber-Grunge / Y2K / Caveira', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Comprida', 0, 10, 'Mens washed grey zip-up hoodie featuring a relaxed oversized fit and a heavy streetwear drop. Stands out with its center front graphic print in a grunge and Y2K aesthetic, displaying a detailed illustration of a skull with large textured wings and abstract swirls. Made from heavyweight cotton with a soft interior.', '\"Washed Cyber Skull\" Zip-Up Hoodie', 'jackets-hoodies', '80% Cotton, 20% Polyester', 'Washed Dark Grey', 'Washed Heavyweight Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Long Sleeve', 'Homem'),
(31, 'Casaco Zip-Up Hoodie \"Washed Cyber Skull\" (Detalhe', 'Fotografia alternativa de exibição do casaco masculino cinzento-escuro estonado (washed grey) com capuz e fecho de correr integral. Corte largo de estilo oversized com caimento pesado streetwear, destacando o alinhamento frontal do estampado gráfico de caveira alada e arabescos de estética cyber-grunge.', 'roupahomem32.png', 46.99, 'casacos-hoodies', 'S', '80% Algodão, 20% Poliéster', 'Cinzento Escuro Desgastado', 'Algodão Pesado Desgastado', 'Perspetiva frontal completa do produto vestido, fecho de correr central metálico, estampado em serig', 'Estampado Gráfico / Cyber-Grunge / Y2K / Caveira', 'Casual', 'Elasticidade Ligeira', 'Oversized', 'Manga Comprida', 0, 10, 'Alternative display angle of the mens washed grey zip-up hoodie. Showcases the relaxed oversized streetwear fit and heavy drop, highlighting the front alignment of the winged skull and cyber-grunge tribal graphic print.', '\"Washed Cyber Skull\" Zip-Up Hoodie (Detail Shot)', 'jackets-hoodies', '80% Cotton, 20% Polyester', 'Washed Dark Grey', 'Washed Heavyweight Cotton', 'Casual', 'Slight Stretch', 'Oversized', 'Long Sleeve', 'Homem');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos_utilizador`
--

CREATE TABLE `tipos_utilizador` (
  `id_tipos_utilizador` int(11) NOT NULL,
  `tipo_utilizador` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `tipos_utilizador`
--

INSERT INTO `tipos_utilizador` (`id_tipos_utilizador`, `tipo_utilizador`) VALUES
(0, 'administrador'),
(1, 'utilizador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id_utilizadores` int(11) NOT NULL,
  `utilizador` varchar(20) NOT NULL,
  `password` varchar(41) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tipos_utilizador_id_tipos_utilizador` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `token` varchar(40) NOT NULL,
  `estado_conta` int(11) NOT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_token_expira` int(11) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT 'default_avatar.png',
  `foto_capa` varchar(255) DEFAULT 'default_capa.jpg',
  `descricao` text DEFAULT NULL,
  `idade` int(11) DEFAULT NULL,
  `genero` varchar(20) DEFAULT NULL,
  `morada` varchar(255) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id_utilizadores`, `utilizador`, `password`, `email`, `tipos_utilizador_id_tipos_utilizador`, `id_estado`, `token`, `estado_conta`, `reset_token`, `reset_token_expira`, `foto_perfil`, `foto_capa`, `descricao`, `idade`, `genero`, `morada`, `cidade`, `codigo_postal`) VALUES
(1, 'admin', '*0D3CED9BEC10A777AEC23CCC353A8C08A633045E', 'suporte@localhost.com', 0, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', '', NULL, 'Masculino', NULL, NULL, NULL),
(11, 'ruidinis', '*0D3CED9BEC10A777AEC23CCC353A8C08A633045E', 'ruidinis@localhost.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'anasilva', '*0D3CED9BEC10A777AEC23CCC353A8C08A633045E', 'anasilva@localhost.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'teste1', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'teste1@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'teste2', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'teste2@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'teste3', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'teste3@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'teste4', '*32F5BE1BCC8513B78FE6A4C3CF10883FA4621089', 'teste4@gmail.com', 1, 0, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'teste5', '*84E1623CA4769B0E9D74D516D4C1D6173BB74AA2', 'teste5@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'teste6', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'teste6@gmail.com', 1, 0, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'teste7', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'teste7@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'teste8', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'teste8@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(22, '123', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', '123@gmail.com', 1, 1, '', 0, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(23, '123123', '*0B0A8BA0BB47561FA5C1FE726FFDFFC56F3FF585', '123213123@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(24, '12312312312', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', '3123123213@gmail.com', 1, 1, '', 0, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(25, '67teste', '*0C75A7586CD749417319A42C7EFA431B405DF0E4', '67@gmail.com', 1, 1, '', 0, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'admin2', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'adminteste@gmail.com', 0, 0, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'teste6767', '*0C75A7586CD749417319A42C7EFA431B405DF0E4', '6767@mail.com', 1, 1, '', 0, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'containativa', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'containativa@gmail.com', 1, 1, '', 0, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'qqq', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'qqq@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'alexreidelas', '$2y$10$IpuZRGiBkZj5g7rxevctR.g1/39Cq525t9', 'alex@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'yuyu', '$2y$10$gur7Yg/JmMgLrBexa6nGauG63qBFZo4ukL', 'yuyu@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'sqx', '*4D37FB2A36981702C31332ABFC9D64E138340FC5', 'sqx@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'wer', '*1732A8B8F1D664B76111DE273E86D80F4892EA5A', 'wer@gmail.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'testeemail2', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'cemeno9256@duoley.com', 1, 1, '', 1, NULL, NULL, 'default_avatar.png', 'default_capa.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'alex', '*E56A114692FE0DE073F9A1DD68A00EEB9703F3F1', 'noddyoreidelas@gmail.com', 1, 1, '', 1, NULL, NULL, 'perfil_37.png', 'capa_37.jpg', '', 20, 'Masculino', 'Pedrulha, Coimbra', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilizador_id` (`utilizador_id`);

--
-- Índices para tabela `carrinho_itens`
--
ALTER TABLE `carrinho_itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrinho_id` (`carrinho_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices para tabela `historico_itens`
--
ALTER TABLE `historico_itens`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `newsletter_campanhas`
--
ALTER TABLE `newsletter_campanhas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `newsletter_subscritores`
--
ALTER TABLE `newsletter_subscritores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tipos_utilizador`
--
ALTER TABLE `tipos_utilizador`
  ADD PRIMARY KEY (`id_tipos_utilizador`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id_utilizadores`),
  ADD UNIQUE KEY `utilizador` (`utilizador`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `tipos_utilizador_id_tipos_utilizador` (`tipos_utilizador_id_tipos_utilizador`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de tabela `carrinho_itens`
--
ALTER TABLE `carrinho_itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `historico_itens`
--
ALTER TABLE `historico_itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `newsletter_campanhas`
--
ALTER TABLE `newsletter_campanhas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `newsletter_subscritores`
--
ALTER TABLE `newsletter_subscritores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id_utilizadores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `carrinho_ibfk_1` FOREIGN KEY (`utilizador_id`) REFERENCES `utilizadores` (`id_utilizadores`);

--
-- Limitadores para a tabela `carrinho_itens`
--
ALTER TABLE `carrinho_itens`
  ADD CONSTRAINT `carrinho_itens_ibfk_1` FOREIGN KEY (`carrinho_id`) REFERENCES `carrinho` (`id`),
  ADD CONSTRAINT `carrinho_itens_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

--
-- Limitadores para a tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD CONSTRAINT `utilizadores_ibfk_1` FOREIGN KEY (`tipos_utilizador_id_tipos_utilizador`) REFERENCES `tipos_utilizador` (`id_tipos_utilizador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
