<?php
session_start();

$ligacao = mysqli_connect("localhost", "root", "", "bd_site");

$ordenar = $_GET['ordenar'] ?? '';
$cat = $_GET['cat'] ?? '';
$pesquisa = $_GET['pesquisa'] ?? '';
$tamanho = $_GET['tamanho'] ?? '';
$composicao    = $_GET['composicao']    ?? '';
$cor           = $_GET['cor']           ?? '';
$material      = $_GET['material']      ?? '';
$detalhes      = $_GET['detalhes']      ?? '';
$tipo_desenho  = $_GET['tipo_desenho']  ?? '';
$estilo        = $_GET['estilo']        ?? '';
$elasticidade  = $_GET['elasticidade']  ?? '';
$tipo_ajuste   = $_GET['tipo_ajuste']   ?? '';
$comprimento_manga = $_GET['comprimento_manga'] ?? '';

$itens_por_pagina = 20; 
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $itens_por_pagina;

$generos_ativos = isset($_GET['genero']) ? (array)$_GET['genero'] : [];

$where = [];

/* 🔍 CATEGORIA */
if (!empty($cat)) {
    $cat_safe = mysqli_real_escape_string($ligacao, $cat);
    $where[] = "categoria = '$cat_safe'";
}

/* 🔎 PESQUISA */
if (!empty($pesquisa)) {
    $pesquisa_safe = mysqli_real_escape_string($ligacao, $pesquisa);
    $where[] = "designacao LIKE '%$pesquisa_safe%'";
}

/* 👕 TAMANHO */
if (!empty($tamanho)) {
    $tamanho_safe = mysqli_real_escape_string($ligacao, $tamanho);
    $where[] = "tamanho = '$tamanho_safe'";
}

if (!empty($composicao)) {
    $s = mysqli_real_escape_string($ligacao, $composicao);
    $where[] = "composicao = '$s'";
}
if (!empty($cor)) {
    $s = mysqli_real_escape_string($ligacao, $cor);
    $where[] = "cor = '$s'";
}
if (!empty($material)) {
    $s = mysqli_real_escape_string($ligacao, $material);
    $where[] = "material = '$s'";
}
if (!empty($detalhes)) {
    $s = mysqli_real_escape_string($ligacao, $detalhes);
    $where[] = "detalhes = '$s'";
}
if (!empty($tipo_desenho)) {
    $s = mysqli_real_escape_string($ligacao, $tipo_desenho);
    $where[] = "tipo_desenho = '$s'";
}
if (!empty($estilo)) {
    $s = mysqli_real_escape_string($ligacao, $estilo);
    $where[] = "estilo = '$s'";
}
if (!empty($elasticidade)) {
    $s = mysqli_real_escape_string($ligacao, $elasticidade);
    $where[] = "elasticidade = '$s'";
}
if (!empty($tipo_ajuste)) {
    $s = mysqli_real_escape_string($ligacao, $tipo_ajuste);
    $where[] = "tipo_ajuste = '$s'";
}
if (!empty($comprimento_manga)) {
    $s = mysqli_real_escape_string($ligacao, $comprimento_manga);
    $where[] = "comprimento_manga = '$s'";
}
if (!empty($generos_ativos)) {
    $gs = array_map(function($g) use ($ligacao) { 
        return "'" . mysqli_real_escape_string($ligacao, $g) . "'"; 
    }, $generos_ativos);
    $where[] = "genero IN (" . implode(',', $gs) . ")";
}
/* 🔗 WHERE FINAL */
$where_sql = "";
if (!empty($where)) {
    $where_sql = " WHERE " . implode(" AND ", $where);
}

/* 🔥 ORDER */
$order_sql = "";

if ($ordenar == "vendidos") {
    $order_sql = " ORDER BY vendidos DESC";
} elseif ($ordenar == "preco_asc") {
    $order_sql = " ORDER BY preco ASC";
} elseif ($ordenar == "preco_desc") {
    $order_sql = " ORDER BY preco DESC";
}

/* 📊 TOTAL */
$query_total = "SELECT COUNT(*) as total FROM produtos" . $where_sql . ($where_sql ? " AND stock > 0" : " WHERE stock > 0");
$res_total = mysqli_query($ligacao, $query_total);
$row_total = mysqli_fetch_assoc($res_total);

$total_produtos = $row_total['total'];
$total_paginas = ($total_produtos > 0) ? ceil($total_produtos / $itens_por_pagina) : 1;

/* 🛒 PRODUTOS */
$query = "SELECT * FROM produtos" . $where_sql . ($where_sql ? " AND stock > 0" : " WHERE stock > 0") . $order_sql . " LIMIT $itens_por_pagina OFFSET $offset";
$res = mysqli_query($ligacao, $query);
?>





<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Loja</title>
    <link rel="icon" type="image/png" href="URBAE COMPLETO.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

.nav-top {
    display: flex;
    justify-content: space-between;
    align-items: center; /* Centraliza verticalmente todo o conteúdo */
    background-color: #242c34; /* Garante a cor cinza-escura correta */
    height: 42px; /* Altura fixa perfeita (podes mudar para 45px ou 50px se preferires) */
    /* 2. ESPAÇAMENTO LATERAL */
    padding: 0 40px; /* Alinha perfeitamente com os limites da tua nav branca */
    box-sizing: border-box; /* Garante que a altura se mantém estritamente nos 36px */
}

   /* 1. Estrutura Global e Layout */
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
}

.shop-container {
    display: flex !important;
    width: 95% !important;   /* Ocupa quase a tela toda */
    max-width: 1600px !important; /* Limite de segurança para não virar um outdoor */
    margin: 0 auto !important;
    gap: 20px;
    align-items: flex-start;
}

/* 2. Barra Lateral (Categorias) - Encostada à esquerda */
.shop-sidebar {
    width: 230px;
    padding: 20px 20px 40px 30px;
    border-right: 1px solid #f2f2f2;
    flex-shrink: 0;
}

.shop-sidebar h2 {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: #000;
    margin-bottom: 25px;
    font-weight: 700;
}

.shop-sidebar {
    width: 280px;
    padding: 20px 15px 40px 20px;
    border-right: 1px solid #f2f2f2;
    flex-shrink: 0;
}

.sidebar-menu li {
    margin-bottom: 12px;
}

.sidebar-menu a {
    text-decoration: none !important;
    color: #888;
    font-size: 13px;
    transition: 0.3s ease;
    display: block;
}

.sidebar-menu a:hover, 
.sidebar-menu a.active {
    color: #000;
    font-weight: 600;
}

/* 3. Área Principal de Produtos */
.shop-content {
    flex-grow: 1;
    padding: 0px 15px 40px 10px;
    min-width: 0;
}

.product-grid {
    display: grid;
    /* Mudamos de 180px para 1fr para os cards crescerem */
    grid-template-columns: repeat(4, 1fr); 
    
    /* Reduzi um pouco o gap para sobrar mais espaço para o card em si */
    gap: 15px; 
    
    /* justify-content: start; -> Pode remover esta linha se quiser que ocupe a largura toda */
    width: 100%;
}

.product-card {
    background: #fff;
    border-radius: 4px; /* Cantos ligeiramente arredondados */
    overflow: hidden;
    display: flex;
    flex-direction: column; /* Organiza os elementos na vertical */
    transition: box-shadow 0.3s ease;
    width: 100%;
    /* Altura fixa opcional para manter o alinhamento perfeito (ex: 420px) */
    height: 100%; 
}

.product-card:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

.product-img-wrapper {
    background-color: #f9f9f9;
    aspect-ratio: 3/4;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
    margin-bottom: 0;
}

.product-img-wrapper a img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block; /* Remove espaços vazios na base da imagem */
}



.product-card:hover img {
    transform: scale(1.03);
}

.product-info {
    padding: 6px 2px; /* Reduzido para aproximar o texto da imagem */
}

/* --- Título do Produto (Fino e com limite de 2 linhas) --- */
.product-info h3 {
    font-size: 12px;
    line-height: 1.4;
    margin-bottom: 8px;
    color: #222;
    font-weight: 400; /* Fonte mais leve como na Shein */
    height: 34px;     /* Altura fixa para alinhar os preços */
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2; /* Adicione esta linha aqui */
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-info-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* --- Preço --- */
.product-info-footer p {
    font-size: 18px;
    font-weight: 700; /* Mais negrito */
    letter-spacing: -0.5px;
}

/* --- O BOTÃO REDONDO (Estilo Shein) --- */
.btn-add-carrinho {
    background-color: #fff; /* Fundo branco */
    color: #000;            /* Ícone preto */
    border: 1px solid #ddd; /* Borda fininha */
    width: 36px;            /* Largura fixa */
    height: 36px;           /* Altura fixa */
    border-radius: 50%;     /* Fica redondo */
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
}

.btn-add-carrinho:hover {
    background-color: #f8f8f8;
    border-color: #000;
}

.btn-add-carrinho i {
    font-size: 14px;
}

.product-tag {
    font-size: 10px;
    background-color: #fee8ae;
    color: #c77210;
    padding: 2px 6px;
    border-radius: 2px;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 5px;
}

/* 6. Paginação no Fundo */
.pagination-container {
    display: flex;
    justify-content: center;
    width: 100%;
    margin-top: 50px;
    padding-bottom: 50px;
}

.pagination a {
    color: #999;
    padding: 8px 16px;
    text-decoration: none !important;
    border: 1px solid #eee;
    margin: 0 4px;
    font-size: 12px;
    transition: 0.3s;
}

.pagination a.active {
    background-color: #000;
    color: #fff;
    border-color: #000;
    font-weight: 600;
}

.pagination a:hover:not(.active) {
    border-color: #000;
    color: #000;
}

/* 1. BARRA DE FILTROS (SUBIR TUDO) */
.filtros-bar {
    display: flex;
    align-items: center;
    gap: 8px;
    
    /* Reduzi a margem inferior de 25px para 10px para os produtos subirem */
    margin-bottom: 20px; 
    
    /* Retirei o padding para não ocupar espaço vertical desnecessário */
    padding: 0; 
    
    background: none;
    border: none;
    flex-wrap: wrap;
    
    /* Se quiser subir ainda mais em relação ao menu de cima, use margem negativa: */
    margin-top: -70px; 
}

/* 2. O BOTÃO DE ORDENAR (AJUSTADO) */
.ordenar-btn {
    text-decoration: none !important;
    font-size: 12px;
    font-weight: 500;
    color: #000;         /* Texto preto para combinar com a Urbae */
    padding: 6px 14px;
    border: 1px solid #ddd;
    border-radius: 4px;  /* Menos arredondado fica mais moderno/Shein */
    background: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
}

.ordenar-btn:hover {
    border-color: #000;
    background: #fdfdfd;
}

/* 3. O RÓTULO "ORDENAR POR" */
.filtros-label {
    font-size: 10px;     /* Um pouco menor para dar elegância */
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: #999;
    margin-right: 4px;
    font-weight: 600;
}

.filtro-btn.active {
    background: #000;
    color: #fff !important;
    border-color: #000;
}


.ordenar-dropdown {
    position: relative;
    display: inline-block;
}

.ordenar-btn {
    background: #fff;
    border: 1px solid #ddd;
    padding: 8px 16px;
    font-size: 13px;
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: border-color 0.2s;
}

.ordenar-btn:hover {
    border-color: #000;
}

.ordenar-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    border: 1px solid #eee;
    min-width: 200px;
    z-index: 999;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.ordenar-dropdown:hover .ordenar-menu {
    display: block;
}

.ordenar-opcao {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    font-size: 13px;
    color: #444;
    text-decoration: none !important;
    transition: background 0.2s;
}

.ordenar-opcao:hover {
    background: #f9f9f9;
    color: #000;
}

.ordenar-opcao.ativo {
    font-weight: 600;
    color: #000;
}

/* Container principal do cabeçalho da sidebar */
.sidebar-header {
    display: flex;
    justify-content: space-between; /* Empurra o título para a esquerda e o botão para a direita */
    align-items: center;
    width: 100%;
    padding-bottom: 10px;
}

/* Estilo do título "FILTROS" */
.sidebar-header h2 {
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
    color: #222;
}

/* O Botão de Limpar */
.btn-reset-filters {
    display: flex;
    align-items: center;
    gap: 5px;               /* Espaço entre o ícone X e o texto */
    font-size: 11px;
    font-weight: 600;
    color: #888;            /* Cor cinza discreta */
    text-transform: uppercase;
    text-decoration: none !important;
    border: 1px solid #eee;
    padding: 4px 10px;
    border-radius: 4px;
    white-space: nowrap;    /* Impede que o texto "Limpar" quebre para baixo */
    transition: all 0.2s ease;
}

/* Efeito ao passar o rato */
.btn-reset-filters:hover {
    color: #000;
    border-color: #000;
    background-color: #f9f9f9;
}

/* Linha divisória opcional */
.sidebar-divider {
    border: 0;
    border-top: 1px solid #eee;
    margin: 0 0 20px 0;
}

/* Configuração Geral da Header */
.URBAE-nav {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Distribui os 3 blocos */
    padding: 10px 40px;
    background-color: #fff;
    height: 90px;
    position: relative;
    border-bottom: 1px solid #eee;
}

/* 1. Lado Esquerdo (Logo) */
.URBAE-nav > a:first-child {
    flex: 1; /* Ocupa espaço à esquerda */
    display: flex;
    align-items: center;
}

/* 2. Centro (Menu de Links) */
.nav-links {
    flex: 2; /* Dá mais espaço ao centro */
    display: flex;
    justify-content: center; /* CENTRALIZA OS LINKS */
    gap: 25px;
}

.nav-links a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    font-size: 16px;
    transition: color 0.3s;
}

.nav-links a:hover {
    color: #5d8e46; /* Cor verde da URBAE no hover */
}

/* 3. Lado Direito (Pesquisa, Carrinho, User) */
.nav-icons {
    flex: 1; /* Ocupa o mesmo espaço que o logo para manter o equilíbrio */
    display: flex;
    align-items: center;
    justify-content: flex-end; /* Empurra tudo para a direita */
    gap: 15px;
}

/* Ajuste da barra de pesquisa para não ser muito larga */
#pesquisa {
    border: 1px solid #ccc;
    padding: 5px 10px;
    border-radius: 4px;
    width: 150px; /* Largura fixa para não empurrar o menu */
}

/* Garante que os ícones fiquem alinhados */
.icon-badge {
    color: #333;
    font-size: 18px;
    display: flex;
    align-items: center;
    text-decoration: none;
}

/* Estilo inicial: Invisível e sem largura */
.search-input {
    width: 0;
    opacity: 0;
    padding: 5px 0;
    border: 1px solid transparent;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    outline: none;
    border-radius: 4px;
    background-color: #f9f9f9;
    /* Adiciona esta linha para desativar a interação enquanto invisível */
    pointer-events: none; 
}

.search-input.active {
    width: 200px;
    opacity: 1;
    padding: 5px 12px;
    border: 1px solid #ddd;
    margin-right: 5px;
    /* Reativa a interação quando estiver ativo */
    pointer-events: auto; 
}
</style>
</head>

<body>

<!-- NAV CINZENTA AZULADO DO TOPO -->
    <nav class="nav-top">
    <div class="contact-left">
        <i class="fa fa-envelope"></i>urbaegeral@gmail.com
        <i class="fa fa-phone mx-2"></i>911-825-589
    </div>

    <div class="social-right">
        <a href="https://www.instagram.com/urbae_231/"><i class="fab fa-instagram"></i></a>
    </div>
    </nav>
  <!-- NAV CINZENTA AZULADO DO TOPO FIM-->
    <hr>


    <!-- NAV BRANCA URBÆ -->
<header class="URBAE-nav">

        <a href="index.php">
            <img src="URBAE verde logo.png" alt="URBAE Logo" height="90" width="110" style="margin-left: 30px;">
        </a>

        <nav class="nav-links">
    <a href="index.php">Home</a>
    <a href="about.php">Sobre</a>
    <a href="shop.php">Comprar</a>
    <a href="contact.php">Contactar</a>

    <?php if (isset($_SESSION["id_tipos_utilizador"]) && $_SESSION["id_tipos_utilizador"] == 0): ?>
        <a href="admin.php">Painel Admin</a>
    <?php endif; ?>
</nav>
        <!-- GERIR UTILIZADORES LINK (APENAS PARA ADMIN) Fim -->



     <div class="nav-icons">
    <!-- Action corrigido para shop.php -->
    <form method="GET" action="shop.php" id="searchForm" style="display:flex; align-items:center; gap:6px;">
        <?php if (!empty($cat)): ?>
            <input type="hidden" name="cat" value="<?= htmlspecialchars($cat) ?>">
        <?php endif; ?>
        
        <!-- Input com classe para controlar a visibilidade -->
        <input type="text" name="pesquisa" id="pesquisa" class="search-input" 
               placeholder="Search..." 
               value="<?= htmlspecialchars($pesquisa ?? '') ?>">
        
        <!-- Botão da lupa que controla o abrir/fechar -->
        <button type="button" id="lupaBtn" style="background:none; border:none; cursor:pointer;">
            <i class="fas fa-search"></i>
        </button>
    </form>
    
    <div id="sugestoes"></div>

<?php if (!isset($_SESSION["utilizador"])): ?>
    <a href="#" class="icon-badge" onclick="alert('Tens de iniciar sessão para aceder ao carrinho!'); return false;">
        <i class="fas fa-shopping-cart"></i>
    </a>
<?php else: ?>
    <a href="carrinho.php" class="icon-badge">
        <i class="fas fa-shopping-cart"></i>
    </a>
<?php endif; ?>

<?php if (!isset($_SESSION["utilizador"])): ?>
    <a href="#" class="icon-badge user-btn">
        <i class="fas fa-user"></i>
    </a>
<?php else: ?>
    <a href="perfil.php" class="icon-badge" title="O meu perfil">
        <i class="fas fa-user"></i>
    </a>
<form action="logout.php" method="POST" style="display: inline-flex; align-items: center; white-space: nowrap; gap: 8px;">
        <span style="font-weight:600;">
            <?= $_SESSION["utilizador"] ?>
        </span>
        <button type="submit" name="botaoLogout" value="1" 
                style="background:none; border:none; cursor:pointer; padding: 0; display: flex; align-items: center;">
            <i class="fas fa-sign-out-alt"></i>
        </button>
    </form>
<?php endif; ?>

            <!-- BOTÃO DA BANDEIRA (abre modal) -->
            <a href="#" class="icon-badge lang-btn" id="openLangModal" title="Idioma">
                <img src="https://flagcdn.com/w20/pt.png" alt="PT">
            </a>

        </div>

    </header>
    <!-- NAV BRANCA URBÆ FIM-->








<div class="shop-container">
    
    <aside class="shop-sidebar">
        
    <div class="sidebar-header">
    <h2>Filtros</h2>
    
    <!-- Este link recarrega a página sem parâmetros, limpando tudo -->
    <a href="shop.php" class="btn-reset-filters">
        <i class="fas fa-times"></i> Limpar
    </a>
</div>

<!-- Linha divisória para separar do resto -->
<hr class="sidebar-divider">

<div style="font-size:16px; font-weight:700; color:#000; padding-bottom:15px; border-bottom:1px solid #eee; margin-bottom:20px;">
    Filtro
</div>

<?php
// Função auxiliar para gerar URLs mantendo todos os filtros activos
function filtro_url($params_actuais, $chave, $valor) {
    $p = $params_actuais;
    if (isset($p[$chave]) && $p[$chave] === $valor) {
        unset($p[$chave]); // toggle off
    } else {
        $p[$chave] = $valor;
    }
    return 'shop.php?' . http_build_query($p);

}

$todos_params = [];
if (!empty($cat))              $todos_params['cat']              = $cat;
if (!empty($pesquisa))         $todos_params['pesquisa']         = $pesquisa;
if (!empty($ordenar))          $todos_params['ordenar']          = $ordenar;
if (!empty($tamanho))          $todos_params['tamanho']          = $tamanho;
if (!empty($composicao))       $todos_params['composicao']       = $composicao;
if (!empty($cor))              $todos_params['cor']              = $cor;
if (!empty($material))         $todos_params['material']         = $material;
if (!empty($detalhes))         $todos_params['detalhes']         = $detalhes;
if (!empty($tipo_desenho))     $todos_params['tipo_desenho']     = $tipo_desenho;
if (!empty($estilo))           $todos_params['estilo']           = $estilo;
if (!empty($elasticidade))     $todos_params['elasticidade']     = $elasticidade;
if (!empty($tipo_ajuste))      $todos_params['tipo_ajuste']      = $tipo_ajuste;
if (!empty($comprimento_manga)) $todos_params['comprimento_manga'] = $comprimento_manga;


function render_secao($titulo, $chave, $opcoes, $valor_ativo, $todos_params, $colunas = 1) {
    // 1. Decida se a seção deve começar aberta ou fechada.
    // Dica: Se quiser que comece fechada por padrão, adicione a classe 'fechado' e mude o span para '+'
    $classe_aberta = ""; 
    $icone_inicial = "−"; 

    echo "<div class='filtro-secao $classe_aberta'>";
    
    // O JS vai procurar exatamente por esta div 'filtro-secao-header' e pelo 'span'
    echo "<div class='filtro-secao-header'><strong>$titulo</strong><span>$icone_inicial</span></div>";
    
    echo "<div class='filtro-secao-body'>";
    
    if ($colunas == 2) {
        echo "<div style='display:grid; grid-template-columns:1fr 1fr; gap:6px;'>";
    }

    foreach ($opcoes as $op) {
        $ativo = $valor_ativo === $op;
        $url = filtro_url($todos_params, $chave, $op);
        echo "<a href='$url' class='filtro-check" . ($ativo ? " ativo" : "") . "'>";
        echo "<span class='check-box'>" . ($ativo ? "✓" : "") . "</span>";
        echo "$op</a>";
    }

    if ($colunas == 2) {
        echo "</div>";
    }
    
    echo "</div></div>";
}
?>

<style>

.shop-container {
    display: flex;
    align-items: flex-start;
    gap: 30px;
    padding: 20px;
    /* Aumente o max-width para o site "abrir" mais nas laterais */
    max-width: 1400px; 
    margin: 0 auto; /* Centraliza o site no ecrã */
}
.shop-sidebar {
    width: 260px;
    flex-shrink: 0;
    
    /* Faz a barra ficar fixa ao rolar a página */
    position: -webkit-sticky;
    position: sticky;
    top: 20px; 
    
    /* Define a altura máxima como a altura da tela (100vh) */
    /* Subtraímos 40px para dar um respiro no topo e rodapé */
    max-height: calc(100vh - 40px); 
    
    /* Ativa o scroll interno */
    overflow-y: auto;
    overflow-x: hidden;
    
    /* Espaço interno para a scrollbar não encostar no conteúdo */
    padding-right: 15px;
}
.shop-sidebar::-webkit-scrollbar {
    width: 4px; /* Bem fininho */
}

.shop-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.shop-sidebar::-webkit-scrollbar-thumb {
    background: #e0e0e0; /* Cor cinza clara */
    border-radius: 10px;
}

.shop-sidebar::-webkit-scrollbar-thumb:hover {
    background: #333; /* Fica escuro ao passar o mouse */
}

/* Quando a seção estiver com a classe 'fechado', o corpo some */
.filtro-secao.fechado .filtro-secao-body {
    display: none;
}

.filtro-secao { border-bottom: 1px solid #eee; padding: 15px 0; }
/* --- Estrutura da Seção --- */
.filtro-secao { 
    border-bottom: 1px solid #eee; 
    padding: 15px 0; 
}

/* --- Cabeçalho (Título e Ícone +/-) --- */
.filtro-secao-header { 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    cursor: pointer; 
    font-size: 14px; 
    font-weight: 600; 
    color: #000; 
    margin-bottom: 12px; 
    user-select: none;
    
}

/* --- Links e Itens do Filtro --- */
.filtro-secao-body a.filtro-check { 
    display: flex; 
    align-items: center; 
    gap: 8px; 
    text-decoration: none !important; 
    font-size: 13px; 
    color: #444; 
    padding: 4px 0; 
    transition: color 0.2s; 
}

.filtro-secao-body a.filtro-check:hover { 
    color: #000; 
}

/* --- Estados Ativos --- */
.filtro-secao-body a.filtro-check.ativo { 
    color: #000; 
    font-weight: 600; 
}

.filtro-check.ativo .check-box { 
    background: #000; 
    border-color: #000; 
    color: #fff; 
}

/* --- Elementos Visuais (Checkbox e Cores) --- */
.check-box { 
    width: 14px; 
    height: 14px; 
    border: 1px solid #ccc; 
    display: inline-flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 10px; 
    flex-shrink: 0; 
    color: #fff; 
    background: #fff; 
}

.cor-circle { 
    width: 22px; 
    height: 22px; 
    border-radius: 50%; 
    display: inline-block; 
    flex-shrink: 0; 
    border: 1px solid #ddd; 
}

/* --- Lógica para Minimizar (JS toggle class) --- */
.filtro-secao.fechado .filtro-secao-body {
    display: none;
}

/* Checkbox visual */
.check-box {
    width: 14px;
    height: 14px;
    border: 1px solid #ccc;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    flex-shrink: 0;
    background: #fff;
}

.filtro-check.ativo .check-box {
    background: #000;
    border-color: #000;
    color: #fff;
}

</style>

<!-- PREÇO -->
<div class="filtro-secao">
    <div class="filtro-secao-header"><strong>Preço</strong><span>−</span></div>
    <div class="filtro-secao-body">
        <?php
        $opcoes_preco = ['preco_asc' => '↑ Menor para Maior', 'preco_desc' => '↓ Maior para Menor'];
        foreach ($opcoes_preco as $val => $label):
            $ativo = $ordenar === $val;
            $url = filtro_url($todos_params, 'ordenar', $val);
        ?>
        <a href="<?= $url ?>" class="filtro-check <?= $ativo ? 'ativo' : '' ?>">
            <span class="check-box"><?= $ativo ? '✓' : '' ?></span>
            <?= $label ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- TAMANHO -->
<?php
render_secao('Tamanho', 'tamanho',
    ['XS','S','M','L','XL','XXL'],
    $tamanho, $todos_params, 2);
?>

<!-- GÉNERO -->
<div class="filtro-secao">
    <div class="filtro-secao-header">
        <strong>Género</strong><span>−</span>
    </div>
    <div class="filtro-secao-body">
        <?php foreach (['Homem', 'Mulher'] as $g):
            $ativo = in_array($g, $generos_ativos);
            $p = $todos_params;
            if ($ativo) {
                $p['genero'] = array_values(array_filter($generos_ativos, fn($v) => $v !== $g));
                if (empty($p['genero'])) unset($p['genero']);
            } else {
                $p['genero'] = array_merge($generos_ativos, [$g]);
            }
            unset($p['pagina']);
            $url = 'shop.php?' . http_build_query($p);
        ?>
        <a href="<?= $url ?>" class="filtro-check <?= $ativo ? 'ativo' : '' ?>">
            <span class="check-box"><?= $ativo ? '✓' : '' ?></span>
            <?= $g ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- COMPOSIÇÃO -->
<?php
render_secao('Composição', 'composicao',
    ['Algodão','Poliéster','Liocel','Modal','Lã','Seda','Elastane','Nylon','Viscose','Spandex'],
    $composicao, $todos_params);
?>

<!-- COR -->
<div class="filtro-secao">
    <div class="filtro-secao-header"><strong>Cor</strong><span>−</span></div>
    <div class="filtro-secao-body">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
        <?php
        $cores = [
            'Preto' => '#000000', 'Branco' => '#ffffff', 'Azul' => '#1a6fc4',
            'Vermelho' => '#e53935', 'Verde' => '#2e7d32', 'Rosa' => '#f48fb1',
            'Cinza' => '#9e9e9e', 'Amarelo' => '#fdd835', 'Castanho' => '#6d4c41',
            'Laranja' => '#fb8c00', 'Roxa' => '#8e24aa', 'Caqui' => '#c8b05a'
        ];
        foreach ($cores as $nome => $hex):
            $ativo = $cor === $nome;
            $url = filtro_url($todos_params, 'cor', $nome);
        ?>
        <a href="<?= $url ?>" class="filtro-check <?= $ativo ? 'ativo' : '' ?>" style="gap:8px;">
            <span class="cor-circle" style="background:<?= $hex ?>; <?= $ativo ? 'border:2px solid #000;' : '' ?>"></span>
            <?= $nome ?>
        </a>
        <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- MATERIAL -->
<?php
render_secao('Material', 'material',
    ['Poliéster','Algodão','Lantejoulas','Misturas de Algodão','Poliuretano','Fibra Artificial'],
    $material, $todos_params);
?>

<!-- DETALHES -->
<?php
render_secao('Detalhes', 'detalhes',
    ['Nenhum','Difuso','Impressão Completa','Rasgado','Escavar','Tubulação de Contraste'],
    $detalhes, $todos_params);
?>

<!-- TIPO DE DESENHO -->
<?php
render_secao('Tipo de Desenho', 'tipo_desenho',
    ['Simples','Impressão Aleatória','Padrão Texturizado','Impressão de Pele de Cobra'],
    $tipo_desenho, $todos_params);
?>

<!-- ESTILO -->
<?php
render_secao('Estilo', 'estilo',
    ['Casual','Elegante','Desportivo','Glamour','Modesto','Boho','Sexy'],
    $estilo, $todos_params);
?>

<!-- ELASTICIDADE -->
<?php
render_secao('Elasticidade do Tecido', 'elasticidade',
    ['Estiramento Leve','Não Estirável','Stretch Médio','Estiramento Alto'],
    $elasticidade, $todos_params);
?>

<!-- TIPO DE AJUSTE -->
<?php
render_secao('Tipo de Ajuste', 'tipo_ajuste',
    ['Solto','Magro','Ajuste Regular','Slim Fit','Oversized'],
    $tipo_ajuste, $todos_params);
?>

<!-- COMPRIMENTO DA MANGA -->
<?php
render_secao('Comprimento da Manga', 'comprimento_manga',
    ['Manga Comprida','Manga Curta','Manga Cavada','Sem Mangas','Três Quartos'],
    $comprimento_manga, $todos_params);
?>

<?php if (count(array_filter($todos_params)) > 0): ?>
    <a href="shop.php" style="display:block; margin-top:20px; font-size:12px; color:#999; text-decoration:none; text-align:center; padding:8px; border:1px solid #eee;">
        ✕ Limpar todos os filtros
    </a>
<?php endif; ?>

</aside>

<main class="shop-content">

<?php
$params_base = [];
if (!empty($cat))              $params_base['cat']              = $cat;
if (!empty($pesquisa))         $params_base['pesquisa']         = $pesquisa;
if (!empty($tamanho))          $params_base['tamanho']          = $tamanho;
if (!empty($composicao))       $params_base['composicao']       = $composicao;
if (!empty($cor))              $params_base['cor']              = $cor;
if (!empty($material))         $params_base['material']         = $material;
if (!empty($detalhes))         $params_base['detalhes']         = $detalhes;
if (!empty($tipo_desenho))     $params_base['tipo_desenho']     = $tipo_desenho;
if (!empty($estilo))           $params_base['estilo']           = $estilo;
if (!empty($elasticidade))     $params_base['elasticidade']     = $elasticidade;
if (!empty($tipo_ajuste))      $params_base['tipo_ajuste']      = $tipo_ajuste;
if (!empty($comprimento_manga)) $params_base['comprimento_manga'] = $comprimento_manga;
?>



<div class="filtros-bar">
    <span class="filtros-label">Ordenar por:</span>

    <div class="ordenar-dropdown">
        <button class="ordenar-btn">
            <?php
            $labels_ordenar = [
                '' => 'Relevância',
                'vendidos' => 'Mais Vendidos',
                'preco_asc' => '↑ Menor Preço',
                'preco_desc' => '↓ Maior Preço'
            ];
            echo $labels_ordenar[$ordenar] ?? 'Relevância';
            ?>
            <i class="fas fa-chevron-down" style="font-size:10px; margin-left:6px;"></i>
        </button>
        <div class="ordenar-menu">
            <?php foreach ($labels_ordenar as $val => $label):
                $url = 'shop.php?' . http_build_query(array_merge((array)$params_base, $val ? ['ordenar' => $val] : []));
            ?>
            <a href="<?= $url ?>" class="ordenar-opcao <?= $ordenar === $val ? 'ativo' : '' ?>">
                <?= $label ?>
                <?php if ($ordenar === $val): ?>
                    <i class="fas fa-check" style="margin-left:auto; font-size:11px;"></i>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<div class="product-grid">
    <?php while ($row = mysqli_fetch_assoc($res)) { 
        $img = !empty($row['imagem']) ? $row['imagem'] : 'sapatos index2.jpg';
        $produto_id = $row['id'];
    ?>
        <div class="product-card">
            <!-- 1. Envolver a imagem com o link para a página de detalhes -->
            <div class="product-img-wrapper">
                <a href="produto.php?id=<?= $produto_id ?>" style="display: block;">
<img src="<?= !empty($row['imagem']) ? 'assets/img/produtos/' . $row['imagem'] : 'sapatos index2.jpg' ?>">                </a>
            </div>
            
            <div class="product-info">
                <!-- 2. Título também leva à página do produto -->
                <a href="produto.php?id=<?= $produto_id ?>" style="text-decoration: none; color: inherit;">
                    <h3><?= $row['designacao'] ?? 'Produto URBÆ' ?></h3>
                </a>
                
                <div class="product-info-footer">
                    <p><?= number_format($row['preco'], 2, ',', '.') ?> €</p>
                    
                    <form class="form-ajax-carrinho" style="margin:0;">
                        <input type="hidden" name="id_produto" value="<?= $produto_id ?>">
                        
                        <?php if (isset($_SESSION['utilizador'])): ?>
                            <button type="submit" class="btn-add-carrinho" title="Adicionar ao carrinho">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn-add-carrinho" onclick="alertaLogin()">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    <?php } mysqli_close($ligacao); ?>
</div>

<div class="pagination-container">
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="shop.php?pagina=<?= $i ?><?= $cat ? "&cat=$cat" : "" ?>" 
               class="<?= $i == $pagina_atual ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

<script>
    document.querySelectorAll('.form-ajax-carrinho').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 

            const formData = new FormData(this);
            const btn = this.querySelector('.btn-add-carrinho');
            const textoOriginal = btn.innerText;

            fetch('adicionar_carrinho.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                btn.innerText = "✓ Adicionado";
                btn.style.backgroundColor = "#28a745"; 

                setTimeout(() => {
                    btn.innerText = textoOriginal;
                    btn.style.backgroundColor = ""; 
                }, 2000);
            })
            .catch(error => console.error('Erro:', error));
        });
    });
    </script>
    </main> 
</div>





    







<!-- Começo do MODAL Bandeira -->

<!-- MODAL LOGIN -->
<div id="userModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close">&times;</span>

    <h2>Entrar</h2>

    <?php if (isset($_SESSION["erro"])): ?>
      <div class="msg-feedback erro">
        <?= $_SESSION["erro"]; ?>
      </div>
    <?php unset($_SESSION["erro"]); endif; ?>

    <form class="modal-form" action="login.php" method="POST">
      <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">

      <label>Utilizador</label>
      <input type="text" name="utilizador" required>

<label>Password</label>
<div style="position:relative;">
    <input type="password" name="password" id="passwordLoginInput" required style="width:100%; padding-right:40px; box-sizing:border-box;">
    <span onclick="togglePasswordLogin()" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999; font-size:14px;">
        <i class="fas fa-eye" id="eyeIconLogin"></i>
    </span>
</div>

      <button type="submit" name="botaoLogin" value="1" class="modal-btn">
        Login
      </button>
      <p style="text-align:center; margin-top:10px;">
    <a href="recuperar_password.php" style="font-size:12px; color:#888;">Esqueci a password</a>
</p>
    </form>

    <p class="modal-register">
      Ainda não tem conta? <a href="#" id="openRegister">Registar</a>
    </p>
  </div>
</div>

<!-- MODAL REGISTAR -->
<div id="registerModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close register-close">&times;</span>

    <h2>Criar Conta</h2>

    <?php if (isset($_SESSION["erro_registo"])): ?>
      <div class="msg-feedback erro">
        <?= $_SESSION["erro_registo"]; ?>
      </div>
    <?php unset($_SESSION["erro_registo"]); endif; ?>

    <?php if (isset($_SESSION["sucesso"])): ?>
      <div class="msg-feedback sucesso">
        <?= $_SESSION["sucesso"]; ?>
      </div>
    <?php unset($_SESSION["sucesso"]); endif; ?>

    <form class="modal-form" action="registar.php" method="POST">
      <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">

      <label>Utilizador</label>
      <input type="text" name="utilizador" required>

      <label>Email</label>
      <input type="email" name="email" required>

<label>Password</label>
<div style="position:relative;">
    <input type="password" name="password" id="passwordInput" required style="width:100%; padding-right:40px; box-sizing:border-box;">
    <span onclick="togglePassword()" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999; font-size:14px;">
        <i class="fas fa-eye" id="eyeIcon"></i>
    </span>
</div>
<small style="color:#999; font-size:11px; display:block; margin-top:4px; line-height:1.5;">
    Mínimo 8 caracteres, 1 maiúscula, 1 número e 1 caractere especial
</small>

      <button type="submit" name="botaoRegistar" value="1" class="modal-btn">
        Criar Conta
      </button>
    </form>

    <p class="modal-register">
      Já tem conta? <a href="#" id="voltarLogin">Entrar</a>
    </p>
  </div>
</div>


<script>
    function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }


    function togglePasswordLogin() {
    const input = document.getElementById('passwordLoginInput');
    const icon = document.getElementById('eyeIconLogin');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
}


function togglePasswordLogin() {
    const input = document.getElementById('passwordLoginInput');
    const icon = document.getElementById('eyeIconLogin');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
    </script>

    
<script>
document.addEventListener("DOMContentLoaded", () => {

  const mensagens = document.querySelectorAll(".msg-feedback");
  const inputs = document.querySelectorAll(
    "#userModal input, #registerModal input"
  );

  inputs.forEach(input => {
    input.addEventListener("input", () => {
      mensagens.forEach(msg => {
        msg.style.display = "none";
      });
    });
  });

  // LOGIN
  const userBtn = document.querySelector(".user-btn");
  const userModal = document.getElementById("userModal");
  const closeBtns = document.querySelectorAll(".modal-close");

  if (userBtn) {
    userBtn.addEventListener("click", (e) => {
      e.preventDefault();
      userModal.style.display = "flex";
    });
  }

  closeBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      userModal.style.display = "none";
    });
  });

  window.addEventListener("click", (e) => {
    if (e.target === userModal) {
      userModal.style.display = "none";
    }
  });

  // REGISTRO
  const registerModal = document.getElementById("registerModal");
  const openRegister = document.getElementById("openRegister");
  const voltarLogin = document.getElementById("voltarLogin");

  if (openRegister) {
    openRegister.addEventListener("click", (e) => {
      e.preventDefault();
      userModal.style.display = "none";
      registerModal.style.display = "flex";
    });
  }

  if (voltarLogin) {
    voltarLogin.addEventListener("click", (e) => {
      e.preventDefault();
      registerModal.style.display = "none";
      userModal.style.display = "flex";
    });
  }

  document.querySelectorAll(".register-close").forEach(btn => {
    btn.addEventListener("click", () => {
      registerModal.style.display = "none";
    });
  });

  window.addEventListener("click", (e) => {
    if (e.target === registerModal) {
      registerModal.style.display = "none";
    }
  });

});
</script>



    <nav class="nav-top">
        <div class="contact-left">
        </div>
     </nav>
<!-- MODAL E BANDEIRA FIM -->

<script src="pesquisar.js"></script>

<script>
// Guardar posição do scroll antes de sair
document.querySelectorAll('.filtro-check, .sidebar-menu a, .filtro-btn').forEach(link => {
    link.addEventListener('click', function() {
        sessionStorage.setItem('scrollPos', window.scrollY);
    });
});

// Restaurar posição do scroll ao carregar
window.addEventListener('load', function() {
    const pos = sessionStorage.getItem('scrollPos');
    if (pos) {
        window.scrollTo(0, parseInt(pos));
        sessionStorage.removeItem('scrollPos');
    }
});
</script>

<script>
document.querySelectorAll('.filtro-secao-header').forEach(header => {
    header.addEventListener('click', function() {
        // Encontra o container pai (filtro-secao)
        const secao = this.parentElement;
        
        // Alterna a classe 'fechado'
        secao.classList.toggle('fechado');
        
        // Alterna o ícone entre + e −
        const icone = this.querySelector('span');
        if (icone) {
            if (secao.classList.contains('fechado')) {
                icone.textContent = '+';
            } else {
                icone.textContent = '−';
            }
        }
    });
}); // Aqui faltava o ); no seu print
</script>


<!-- Importa a biblioteca para o pop-up bonito (SweetAlert2) -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
function alertaLogin() {
    Swal.fire({
        title: 'URBÆ',
        text: 'Para continuar, escolha uma das opções abaixo:',
        icon: 'info',
        showDenyButton: true,      // Ativa o segundo botão
        showCancelButton: true,    // Ativa o botão de cancelar
        confirmButtonColor: '#000', // Cor do Login
        denyButtonColor: '#444',    // Cor do Criar Conta
        cancelButtonColor: '#aaa',  // Cor do Continuar a ver
        confirmButtonText: 'Fazer Login',
        denyButtonText: 'Criar Conta',
        cancelButtonText: 'Continuar a ver',
        borderRadius: '0' // Estilo minimalista URBÆ
    }).then((result) => {
        if (result.isConfirmed) {
            // AÇÃO PARA FAZER LOGIN:
            // Abre o teu modal de login. 
            // Se o teu modal abre com uma função (ex: abrirModal()), coloca-a aqui:
            document.querySelector('.user-btn').click(); 
        } else if (result.isDenied) {
            // AÇÃO PARA CRIAR CONTA:
            // Abre o teu modal na aba de registo ou clica no botão do modal
            document.querySelector('.user-btn').click(); 
            // Opcional: Adicionar um pequeno delay para mudar para a aba de registo se necessário
        }
        // Se clicar em Cancelar, o modal apenas fecha e ele continua a ver
    })
}
</script>


<script>

document.getElementById('lupaBtn').addEventListener('click', function(e) {
    const input = document.getElementById('pesquisa');
    const form = document.getElementById('searchForm');

    // Se a barra estiver fechada, abre e foca nela
    if (!input.classList.contains('active')) {
        input.classList.add('active');
        input.focus();
    } 
    // Se estiver aberta e tiver texto, submete a pesquisa para shop.php
    else if (input.value.trim() !== "") {
        form.submit();
    } 
    // Se estiver aberta mas vazia, fecha a barra
    else {
        input.classList.remove('active');
    }
    
    e.stopPropagation(); // Impede que o clique feche a barra imediatamente
});

// Fechar a barra automaticamente se clicares em qualquer outro lugar do site
document.addEventListener('click', function(e) {
    const input = document.getElementById('pesquisa');
    if (!input.contains(e.target)) {
        input.classList.remove('active');
    }
});


    </script>


<!-- CHATBOT URBÆ COM IA -->
<div id="chat-bubble" onclick="toggleChat()">
    <i class="fas fa-comment-dots"></i>
</div>

<div id="chat-box">
    <div id="chat-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:8px; height:8px; background:#4caf50; border-radius:50%;"></div>
            <div>
                <div style="font-weight:600; font-size:14px;">URBÆ Assistente</div>
                <div style="font-size:10px; color:#aaa; margin-top:1px;">Powered by IA</div>
            </div>
        </div>
        <span onclick="toggleChat()" style="cursor:pointer; font-size:18px; color:#999;">&times;</span>
    </div>

    <div id="chat-messages">
        <div class="chat-msg bot">
            Olá! 👋 Sou o assistente virtual da <strong>URBÆ</strong>. Como posso ajudar?
        </div>
        <div id="chat-opcoes">
            <button class="chat-btn" onclick="enviarPergunta('O que é a URBÆ?')">O que é a URBÆ?</button>
            <button class="chat-btn" onclick="enviarPergunta('Como faço uma encomenda?')">Como faço uma encomenda?</button>
            <button class="chat-btn" onclick="enviarPergunta('Política de devoluções')">Devoluções</button>
            <button class="chat-btn" onclick="enviarPergunta('Quais são os contactos?')">Contactos</button>
        </div>
    </div>

    <div id="chat-input-area">
        <input type="text" id="chat-input" placeholder="Escreve uma mensagem..." onkeypress="if(event.key==='Enter') enviarMensagem()">
        <button onclick="enviarMensagem()"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<style>
#chat-bubble {
    position: fixed;
    bottom: 25px;
    right: 25px;
    width: 55px;
    height: 55px;
    background: #000;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    cursor: pointer;
    z-index: 99999;
    box-shadow: 0 4px 20px rgba(0,0,0,0.25);
    transition: transform 0.2s, background 0.2s;
}
#chat-bubble:hover { transform: scale(1.1); background: #333; }

#chat-box {
    display: none;
    position: fixed;
    bottom: 90px;
    right: 25px;
    width: 320px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.15);
    z-index: 99998;
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
    flex-direction: column;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

#chat-header {
    background: #000;
    color: #fff;
    padding: 15px 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#chat-messages {
    padding: 18px;
    max-height: 320px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.chat-msg {
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 13px;
    line-height: 1.5;
    max-width: 85%;
}

.chat-msg.bot {
    background: #f5f5f5;
    color: #333;
    align-self: flex-start;
    border-bottom-left-radius: 4px;
}

.chat-msg.user {
    background: #000;
    color: #fff;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
}

.chat-msg.typing {
    background: #f5f5f5;
    color: #999;
    align-self: flex-start;
    font-style: italic;
    font-size: 12px;
}

#chat-opcoes {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 5px;
}

.chat-btn {
    background: #fff;
    border: 1px solid #ddd;
    padding: 9px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
    text-align: left;
    transition: all 0.2s;
    color: #333;
}
.chat-btn:hover { border-color: #000; background: #f9f9f9; color: #000; }

#chat-input-area {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    border-top: 1px solid #f0f0f0;
    gap: 8px;
}

#chat-input {
    flex: 1;
    border: 1px solid #eee;
    padding: 9px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-family: 'Poppins', sans-serif;
    outline: none;
    transition: border-color 0.2s;
}
#chat-input:focus { border-color: #000; }

#chat-input-area button {
    background: #000;
    color: #fff;
    border: none;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    transition: background 0.2s;
    flex-shrink: 0;
}
#chat-input-area button:hover { background: #333; }
</style>

<script>
const GEMINI_API_KEY = 'AIzaSyDkdN6dbeh7sk2vdV4DAOVGUEUqPr24tFA';
const GEMINI_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=${GEMINI_API_KEY}`;

const CONTEXTO = `És o assistente virtual da URBÆ, uma marca portuguesa independente de streetwear contemporâneo e cultura urbana. 
O teu tom deve ser moderno, jovem e descontraído, mas sempre profissional, educado e focado em ajudar o cliente.

⚡ Regra dos Emojis: Usa emojis ao de leve para dar personalidade ao texto e tenta SEMPRE terminar a tua resposta com um emoji que combine com o fecho da frase (ex: 🛹, ✌️, 📦, 👕, 🔥). Sem exageros no meio do texto.

Informações Detalhadas da URBÆ:
• O que vendemos 👕: Sweaters, camisas, calças, calçado e acessórios (braceletes e relógios). As nossas peças seguem a tendência de streetwear com foco em designs exclusivos e cortes modernos.
• Tamanhos e Ajuste 📐: Temos tamanhos do S ao XL. Várias das nossas peças têm um corte ligeiramente oversized, ideal para o estilo urbano.
• Pagamentos 💳: Aceitamos PayPal, Multibanco (entidade e referência geradas na hora) e cartões Mastercard. O processo é 100% seguro.
• Portes e Envios 📦: O envio é totalmente gratuito para encomendas acima de 45€. Para valores inferiores, o custo do transporte é calculado no checkout.
• Prazos e Rastreio 🚚: A entrega demora entre 8 a 11 dias úteis. Assim que o pedido sair do armazém, enviamos um email ao cliente com o código de rastreio para acompanhar a entrega.
• Trocas e Devoluções 🔄: O cliente tem 14 dias após a receção para solicitar a troca ou devolução. O artigo deve estar sem marcas de uso, sem lavagens e com todas as etiquetas originais afixadas.
• Contactos e Horário 📱: Atendimento de Segunda a Sexta, das 09h às 18h. Email: urbaegeral@gmail.com | Telemóvel: 911 825 589.
• Onde estamos 📍: Situados na N1, Coimbra, Portugal. Nota: Este espaço serve apenas como escritório/central logístico, as vendas são feitas exclusivamente na nossa loja online.

Diretrizes de Resposta:
1. Sê muito direto. Responde em formato curto (máximo 3-4 linhas) para o chat ser dinâmico e fácil de ler no telemóvel.
2. Restringe-te ao universo da URBÆ. Se tentarem falar de política, futebol ou outros temas de fora, desvia o assunto com simpatia e diz que só estás programado para ajudar com o streetwear e a nossa loja.`;

let historico = [];

function toggleChat() {
    const box = document.getElementById('chat-box');
    if (box.style.display === 'flex') {
        box.style.display = 'none';
    } else {
        box.style.display = 'flex';
        box.style.flexDirection = 'column';
    }
}

function adicionarMensagem(texto, tipo) {
    const msgs = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.className = 'chat-msg ' + tipo;
    div.innerHTML = texto.replace(/\n/g, '<br>');
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
    return div;
}

function esconderOpcoes() {
    const opcoes = document.getElementById('chat-opcoes');
    if (opcoes) opcoes.style.display = 'none';
}

async function enviarPergunta(pergunta) {
    esconderOpcoes();
    adicionarMensagem(pergunta, 'user');
    await chamarGemini(pergunta);
}

async function enviarMensagem() {
    const input = document.getElementById('chat-input');
    const texto = input.value.trim();
    if (!texto) return;
    input.value = '';
    esconderOpcoes();
    adicionarMensagem(texto, 'user');
    await chamarGemini(texto);
}

async function chamarGemini(pergunta) {
    const typing = adicionarMensagem('A escrever...', 'typing');

    historico.push({ role: 'user', parts: [{ text: pergunta }] });

    const mensagens = [
        { role: 'user', parts: [{ text: CONTEXTO }] },
        { role: 'model', parts: [{ text: 'Entendido! Estou pronto para ajudar com questões sobre a URBÆ.' }] },
        ...historico
    ];

    try {
        const response = await fetch(GEMINI_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ contents: mensagens })
        });

        const data = await response.json();
        console.log('Resposta Gemini:', JSON.stringify(data));

        if (data.error) {
            historico.pop(); // remove a pergunta se houve erro
            typing.remove();
            adicionarMensagem('Erro da API: ' + data.error.message, 'bot');
            return;
        }

        const resposta = data.candidates?.[0]?.content?.parts?.[0]?.text;
        
        if (!resposta) {
            historico.pop();
            typing.remove();
            adicionarMensagem('Não consegui gerar uma resposta. Tenta novamente.', 'bot');
            return;
        }

        historico.push({ role: 'model', parts: [{ text: resposta }] });
        typing.remove();
        adicionarMensagem(resposta, 'bot');

    } catch (error) {
        historico.pop();
        typing.remove();
        console.error('Erro:', error);
        adicionarMensagem('Erro de ligação. Verifica a tua internet.', 'bot');
    }
}
</script>


<script>
    function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
    </script>


</body>
	<!-- MODAL DE IDIOMAS -->
    <div id="langModal" class="modal-overlay" style="display:none;">
      <div class="modal-box" style="max-width:300px; text-align:center;">
        <span class="modal-close" id="closeLangModal">&times;</span>

        <h2>Escolher Idioma</h2>

        <div class="lang-options" style="margin-top:20px; display:flex; justify-content:space-around;">
          
          <!-- PORTUGUÊS -->
          <a href="index.php" class="lang-choice">
            <img src="https://flagcdn.com/w40/pt.png" alt="Português">
            <p>Português</p>
          </a>

          <!-- INGLÊS -->
          <a href="indexeng.php" class="lang-choice">
            <img src="https://flagcdn.com/w40/us.png" alt="English">
            <p>English</p>
          </a>

        </div>
      </div>
    </div>

    <!-- SCRIPT DO MODAL -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {

        const langModal = document.getElementById("langModal");
        const openLangModal = document.getElementById("openLangModal");
        const closeLangModal = document.getElementById("closeLangModal");

        openLangModal.addEventListener("click", (e) => {
            e.preventDefault();
            langModal.style.display = "flex";
        });

        closeLangModal.addEventListener("click", () => {
            langModal.style.display = "none";
        });

        window.addEventListener("click", (e) => {
            if (e.target === langModal) {
                langModal.style.display = "none";
            }
        });

    });
    </script>
    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">

            <div class="footer-top">

                <div class="footer-box">
                    <h2 class="footer-title green">URBÆ</h2>
                    <hr style="background-color: #474747; border: none; opacity: 0.4; height: 1px;">
                    <br>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> N1, Coimbra</li>
                        <li><i class="fas fa-phone"></i> 911-825-589</li>
                        <li><i class="fas fa-envelope"></i> urbaegeral@gmail.com</li>
                    </ul>
                </div>

                    <div class="footer-box">
                        <h2 class="footer-title">Nossas Coleções</h2>
                        <hr style="height: 1px; background-color: #474747; border: none; opacity: 0.4;">
                        <br>
                        <ul>
                            <li><a href="shop.php?cat=camisas">Camisas</a></li>
                            <li><a href="shop.php?cat=sweaters">Sweaters</a></li>
                            <li><a href="shop.php?cat=Calcas">Calças</a></li>
                            <li><a href="shop.php?cat=sapatos">Sapatos</a></li>
                            <li><a href="shop.php?cat=Braceletes">Braceletes</a></li>
                            <li><a href="shop.php?cat=acessorios">Acessórios</a></li>
                            <li><a href="shop.php?cat=relogios">Relógios</a></li>
                        </ul>
                    </div>

                <div class="footer-box">
                    <h2 class="footer-title">Mais informações</h2>
                    <hr style="height: 1px; background-color: #474747; border: none; opacity: 0.4;">
                    <br>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">Sobre nós</a></li>
                        <li><a href="contact.php">Contacto</a></li>
                        <li><a href="termos.php">Termos e Condições</a></li>
                        <li><a href="politicaprivacidade.php">Política de Privacidade</a></li>
                        <li><a href="pagamento_e_impostos.php">pagamento e impostos</a></li>
                    </ul>
                </div>

            </div>

            <hr class="footer-line">

            <div class="footer-bottom">
                <div class="socials">
                    <a href="https://www.instagram.com/urbae_231/"><i class="fab fa-instagram"></i></a>
                </div>

                <!-- NEWSLETTER PARA EMAIL -->
              <div class="newsletter">
    <form action="subscrever.php" method="POST">
        <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
        <input type="email" name="email" placeholder="Endereço de email" required>
        <button type="submit">Inscrever-se</button>
    </form>

                  <?php if (isset($_GET["newsletter"])): ?>

                      <?php if ($_GET["newsletter"] == "sucesso"): ?>
                          <p style="color:lightgreen; margin-top:8px;">
                              Subscrição efetuada com sucesso!
                          </p>

                      <?php elseif ($_GET["newsletter"] == "existe"): ?>
                          <p style="color:#ff4d4d; margin-top:8px;">
                              Este email já está subscrito.
                          </p>

                      <?php else: ?>
                          <p style="color:#ff4d4d; margin-top:8px;">
                              Email inválido.
                          </p>
                      <?php endif; ?>

                  <?php endif; ?>

              </div>

               <!-- NEWSLETTER PARA EMAIL FIM-->


            <p class="copyright">
                &copy; 2024 Alexandre. All rights reserved.
            </p>

        </div>
    </footer>
    
</html>
