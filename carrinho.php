<?php
session_start();
if ( ! isset($_SESSION["utilizador"]) ) {
    $_SESSION["mensagem"] = "Inicie sessão para efetuar compras.";
    Header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
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

        if (data.error) {
            historico.pop();
            typing.remove();
            adicionarMensagem('Erro: ' + data.error.message, 'bot');
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
        adicionarMensagem('Erro de ligação. Verifica a tua internet.', 'bot');
    }
}
</script>
<body>

<?php if (isset($_SESSION["erro_stock"])): ?>
    <script>
        Swal.fire({ icon: 'error', title: 'Stock Insuficiente', text: '<?php echo $_SESSION["erro_stock"]; ?>', confirmButtonColor: '#000' });
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
            <div class="carrinho-titulo">O Meu Carrinho</div>
            <a href="shop.php" style="display:inline-flex; align-items:center; gap:8px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1.5px; color:#999; text-decoration:none; margin-bottom:20px; transition:color 0.2s;">
                <i class="fas fa-chevron-left" style="font-size:10px;"></i> Continuar a comprar
            </a>
            <div style="text-align:center; padding:60px 20px; color:#ccc;">
                <i class="fas fa-shopping-cart" style="font-size:40px; margin-bottom:15px; display:block;"></i>
                <p style="font-size:14px; color:#999;">O teu carrinho está vazio.</p>
                <a href="shop.php" style="display:inline-block; margin-top:20px; padding:12px 30px; background:#000; color:#fff; text-decoration:none; font-size:11px; font-weight:700; letter-spacing:2px; text-transform:uppercase;">Ver Produtos</a>
            </div>
        </div>
        <div class="carrinho-resumo-box">
            <div class="resumo-titulo">Resumo da Encomenda</div>
            <div class="resumo-linha">
                <span>Subtotal</span>
                <span>0,00 €</span>
            </div>
            <div class="resumo-linha">
                <span>Envio</span>
                <span>Grátis</span>
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
        <a href="https://www.instagram.com/urbae_231/"><i class="fab fa-instagram"></i></a>
    </div>
</nav>
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



<div class="carrinho-page">
<div class="carrinho-wrapper">

    <!-- COLUNA ESQUERDA: ITENS -->
    <div class="carrinho-itens-box">
<div class="carrinho-titulo">O Meu Carrinho</div>
<a href="shop.php" style="display:inline-flex; align-items:center; gap:8px; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1.5px; color:#999; text-decoration:none; margin-bottom:20px; transition:color 0.2s;">
    <i class="fas fa-chevron-left" style="font-size:10px;"></i> Continuar a comprar
</a>        
        <input type="text" id="pesquisaCarrinho" placeholder="Pesquisar produtos...">
        
        <?php while ( $item = mysqli_fetch_array($resultado_itens) ) { 
            $preco_unitario = $item["preco_total_itens"] / $item["quantidade"];
        ?>
        <div class="item_carrinho" data-preco-unit="<?= $preco_unitario ?>">
            <div class="item_nome"><?php echo $item["designacao"]; ?></div>
            <div class="item_quantidade">
                <input id="item<?php echo $item['produto_id']?>" type="number" min="1" value="<?php echo $item["quantidade"]; ?>" onchange="atualizarItem(this)">
            </div>
            <div class="item_preco"><?php echo number_format($item["preco_total_itens"], 2, ',', '.') . " €"; ?></div>
            <div class="item_remover"><a href="gerir-carrinho.php?item_quantidade=0&produto_id=<?php echo $item['produto_id']?>"><i class="fa fa-trash"></i></a></div>
        </div>
        <?php } ?>
    </div>

    <!-- COLUNA DIREITA: RESUMO + PAGAMENTO -->
    <div class="carrinho-resumo-box">
        <div class="resumo-titulo">Resumo da Encomenda</div>
        
        <div class="resumo-linha">
            <span>Subtotal</span>
            <span><?php echo number_format($preco_total_carrinho, 2, ',', '.') . " €"; ?></span>
        </div>
        <div class="resumo-linha">
            <span>Envio</span>
            <span>Grátis</span>
        </div>
        <div class="resumo-total">
            <span>Total</span>
            <span><?php echo number_format($preco_total_carrinho, 2, ',', '.') . " €"; ?></span>
        </div>

        <p class="payment-title">Método de Pagamento</p>
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
        <h3 id="tituloModal">Finalizar Compra</h3>
        <p id="descModal">Confirme os dados para prosseguir.</p>

        <form id="formFinal" action="gerir-carrinho.php" method="GET" onsubmit="processarPagamento(event)">
            <input type="hidden" name="carrinho_id" value="<?php echo $carrinho_id; ?>">
            <input type="hidden" name="carrinho_estado" value="1">
            <input type="hidden" name="idioma" value="pt">
            <input type="hidden" id="inputMetodo" name="metodo" value="">
            
            <input type="hidden" id="morada_entrega" name="morada_entrega" value="">
            <!-- Campos PayPal -->
            <div id="camposPaypal" style="display:none;">
                <div class="paypal-header">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal">
                </div>
                <input type="email" id="email_paypal" placeholder="Email do PayPal" class="modal-input">
                <input type="password" id="pass_paypal" placeholder="Password do PayPal" class="modal-input">
                <p class="ssl-info"><i class="fas fa-lock"></i> Ligação segura SSL — Os seus dados estão protegidos</p>
            </div>

        <!-- Campos Mastercard -->
<div id="camposCartao" style="display: none; width: 100% !important; box-sizing: border-box !important;">
    
    <!-- O !important vai obrigar o Número do Cartão a esticar até aos 100% da caixa -->
    <input type="text" id="num_cartao" placeholder="Número do cartão (16 dígitos)" maxlength="19" class="modal-input" 
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
                <p><strong>Entidade:</strong> 12345</p>
                <p><strong>Referência:</strong> 244 283 325</p>
                <p><strong>Valor:</strong> <?php echo number_format($preco_total_carrinho, 2, ',', '.') . " €"; ?></p>
            </div>

            <button type="submit" class="btn-confirmar">CONFIRMAR E PAGAR</button>
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
        window.location.href = 'perfil.php';
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
            Swal.fire({ icon: 'error', title: 'Número inválido', text: 'O número do cartão deve ter 16 dígitos.', confirmButtonColor: '#000' });
            return;
        }
        if (!/^\d{2}\/\d{2}$/.test(valCartao)) {
            Swal.fire({ icon: 'error', title: 'Data inválida', text: 'Insere a data no formato MM/AA.', confirmButtonColor: '#000' });
            return;
        }
        const [mes, ano] = valCartao.split('/').map(Number);
        const agora = new Date();
        const anoAtual = agora.getFullYear() % 100;
        const mesAtual = agora.getMonth() + 1;
        if (ano < anoAtual || (ano === anoAtual && mes < mesAtual)) {
            Swal.fire({ icon: 'error', title: 'Cartão expirado', text: 'A data de validade do cartão já expirou.', confirmButtonColor: '#000' });
            return;
        }
        if (mes < 1 || mes > 12) {
            Swal.fire({ icon: 'error', title: 'Mês inválido', text: 'O mês deve estar entre 01 e 12.', confirmButtonColor: '#000' });
            return;
        }
        if (cvv.length !== 3) {
            Swal.fire({ icon: 'error', title: 'CVV inválido', text: 'O CVV deve ter 3 dígitos.', confirmButtonColor: '#000' });
            return;
        }
    }

    if (metodo === 'paypal') {
        const emailPaypal = document.getElementById('email_paypal').value;
        const passPaypal = document.getElementById('pass_paypal').value;

        if (!emailPaypal || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailPaypal)) {
            Swal.fire({ icon: 'error', title: 'Email inválido', text: 'Insere um email válido do PayPal.', confirmButtonColor: '#000' });
            return;
        }
        if (passPaypal.length < 6) {
            Swal.fire({ icon: 'error', title: 'Password inválida', text: 'A password deve ter pelo menos 6 caracteres.', confirmButtonColor: '#000' });
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
            Swal.fire({ icon: 'error', title: 'Stock Insuficiente', text: 'Não há stock suficiente.', confirmButtonColor: '#000' });
            return;
        }

        Swal.fire({
            title: 'A processar...',
            text: metodo === 'mastercard' ? 'A validar cartão com o banco...' :
                  metodo === 'paypal' ? 'A autenticar com o PayPal...' :
                  'A registar a sua encomenda...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => { Swal.showLoading(); }
        });

        setTimeout(() => {
            Swal.fire({
                title: 'Pagamento Confirmado!',
                text: 'A sua encomenda foi registada com sucesso.',
                icon: 'success',
                confirmButtonColor: '#000',
                confirmButtonText: 'Continuar'
            }).then(() => {
                window.location.href = 'index.php';
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
        <h2>Escolher Idioma</h2>
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