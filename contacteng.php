<?php
session_start();

$ligacao = mysqli_connect("localhost", "root", "", "bd_site");

$ordenar = $_GET['ordenar'] ?? '';
$cat = $_GET['cat'] ?? '';
$pesquisa = $_GET['pesquisa'] ?? '';

$itens_por_pagina = 18; 
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
    <title>Contacto | URBÆ</title>
    <link rel="icon" type="image/png" href="URBAE COMPLETO.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>


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


        :root {
            --verde-urbae: #1a472a;
            --dourado-suave: #c5a059;
            --cinza-texto: #555;
            --fundo-alternativo: #f8faf8;
        }

/* Hero de Contacto */
.contact-hero {
    background: linear-gradient(rgba(26, 71, 42, 0.8), rgba(26, 71, 42, 0.8)), 
                url('contactar.png') center/cover;
    color: white;
    padding: 100px 0;
    text-align: center;
}

        .contact-hero h1 {
            font-size: 3rem;
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        /* Layout Grid */
        .contact-section { padding: 80px 0; background: white; }
        
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 80px;
            align-items: start;
        }

        /* Informações à Esquerda */
        .contact-info h2 {
            font-family: 'Montserrat', sans-serif;
            color: var(--verde-urbae);
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .info-item i {
            font-size: 1.5rem;
            color: var(--verde-urbae);
            width: 60px;
            height: 60px;
            background: var(--fundo-alternativo);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 20px;
            transition: 0.3s;
        }

        .info-item:hover i {
            background: var(--verde-urbae);
            color: white;
        }

        .info-text h4 {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            font-size: 1.1rem;
            color: #333;
        }

        .info-text p { margin: 5px 0 0; color: var(--cinza-texto); }

        /* Formulário à Direita */
        .form-container {
            background: var(--fundo-alternativo);
            padding: 50px;
            border-radius: 4px;
            box-shadow: 10px 10px 0px var(--verde-urbae);
        }

        .contact-form .form-group { margin-bottom: 20px; }

        .contact-form label {
            display: block;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 8px;
            color: var(--verde-urbae);
        }

        .contact-form input, 
        .contact-form textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 0;
            font-family: 'Poppins', sans-serif;
            transition: 0.3s;
        }

        .contact-form input:focus, 
        .contact-form textarea:focus {
            outline: none;
            border-color: var(--verde-urbae);
            background: white;
        }

        .btn-send {
            background: var(--verde-urbae);
            color: white;
            border: none;
            padding: 15px 40px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }

        .btn-send:hover {
            background: var(--dourado-suave);
            transform: translateY(-3px);
        }

        /* Mapa */
        .map-container {
            height: 450px;
            filter: grayscale(100%) contrast(1.2); /* Estilo Urbano/Premium */
            border-top: 1px solid #eee;
        }

        @media (max-width: 992px) {
            .contact-grid { grid-template-columns: 1fr; gap: 50px; }
            .form-container { box-shadow: none; }
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
        <a href="admineng.php">Control Panel</a>
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
    <a href="#" class="icon-badge" onclick="alert('You need to log in to access your cart!'); return false;">
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

            <!-- BOTÃO DA BANDEIRA (abre modal) -->
            <a href="#" class="icon-badge lang-btn" id="openLangModal" title="Idioma">
                <img src="https://flagcdn.com/w20/us.png" alt="EN">
            </a>

        </div>

    </header>
    <!-- NAV BRANCA URBÆ FIM-->

    <section class="contact-hero">
        <div class="container">
            <h1>Contacts</h1>
            <p>We're just a message away.</p>
        </div>
    </section>

    <section class="contact-section container">
        <div class="contact-grid">
            
            <div class="contact-info">
                <h2>Contact Us</h2>
                <p style="margin-bottom: 40px; color: #777;">Do you have any questions about a product or your order? Our team is ready to help.</p>

                <div class="info-item">
                    <i class="fas fa-location-dot"></i>
                    <div class="info-text">
                        <h4>Location</h4>
                        <p>Street Nacional 1, Coimbra, Portugal</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-phone-volume"></i>
                    <div class="info-text">
                        <h4>Phone Number</h4>
                        <p>+351 911 825 589</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-paper-plane"></i>
                    <div class="info-text">
                        <h4>Email</h4>
                        <p>urbaegeral@gmail.com</p>
                    </div>
                </div>
            </div>

                                <div class="form-container">
                        <?php if (isset($_SESSION['utilizador'])): ?>
                            <form action="enviar_contacto.php" method="POST" class="contact-form">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="nome" required value="<?= $_SESSION['utilizador'] ?>">
                                </div>
                                
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" name="assunto" required placeholder="How can we help?">
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea name="mensagem" rows="5" required placeholder="Write your message here..."></textarea>
                                </div>
                                <button type="submit" class="btn-send">Send Message</button>
                            </form>
                        <?php else: ?>
                            <div style="text-align: center; padding: 20px; border: 1px dashed #ccc;">
                            <p>Please <a href="#" class="open-login-modal">login</a> to send a message.</p>                            </div>
                        <?php endif; ?>
                    </div>
            </div>

        </div>
    </section>

<div class="map-container">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3045.717652399201!2d-8.445463123466183!3d40.24268846654261!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd22ff281d89f6cf%3A0xc0cd0c730ebe4109!2sChurrasqueira%20da%20Pedrulha!5e0!3m2!1spt-PT!2spt!4v1740998400000!5m2!1spt-PT!2spt" 
        width="100%" 
        height="100%" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
<script src="pesquisar.js"></script>



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


<!-- MODAL LOGIN -->
<div id="userModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close">&times;</span>

    <h2>Enter</h2>

    <?php if (isset($_SESSION["erro"])): ?>
      <div class="msg-feedback erro">
        <?= $_SESSION["erro"]; ?>
      </div>
    <?php unset($_SESSION["erro"]); endif; ?>

    <form class="modal-form" action="login.php" method="POST">
      <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">

      <label>Username</label>
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
    <a href="recuperar_passwordeng.php" style="font-size:12px; color:#888;">I forgot my password</a>
</p>
    </form>

    <p class="modal-register">
      Don't have an account? <a href="#" id="openRegister">Register</a>
    </p>
  </div>
</div>

<!-- MODAL REGISTAR -->
<div id="registerModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close register-close">&times;</span>

    <h2>Create Account</h2>

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

      <label>Username</label>
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

      <button type="submit" name="botaoRegistar" value="1" class="modal-btn">
        Create Account
      </button>
    </form>

    <p class="modal-register">
      Don't have an account? <a href="#" id="voltarLogin">Enter</a>
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
  const inputs = document.querySelectorAll("#userModal input, #registerModal input");

  inputs.forEach(input => {
    input.addEventListener("input", () => {
      mensagens.forEach(msg => { msg.style.display = "none"; });
    });
  });

  // --- MODAIS ---
  const userModal = document.getElementById("userModal");
  const registerModal = document.getElementById("registerModal");
  const closeBtns = document.querySelectorAll(".modal-close");

  // 1. Abrir Login (Botão do Menu OU Link de contacto)
  const userBtn = document.querySelector(".user-btn");
  const contactLoginLink = document.querySelector(".open-login-modal");

  const abrirLogin = (e) => {
    e.preventDefault();
    userModal.style.display = "flex";
  };

  if (userBtn) userBtn.addEventListener("click", abrirLogin);
  if (contactLoginLink) contactLoginLink.addEventListener("click", abrirLogin);

  // 2. Fechar Modais
  closeBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      userModal.style.display = "none";
      registerModal.style.display = "none";
    });
  });

  window.addEventListener("click", (e) => {
    if (e.target === userModal) userModal.style.display = "none";
    if (e.target === registerModal) registerModal.style.display = "none";
  });

  // 3. Alternar entre Login e Registo
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

});
</script>





<script src="script.js"></script>
  <!--registar modal FIM-->




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

<!-- LANGUAGE MODAL -->
    <div id="langModal" class="modal-overlay" style="display:none;">
      <div class="modal-box" style="max-width:300px; text-align:center;">
        <span class="modal-close" id="closeLangModal">&times;</span>
        <h2>Select Language</h2>

        <div class="lang-options" style="margin-top:20px; display:flex; justify-content:space-around;">
          
          <!-- PORTUGUESE -->
          <a href="index.php" class="lang-choice">
            <img src="https://flagcdn.com/w40/pt.png" alt="Português">
            <p>Português</p>
          </a>
          <!-- ENGLISH -->
          <a href="indexeng.php" class="lang-choice">
            <img src="https://flagcdn.com/w40/us.png" alt="English">
            <p>English</p>
          </a>

        </div>
      </div>
    </div>
    <!-- MODAL SCRIPT --> <script> document.addEventListener("DOMContentLoaded", () => {
        const langModal = document.getElementById("langModal");
        const openLangModal = document.getElementById("openLangModal");
        const closeLangModal = document.getElementById("closeLangModal");
        openLangModal.addEventListener("click", (e) => { e.preventDefault();
        langModal.style.display = "flex"; });
        closeLangModal.addEventListener("click", () => { langModal.style.display = "none"; });
        window.addEventListener("click", (e) => { if (e.target === langModal) { langModal.style.display = "none";

            }
        }); 
     }); </script>


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
                    <h2 class="footer-title">More informations</h2>
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
        <input type="email" name="email" placeholder="Gmail" required>
        <button type="submit">Subscribe</button>
    </form>

                  <?php if (isset($_GET["newsletter"])): ?>

                      <?php if ($_GET["newsletter"] == "sucesso"): ?>
                          <p style="color:lightgreen; margin-top:8px;">
                              subscription successful! You will receive our newsletters.
                          </p>

                      <?php elseif ($_GET["newsletter"] == "existe"): ?>
                          <p style="color:#ff4d4d; margin-top:8px;">
                              This Gmail is already subscribed.
                          </p>

                      <?php else: ?>
                          <p style="color:#ff4d4d; margin-top:8px;">
                              Invalid Gmail.
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

    <script src="script.js"></script>
</html>