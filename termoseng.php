<?php
session_start();

$pesquisa = $_GET['pesquisa'] ?? '';
$cat = $_GET['cat'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Terms and Conditions | URBÆ</title>
    <link rel="icon" type="image/png" href="URBAE COMPLETO.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>

#pesquisa {
    border: 1px solid #ccc;
    padding: 5px 10px;
    border-radius: 4px;
    width: 150px; /* Largura fixa para não empurrar o menu */
}


.URBAE-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 40px;
    background-color: #fff;
    height: 90px;
    position: relative;
    border-bottom: 1px solid #eee;
}

.URBAE-nav > a:first-child {
    flex: 1;
    display: flex;
    align-items: center;
}

.nav-links {
    flex: 2;
    display: flex;
    justify-content: center;
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
    color: #5d8e46;
}

.nav-icons {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 15px;
}

.icon-badge {
    color: #333;
    font-size: 18px;
    display: flex;
    align-items: center;
    text-decoration: none;
}

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





        .page-hero {
            background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)),
                        url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=2070') center/cover;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .page-hero h1 {
            font-size: 3rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            letter-spacing: 6px;
            margin-bottom: 10px;
        }
        .page-hero p { color: rgba(255,255,255,0.7); font-size: 14px; }

        .termos-container {
            max-width: 860px;
            margin: 70px auto;
            padding: 0 30px 80px;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .termos-container .intro {
            background: #f9f9f9;
            border-left: 4px solid #000;
            padding: 20px 25px;
            margin-bottom: 50px;
            font-size: 14px;
            color: #555;
            line-height: 1.8;
        }

        .termos-secao {
            margin-bottom: 45px;
            padding-bottom: 45px;
            border-bottom: 1px solid #eee;
        }

        .termos-secao:last-child { border-bottom: none; }

        .termos-secao h2 {
            font-size: 18px;
            font-weight: 700;
            color: #000;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .termos-secao h2 span.num {
            background: #000;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .termos-secao p {
            font-size: 14px;
            line-height: 1.9;
            color: #555;
            margin-bottom: 12px;
        }

        .termos-secao ul {
            padding-left: 20px;
            margin: 10px 0;
        }

        .termos-secao ul li {
            font-size: 14px;
            color: #555;
            line-height: 1.9;
            margin-bottom: 6px;
        }

        .ultima-atualizacao {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-bottom: 40px;
        }
    </style>
</head>

<!-- CHATBOT URBÆ AI -->
<div id="chat-bubble" onclick="toggleChat()">
    <i class="fas fa-comment-dots"></i>
</div>

<div id="chat-box">
    <div id="chat-header">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:8px; height:8px; background:#4caf50; border-radius:50%;"></div>
            <div>
                <div style="font-weight:600; font-size:14px;">URBÆ Assistant</div>
                <div style="font-size:10px; color:#aaa; margin-top:1px;">Powered by AI</div>
            </div>
        </div>
        <span onclick="toggleChat()" style="cursor:pointer; font-size:18px; color:#999;">&times;</span>
    </div>

    <div id="chat-messages">
        <div class="chat-msg bot">
            Hi! 👋 I'm the <strong>URBÆ</strong> virtual assistant. How can I help?
        </div>
        <div id="chat-opcoes">
            <button class="chat-btn" onclick="enviarPergunta('What is URBÆ?')">What is URBÆ?</button>
            <button class="chat-btn" onclick="enviarPergunta('How do I place an order?')">How to order?</button>
            <button class="chat-btn" onclick="enviarPergunta('Return policy')">Returns</button>
            <button class="chat-btn" onclick="enviarPergunta('Contact information')">Contacts</button>
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
const GEMINI_API_KEY = 'AIzaSyDkdN6dbeh7sk2vdV4DAOVGUEUqPr24tFA';
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

        if (data.error) {
            historico.pop();
            typing.remove();
            adicionarMensagem('Error: ' + data.error.message, 'bot');
            return;
        }

        const resposta = data.candidates?.[0]?.content?.parts?.[0]?.text;

        if (!resposta) {
            historico.pop();
            typing.remove();
            adicionarMensagem('Could not generate a response. Please try again.', 'bot');
            return;
        }

        historico.push({ role: 'model', parts: [{ text: resposta }] });
        typing.remove();
        adicionarMensagem(resposta, 'bot');

    } catch (error) {
        historico.pop();
        typing.remove();
        adicionarMensagem('Connection error. Check your internet.', 'bot');
    }
}
</script>
<body>

<!-- NAV TOPO -->
<nav class="nav-top">
    <div class="contact-left">
        <i class="fa fa-envelope"></i>urbaegeral@gmail.com
        <i class="fa fa-phone mx-2"></i>911-825-589
    </div>
    <div class="social-right">
        <a href="https://www.instagram.com/urbae_eng/"><i class="fab fa-instagram"></i></a>
    </div>
</nav>
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
        <a href="admin.php">Admin Panel</a>
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

<!-- HERO -->
<section class="page-hero">
    <div class="container">
        <h1>Terms and Conditions</h1>
        <p>Last updated: January 2026</p>
    </div>
</section>

<!-- CONTEÚDO -->
<div class="termos-container">

    <div class="intro">
        Welcome to <strong>URBÆ</strong>. By accessing and using our website, you are agreeing to the present Terms and Conditions. We recommend reading them carefully before making any purchase or using our services.
    </div>

    <p class="ultima-atualizacao">Version in force since January 1, 2024</p>

    <div class="termos-secao">
        <h2><span class="num">1</span> Company Identification</h2>
        <p><strong>URBÆ</strong> is an urban fashion brand based in Coimbra, Portugal. For any inquiries, you can contact us at:</p>
        <ul>
            <li><strong>Email:</strong> urbaegeral@gmail.com</li>
            <li><strong>Phone:</strong> 911-825-589</li>
            <li><strong>Address:</strong> N1, Coimbra, Portugal</li>
        </ul>
    </div>

    <div class="termos-secao">
        <h2><span class="num">2</span> Acceptance of Terms</h2>
        <p>By using our website and/or making a purchase, you confirm that you have read, understood, and agree to the present Terms and Conditions in their entirety. If you do not agree with any provision, you should refrain from using our service.</p>
        <p>URBÆ reserves the right to modify these terms at any time, with changes published on this page along with the respective update date.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">3</span> Registration and User Account</h2>
        <p>To make purchases on our website, you need to create an account. By registering, you commit to:</p>
        <ul>
            <li>Providing truthful, accurate, and up-to-date information;</li>
            <li>Maintaining the confidentiality of your access credentials;</li>
            <li>Notifying us immediately in case of unauthorized access to your account;</li>
            <li>Being responsible for all activities conducted under your account.</li>
        </ul>
        <p>URBÆ reserves the right to suspend or close accounts that violate these terms.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">4</span> Products and Prices</h2>
        <p>All prices displayed on the website are expressed in Euros (€) and include VAT at the legal rate in force. URBÆ reserves the right to change prices without prior notice.</p>
        <p>Product images are for illustrative purposes only. We make every effort to ensure that colors and details are presented with the highest possible fidelity, however, variations may occur depending on the device used.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">5</span> Orders and Payments</h2>
        <p>By finalizing an order, you are making a binding purchase offer. The order is only considered confirmed after receipt of the respective payment. We accept the following payment methods:</p>
        <ul>
            <li>Credit/debit card (Mastercard)</li>
            <li>MB</li>
            <li>PayPal</li>
        </ul>
        <p>In case of payment failure, the order will be automatically canceled.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">6</span> Shipping and Delivery</h2>
        <p>Delivery times are estimates and may vary depending on the location and shipping carrier. URBÆ is not responsible for delays caused by external factors to our operation, such as strikes or adverse weather conditions.</p>
        <ul>
            <li><strong>Portugal Continental:</strong> 2 to 4 business days</li>
            <li><strong>Islands:</strong> 5 to 8 business days</li>
            <li><strong>Europe:</strong> 7 to 14 business days</li>
        </ul>
    </div>

    <div class="termos-secao">
        <h2><span class="num">7</span> Returns and Exchanges</h2>
        <p>According to Portuguese and European legislation, you have the right to return any product within <strong>14 days</strong> of receipt, without the need for justification. To initiate the return process:</p>
        <ul>
            <li>Contact us by email at urbaegeral@gmail.com;</li>
            <li>The product must be returned in its original condition, unused and with labels;</li>
            <li>Return shipping costs are the responsibility of the customer, unless the product is defective;</li>
            <li>The refund will be processed within 14 days after receiving the returned product.</li>
        </ul>
    </div>

    <div class="termos-secao">
        <h2><span class="num">8</span> Intellectual Property</h2>
        <p>All content present on this website, including texts, images, logos, icons and design, is the exclusive property of URBÆ and is protected by copyright law. Unauthorized reproduction, distribution or use of any content is strictly prohibited.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">9</span> Limitation of Liability</h2>
        <p>URBÆ is not liable for any direct, indirect, incidental or consequential damages resulting from the use or inability to use our website or services, including technical failures, interruptions or system errors.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">10</span> Applicable Law</h2>
        <p>These Terms and Conditions are governed by Portuguese law. Any dispute arising from the use of our website or services shall be subject to the exclusive jurisdiction of the competent Portuguese courts.</p>
        <p>For alternative dispute resolution, you may resort to the Consumer Dispute Resolution Center or another legally constituted alternative dispute resolution entity.</p>
    </div>

</div>

<!-- MODAIS LOGIN/REGISTO -->
<div id="userModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close">&times;</span>
    <h2>Entrar</h2>
    <?php if (isset($_SESSION["erro"])): ?>
      <div class="msg-feedback erro"><?= $_SESSION["erro"]; ?></div>
    <?php unset($_SESSION["erro"]); endif; ?>
    <form class="modal-form" action="logineng.php" method="POST">
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
      <button type="submit" name="botaoLogin" value="1" class="modal-btn">Login</button>
      <p style="text-align:center; margin-top:10px;">
        <a href="recuperar_passwordeng" style="font-size:12px; color:#888;">Esqueci a password</a>
      </p>
    </form>
    <p class="modal-register">Already have an account? <a href="#" id="openRegister">Register</a></p>
  </div>
</div>

<div id="registerModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close register-close">&times;</span>
    <h2>Create Account</h2>
    <?php if (isset($_SESSION["erro_registo"])): ?>
      <div class="msg-feedback erro"><?= $_SESSION["erro_registo"]; ?></div>
    <?php unset($_SESSION["erro_registo"]); endif; ?>
    <?php if (isset($_SESSION["sucesso"])): ?>
      <div class="msg-feedback sucesso"><?= $_SESSION["sucesso"]; ?></div>
    <?php unset($_SESSION["sucesso"]); endif; ?>
    <form class="modal-form" action="registareng.php" method="POST">
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
      <button type="submit" name="botaoRegistar" value="1" class="modal-btn">Create Account</button>
    </form>
    <p class="modal-register">Already have an account? <a href="#" id="voltarLogin">Login</a></p>
  </div>
</div>

<!-- MODAL IDIOMAS -->
<div id="langModal" class="modal-overlay" style="display:none;">
  <div class="modal-box" style="max-width:300px; text-align:center;">
    <span class="modal-close" id="closeLangModal">&times;</span>
    <h2>Choose Language</h2>
    <div class="lang-options" style="margin-top:20px; display:flex; justify-content:space-around;">
      <a href="index.php" class="lang-choice"><img src="https://flagcdn.com/w40/pt.png" alt="PT"><p>Português</p></a>
      <a href="indexeng.php" class="lang-choice"><img src="https://flagcdn.com/w40/us.png" alt="EN"><p>English</p></a>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const userBtn = document.querySelector(".user-btn");
  const userModal = document.getElementById("userModal");
  const registerModal = document.getElementById("registerModal");
  const langModal = document.getElementById("langModal");

  if (userBtn) userBtn.addEventListener("click", (e) => { e.preventDefault(); userModal.style.display = "flex"; });

  document.querySelectorAll(".modal-close").forEach(btn => {
    btn.addEventListener("click", () => {
      userModal.style.display = "none";
      registerModal.style.display = "none";
    });
  });

  document.querySelectorAll(".register-close").forEach(btn => {
    btn.addEventListener("click", () => { registerModal.style.display = "none"; });
  });

  document.getElementById("openRegister")?.addEventListener("click", (e) => {
    e.preventDefault(); userModal.style.display = "none"; registerModal.style.display = "flex";
  });

  document.getElementById("voltarLogin")?.addEventListener("click", (e) => {
    e.preventDefault(); registerModal.style.display = "none"; userModal.style.display = "flex";
  });

  window.addEventListener("click", (e) => {
    if (e.target === userModal) userModal.style.display = "none";
    if (e.target === registerModal) registerModal.style.display = "none";
    if (e.target === langModal) langModal.style.display = "none";
  });

  document.getElementById("openLangModal")?.addEventListener("click", (e) => {
    e.preventDefault(); langModal.style.display = "flex";
  });

  document.getElementById("closeLangModal")?.addEventListener("click", () => {
    langModal.style.display = "none";
  });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // 1. GESTÃO DOS MODAIS (LOGIN/REGISTO/IDIOMA)
    const userBtn = document.querySelector(".user-btn");
    const userModal = document.getElementById("userModal");
    const registerModal = document.getElementById("registerModal");
    const langModal = document.getElementById("langModal");

    if (userBtn) userBtn.addEventListener("click", (e) => { e.preventDefault(); userModal.style.display = "flex"; });

    document.querySelectorAll(".modal-close").forEach(btn => {
        btn.addEventListener("click", () => {
            userModal.style.display = "none";
            registerModal.style.display = "none";
            langModal.style.display = "none";
        });
    });

    document.getElementById("openRegister")?.addEventListener("click", (e) => {
        e.preventDefault(); userModal.style.display = "none"; registerModal.style.display = "flex";
    });

    document.getElementById("voltarLogin")?.addEventListener("click", (e) => {
        e.preventDefault(); registerModal.style.display = "none"; userModal.style.display = "flex";
    });

    document.getElementById("openLangModal")?.addEventListener("click", (e) => {
        e.preventDefault(); langModal.style.display = "flex";
    });

    // 2. LÓGICA DA LUPA (PESQUISA ANIMADA)
    const lupaBtn = document.getElementById('lupaBtn');
    const inputPesquisa = document.getElementById('pesquisa');
    const searchForm = document.getElementById('searchForm');

    if (lupaBtn) {
        lupaBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (!inputPesquisa.classList.contains('active')) {
                // Abre a barra
                inputPesquisa.classList.add('active');
                inputPesquisa.focus();
            } else {
                // Se já estiver aberta
                if (inputPesquisa.value.trim() !== "") {
                    searchForm.submit(); // Pesquisa se houver texto
                } else {
                    inputPesquisa.classList.remove('active'); // Fecha se estiver vazia
                }
            }
        });
    }

    // Fechar a barra se clicar fora
    document.addEventListener('click', function(e) {
        if (!searchForm.contains(e.target)) {
            inputPesquisa.classList.remove('active');
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
                <hr style="background-color:#474747; border:none; opacity:0.4; height:1px;"><br>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> N1, Coimbra</li>
                    <li><i class="fas fa-phone"></i> 911-825-589</li>
                    <li><i class="fas fa-envelope"></i> urbaegeral@gmail.com</li>
                </ul>
            </div>
            <div class="footer-box">
                <h2 class="footer-title">Our Collections</h2>
                <hr style="height:1px; background-color:#474747; border:none; opacity:0.4;"><br>
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
                <hr style="height:1px; background-color:#474747; border:none; opacity:0.4;"><br>
                <ul>
                    <li><a href="indexeng.php">Home</a></li>
                    <li><a href="abouteng.php">About Us</a></li>
                    <li><a href="contacteng.php">Contact</a></li>
                    <li><a href="termosecondicoeseng.php">Terms and Conditions</a></li>
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
            <div class="newsletter">
                <form action="subscrever.php" method="POST">
                    <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <input type="email" name="email" placeholder="Email address" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
            <p class="copyright">&copy; 2024 Alexandre. All rights reserved.</p>
        </div>
    </div>
</footer>


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


</html>