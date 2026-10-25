<?php
session_start();
$ligacao = mysqli_connect("localhost", "root", "", "bd_site");

$ordenar = $_GET['ordenar'] ?? '';
$cat = $_GET['cat'] ?? '';
$pesquisa = $_GET['pesquisa'] ?? '';

$itens_por_pagina = 20; // Definir o número de itens por página
$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $itens_por_pagina;

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
$query_total = "SELECT COUNT(*) as total FROM produtos" . $where_sql;
$res_total = mysqli_query($ligacao, $query_total);
$row_total = mysqli_fetch_assoc($res_total);

$total_produtos = $row_total['total'];
$total_paginas = ($total_produtos > 0) ? ceil($total_produtos / $itens_por_pagina) : 1;

/* 🛒 PRODUTOS */
$query = "SELECT * FROM produtos" . $where_sql . $order_sql . " LIMIT $itens_por_pagina OFFSET $offset";
$res = mysqli_query($ligacao, $query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Urbae Portugal</title> 
    <link rel="icon" type="image/png" href="URBAE COMPLETO.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

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
<body>


<?php
// --- BLOCO DE MENSAGENS (ADICIONA ISTO) ---
if (isset($_SESSION["mensagem"])) {
    echo "<div style='background-color: #2c8c5c; color: white; padding: 20px; text-align: center; font-weight: bold; position: sticky; top: 0; z-index: 10000;'>";
    echo "<i class='fa fa-check-circle'></i> " . $_SESSION["mensagem"];
    echo "</div>";
    unset($_SESSION["mensagem"]); // Para a mensagem desaparecer se atualizares a página
}

if (isset($_SESSION["erro"])) {
if (isset($_SESSION["erro"])) {
    // Removemos os 'echo' que desenhavam a barra vermelha no topo
    unset($_SESSION["erro"]); 
}
}
// ------------------------------------------
?>


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

    <!--inicio do slider-->

<div class="promo-slider">

  <div class="promo-slide active">
    <div class="promo-text">
      <h2>URBÆ Essentials</h2>
      <p>Minimalismo que inspira presença.</p>
    </div>
    <div class="promo-image">
      <img src="slide1index.png" alt="URBÆ product">
    </div>
  </div>

  <div class="promo-slide">
    <div class="promo-text">
      <h2>Matriz Urbana</h2>
      <p>A estética nasce no detalhe.</p>
    </div>
    <div class="promo-image">
      <img src="slide2index.png" alt="URBÆ product">
    </div>
  </div>

  <div class="promo-slide">
    <div class="promo-text">
      <h2>Linha Superior</h2>
      <p>Design que fala por si.</p>
    </div>
    <div class="promo-image">
      <img src="slide3index.png" alt="URBÆ product">
    </div>
  </div>

    <div class="slider-dots">
    <span class="dot active"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    </div>

  <!-- SETAS -->
  <button class="arrow left">&#10094;</button>
  <button class="arrow right">&#10095;</button>

</div>

<script src="slider.js"></script>
    <!--fim do slider-->    


    <!-- Categorias do mes -->
<section class="categories-month">
  <h2>Categorias do mês</h2>
  <p>
      Os produtos mais escolhidos deste mês: peças de alta qualidade, minimalistas e feitas para durar.
  </p>

  <div class="categories-grid">
    <div class="category-item">
      <div class="category-img">
        <img src="sweaterindex2.png" alt="Camisolas">
      </div>
      <h3>Sweaters</h3>
      <a href="shop.php?cat=sweaters" class="btn-shop">Comprar</a>
    </div>

    <div class="category-item">
      <div class="category-img">
        <img src="calcasbaddyindex.png" alt="calças">
      </div>
      <h3>calças</h3>
      <a href="shop.php?cat=calcas" class="btn-shop">Comprar</a>
    </div>

    <div class="category-item">
      <div class="category-img">
        <img src="camisolaindex.png" alt="Calças">
      </div>
      <h3>Camisolas</h3>
      <a href="shop.php?cat=camisas" class="btn-shop">Comprar</a>
    </div>
  </div>
</section>

<!--Fim categorias do mes-->


    <!-- Featured Products (Parte de baixo do site) -->
    <section class="featured">
  <h2>Produto em Destaque</h2>
  <p class="featured-sub">
    Os produtos mais escolhidos deste mês destacam‑se pela construção sólida, materiais premium e acabamento impecável.    <br></p>

  <div class="featured-grid">

    <div class="product-card">
        <img src="sweaterstreetindex.png" alt="Sweater StreetWear">
        <div class="product-info">
            <div class="product-top">
                <div class="stars">★★★★☆</div>
                <span class="price">67.99€</span>
            </div>
            <h3>Street Sweater</h3>
            <p>Sweater Streetwear de alta qualidade, ideal para ocasiões especiais ou uso diário.</p>
            <span class="reviews">Reviews (24)</span>
            <a href="produto.php?id=1" class="btn-ver-index">Ver Produto</a>
        </div>
    </div>

<div class="product-card">
    <img src="assets/img/produtos/indexcalcas.png" alt="Calças Baggy">
    <div class="product-info">
        <div class="product-top">
            <div class="stars">★★★☆☆</div>
            <span class="price">39.99€</span>
        </div>
        <h3>Calças de Ganga Baggy</h3>
        <p>Calças baggy de alta qualidade, perfeitas para um estilo urbano e confortável.</p>
        <span class="reviews">Reviews (48)</span>
        <a href="produto.php?id=2" class="btn-ver-index">Ver Produto</a>
    </div>
</div>

    <div class="product-card">
        <img src="sweaterindex2.png" alt="Sweater StreetWear">
        <div class="product-info">
            <div class="product-top">
                <div class="stars">★★★★★</div>
                <span class="price">69.99€</span>
            </div>
            <h3>Hoodie Full-Zip</h3>
            <p>Sweater Streetwear, peça de alta qualidade, perfeita para um estilo urbano e moderno.</p>
            <span class="reviews">Reviews (74)</span>
            <a href="produto.php?id=3" class="btn-ver-index">Ver Produto</a>
        </div>
    </div>

</div>
</section>




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
    <input type="password" name="password" id="passwordLoginInput" required style="width:100%; padding-right:40px; box-sizing:border-box;">
    <span onclick="togglePasswordLogin()" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); cursor:pointer; color:#999; font-size:14px;">
        <i class="fas fa-eye" id="eyeIconLogin"></i>
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
    
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($_SESSION["sucesso_compra"])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Confirmado!',
        text: '<?php echo $_SESSION["sucesso_compra"]; ?>',
        confirmButtonColor: '#2c8c5c',
        timer: 5000 // Fecha sozinho após 5 segundos se o user não clicar
    });
</script>
<?php unset($_SESSION["sucesso_compra"]); endif; ?>

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
                <div style="font-size:10px; color:#aaa; margin-top:1px;">Movido a IA</div>
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
                        <h2 class="footer-title">Nossas Coleções</h2>
                        <hr style="height: 1px; background-color: #474747; border: none; opacity: 0.4;">
                        <br>
                        <ul>
                            <li><a href="shop.php?cat=camisas">Camisas</a></li>
                            <li><a href="shop.php?cat=sweaters">Sweaters</a></li>
                            <li><a href="shop.php?cat=Calcas">Calças</a></li>
                            <li><a href="shop.php?cat=sapatos">Sapatos</a></li>
                            <li><a href="shop.php?cat=acessorios">Acessórios</a></li>
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
</html>
