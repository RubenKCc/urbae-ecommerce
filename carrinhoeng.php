<?php
session_start();
if ( ! isset($_SESSION["utilizador"]) ) {
    $_SESSION["mensagem"] = "Log in to make purchases.";
    Header("Location: indexeng.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="EN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Carrinho - URBÆ</title>
    <link rel="icon" type="image/png" href="URBAE COMPLETO.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
/* Ajuste da barra de pesquisa para não ser muito larga */
#pesquisa {
    border: 1px solid #ccc;
    padding: 5px 10px;
    border-radius: 4px;
    width: 150px; /* Largura fixa para não empurrar o menu */
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

/* Garante que os ícones fiquem alinhados */
.icon-badge {
    color: #333;
    font-size: 18px;
    display: flex;
    align-items: center;
    text-decoration: none;
}

        .swal2-container { z-index: 100000 !important; }

        .carrinho-page {
            background: #f9f9f9;
            min-height: 100vh;
            padding: 40px 0 80px;
        }

        .carrinho-wrapper {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 30px;
            width: 85%;
            max-width: 1100px;
            margin: 0 auto;
        }

        .carrinho-titulo {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #000;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000;
        }

        .carrinho-itens-box {
            background: #fff;
            border: 1px solid #eee;
            padding: 30px;
        }

        #pesquisaCarrinho {
            width: 100%;
            padding: 11px 15px;
            border: 1px solid #ddd;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 20px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        #pesquisaCarrinho:focus { border-color: #000; }

        .item_carrinho {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 0;
            border-bottom: 1px solid #f0f0f0;
            gap: 15px;
        }

        .item_nome {
            flex: 2;
            font-size: 14px;
            font-weight: 600;
            color: #111;
        }

        .item_quantidade {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .item_quantidade input {
            width: 50px;
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 13px;
            text-align: center;
            font-family: 'Poppins', sans-serif;
            outline: none;
        }

        .item_quantidade button {
            padding: 6px 10px;
            background: #fff;
            border: 1px solid #ddd;
            cursor: pointer;
            color: #555;
            transition: all 0.2s;
        }
        .item_quantidade button:hover { background: #000; color: #fff; border-color: #000; }

        .item_preco {
            flex: 1;
            text-align: right;
            font-weight: 700;
            font-size: 15px;
            color: #000;
        }

        .item_remover a {
            color: #ccc;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.2s;
        }
        .item_remover a:hover { color: #e74c3c; }

        .carrinho-resumo-box {
            background: #fff;
            border: 1px solid #eee;
            padding: 30px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .resumo-titulo {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #000;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }

        .resumo-linha {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .resumo-total {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 700;
            color: #000;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #000;
        }

        .payment-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #999;
            margin: 25px 0 15px;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #eee;
            padding: 12px 15px;
            cursor: pointer;
            transition: all 0.2s;
            background: #fff;
        }
        .payment-option:hover { border-color: #000; background: #fafafa; }

        .payment-option img {
            height: 28px;
            object-fit: contain;
            width: 60px;
        }

        .payment-option span {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        #modalPagamento {
            display: none;
            position: fixed;
            z-index: 99999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
        }

        .modal-content {
            background: #fff;
            padding: 40px;
            width: 90%;
            max-width: 460px;
            position: relative;
            animation: fadeIn 0.25s ease;
            border-top: 3px solid #000;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #tituloModal {
            font-size: 20px;
            font-weight: 700;
            color: #000;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        #descModal { font-size: 13px; color: #999; margin-bottom: 20px; }

        .modal-fechar {
            position: absolute;
            top: 15px; right: 20px;
            cursor: pointer;
            font-size: 22px;
            color: #aaa;
            line-height: 1;
            transition: color 0.2s;
        }
        .modal-fechar:hover { color: #000; }

        .modal-input {
            width: 100%;
            padding: 13px 15px !important;
            margin-top: 12px;
            border: 1px solid #ddd;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            color: #333;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        .modal-input:focus { border-color: #000; }

        #val_cartao, #cvv_cartao {
            flex: 1;
            padding: 13px !important;
            border: 1px solid #ddd;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }
        #val_cartao:focus, #cvv_cartao:focus { border-color: #000; }

        .btn-confirmar {
            width: 100%;
            background: #000;
            color: #fff;
            border: none;
            padding: 15px;
            cursor: pointer;
            font-weight: 700;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 20px;
            transition: background 0.2s;
        }
        .btn-confirmar:hover { background: #222; }

        .paypal-header {
            text-align: center;
            margin-bottom: 15px;
            padding: 15px;
            background: #f7f9fc;
        }
        .paypal-header img { height: 35px; }

        .ssl-info { font-size: 11px; color: #bbb; text-align: center; margin-top: 10px; }

        #camposMB {
            background: #f8f8f8;
            padding: 18px;
            border-left: 3px solid #000;
            margin-bottom: 10px;
        }
        #camposMB p { margin: 8px 0; font-size: 14px; color: #333; }
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

<?php if (isset($_SESSION["erro_stock"])): ?>
    <script>
        Swal.fire({ icon: 'error', title: 'Insufficient Stock', text: '<?php echo $_SESSION["erro_stock"]; ?>', confirmButtonColor: '#000' });
    </script>
<?php unset($_SESSION["erro_stock"]); endif; ?>

<?php
require ".ht_conexao-bd.php";

$sql = "select * from carrinho where estado=0 and utilizador_id=(select id_utilizadores from utilizadores where utilizador = '" . $_SESSION["utilizador"] . "')";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    echo '
    <div class="carrinho-page">
    <div class="carrinho-wrapper">
        <div class="carrinho-itens-box">
            <div class="carrinho-titulo">My Cart</div>
            <a href="shopeng.php" style="display:inline-flex; align-items:center; gap:8px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1.5px; color:#999; text-decoration:none; margin-bottom:20px; transition:color 0.2s;">
                <i class="fas fa-chevron-left" style="font-size:10px;"></i> Continue Shopping
            </a>
            <div style="text-align:center; padding:60px 20px; color:#ccc;">
                <i class="fas fa-shopping-cart" style="font-size:40px; margin-bottom:15px; display:block;"></i>
                <p style="font-size:14px; color:#999;">Your cart is empty.</p>
                <a href="shopeng.php" style="display:inline-block; margin-top:20px; padding:12px 30px; background:#000; color:#fff; text-decoration:none; font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase;">View Products</a>
            </div>
        </div>
        <div class="carrinho-resumo-box">
            <div class="resumo-titulo">Order Summary</div>
            <div class="resumo-linha">
                <span>Subtotal</span>
                <span>0,00 €</span>
            </div>
            <div class="resumo-linha">
                <span>Shipping</span>
                <span>Free</span>
            </div>
            <div class="resumo-total">
                <span>Total</span>
                <span>0,00 €</span>
            </div>
        </div>
    </div>
    </div>';
    exit();
}

$registo = mysqli_fetch_array($resultado);
$carrinho_id = $registo["id"];
$preco_total_carrinho = $registo["preco_total_carrinho"];
// Buscar morada do utilizador
$sql_user = "SELECT morada, cidade, codigo_postal FROM utilizadores WHERE utilizador = '" . $_SESSION["utilizador"] . "'";
$res_user = mysqli_query($conexao, $sql_user);
$user_dados = mysqli_fetch_assoc($res_user);
$morada = $user_dados['morada'] ?? '';
$cidade = $user_dados['cidade'] ?? '';
$codigo_postal = $user_dados['codigo_postal'] ?? '';
$morada_completa = trim("$morada, $cidade $codigo_postal", ', ');

$sql_itens = "select * from carrinho_itens, produtos where produtos.id = carrinho_itens.produto_id and carrinho_itens.carrinho_id=" . $carrinho_id;
$resultado_itens = mysqli_query($conexao, $sql_itens);
?>

<!-- NAV CINZENTA DO TOPO -->
<nav class="nav-top">
    <div class="contact-left">
        <i class="fa fa-envelope"></i>urbaegeral@gmail.com
        <i class="fa fa-phone mx-2"></i>911-825-589
    </div>
    <div class="social-right">
        <a href="https://www.instagram.com/urbae_eng/"><i class="fab fa-instagram"></i></a>
    </div>
</nav>



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



<div class="carrinho-page">
<div class="carrinho-wrapper">

    <!-- COLUNA ESQUERDA: ITENS -->
    <div class="carrinho-itens-box">
<div class="carrinho-titulo">My Cart</div>
<a href="shopeng.php" style="display:inline-flex; align-items:center; gap:8px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1.5px; color:#999; text-decoration:none; margin-bottom:20px; transition:color 0.2s;">
    <i class="fas fa-chevron-left" style="font-size:10px;"></i> Continue Shopping
</a>        
        <input type="text" id="pesquisaCarrinho" placeholder="Search products...">
        
            <?php while ( $item = mysqli_fetch_array($resultado_itens) ) { 
                $preco_unitario = $item["preco_total_itens"] / $item["quantidade"];
            ?>
            <div class="item_carrinho" data-preco-unit="<?= $preco_unitario ?>">
                <div class="item_nome"><?php echo $item["designacao"]; ?></div>
                <div class="item_quantidade">
                    <input id="item<?php echo $item['produto_id']?>" type="number" min="1" value="<?php echo $item["quantidade"]; ?>" onchange="atualizarItem(this)">
                </div>
                <div class="item_preco"><?php echo number_format($item["preco_total_itens"], 2, ',', '.') . " €"; ?></div>
                <div class="item_remover"><a href="gerir-carrinhoeng.php?item_quantidade=0&produto_id=<?php echo $item['produto_id']?>"><i class="fa fa-trash"></i></a></div>
            </div>
            <?php } ?>
    </div>

    <!-- COLUNA DIREITA: RESUMO + PAGAMENTO -->
    <div class="carrinho-resumo-box">
        <div class="resumo-titulo">Order Summary</div>
        
        <div class="resumo-linha">
            <span>Subtotal</span>
            <span><?php echo number_format($preco_total_carrinho, 2, ',', '.') . " €"; ?></span>
        </div>
        <div class="resumo-linha">
            <span>Shipping</span>
            <span>Free</span>
        </div>
        <div class="resumo-total">
            <span>Total</span>
            <span><?php echo number_format($preco_total_carrinho, 2, ',', '.') . " €"; ?></span>
        </div>

        <p class="payment-title">Payment Method</p>
        <div class="payment-options">
            <div class="payment-option" onclick="abrirModal('paypal')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">
                <span>PayPal</span>
            </div>
            <div class="payment-option" onclick="abrirModal('multibanco')">
            <img src="multibanco.png" alt="Multibanco">                <span>Multibanco</span>
            </div>
            <div class="payment-option" onclick="abrirModal('mastercard')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/MasterCard_Logo.svg" alt="Mastercard">
                <span>Mastercard</span>
            </div>
        </div>
    </div>

</div>
</div>

<!-- MODAL DE PAGAMENTO -->
<div id="modalPagamento">
    <div class="modal-content">
        <span class="modal-fechar" onclick="fecharModal()">&times;</span>
        <h3 id="tituloModal">Finalize Purchase</h3>
        <p id="descModal">Confirm the details to proceed.</p>

        <form id="formFinal" action="gerir-carrinho.php" method="GET" onsubmit="processarPagamento(event)">
            <input type="hidden" name="carrinho_id" value="<?php echo $carrinho_id; ?>">
            <input type="hidden" name="carrinho_estado" value="1">
            <input type="hidden" name="idioma" value="en">
            <input type="hidden" id="inputMetodo" name="metodo" value="">
            <input type="hidden" id="morada_entrega" name="morada_entrega" value="">

            <!-- Campos PayPal -->
            <div id="camposPaypal" style="display:none;">
                <div class="paypal-header">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">
                </div>
                <input type="email" id="email_paypal" placeholder="PayPal Email" class="modal-input">
                <input type="password" id="pass_paypal" placeholder="PayPal Password" class="modal-input">
                <p class="ssl-info"><i class="fas fa-lock"></i> Secure SSL Connection — Your data is protected</p>
            </div>

            <!-- Campos Mastercard -->
            <div id="camposCartao" style="display: none; width: 100% !important; box-sizing: border-box !important;">
                
                <!-- O !important vai obrigar o Número do Cartão a esticar até aos 100% da caixa -->
                <input type="text" id="num_cartao" placeholder="Card Number (16 digits)" maxlength="19" class="modal-input" 
                    style="width: 100% !important; padding: 13px !important; border: 1px solid #ddd !important; font-size: 14px !important; font-family: 'Poppins', sans-serif !important; outline: none !important; box-sizing: border-box !important; margin-bottom: 0 !important;">
                
                <!-- Linha dos dois campos inferiores -->
                <div style="display: flex !important; gap: 10px !important; margin-top: 10px !important; width: 100% !important; box-sizing: border-box !important;">
                    
                    <input type="text" id="val_cartao" placeholder="MM/AA" maxlength="5" 
                        style="flex: 1 !important; width: 0 !important; padding: 13px !important; border: 1px solid #ddd !important; font-size: 14px !important; font-family: 'Poppins', sans-serif !important; outline: none !important; box-sizing: border-box !important;">
                    
                    <input type="text" id="cvv_cartao" placeholder="CVV" maxlength="3" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        style="flex: 1 !important; width: 0 !important; padding: 13px !important; border: 1px solid #ddd !important; font-size: 14px !important; font-family: 'Poppins', sans-serif !important; outline: none !important; box-sizing: border-box !important;">
                </div>
            </div>

            <!-- Campos Multibanco -->
            <div id="camposMB" style="display:none;">
                <p><strong>Entity:</strong> 12345</p>
                <p><strong>Reference:</strong> 244 283 325</p>
                <p><strong>Amount:</strong> <?php echo number_format($preco_total_carrinho, 2, ',', '.') . " €"; ?></p>
            </div>

            <button type="submit" class="btn-confirmar">CONFIRM AND PAY</button>
        </form>
    </div>
</div>

<script>
function alterarQuantidadeItem(itemId) {
    var produto_id = itemId.substr(4);
    var item_quantidade = document.getElementById(itemId).value;
    window.location.assign("gerir-carrinho.php?item_quantidade=" + item_quantidade + "&produto_id=" + produto_id);
}

function abrirModal(metodo) {
    const morada = <?= json_encode($morada_completa) ?>;

    if (morada) {
        Swal.fire({
            title: 'Confirmar Morada de Entrega',
            html: `
                <p style="font-size:14px; color:#555; margin-bottom:15px;">A encomenda será enviada para:</p>
                <p style="font-size:15px; font-weight:700; color:#000; margin-bottom:20px;">${morada}</p>
                <div id="morada-alternativa" style="display:none; margin-top:10px;">
                    <input type="text" id="nova-morada" placeholder="Insere a nova morada" 
                           style="width:100%; padding:10px; border:1px solid #ddd; font-size:13px; box-sizing:border-box; font-family:'Poppins',sans-serif;">
                </div>
            `,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Sim, está certa',
            denyButtonText: 'Enviar para outra morada',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#000',
            denyButtonColor: '#555',
            didOpen: () => {
                const denyBtn = Swal.getDenyButton();
                denyBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    document.getElementById('morada-alternativa').style.display = 'block';
                    Swal.update({
                        showDenyButton: false,
                        confirmButtonText: 'Confirmar esta morada',
                    });
                });
            }
        }).then((result) => {
    if (result.isConfirmed) {
        const novaMorada = document.getElementById('nova-morada');
        if (novaMorada && novaMorada.value.trim()) {
            document.getElementById('morada_entrega').value = novaMorada.value.trim();
        } else {
            document.getElementById('morada_entrega').value = morada;
        }
        abrirModalPagamento(metodo);
    } else if (result.isDenied) {
        window.location.href = 'perfileng.php';
    }
});
    } else {
        Swal.fire({
            title: 'Morada não definida',
            html: `
                <p style="font-size:14px; color:#555; margin-bottom:10px;">Não tens morada definida. Insere a morada de entrega:</p>
                <input type="text" id="nova-morada" placeholder="Morada de entrega" 
                       style="width:100%; padding:10px; border:1px solid #ddd; font-size:13px; box-sizing:border-box; font-family:'Poppins',sans-serif;">
            `,
            confirmButtonText: 'Confirmar',
            confirmButtonColor: '#000',
            showCancelButton: true,
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('morada_entrega').value = document.getElementById('nova-morada').value.trim();
                abrirModalPagamento(metodo);
            }
        });
    }
}

function abrirModalPagamento(metodo) {
    const modal = document.getElementById('modalPagamento');
    const inputMetodo = document.getElementById('inputMetodo');
    const titulo = document.getElementById('tituloModal');
    const camposCartao = document.getElementById('camposCartao');
    const camposMB = document.getElementById('camposMB');
    const camposPaypal = document.getElementById('camposPaypal');

    inputMetodo.value = metodo;
    modal.style.display = 'flex';

    camposCartao.style.display = "none";
    camposMB.style.display = "none";
    camposPaypal.style.display = "none";

    if (metodo === 'mastercard') {
        titulo.innerText = "Pagamento com Cartão";
        camposCartao.style.display = "block";
    } else if (metodo === 'multibanco') {
        titulo.innerText = "Dados Multibanco";
        camposMB.style.display = "block";
    } else if (metodo === 'paypal') {
        titulo.innerText = "Pagar com PayPal";
        camposPaypal.style.display = "block";
    }
}

function fecharModal() {
    document.getElementById('modalPagamento').style.display = 'none';
}

function processarPagamento(event) {
    event.preventDefault();
    const metodo = document.getElementById('inputMetodo').value;

    if (metodo === 'mastercard') {
        const numCartao = document.getElementById('num_cartao').value.replace(/\s/g, '');
        const valCartao = document.getElementById('val_cartao').value;
        const cvv = document.getElementById('cvv_cartao').value;

        if (numCartao.length !== 16) {
            Swal.fire({ icon: 'error', title: 'Invalid Number', text: 'The card number must have 16 digits.', confirmButtonColor: '#000' });
            return;
        }
        if (!/^\d{2}\/\d{2}$/.test(valCartao)) {
            Swal.fire({ icon: 'error', title: 'Invalid Date', text: 'Enter the date in MM/YY format.', confirmButtonColor: '#000' });
            return;
        }
        const [mes, ano] = valCartao.split('/').map(Number);
        const agora = new Date();
        const anoAtual = agora.getFullYear() % 100;
        const mesAtual = agora.getMonth() + 1;
        if (ano < anoAtual || (ano === anoAtual && mes < mesAtual)) {
            Swal.fire({ icon: 'error', title: 'Expired card', text: 'The card expiration date ', confirmButtonColor: '#000' });
            return;
        }
        if (mes < 1 || mes > 12) {
            Swal.fire({ icon: 'error', title: 'Invalid Month', text: 'The month must be between 01 and 12.', confirmButtonColor: '#000' });
            return;
        }
        if (cvv.length !== 3) {
            Swal.fire({ icon: 'error', title: 'Invalid CVV', text: 'The CVV must have 3 digits.', confirmButtonColor: '#000' });
            return;
        }
    }

    if (metodo === 'paypal') {
        const emailPaypal = document.getElementById('email_paypal').value;
        const passPaypal = document.getElementById('pass_paypal').value;

        if (!emailPaypal || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailPaypal)) {
            Swal.fire({ icon: 'error', title: 'Invalid Email', text: 'Enter a valid PayPal email.', confirmButtonColor: '#000' });
            return;
        }
        if (passPaypal.length < 6) {
            Swal.fire({ icon: 'error', title: 'Invalid Password', text: 'The password must have at least 6 characters.', confirmButtonColor: '#000' });
            return;
        }
    }

    fecharModal();

    const form = document.getElementById('formFinal');
    const params = new URLSearchParams(new FormData(form));

    fetch('gerir-carrinho.php?' + params.toString())
    .then(response => response.json())
    .then(data => {
        if (data.status === 'erro_stock') {
            Swal.fire({ icon: 'error', title: 'Insufficient Stock', text: 'There is not enough stock available.', confirmButtonColor: '#000' });
            return;
        }

        Swal.fire({
            title: 'Processing...',
            text: metodo === 'mastercard' ? 'Validating card with the bank...' :
                  metodo === 'paypal' ? 'Authenticating with PayPal...' :
                  'Registering your order...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => { Swal.showLoading(); }
        });

        setTimeout(() => {
            Swal.fire({
                title: 'Payment Confirmed!',
                text: 'Your order has been registered successfully.',
                icon: 'success',
                confirmButtonColor: '#000',
                confirmButtonText: 'Continue'
            }).then(() => {
                window.location.href = 'indexeng.php';
            });
        }, 2000);
    });
}

document.getElementById('num_cartao')?.addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '').replace(/(.{4})/g, '$1 ').trim();
});
document.getElementById('val_cartao')?.addEventListener('input', function (e) {
    let v = e.target.value.replace(/\D/g, '');
    if (v.length > 2) v = v.substring(0,2) + '/' + v.substring(2,4);
    e.target.value = v;
});

document.getElementById('pesquisaCarrinho').addEventListener('input', function() {
    const termo = this.value.toLowerCase();
    document.querySelectorAll('.item_carrinho').forEach(item => {
        const nome = item.querySelector('.item_nome').textContent.toLowerCase();
        item.style.display = nome.includes(termo) ? 'flex' : 'none';
    });
});
</script>

<!-- MODAL IDIOMAS -->
<div id="langModal" class="modal-overlay" style="display:none;">
    <div class="modal-box" style="max-width:300px; text-align:center;">
        <span class="modal-close" id="closeLangModal">&times;</span>
        <h2>Choose Language</h2>
        <div class="lang-options" style="margin-top:20px; display:flex; justify-content:space-around;">
            <a href="index.php" class="lang-choice">
                <img src="https://flagcdn.com/w40/pt.png" alt="Português">
                <p>Português</p>
            </a>
            <a href="indexeng.php" class="lang-choice">
                <img src="https://flagcdn.com/w40/us.png" alt="English">
                <p>English</p>
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const langModal = document.getElementById("langModal");
    const openLangModal = document.getElementById("openLangModal");
    const closeLangModal = document.getElementById("closeLangModal");

    openLangModal?.addEventListener("click", (e) => {
        e.preventDefault();
        langModal.style.display = "flex";
    });

    closeLangModal?.addEventListener("click", () => {
        langModal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === langModal) langModal.style.display = "none";
    });
});
</script>

<script> 
function atualizarItem(input) {
    const card = input.closest('.item_carrinho');
    const precoUnit = parseFloat(card.dataset.precoUnit);
    const qtd = parseInt(input.value) || 1;
    const novoTotal = precoUnit * qtd;

    // Atualizar preço do item
    card.querySelector('.item_preco').textContent = novoTotal.toLocaleString('pt-PT', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €';

    // Recalcular total geral
    let totalGeral = 0;
    document.querySelectorAll('.item_carrinho').forEach(c => {
        const pu = parseFloat(c.dataset.precoUnit);
        const q = parseInt(c.querySelector('input[type="number"]').value) || 1;
        totalGeral += pu * q;
    });

    // Atualizar subtotal e total no resumo
    const totalFormatado = totalGeral.toLocaleString('pt-PT', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' €';
    document.querySelectorAll('.resumo-linha span:last-child')[0].textContent = totalFormatado;
    document.querySelector('.resumo-total span:last-child').textContent = totalFormatado;
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

        <script>
        document.getElementById('lupaBtn').addEventListener('click', function(e) {
    const input = document.getElementById('pesquisa');
    const form = document.getElementById('searchForm');
    if (!input.classList.contains('active')) {
        input.classList.add('active');
        input.focus();
    } else if (input.value.trim() !== "") {
        form.submit();
    } else {
        input.classList.remove('active');
    }
    e.stopPropagation();
});

document.addEventListener('click', function(e) {
    const input = document.getElementById('pesquisa');
    if (input && !input.contains(e.target)) {
        input.classList.remove('active');
    }
});
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



</html>