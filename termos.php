<?php
session_start();

$pesquisa = $_GET['pesquisa'] ?? '';
$cat = $_GET['cat'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Termos e Condições | URBÆ</title>
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
        <img src="URBAE verde logo.png" alt="URBAE Logo" height="90" width="110" style="margin-left:30px;">
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
    <!-- Substitui a secção da NAV-ICONS por esta -->
<div class="nav-icons">
    <form method="GET" action="shop.php" id="searchForm" style="display:flex; align-items:center; gap:6px;">
        <!-- Adicionei o ID 'pesquisa' e a classe 'search-input' -->
        <input type="text" name="pesquisa" id="pesquisa" class="search-input" placeholder="Pesquisar..." value="<?= htmlspecialchars($pesquisa) ?>">
        
        <!-- Adicionei o ID 'lupaBtn' -->
        <button type="button" id="lupaBtn" style="background:none; border:none; cursor:pointer;">
            <i class="fas fa-search"></i>
        </button>
    </form>
    
    <?php if (!isset($_SESSION["utilizador"])): ?>
        <a href="#" class="icon-badge" onclick="alert('Tens de iniciar sessão para aceder ao carrinho!'); return false;">
            <i class="fas fa-shopping-cart"></i>
        </a>
        <a href="#" class="icon-badge user-btn"><i class="fas fa-user"></i></a>
    <?php else: ?>
        <a href="carrinho.php" class="icon-badge"><i class="fas fa-shopping-cart"></i></a>
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
        <img src="https://flagcdn.com/w20/pt.png" alt="PT">
    </a>
</div>
</header>

<!-- HERO -->
<section class="page-hero">
    <div class="container">
        <h1>Termos e Condições</h1>
        <p>Última atualização: Janeiro 2024</p>
    </div>
</section>

<!-- CONTEÚDO -->
<div class="termos-container">

    <div class="intro">
        Bem-vindo à <strong>URBÆ</strong>. Ao aceder e utilizar o nosso website, está a aceitar os presentes Termos e Condições. Recomendamos a leitura atenta antes de efetuar qualquer compra ou utilização dos nossos serviços.
    </div>

    <p class="ultima-atualizacao">Versão em vigor desde 1 de Janeiro de 2024</p>

    <div class="termos-secao">
        <h2><span class="num">1</span> Identificação da Empresa</h2>
        <p>A <strong>URBÆ</strong> é uma marca de moda urbana sediada em Coimbra, Portugal. Para qualquer questão, pode contactar-nos através de:</p>
        <ul>
            <li><strong>Email:</strong> urbaegeral@gmail.com</li>
            <li><strong>Telefone:</strong> 911-825-589</li>
            <li><strong>Morada:</strong> N1, Coimbra, Portugal</li>
        </ul>
    </div>

    <div class="termos-secao">
        <h2><span class="num">2</span> Aceitação dos Termos</h2>
        <p>Ao utilizar o nosso website e/ou efetuar uma compra, confirma que leu, compreendeu e aceita os presentes Termos e Condições na sua totalidade. Caso não concorde com alguma disposição, deverá abster-se de utilizar o nosso serviço.</p>
        <p>A URBÆ reserva-se o direito de alterar estes termos a qualquer momento, sendo as alterações publicadas nesta página com a respetiva data de atualização.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">3</span> Registo e Conta de Utilizador</h2>
        <p>Para efetuar compras no nosso website, é necessário criar uma conta. Ao registar-se, compromete-se a:</p>
        <ul>
            <li>Fornecer informações verídicas, precisas e atualizadas;</li>
            <li>Manter a confidencialidade das suas credenciais de acesso;</li>
            <li>Notificar-nos imediatamente em caso de acesso não autorizado à sua conta;</li>
            <li>Ser responsável por todas as atividades realizadas na sua conta.</li>
        </ul>
        <p>A URBÆ reserva-se o direito de suspender ou encerrar contas que violem estes termos.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">4</span> Produtos e Preços</h2>
        <p>Todos os preços apresentados no website estão expressos em Euros (€) e incluem IVA à taxa legal em vigor. A URBÆ reserva-se o direito de alterar os preços sem aviso prévio.</p>
        <p>As imagens dos produtos são meramente ilustrativas. Fazemos todos os esforços para garantir que as cores e detalhes sejam apresentados com a maior fidelidade possível, no entanto, podem existir variações dependendo do dispositivo utilizado.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">5</span> Encomendas e Pagamentos</h2>
        <p>Ao finalizar uma encomenda, está a fazer uma oferta de compra vinculativa. A encomenda só é considerada confirmada após receção do respetivo pagamento. Aceitamos os seguintes métodos de pagamento:</p>
        <ul>
            <li>Cartão de crédito/débito (Mastercard)</li>
            <li>MB</li>
            <li>PayPal</li>
        </ul>
        <p>Em caso de falha no pagamento, a encomenda será automaticamente cancelada.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">6</span> Envio e Entrega</h2>
        <p>Os prazos de entrega são estimativas e podem variar consoante a localização e a transportadora. A URBÆ não se responsabiliza por atrasos causados por fatores externos à nossa operação, como greves ou condições meteorológicas adversas.</p>
        <ul>
            <li><strong>Portugal Continental:</strong> 2 a 4 dias úteis</li>
            <li><strong>Ilhas:</strong> 5 a 8 dias úteis</li>
            <li><strong>Europa:</strong> 7 a 14 dias úteis</li>
        </ul>
    </div>

    <div class="termos-secao">
        <h2><span class="num">7</span> Devoluções e Trocas</h2>
        <p>De acordo com a legislação portuguesa e europeia, tem direito a devolver qualquer produto no prazo de <strong>14 dias</strong> após a receção, sem necessidade de justificação. Para iniciar o processo de devolução:</p>
        <ul>
            <li>Contacte-nos por email para urbaegeral@gmail.com;</li>
            <li>O produto deve ser devolvido no estado original, sem uso e com etiquetas;</li>
            <li>Os custos de devolução são da responsabilidade do cliente, salvo em caso de produto defeituoso;</li>
            <li>O reembolso será processado no prazo de 14 dias após receção do produto devolvido.</li>
        </ul>
    </div>

    <div class="termos-secao">
        <h2><span class="num">8</span> Propriedade Intelectual</h2>
        <p>Todo o conteúdo presente neste website, incluindo textos, imagens, logótipos, ícones e design, é propriedade exclusiva da URBÆ e está protegido por legislação de direitos de autor. É expressamente proibida a reprodução, distribuição ou utilização não autorizada de qualquer conteúdo.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">9</span> Limitação de Responsabilidade</h2>
        <p>A URBÆ não se responsabiliza por quaisquer danos diretos, indiretos, incidentais ou consequentes resultantes da utilização ou impossibilidade de utilização do nosso website ou serviços, incluindo falhas técnicas, interrupções ou erros no sistema.</p>
    </div>

    <div class="termos-secao">
        <h2><span class="num">10</span> Lei Aplicável</h2>
        <p>Os presentes Termos e Condições são regidos pela legislação portuguesa. Qualquer litígio decorrente da utilização do nosso website ou serviços será submetido à jurisdição exclusiva dos tribunais portugueses competentes.</p>
        <p>Para resolução alternativa de litígios, pode recorrer ao Centro de Arbitragem de Conflitos de Consumo ou a outra entidade de resolução alternativa de litígios legalmente constituída.</p>
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


</html>