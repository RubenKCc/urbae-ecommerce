<?php
session_start();

$pesquisa = $_GET['pesquisa'] ?? '';
$cat = $_GET['cat'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Política de Privacidade | URBÆ</title>
    <link rel="icon" type="image/png" href="URBAE COMPLETO.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
 * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f0f2f5; font-family: 'Poppins', sans-serif; }


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
#pesquisa {
    border: 1px solid #ccc;
    padding: 5px 10px;
    border-radius: 4px;
    width: 150px; /* Largura fixa para não empurrar o menu */
}

/* Container principal da lupa */
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



/* Classe 'active' que o JavaScript vai adicionar */
.search-input.active {
    width: 200px; /* Largura da barra aberta */
    opacity: 1;
    padding: 5px 12px;
    border: 1px solid #ddd;
    margin-right: 5px;
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
        /* Estilo inicial: Invisível e sem largura */

        .page-hero {
            background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)),
                        url('https://images.unsplash.com/photo-1563013544-824ae1b704d3?q=80&w=2070') center/cover;
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

        .privacidade-container {
            max-width: 860px;
            margin: 70px auto;
            padding: 0 30px 80px;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .privacidade-container .intro {
            background: #f9f9f9;
            border-left: 4px solid #000;
            padding: 20px 25px;
            margin-bottom: 50px;
            font-size: 14px;
            color: #555;
            line-height: 1.8;
        }

        .privacidade-secao {
            margin-bottom: 45px;
            padding-bottom: 45px;
            border-bottom: 1px solid #eee;
        }

        .privacidade-secao:last-child { border-bottom: none; }

        .privacidade-secao h2 {
            font-size: 18px;
            font-weight: 700;
            color: #000;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .privacidade-secao h2 span.num {
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

        .privacidade-secao p {
            font-size: 14px;
            line-height: 1.9;
            color: #555;
            margin-bottom: 12px;
        }

        .privacidade-secao ul {
            padding-left: 20px;
            margin: 10px 0;
        }

        .privacidade-secao ul li {
            font-size: 14px;
            color: #555;
            line-height: 1.9;
            margin-bottom: 6px;
        }

        .rgpd-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #000;
            color: #fff;
            padding: 10px 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-bottom: 40px;
        }

        .ultima-atualizacao {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-bottom: 40px;
        }
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

<!-- NAV TOPO -->
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

<!-- NAV BRANCA -->
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
    <div class="nav-icons">
        <form method="GET" action="shop.php" id="searchForm" style="display:flex; align-items:center; gap:6px;">
            <input type="text" name="pesquisa" id="pesquisa" class="search-input" placeholder="Pesquisar..." value="">
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
                <span style="font-weight:600;"><?= $_SESSION["utilizador"] ?></span>
                <button type="submit" name="botaoLogout" value="1" style="background:none; border:none; cursor:pointer; padding: 0; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        <?php endif; ?>

        <a href="#" class="icon-badge lang-btn" id="openLangModal" title="Idioma">
            <img src="https://flagcdn.com/w20/pt.png" alt="PT">
        </a>
    </div>
</header>
<hr>

<!-- HERO -->
<section class="page-hero">
    <div class="container">
        <h1>Política de Privacidade</h1>
        <p>Última atualização: Janeiro 2024</p>
    </div>
</section>

<!-- CONTEÚDO -->
<div class="privacidade-container">

    <div style="text-align:center; margin-bottom:30px;">
        <span class="rgpd-badge"><i class="fas fa-shield-alt"></i> Conforme com o RGPD</span>
    </div>

    <div class="intro">
        A <strong>URBÆ</strong> respeita a sua privacidade e está comprometida com a proteção dos seus dados pessoais. Esta Política de Privacidade descreve como recolhemos, utilizamos e protegemos as suas informações, em conformidade com o Regulamento Geral sobre a Proteção de Dados (RGPD) — Regulamento (UE) 2016/679.
    </div>

    <p class="ultima-atualizacao">Versão em vigor desde 1 de Janeiro de 2024</p>

    <div class="privacidade-secao">
        <h2><span class="num">1</span> Responsável pelo Tratamento</h2>
        <p>O responsável pelo tratamento dos seus dados pessoais é a <strong>URBÆ</strong>, com sede em Coimbra, Portugal. Para exercer os seus direitos ou esclarecer dúvidas, contacte-nos:</p>
        <ul>
            <li><strong>Email:</strong> urbaegeral@gmail.com</li>
            <li><strong>Telefone:</strong> 911-825-589</li>
            <li><strong>Morada:</strong> N1, Coimbra, Portugal</li>
        </ul>
    </div>

    <div class="privacidade-secao">
        <h2><span class="num">2</span> Dados que Recolhemos</h2>
        <p>Recolhemos apenas os dados estritamente necessários para a prestação dos nossos serviços:</p>
        <ul>
            <li><strong>Dados de identificação:</strong> nome de utilizador;</li>
            <li><strong>Dados de contacto:</strong> endereço de email;</li>
            <li><strong>Dados de acesso:</strong> password (armazenada de forma encriptada);</li>
            <li><strong>Dados de navegação:</strong> endereço IP, tipo de browser, páginas visitadas;</li>
            <li><strong>Dados de compra:</strong> histórico de encomendas e itens no carrinho.</li>
        </ul>
    </div>

    <div class="privacidade-secao">
        <h2><span class="num">3</span> Finalidade do Tratamento</h2>
        <p>Os seus dados são utilizados exclusivamente para:</p>
        <ul>
            <li>Gestão e autenticação da sua conta de utilizador;</li>
            <li>Processamento e gestão das suas encomendas;</li>
            <li>Envio de comunicações transacionais (confirmações, faturas);</li>
            <li>Envio de newsletter, caso tenha dado o seu consentimento;</li>
            <li>Melhoria contínua do nosso website e serviços;</li>
            <li>Cumprimento de obrigações legais.</li>
        </ul>
    </div>

    <div class="privacidade-secao">
        <h2><span class="num">4</span> Base Legal do Tratamento</h2>
        <p>O tratamento dos seus dados baseia-se nas seguintes bases legais:</p>
        <ul>
            <li><strong>Execução de contrato:</strong> para processar as suas encomendas e gerir a sua conta;</li>
            <li><strong>Consentimento:</strong> para o envio de newsletter e comunicações de marketing;</li>
            <li><strong>Interesse legítimo:</strong> para melhorar os nossos serviços e garantir a segurança;</li>
            <li><strong>Obrigação legal:</strong> para cumprir requisitos fiscais e legais aplicáveis.</li>
        </ul>
    </div>

    <div class="privacidade-secao">
        <h2><span class="num">5</span> Partilha de Dados</h2>
        <p>A URBÆ não vende, aluga nem partilha os seus dados pessoais com terceiros para fins comerciais. Os seus dados podem ser partilhados apenas com:</p>
        <ul>
            <li>Prestadores de serviços de logística e entrega, para cumprimento das encomendas;</li>
            <li>Processadores de pagamento, para conclusão das transações;</li>
            <li>Autoridades competentes, quando exigido por lei.</li>
        </ul>
        <p>Todos os nossos parceiros estão sujeitos a acordos de confidencialidade e conformidade com o RGPD.</p>
    </div>

    <div class="privacidade-secao">
        <h2><span class="num">6</span> Retenção de Dados</h2>
        <p>Os seus dados são conservados pelo período estritamente necessário para as finalidades para as quais foram recolhidos:</p>
        <ul>
            <li><strong>Dados de conta:</strong> enquanto a conta estiver ativa ou até pedido de eliminação;</li>
            <li><strong>Dados de encomendas:</strong> 10 anos (obrigação legal fiscal);</li>
            <li><strong>Dados de newsletter:</strong> até cancelamento da subscrição.</li>
        </ul>
    </div>

    <div class="privacidade-secao">
        <h2><span class="num">7</span> Os Seus Direitos</h2>
        <p>Ao abrigo do RGPD, tem os seguintes direitos sobre os seus dados pessoais:</p>
        <ul>
            <li><strong>Direito de acesso:</strong> consultar os dados que temos sobre si;</li>
            <li><strong>Direito de retificação:</strong> corrigir dados incorretos ou incompletos;</li>
            <li><strong>Direito ao apagamento:</strong> solicitar a eliminação dos seus dados;</li>
            <li><strong>Direito à portabilidade:</strong> receber os seus dados em formato legível;</li>
            <li><strong>Direito de oposição:</strong> opor-se ao tratamento para fins de marketing;</li>
            <li><strong>Direito de limitação:</strong> restringir o tratamento em determinadas circunstâncias.</li>
        </ul>
        <p>Para exercer qualquer um destes direitos, contacte-nos através de urbaegeral@gmail.com. Tem também o direito de apresentar uma reclamação à <strong>CNPD</strong> (Comissão Nacional de Proteção de Dados).</p>
    </div>

    <div class="privacidade-secao">
        <h2><span class="num">8</span> Segurança dos Dados</h2>
        <p>Implementamos medidas técnicas e organizativas adequadas para proteger os seus dados contra acesso não autorizado, perda, destruição ou divulgação. As passwords são armazenadas de forma encriptada e nunca em texto simples.</p>
        <p>Em caso de violação de dados que represente risco para os seus direitos, seremos notificados à CNPD no prazo de 72 horas e informá-lo-emos diretamente se necessário.</p>
    </div>

    <div class="privacidade-secao">
        <h2><span class="num">9</span> Cookies</h2>
        <p>O nosso website utiliza cookies estritamente necessários para o funcionamento da sessão de utilizador. Não utilizamos cookies de rastreamento ou publicidade de terceiros.</p>
    </div>

    <div class="privacidade-secao">
        <h2><span class="num">10</span> Alterações a Esta Política</h2>
        <p>A URBÆ reserva-se o direito de atualizar esta Política de Privacidade a qualquer momento. Quaisquer alterações significativas serão comunicadas por email aos utilizadores registados. A data da última atualização está sempre indicada no topo desta página.</p>
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

<div id="registerModal" class="modal-overlay">
  <div class="modal-box">
    <span class="modal-close register-close">&times;</span>
    <h2>Criar Conta</h2>
    <?php if (isset($_SESSION["erro_registo"])): ?>
      <div class="msg-feedback erro"><?= $_SESSION["erro_registo"]; ?></div>
    <?php unset($_SESSION["erro_registo"]); endif; ?>
    <?php if (isset($_SESSION["sucesso"])): ?>
      <div class="msg-feedback sucesso"><?= $_SESSION["sucesso"]; ?></div>
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
      <button type="submit" name="botaoRegistar" value="1" class="modal-btn">Criar Conta</button>
    </form>
    <p class="modal-register">Já tem conta? <a href="#" id="voltarLogin">Entrar</a></p>
  </div>
</div>

<!-- MODAL IDIOMAS -->
<div id="langModal" class="modal-overlay" style="display:none;">
  <div class="modal-box" style="max-width:300px; text-align:center;">
    <span class="modal-close" id="closeLangModal">&times;</span>
    <h2>Escolher Idioma</h2>
    <div class="lang-options" style="margin-top:20px; display:flex; justify-content:space-around;">
      <a href="index.php" class="lang-choice"><img src="https://flagcdn.com/w40/pt.png" alt="PT"><p>Português</p></a>
      <a href="indexeng.php" class="lang-choice"><img src="https://flagcdn.com/w40/us.png" alt="EN"><p>English</p></a>
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
                <hr style="height:1px; background-color:#474747; border:none; opacity:0.4;"><br>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">Sobre nós</a></li>
                    <li><a href="contact.php">Contacto</a></li>
                    <li><a href="termosecondicoes.php">Termos e Condições</a></li>
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
            <div class="newsletter">
                <form action="subscrever.php" method="POST">
                    <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                    <input type="email" name="email" placeholder="Endereço de email" required>
                    <button type="submit">Inscrever-se</button>
                </form>
            </div>
            <p class="copyright">&copy; 2024 Alexandre. All rights reserved.</p>
        </div>
    </div>
</footer>




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

<script src="pesquisar.js"></script>

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