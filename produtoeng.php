<?php
session_start();
$cat = isset($_GET['cat']) ? $_GET['cat'] : '';
$pesquisa = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
require ".ht_conexao-bd.php"; // Usa a tua variável $conexao


// 1. Capturar o ID do produto vindo da URL (produto.php?id=...)
$id = isset($_GET['id']) ? mysqli_real_escape_string($conexao, $_GET['id']) : 0;

// 2. Procurar os dados do produto na Base de Dados
$sql = "SELECT * FROM produtos WHERE id = '$id'";
$res = mysqli_query($conexao, $sql);
$produto = mysqli_fetch_assoc($res);

// 3. Se o produto não existir, volta para o shop
if (!$produto) {
    header("Location: shopeng.php");
    exit();
}

// Configurar a imagem
$img = !empty($produto['imagem']) ? $produto['imagem'] : 'default.jpg';

// Pegar os novos detalhes diretamente da variável $produto que veio da BD
$cor        = !empty($produto['cor_en'])        ? $produto['cor_en']        : ($produto['cor'] ?? 'Not defined');
$material   = !empty($produto['material_en'])   ? $produto['material_en']   : ($produto['material'] ?? 'Not specified');
$composicao = !empty($produto['composicao_en']) ? $produto['composicao_en'] : ($produto['composicao'] ?? 'N/A');
$estilo     = !empty($produto['estilo_en'])     ? $produto['estilo_en']     : ($produto['estilo'] ?? 'Urban');
$elasticidade = !empty($produto['elasticidade_en']) ? $produto['elasticidade_en'] : ($produto['elasticidade'] ?? 'N/A');
$detalhes     = !empty($produto['detalhes_en']) ? $produto['detalhes_en'] : ($produto['detalhes'] ?? '');?>


<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produto['designacao'] ?> | URBÆ</title>
    
    <link rel="icon" type="image/x-icon" href="URBAE COMPLETO.png">
    <link rel="shortcut icon" href="URBAE COMPLETO.png">

    <link rel="stylesheet" href="style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>

/* --- CONTAINER DE ENVIO ESTILO MARKETPLACE --- */
.shipping-info-card {
    background-color: #f8f8f8; /* Cinza muito claro */
    padding: 20px;
    margin-top: 30px;
    border-radius: 4px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.shipping-header {
    font-size: 14px;
    margin-bottom: 5px;
}

.shipping-header span {
    color: #666;
}

.shipping-item {
    display: flex;
    gap: 15px;
    align-items: flex-start;
}

/* Ícones em Verde */
.shipping-icon i {
    font-size: 20px;
    color: #2c8c5c; /* Verde SHEIN / Sustentável */
}

.shipping-text {
    flex: 1;
}

.shipping-title {
    font-size: 13px;
    font-weight: 700;
    color: #222;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.arrow-detail {
    font-size: 10px;
    color: #999;
}

.shipping-text p {
    font-size: 12px;
    color: #222;
    line-height: 1.4;
    margin-top: 4px;
}

.shipping-text p span {
    color: #999;
}

/* Tags de Segurança */
.security-tags {
    display: flex;
    gap: 15px;
    margin-top: 8px;
    background: #eef9f3; /* Fundo verde clarinho */
    padding: 8px;
    border-radius: 2px;
}

.security-tags span {
    font-size: 11px;
    color: #2c8c5c;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Badge Marketplace */
.badge-market {
    background: #000;
    color: #fff;
    padding: 2px 6px;
    font-size: 10px;
    text-transform: uppercase;
    border-radius: 2px;
    margin-right: 5px;
}

        /* --- BOTÃO VOLTAR --- */
.back-button-container {
    width: 100%;
    margin-bottom: 20px;
    display: block;
}

/* --- BOTÃO VOLTAR (UNIFICADO) --- */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: #000 !important; /* Força o preto */
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 50px; /* Dá o espaço para o SHOP respirar */
    transition: 0.3s;
}

.btn-back:hover {
    opacity: 0.5;
}

.btn-back i {
    font-size: 10px;
}

.btn-back:hover {
    opacity: 0.5; /* Apenas um feedback visual simples */
}

/* Ajuste na estrutura para o botão ficar no topo */
.product-container {
    display: flex;
    flex-wrap: wrap; /* Permite que o botão ocupe a largura total no topo */
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 40px;
    gap: 60px;
}

.product-left, .product-right {
    flex: 1;
}

@media (max-width: 768px) {
    .product-container {
        flex-direction: column;
    }
}


        /* --- RESET E BASES --- */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background-color: #fff;
    color: #1a1a1a;
    overflow-x: hidden;
}

/* --- ANIMAÇÃO DE ENTRADA --- */
main {
    animation: fadeIn 0.8s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* --- CONTAINER PRINCIPAL --- */
.product-container {
    max-width: 1200px;
    margin: 60px auto;
    padding: 0 40px;
    display: flex;
    gap: 80px;
    align-items: flex-start;
}

/* --- COLUNA ESQUERDA: IMAGEM --- */
.product-left {
    flex: 1.3;
    background-color: #f9f9f9;
    border-radius: 4px;
    overflow: hidden;
}

.product-left img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.8s cubic-bezier(0.2, 1, 0.3, 1);
}

.product-left:hover img {
    transform: scale(1.05);
}

/* --- COLUNA DIREITA: INFO --- */
.product-right {
    flex: 1;
    position: sticky;
    top: 40px;
}

.breadcrumb {
    font-size: 11px;
    letter-spacing: 2px;
    color: #999;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.breadcrumb a {
    text-decoration: none;
    color: #999; /* Cor cinza suave */
    transition: 0.3s;
}

.breadcrumb a:hover {
    color: #000;
}

.product-right h1 {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 10px;
    letter-spacing: -1px;
    text-transform: uppercase;
}

.product-price {
    font-size: 24px;
    font-weight: 400;
    color: #333;
    margin-bottom: 30px;
}

.size-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.size-btn {
    width: 48px;
    height: 48px;
    border: 1px solid #ddd;
    background: #fff;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Poppins', sans-serif;
}

.size-btn:hover {
    border-color: #000;
}

.size-btn.selecionado {
    background: #000;
    color: #fff;
    border-color: #000;
}

/* --- EXIBIÇÃO DE TAMANHO --- */
.product-size-display {
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.size-label {
    font-size: 12px;
    font-weight: 700;
    color: #888;
    letter-spacing: 1px;
}

.size-value {
    font-size: 14px;
    font-weight: 600;
    color: #000;
    border: 1px solid #000;
    padding: 6px 18px;
    display: inline-block;
}

/* --- CAIXA DE DESCRIÇÃO --- */
.description-box {
    margin-bottom: 35px;
    padding-top: 25px;
    border-top: 1px solid #eee;
}

.description-box h4 {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    margin-bottom: 12px;
    color: #000;
}

.description-box p {
    font-size: 15px;
    line-height: 1.7;
    color: #666;
}

/* --- BOTÃO DE COMPRA --- */
.btn-buy-large {
    width: 100%;
    padding: 20px;
    background: #000;
    color: #fff;
    border: 1px solid #000;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-buy-large:hover {
    background: #fff;
    color: #000;
}

/* --- BADGES DE CONFIANÇA --- */
.trust-badges {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.badge-item {
    font-size: 12px;
    color: #444;
    display: flex;
    align-items: center;
    gap: 10px;
}

.badge-item i {
    font-size: 16px;
    color: #2c2c2c;
    width: 20px;
}

/* --- RESPONSIVIDADE --- */
@media (max-width: 900px) {
    .product-container {
        flex-direction: column;
        padding: 20px;
        gap: 40px;
    }
    .product-right {
        position: static;
    }
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
        <a href="https://www.instagram.com/urbae_eng/"><i class="fab fa-instagram"></i></a>
    </div>
    </nav>
  <!-- NAV CINZENTA AZULADO DO TOPO FIM-->
    <hr>


    <!-- NAV BRANCA URBÆ -->
<header class="URBAE-nav">

        <a href="indexeng.php">
            <img src="URBAE verde logo.png" alt="URBAE Logo" height="90" width="110" style="margin-left: 30px;">
        </a>

        <nav class="nav-links">
    <a href="indexeng.php">Home</a>
    <a href="abouteng.php">About</a>
    <a href="shopeng.php">Shop</a>
    <a href="contacteng.php">Contact</a>

    <?php if (isset($_SESSION["id_tipos_utilizador"]) && $_SESSION["id_tipos_utilizador"] == 0): ?>
        <a href="admineng.php">Admin Panel</a>
    <?php endif; ?>
</nav>
        <!-- GERIR UTILIZADORES LINK (APENAS PARA ADMIN) Fim -->



     <div class="nav-icons">
    <!-- Action corrigido para shop.php -->
    <form method="GET" action="shopeng.php" id="searchForm" style="display:flex; align-items:center; gap:6px;">
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
    <a href="#" class="icon-badge" onclick="alert('You need to log in to access the cart!'); return false;">
        <i class="fas fa-shopping-cart"></i>
    </a>
<?php else: ?>
    <a href="carrinhoeng.php" class="icon-badge">
        <i class="fas fa-shopping-cart"></i>
    </a>
<?php endif; ?>

<?php if (!isset($_SESSION["utilizador"])): ?>
    <a href="#" class="icon-badge user-btn">
        <i class="fas fa-user"></i>
    </a>
<?php else: ?>
    <a href="perfileng.php" class="icon-badge" title="My Profile">
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

<a href="#" class="icon-badge lang-btn" id="openLangModal" title="Idioma">
    <img src="https://flagcdn.com/w20/us.png" alt="en">
</a>
    </div>

    </header>
    <!-- NAV BRANCA URBÆ FIM-->

    <main class="product-container">

        <!-- COLUNA ESQUERDA: IMAGEM -->
        <div class="product-left">
            <img src="<?= !empty($produto['imagem']) ? 'assets/img/produtos/' . $produto['imagem'] : 'assets/img/produtos/default.jpg' ?>" alt="<?= $produto['designacao'] ?>">        </div>
        </div>

        <!-- COLUNA DIREITA: INFO -->
            <div class="product-right">
            <!-- Botão Voltar agora integrado aqui -->
            <a href="shopeng.php" class="btn-back">
                <i class="fas fa-chevron-left"></i> Go to Shop
            </a>

            <nav class="breadcrumb">
                <a href="shopeng.php">SHOP</a> / <?= strtoupper($produto['designacao']) ?>
            </nav>
            
            <!-- Resto do conteúdo (H1, Preço, etc) -->

            <h1><?= $produto['designacao'] ?></h1>
            <p class="product-price"><?= number_format($produto['preco'], 2, ',', '.') ?> €</p>

            <!-- TAMANHOS -->
            <div class="product-size-section">
                <div style="font-size:12px; font-weight:700; color:#888; letter-spacing:1px; margin-bottom:10px;">TAMANHO</div>
                <div class="size-buttons">
                    <?php
                    $tamanhos = !empty($produto['tamanho']) ? explode(',', $produto['tamanho']) : ['ÚNICO'];
                    foreach ($tamanhos as $t):
                        $t = trim($t);
                    ?>
                    <button class="size-btn" onclick="selecionarTamanho(this, '<?= $t ?>')"><?= strtoupper($t) ?></button>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" id="tamanho_selecionado" name="tamanho" value="">
                <p id="aviso-tamanho" style="color:#e74c3c; font-size:12px; margin-top:8px; display:none;">Por favor seleciona um tamanho.</p>
            </div>

            <div class="description-box">
                <h3>Descrição</h3>
            <p><?= !empty($produto['descricao_en']) ? $produto['descricao_en'] : (!empty($produto['descricao']) ? $produto['descricao'] : "This exclusive URBÆ piece defines modern urban style with premium comfort.") ?></p>            </div>
            <div class="product-specs" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
    <p style="font-size: 13px; margin-bottom: 5px;"><strong>Color:</strong> <?= $cor ?></p>
    <p style="font-size: 13px; margin-bottom: 5px;"><strong>Material:</strong> <?= $material ?></p>
    <p style="font-size: 13px; margin-bottom: 5px;"><strong>Composition:</strong> <?= $composicao ?></p>
    <p style="font-size: 13px; margin-bottom: 5px;"><strong>Style:</strong> <?= $estilo ?></p>
    <p style="font-size: 13px; margin-bottom: 5px;"><strong>Elasticity:</strong> <?= $elasticidade ?></p>
    </div>
    <br>



<!-- FORMULÁRIO AJAX CARRINHO -->
<form class="form-ajax-carrinho">
    <input type="hidden" name="id_produto" value="<?= $produto['id'] ?>">
    <input type="hidden" id="tamanho_selecionado" name="tamanho" value="">
    
    <?php if (isset($_SESSION['utilizador'])): ?>
        <button type="submit" class="btn-buy-large">
            ADD TO CART
        </button>
    <?php else: ?>
        <button type="button" class="btn-buy-large" onclick="alertaLogin()">
            ADD TO CART
        </button>
    <?php endif; ?>
</form>
<p id="aviso-tamanho" style="color:#e74c3c; font-size:12px; margin-top:8px; display:none;">Please select a size.</p>



            <!-- BADGES DE CONFIANÇA -->
<div class="shipping-info-card">
    <div class="shipping-header">
        <strong>Shipping to</strong> <span>Portugal</span>
    </div>

    <!-- Item: Envio -->
    <div class="shipping-item">
        <div class="shipping-icon"><i class="fas fa-truck"></i></div>
        <div class="shipping-text">
            <div class="shipping-title">Free Shipping (Orders ≥ 14,90€) <i class="fas fa-chevron-right arrow-detail"></i></div>
            <p>Estimated Delivery: 8-11 Business Days <span>(Special products, delivery time may be longer than usual.)</span></p>
        </div>
    </div>

    <!-- Item: Devolução -->
    <div class="shipping-item" id="btn-devolucao" style="cursor: pointer;">
    <div class="shipping-icon"><i class="fas fa-undo-alt"></i></div>
    <div class="shipping-text">
        <div class="shipping-title">Return Policy <i class="fas fa-chevron-right arrow-detail"></i></div>
        <div class="security-tags">
            <span><i class="fas fa-check"></i> Free Returns</span>
            <span><i class="fas fa-check"></i> 30-day Return Period</span>
        </div>
    </div>
</div>

    <!-- Item: Segurança -->
<div class="shipping-item" id="btn-seguranca" style="cursor: pointer;">
    <div class="shipping-icon"><i class="fas fa-shield-alt"></i></div>
    <div class="shipping-text">
        <div class="shipping-title">Shopping Security <i class="fas fa-chevron-right arrow-detail"></i></div>
        <div class="security-tags">
            <span><i class="fas fa-check"></i> Secure Payments</span>
            <span><i class="fas fa-check"></i> Privacy Protection</span>
        </div>
    </div>
</div>
    
    <!-- Item: Vendedor -->
    <div class="shipping-item">
        <div class="shipping-icon"><i class="fas fa-store"></i></div>
        <div class="shipping-text">
            <div class="shipping-title"><span class="badge-market">Marketplace</span> Sold by: <strong>URBÆ Official</strong></div>
            <p>Shipped by URBÆ Logistics</p>
        </div>
    </div>
</div>
        </div>
    </main>

    <!-- SCRIPTS (JQuery, SweetAlert e Lógica AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        $('.form-ajax-carrinho').on('submit', function(e) {
            e.preventDefault();
            var btn = $(this).find('button');
            var dados = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: 'adicionar_carrinho.php',
                data: dados,
                success: function(resposta) {
                    if (resposta.trim() === 'sucesso') {
                        // Feedback visual de sucesso
                        btn.html('<i class="fas fa-check"></i> Added to Cart').css({
                            'background': '#5d8e46',
                            'border-color': '#5d8e46',
                            'color': '#fff'
                        });
                        
                        setTimeout(() => { 
                            btn.html('ADD TO CART').css({
                                'background': '#000',
                                'border-color': '#000'
                            }); 
                        }, 2000);
                    } else if (resposta.trim() === 'not_logged_in') {
                        alertaLogin();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error adding to cart: ' + resposta,
                            confirmButtonColor: '#000'
                        });
                    }
                }
            });
        });
    });

    function alertaLogin() {
        Swal.fire({
            title: 'URBÆ',
            text: 'Please log in to add this item to your cart.',
            icon: 'info',
            confirmButtonText: 'LOG IN',
            confirmButtonColor: '#000',
            showCancelButton: true,
            cancelButtonText: 'CLOSE'
        }).then((result) => {
            if (result.isConfirmed) {
                // Se tiveres um modal de login no index, podes tentar abrir, 
                // caso contrário redireciona:
                window.location.href = 'indexeng.php'; 
            }
        });
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

<script src="pesquisar.js"></script>


    <nav class="nav-top">
        <div class="contact-left">
        </div>
     </nav>

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


<script>
// BOTÃO SEGURANÇA
document.getElementById('btn-seguranca').addEventListener('click', function() {
    Swal.fire({
        title: '<span style="font-size: 20px; font-weight: bold;">Secure Shopping</span>',
        html: `
            <div style="text-align: left; font-family: sans-serif; color: #333; line-height: 1.5;">
                <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
                <p style="color: #2c8c5c; font-weight: bold; font-size: 14px;">● Secure Payments</p>
                <p style="font-size: 12px; color: #666; margin-left: 15px;">
                    Your payment on URBÆ is protected by global certifications.
                    <a href="pagamento_e_impostoseng.php" style="color: #007bff; text-decoration: none;">Learn more</a>
                </p>
                <div style="margin: 10px 0 20px 15px; display: flex; gap: 10px;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" width="50">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/MasterCard_Logo.svg" width="35">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" width="15">
                </div>
                <p style="color: #2c8c5c; font-weight: bold; font-size: 14px;">● Secure Logistics</p>
                <p style="font-size: 12px; color: #666; margin-left: 15px;">1. Real-time tracking.<br>2. Full refund for damages.</p>
            </div>
        `,
        showConfirmButton: false,
        showCloseButton: true,
        width: '500px'
    });
});

// BOTÃO DEVOLUÇÃO
document.getElementById('btn-devolucao').addEventListener('click', function() {
    Swal.fire({
        title: '<span style="font-size: 20px; font-weight: bold;">Return Policy</span>',
        html: `
            <div style="text-align: left; font-family: sans-serif; color: #333; line-height: 1.5;">
                <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
                <p style="color: #2c8c5c; font-weight: bold; font-size: 14px;">● Easy Returns</p>
                <p style="font-size: 12px; color: #666; margin-left: 15px;">
                    You can return the item within 30 days. 
                    <a href="termoseng.php" id="link-termos-popup" style="color: #007bff; text-decoration: none; font-weight: 500; cursor: pointer;">Learn more</a>
                </p>
                <ul style="font-size: 12px; color: #666; margin-left: 15px;">
                    <li>Item in original condition.</li>
                    <li>Full refund within 5 business days.</li>
                </ul>
            </div>
        `,
        showConfirmButton: false,
        showCloseButton: true,
        width: '500px',
        didOpen: () => {
            const link = document.getElementById('link-termos-popup');
            if (link) {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.location.href = 'termoseng.php';
                });
            }
        }
    });
});
</script>

<!-- MODAL IDIOMAS -->
<div id="langModal" class="modal-overlay" style="display:none;">
    <div class="modal-box" style="max-width:300px; text-align:center;">
        <span class="modal-close" id="closeLangModal">&times;</span>
        <h2>Escolher Idioma</h2>
        <div style="margin-top:20px; display:flex; justify-content:space-around;">
            <a href="index.php" class="lang-choice">
                <img src="https://flagcdn.com/w40/pt.png" alt="Português"><p>Português</p>
            </a>
            <a href="indexeng.php" class="lang-choice">
                <img src="https://flagcdn.com/w40/us.png" alt="English"><p>English</p>
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

    <script>

        function selecionarTamanho(btn, tamanho) {
    document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('selecionado'));
    btn.classList.add('selecionado');
    document.getElementById('tamanho_selecionado').value = tamanho;
    document.getElementById('aviso-tamanho').style.display = 'none';
}

        </script>

        

<!-- MODAL LOGIN -->
<div id="userModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close">&times;</span>
    <h2>Entrar</h2>
    <?php if (isset($_SESSION["erro"])): ?>
      <div class="msg-feedback erro"><?= $_SESSION["erro"]; ?></div>
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
      <button type="submit" name="botaoLogin" value="1" class="modal-btn">Login</button>
      <p style="text-align:center; margin-top:10px;">
        <a href="recuperar_password.php" style="font-size:12px; color:#888;">Esqueci a password</a>
      </p>
    </form>
    <p class="modal-register">Ainda não tem conta? <a href="#" id="openRegister">Registar</a></p>
  </div>
</div>

<!-- MODAL REGISTAR -->
<div id="registerModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close register-close">&times;</span>
    <h2>Criar Conta</h2>
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
    Minimum 8 characters, 1 uppercase letter, 1 number and 1 special character
</small>
      <button type="submit" name="botaoRegistar" value="1" class="modal-btn">Criar Conta</button>
    </form>
    <p class="modal-register">Já tem conta? <a href="#" id="voltarLogin">Entrar</a></p>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const userBtn = document.querySelector(".user-btn");
    const userModal = document.getElementById("userModal");
    const registerModal = document.getElementById("registerModal");

    userBtn?.addEventListener("click", e => { e.preventDefault(); userModal.style.display = "flex"; });
    document.querySelectorAll(".modal-close").forEach(btn => btn.addEventListener("click", () => userModal.style.display = "none"));
    document.querySelector(".register-close")?.addEventListener("click", () => registerModal.style.display = "none");
    document.getElementById("openRegister")?.addEventListener("click", e => { e.preventDefault(); userModal.style.display = "none"; registerModal.style.display = "flex"; });
    document.getElementById("voltarLogin")?.addEventListener("click", e => { e.preventDefault(); registerModal.style.display = "none"; userModal.style.display = "flex"; });
    window.addEventListener("click", e => { if (e.target === userModal) userModal.style.display = "none"; if (e.target === registerModal) registerModal.style.display = "none"; });
});
</script>


<!-- MODAL LOGIN -->
<div id="userModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close">&times;</span>
    <h2>Entrar</h2>
    <?php if (isset($_SESSION["erro"])): ?>
      <div class="msg-feedback erro"><?= $_SESSION["erro"]; ?></div>
    <?php unset($_SESSION["erro"]); endif; ?>
    <form class="modal-form" action="login.php" method="POST">
      <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
      <label>Utilizador</label>
      <input type="text" name="utilizador" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <button type="submit" name="botaoLogin" value="1" class="modal-btn">Login</button>
      <p style="text-align:center; margin-top:10px;">
        <a href="recuperar_password.php" style="font-size:12px; color:#888;">Esqueci a password</a>
      </p>
    </form>
    <p class="modal-register">Ainda não tem conta? <a href="#" id="openRegister">Registar</a></p>
  </div>
</div>

<!-- MODAL REGISTAR -->
<div id="registerModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close register-close">&times;</span>
    <h2>Criar Conta</h2>
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
    Minimum 8 characters, 1 uppercase letter, 1 number and 1 special character
</small>
      <button type="submit" name="botaoRegistar" value="1" class="modal-btn">Criar Conta</button>
    </form>
    <p class="modal-register">Já tem conta? <a href="#" id="voltarLogin">Entrar</a></p>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const userBtn = document.querySelector(".user-btn");
    const userModal = document.getElementById("userModal");
    const registerModal = document.getElementById("registerModal");

    userBtn?.addEventListener("click", e => { e.preventDefault(); userModal.style.display = "flex"; });
    document.querySelectorAll(".modal-close").forEach(btn => btn.addEventListener("click", () => userModal.style.display = "none"));
    document.querySelector(".register-close")?.addEventListener("click", () => registerModal.style.display = "none");
    document.getElementById("openRegister")?.addEventListener("click", e => { e.preventDefault(); userModal.style.display = "none"; registerModal.style.display = "flex"; });
    document.getElementById("voltarLogin")?.addEventListener("click", e => { e.preventDefault(); registerModal.style.display = "none"; userModal.style.display = "flex"; });
    window.addEventListener("click", e => { if (e.target === userModal) userModal.style.display = "none"; if (e.target === registerModal) registerModal.style.display = "none"; });
});
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
                    <h2 class="footer-title">Our Collections</h2>
                    <hr style="height: 1px; background-color: #474747; border: none; opacity: 0.4;">
                    <br>
                    <ul>
                        <li><a href="shopeng.php?cat=camisas">Shirts</a></li>
                        <li><a href="shopeng.php?cat=sweaters">Sweaters</a></li>
                        <li><a href="shopeng.php?cat=Calcas">Trousers</a></li>
                        <li><a href="shopeng.php?cat=sapatos">Shoes</a></li>
                        <li><a href="shopeng.php?cat=Braceletes">Bracelets</a></li>
                        <li><a href="shopeng.php?cat=acessorios">Accessories</a></li>
                        <li><a href="shopeng.php?cat=relogios">Watches</a></li>
                    </ul>
                </div>

                <div class="footer-box">
                    <h2 class="footer-title">More Information</h2>
                    <hr style="height: 1px; background-color: #474747; border: none; opacity: 0.4;">
                    <br>
                    <ul>
                        <li><a href="indexeng.php">Home</a></li>
                        <li><a href="abouteng.php">About Us</a></li>
                        <li><a href="contacteng.php">Contact</a></li>
                        <li><a href="termoseng.php">Terms and Conditions</a></li>
                        <li><a href="politicaprivacidadeeng.php">Privacy Policy</a></li>
                        <li><a href="pagamento_e_impostoseng.php">Payment and Taxes</a></li>
                    </ul>
                </div>

            </div>

            <hr class="footer-line">

            <div class="footer-bottom">
                <div class="socials">
                    <a href="https://www.instagram.com/urbae_eng/"><i class="fab fa-instagram"></i></a>
                </div>

                <!-- NEWSLETTER PARA EMAIL -->
              <div class="newsletter">
    <form action="subscrever.php" method="POST">
        <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
        <input type="email" name="email" placeholder="Email address" required>
        <button type="submit">Subscribe</button>
    </form>

                  <?php if (isset($_GET["newsletter"])): ?>

                      <?php if ($_GET["newsletter"] == "sucesso"): ?>
                          <p style="color:lightgreen; margin-top:8px;">
                              Subscription successful!
                          </p>

                      <?php elseif ($_GET["newsletter"] == "existe"): ?>
                          <p style="color:#ff4d4d; margin-top:8px;">
                              This email is already subscribed.
                          </p>

                      <?php else: ?>
                          <p style="color:#ff4d4d; margin-top:8px;">
                              Invalid email address.
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

        </script>

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
                <div style="font-weight:600; font-size:14px;">URBÆ Assistant</div>
                <div style="font-size:10px; color:#aaa; margin-top:1px;">Powered by IA</div>
            </div>
        </div>
        <span onclick="toggleChat()" style="cursor:pointer; font-size:18px; color:#999;">&times;</span>
    </div>

    <div id="chat-messages">
        <div class="chat-msg bot">
            Hello! 👋 I am the virtual assistant of <strong>URBÆ</strong>. How can I help you?
        </div>
        <div id="chat-opcoes">
            <button class="chat-btn" onclick="enviarPergunta('What is URBÆ?')">What is URBÆ?</button>
            <button class="chat-btn" onclick="enviarPergunta('How do I place an order?')">How do I place an order?</button>
            <button class="chat-btn" onclick="enviarPergunta('Returns Policy')">Returns Policy</button>
            <button class="chat-btn" onclick="enviarPergunta('Contact Information')">Contact Information</button>
        </div>
    </div>

    <div id="chat-input-area">
        <input type="text" id="chat-input" placeholder="Type a message..." onkeypress="if(event.key==='Enter') enviarMensagem()">
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
const GEMINI_API_KEY = 'AIzaSyB3Z0DrVVGc70Km3lTqT0eN1ulBvFwQvXA';
const GEMINI_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=${GEMINI_API_KEY}`;

const CONTEXTO = `You are the virtual assistant for URBÆ, an independent Portuguese brand focused on contemporary streetwear and urban culture. 
Your tone should be modern, young, and laid-back, yet always professional, polite, and focused on helping the customer.

⚡ Emoji Rule: Use emojis lightly to add personality to the text and ALWAYS try to end your response with an emoji that matches the closing of the sentence (e.g., 🛹, ✌️, 📦, 👕, 🔥). Do not overuse them in the middle of the text.
Always respond in English.

Detailed URBÆ Information:
• What we sell 👕: Sweaters, shirts, pants, footwear, and accessories (braceletes and watches). Our pieces follow the latest streetwear trends with a focus on exclusive designs and modern cuts.
• Sizes & Fit 📐: We offer sizes from S to XL. Several of our items feature a slightly oversized fit, which is ideal for the urban style.
• Payments 💳: We accept PayPal, Multibanco (entity and reference generated instantly), and Mastercard. The checkout process is 100% secure.
• Shipping & Costs 📦: Shipping is completely free for orders over €45. For lower amounts, the shipping fee is calculated at checkout.
• Delivery Times & Tracking 🚚: Delivery takes between 8 to 11 business days. As soon as the order leaves the warehouse, we send an email to the customer with a tracking code to follow the delivery.
• Exchanges & Returns 🔄: Customers have 14 days after receiving their order to request an exchange or return. The item must be unworn, unwashed, and have all original tags attached.
• Contacts & Hours 📱: Support is available Monday to Friday, from 9:00 AM to 6:00 PM (Western European Time). Email: urbaegeral@gmail.com | Phone: 911 825 589.
• Location 📍: Located at N1, Coimbra, Portugal. Note: This space serves only as an office/logistics center; sales are made exclusively through our online store.

Response Guidelines:
1. Be very direct. Keep responses short (maximum 3-4 lines) so the chat stays dynamic and easy to read on mobile devices.
2. Stick strictly to the URBÆ universe. If users try to talk about politics, football, or other unrelated topics, politely deflect and state that you are only programmed to help with streetwear and our store.`;

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
    const typing = adicionarMensagem('Writing...', 'typing');

    historico.push({ role: 'user', parts: [{ text: pergunta }] });

    const mensagens = [
        { role: 'user', parts: [{ text: CONTEXTO }] },
        { role: 'model', parts: [{ text: 'Understood! I am ready to help with questions about URBÆ.' }] },
        ...historico
    ];

    try {
        const response = await fetch(GEMINI_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ contents: mensagens })
        });

        const data = await response.json();
        console.log('Gemini Response:', JSON.stringify(data));

        if (data.error) {
            historico.pop();
            typing.remove();
            adicionarMensagem('API Error: ' + data.error.message, 'bot');
            return;
        }

        const resposta = data.candidates?.[0]?.content?.parts?.[0]?.text;
        
        if (!resposta) {
            historico.pop();
            typing.remove();
            adicionarMensagem('I could not generate a response. Please try again.', 'bot');
            return;
        }

        historico.push({ role: 'model', parts: [{ text: resposta }] });
        typing.remove();
        adicionarMensagem(resposta, 'bot');

    } catch (error) {
        historico.pop();
        typing.remove();
        console.error('Error:', error);
        adicionarMensagem('Connection error. Check your internet.', 'bot');
    }
}
</script>


</body>

</html>