<?php
session_start();
if (!isset($_SESSION["utilizador"])) {
    header("Location: indexeng.php");
    exit();
}

require ".ht_conexao-bd.php";

$ordenar = $_GET['ordenar'] ?? '';
$cat = $_GET['cat'] ?? '';
$pesquisa = $_GET['pesquisa'] ?? '';


$user = $_SESSION["utilizador"];
$sql = "SELECT * FROM utilizadores WHERE utilizador = '$user'";
$res = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_assoc($res);

$traducoes_genero = [
    'Masculino'   => 'Male',
    'Feminino'    => 'Female',
    'Não-binário' => 'Non-binary',
    'Outro'       => 'Other'
];
$genero_em_ingles = $traducoes_genero[$dados['genero'] ?? ''] ?? '';


$sql_enc = "SELECT * FROM carrinho WHERE utilizador_id = {$dados['id_utilizadores']} AND estado = 1 ORDER BY datahora DESC";
$res_enc = mysqli_query($conexao, $sql_enc);
$total_encomendas = mysqli_num_rows($res_enc);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - URBÆ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="URBAE COMPLETO.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

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



        /* CAPA */
        .perfil-capa-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            background: #1a1a1a;
            overflow: hidden;
        }

        .perfil-capa {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 30%;
            display: block;
        }

        .btn-editar-capa {
            position: absolute;
            bottom: 15px;
            right: 20px;
            background: rgba(0,0,0,0.6);
            color: #fff;
            border: none;
            padding: 8px 16px;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            cursor: pointer;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
            letter-spacing: 0.5px;
        }
        .btn-editar-capa:hover { background: rgba(0,0,0,0.85); }

        /* SECÇÃO DO PERFIL */
        .perfil-info-section {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 0;
        }

        .perfil-info-inner {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
        }

        /* FOTO DE PERFIL */
        .foto-perfil-wrapper {
            position: relative;
            display: inline-block;
            margin-top: -60px;
            margin-bottom: 10px;
        }

        .foto-perfil {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            display: block;
        }

        .btn-foto-perfil {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #000;
            color: #fff;
            border: 2px solid #fff;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }
        .btn-foto-perfil:hover { background: #333; }

        .perfil-nome-area {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 15px;
        }

        .perfil-nome {
            font-size: 22px;
            font-weight: 700;
            color: #000;
        }

        .perfil-email {
            font-size: 13px;
            color: #888;
            margin-top: 2px;
        }

        .perfil-descricao-text {
            font-size: 13px;
            color: #555;
            margin-top: 5px;
            max-width: 500px;
            line-height: 1.5;
        }

        .perfil-meta {
            display: flex;
            gap: 20px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .perfil-meta span {
            font-size: 12px;
            color: #888;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .perfil-meta span i { color: #aaa; font-size: 11px; }

        /* STATS */
        .perfil-stats {
            display: flex;
            gap: 30px;
            margin-top: 15px;
        }

        .stat-item {
            text-align: center;
            padding: 12px 0;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: border-color 0.2s;
        }

        .stat-item:hover, .stat-item.ativo {
            border-bottom-color: #000;
        }

        .stat-num {
            font-size: 18px;
            font-weight: 700;
            color: #000;
        }

        .stat-label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* TABS */
        .perfil-tabs {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            gap: 5px;
            padding: 0 20px;
            border-top: 1px solid #eee;
            margin-top: 10px;
        }

        .tab-btn {
            padding: 12px 20px;
            font-size: 13px;
            font-weight: 600;
            color: #888;
            border: none;
            background: none;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.3px;
        }

        .tab-btn:hover { color: #000; }
        .tab-btn.ativo { color: #000; border-bottom-color: #000; }

        /* CONTEÚDO */
        .perfil-content {
            max-width: 900px;
            margin: 25px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
        }

        .tab-content { display: none; }
        .tab-content.ativo { display: block; }

        /* CARDS */
        .card {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e8e8e8;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .card-titulo {
            font-size: 13px;
            font-weight: 700;
            color: #000;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .form-grupo { margin-bottom: 15px; }

        .form-grupo label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #aaa;
            margin-bottom: 6px;
        }

        .form-grupo input,
        .form-grupo select,
        .form-grupo textarea {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #e8e8e8;
            border-bottom: 2px solid #e8e8e8;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s;
            color: #333;
            background: #fafafa;
            border-radius: 4px;
        }

        .form-grupo input:focus,
        .form-grupo select:focus,
        .form-grupo textarea:focus {
            border-bottom-color: #000;
            background: #fff;
        }

        .form-grupo input:disabled {
            background: #f5f5f5;
            color: #bbb;
            cursor: not-allowed;
        }

        .form-grupo textarea { resize: vertical; min-height: 80px; }

        .btn-guardar {
            background: #000;
            color: #fff;
            border: none;
            padding: 12px 28px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
            font-family: 'Poppins', sans-serif;
            border-radius: 4px;
        }
        .btn-guardar:hover { background: #222; }

        /* ENCOMENDAS */
        .encomenda-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f5f5f5;
        }
        .encomenda-item:last-child { border-bottom: none; }

        .encomenda-num { font-weight: 700; color: #000; font-size: 13px; }
        .encomenda-data { color: #bbb; font-size: 11px; margin-top: 3px; }
        .encomenda-total { font-weight: 700; color: #000; font-size: 14px; }

        .badge-pago {
            background: #f0faf4;
            color: #2e7d32;
            padding: 3px 10px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 1px solid #c8e6c9;
            border-radius: 20px;
        }

        .sem-items {
            text-align: center;
            padding: 40px;
            color: #ccc;
            font-size: 13px;
        }
        .sem-items i { font-size: 35px; margin-bottom: 12px; display: block; }

        /* SIDEBAR DIREITA */

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f5f5f5;
            font-size: 13px;
            color: #444;
        }
        .info-item:last-child { border-bottom: none; }
        .info-item i { width: 16px; color: #bbb; font-size: 14px; }

        /* BOTÃO TERMINAR SESSÃO */
        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 11px 14px;
            background: #fff;
            color: #e74c3c;
            border: 1px solid #fde8e8;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
            width: 100%;
            margin-top: 10px;
        }
        .btn-logout:hover { background: #fde8e8; }

        #inputFoto, #inputCapa { display: none; }
    </style>
</head>
<body>

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
<hr>

<!-- NAV BRANCA -->
<header class="URBAE-nav">
    <a href="index.php">
        <img src="URBAE verde logo.png" alt="URBAE Logo" height="90" width="110" style="margin-left: 30px;">
    </a>
    <nav class="nav-links">
        <a href="indexeng.php">Home</a>
        <a href="abouteng.php">About</a>
        <a href="shopeng.php">Shop</a>
        <a href="contacteng.php">Contact</a>
        <?php if (isset($_SESSION["id_tipos_utilizador"]) && $_SESSION["id_tipos_utilizador"] == 0): ?>
            <a href="admin.php">Painel Admin</a>
        <?php endif; ?>
    </nav>
    <div class="nav-icons">
        <form method="GET" action="shopeng.php" id="searchForm" style="display:flex; align-items:center; gap:6px;">
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
                <span style="font-weight:600;"><?= $_SESSION["utilizador"] ?></span>
                <button type="submit" name="botaoLogout" value="1" style="background:none; border:none; cursor:pointer; padding: 0; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        <?php endif; ?>

        <a href="#" class="icon-badge lang-btn" id="openLangModal" title="Idioma">
            <img src="https://flagcdn.com/w20/us.png" alt="eng">
        </a>
    </div>
</header>
<hr>

<!-- FOTO DE CAPA -->
<div class="perfil-capa-wrapper">
    <img src="uploads_capa/<?= htmlspecialchars($dados['foto_capa'] ?? 'default_capa.jpg') ?>" 
         alt="Capa" class="perfil-capa" id="previewCapa">
    <form action="atualizar_perfileng.php" method="POST" enctype="multipart/form-data" id="formCapa">
        <input type="file" name="foto_capa" id="inputCapa" accept="image/*">
        <label for="inputCapa" class="btn-editar-capa">
            <i class="fas fa-camera"></i> Edit Profile Cover
        </label>
    </form>
</div>

<!-- INFO DO PERFIL -->
<!-- INFO DO PERFIL -->
        <div class="perfil-info-section">
            <div class="perfil-info-inner">

                <!-- FOTO DE PERFIL -->
                <form action="atualizar_perfileng.php" method="POST" enctype="multipart/form-data" id="formFoto">
                    <input type="file" name="foto_perfil" id="inputFoto" accept="image/*">
                    <div class="foto-perfil-wrapper">
                        <img src="uploads_perfil/<?= htmlspecialchars($dados['foto_perfil'] ?? 'default_avatar.png') ?>" 
                             alt="Foto de Perfil" class="foto-perfil" id="previewFoto">
                        <label for="inputFoto" class="btn-foto-perfil">
                            <i class="fas fa-camera"></i>
                        </label>
                    </div>
                </form>

                <div class="perfil-nome-area">
                    <div>
                        <div class="perfil-nome"><?= htmlspecialchars($dados['utilizador']) ?></div>
                        <div class="perfil-email"><?= htmlspecialchars($dados['email']) ?></div>
                        <?php if (!empty($dados['descricao'])): ?>
                            <div class="perfil-descricao-text"><?= htmlspecialchars($dados['descricao']) ?></div>
                        <?php endif; ?>
                    
                    <!-- O BLOCO ENTRA DIRETAMENTE AQUI: -->
                    <div class="perfil-meta">
                        <?php if (!empty($dados['idade'])): ?>
                            <span><i class="fas fa-birthday-cake"></i> <?= $dados['idade'] ?> Age</span>
                        <?php endif; ?>
                        
                        <?php if (!empty($genero_em_ingles)): ?>
                            <span><i class="fas fa-venus-mars"></i> <?= htmlspecialchars($genero_em_ingles) ?></span>
                        <?php endif; ?>
                        
                        <span><i class="fas fa-calendar"></i> Member since <?= date('Y') ?></span>
                    </div>
                    
                    <div class="perfil-stats">
                        <div class="stat-item">
                            <div class="stat-num"><?= $total_encomendas ?></div>
                            <div class="stat-label">Orders</div>
                        </div>
                    </div>
                </div>


        <!-- TABS -->
        <div class="perfil-tabs">
            <button class="tab-btn ativo" onclick="mudarTab('publicacoes')">
                <i class="fas fa-user"></i> Profile
            </button>
            <button class="tab-btn" onclick="mudarTab('encomendas')">
                <i class="fas fa-box"></i> Orders
            </button>
            <button class="tab-btn" onclick="mudarTab('definicoes')">
                <i class="fas fa-cog"></i> Settings
            </button>
        </div>
    </div>
</div>

<!-- CONTEÚDO DAS TABS -->
<div class="perfil-content">

    <!-- TAB: PERFIL -->
    <div id="tab-publicacoes" class="tab-content ativo" style="grid-column: span 2;">
        <div style="display:grid; grid-template-columns: 1fr 340px; gap:20px;">
            <div>
                <div class="card">
                    <div class="card-titulo">About Me</div>
                    <form action="atualizar_perfileng.php" method="POST">
                        <input type="hidden" name="acao" value="dados">
                            <div class="form-grupo">
                                <label>Profile Name</label>
                                <input type="text" name="utilizador_novo" value="<?= htmlspecialchars($dados['utilizador']) ?>">
                            </div>
                            <div class="form-grupo">
                                <label>Email</label>
                                <input type="email" value="<?= htmlspecialchars($dados['email']) ?>" disabled>
                            </div>
                        <div class="form-grupo">
                            <label>Bio</label>
                            <textarea name="descricao" placeholder="Write something about yourself..."><?= htmlspecialchars($dados['descricao'] ?? '') ?></textarea>
                        </div>
                        <div class="form-grupo">
                            <label>Shipping Address</label>
                            <input type="text" name="morada" value="<?= htmlspecialchars($dados['Adress'] ?? '') ?>" placeholder="Street, House Number, Postal Code, Locality">
                            </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                            <div class="form-grupo">
                                <label>Age</label>
                                <input type="number" name="idade" min="1" max="120" value="<?= $dados['idade'] ?? '' ?>" placeholder="Ex: 25">
                            </div>
                            <div class="form-grupo">
                                <label>Gender</label>
                                <select name="genero">
                                    <option value="">I prefer not to say</option>
                                    <option value="Masculino" <?= ($dados['genero'] ?? '') == 'Masculino' ? 'selected' : '' ?>>Male</option>
                                    <option value="Feminino" <?= ($dados['genero'] ?? '') == 'Feminino' ? 'selected' : '' ?>>Female</option>
                                    <option value="Não-binário" <?= ($dados['genero'] ?? '') == 'Não-binário' ? 'selected' : '' ?>>Non-binary</option>
                                    <option value="Outro" <?= ($dados['genero'] ?? '') == 'Outro' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn-guardar">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- SIDEBAR DIREITA -->
            <div>
                <div class="card">
                    <div class="card-titulo">Information</div>
                    <div class="info-item"><i class="fas fa-user"></i> <?= htmlspecialchars($dados['utilizador']) ?></div>
                    <div class="info-item"><i class="fas fa-envelope"></i> <?= htmlspecialchars($dados['email']) ?></div>
                    <div class="info-item"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($dados['morada'] ?? 'No saved addresses') ?></div>
                    <?php if (!empty($dados['idade'])): ?>
                    <div class="info-item"><i class="fas fa-birthday-cake"></i> <?= $dados['idade'] ?> years old</div>
                    <?php endif; ?>

<?php if (!empty($genero_em_ingles)): ?>
        <div class="info-item"><i class="fas fa-venus-mars"></i> <?= htmlspecialchars($genero_em_ingles) ?></div>
    <?php endif; ?>
    
    <div class="info-item"><i class="fas fa-box"></i> <?= $total_encomendas ?> order(s)</div>
                </div>

                <div class="card">
                    <div class="card-titulo">Account</div>
                    <form action="logout.php" method="POST">
                        <button type="submit" name="botaoLogout" value="1" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i> End Session
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: ENCOMENDAS -->
    <!-- TAB: ENCOMENDAS -->
<div id="tab-encomendas" class="tab-content" style="grid-column: span 2;">
    <div class="card">
        <div class="card-titulo">Order History</div>
        <?php
        mysqli_data_seek($res_enc, 0);
        if ($total_encomendas == 0):
        ?>
            <div class="sem-items">
                <i class="fas fa-box-open"></i>
                You haven't placed any orders yet..
            </div>
        <?php else: ?>
            <?php while ($enc = mysqli_fetch_assoc($res_enc)): ?>
            <div style="border:1px solid #eee; border-radius:8px; margin-bottom:20px; overflow:hidden;">
                
                <!-- CABEÇALHO DA ENCOMENDA -->
                <div style="background:#f9f9f9; padding:15px 20px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #eee;">
                    <div>
                        <div style="font-weight:700; font-size:14px; color:#000;">URB-<?= str_pad($enc['id'], 6, '0', STR_PAD_LEFT) ?></div>
                        <div style="font-size:11px; color:#bbb; margin-top:3px;"><?= date('d/m/Y', strtotime($enc['datahora'])) ?></div>
                    </div>
                    <span class="badge-pago">Paid</span>
                    <div style="font-weight:700; font-size:16px; color:#000;"><?= number_format($enc['preco_total_carrinho'], 2, ',', '.') ?> €</div>
                </div>

                <!-- PRODUTOS DA ENCOMENDA -->
                <?php
                $sql_prod = "SELECT quantidade, preco_total, designacao, imagem, preco_unit
                            FROM historico_itens
                            WHERE carrinho_id = " . $enc['id'];
                $res_prod = mysqli_query($conexao, $sql_prod);
                ?>
                <div style="padding:15px 20px;">
                    <?php while ($prod = mysqli_fetch_assoc($res_prod)): ?>
                    <div style="display:flex; align-items:center; gap:15px; padding:10px 0; border-bottom:1px solid #f5f5f5;">
                        <?php if (!empty($prod['imagem'])): ?>
                            <img src="<?= htmlspecialchars($prod['imagem']) ?>" alt="<?= htmlspecialchars($prod['designacao']) ?>" 
                                style="width:60px; height:60px; object-fit:cover; border:1px solid #eee;">
                        <?php else: ?>
                            <div style="width:60px; height:60px; background:#f5f5f5; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-tshirt" style="color:#ccc; font-size:20px;"></i>
                            </div>
                        <?php endif; ?>
                        <div style="flex:1;">
                            <div style="font-size:13px; font-weight:600; color:#000;"><?= htmlspecialchars($prod['designacao']) ?></div>
                            <div style="font-size:12px; color:#999; margin-top:3px;">Qtd: <?= $prod['quantidade'] ?></div>
                        </div>
                        <div style="font-size:13px; font-weight:700; color:#000;"><?= number_format($prod['preco_total'], 2, ',', '.') ?> €</div>
                    </div>
                    <?php endwhile; ?>
                </div>

            </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>
    <!-- TAB: DEFINIÇÕES -->
    <div id="tab-definicoes" class="tab-content" style="grid-column: span 2;">
        <div class="card">
            <div class="card-titulo">Change Password</div>
            <form action="atualizar_perfileng.php" method="POST">
                <input type="hidden" name="acao" value="password">
                <div class="form-grupo">
                    <label>Current Password</label>
                    <input type="password" name="password_atual" placeholder="Enter current password">
                </div>
                <div class="form-grupo">
                    <label>New Password</label>
                    <input type="password" name="password_nova" placeholder="New password">
                </div>
                <div class="form-grupo">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmar" placeholder="Repeat new password">
                </div>
                <button type="submit" class="btn-guardar">Change Password</button>
            </form>
        </div>
    </div>

</div>

<!-- MODAL IDIOMAS -->
<div id="langModal" class="modal-overlay" style="display:none;">
    <div class="modal-box" style="max-width:300px; text-align:center;">
        <span class="modal-close" id="closeLangModal">&times;</span>
        <h2>Escolher Idioma</h2>
        <div style="margin-top:20px; display:flex; justify-content:space-around;">
            <a href="perfil.php" class="lang-choice">
                <img src="https://flagcdn.com/w40/pt.png" alt="Português"><p>Português</p>
            </a>
            <a href="perfileng.php" class="lang-choice">
                <img src="https://flagcdn.com/w40/us.png" alt="English"><p>English</p>
            </a>
        </div>
    </div>
</div>

<script>
// TABS
function mudarTab(tab) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('ativo'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('ativo'));
    document.getElementById('tab-' + tab).classList.add('ativo');
    event.target.classList.add('ativo');
}

let cropper = null;
let tipoRecorte = null;

// FOTO DE PERFIL
document.getElementById('inputFoto').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    tipoRecorte = 'perfil';
    document.getElementById('tituloRecorte').textContent = 'Recortar Foto de Perfil';
    abrirRecorte(file);
});

// FOTO DE CAPA
document.getElementById('inputCapa').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    tipoRecorte = 'capa';
    document.getElementById('tituloRecorte').textContent = 'Recortar Foto de Capa';
    abrirRecorte(file);
});

function abrirRecorte(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('imagemRecorte');
        img.src = e.target.result;
        document.getElementById('modalRecorte').style.display = 'flex';

        if (cropper) cropper.destroy();

        cropper = new Cropper(img, {
            aspectRatio: tipoRecorte === 'perfil' ? 1 : 16/4,
            viewMode: 1,
            movable: true,
            zoomable: true,
            rotatable: false,
            scalable: false,
        });
    };
    reader.readAsDataURL(file);
}

function cancelarRecorte() {
    document.getElementById('modalRecorte').style.display = 'none';
    if (cropper) { cropper.destroy(); cropper = null; }
    document.getElementById('inputFoto').value = '';
    document.getElementById('inputCapa').value = '';
}

function confirmarRecorte() {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
        width: tipoRecorte === 'perfil' ? 300 : 1200,
        height: tipoRecorte === 'perfil' ? 300 : 300,
    });

    canvas.toBlob(function(blob) {
        const formData = new FormData();
        const campo = tipoRecorte === 'perfil' ? 'foto_perfil' : 'foto_capa';
        formData.append(campo, blob, campo + '.jpg');

        fetch('atualizar_perfil.php', {
            method: 'POST',
            body: formData
        }).then(() => {
            const preview = tipoRecorte === 'perfil' ? 'previewFoto' : 'previewCapa';
            document.getElementById(preview).src = canvas.toDataURL();
            document.getElementById('modalRecorte').style.display = 'none';
            if (cropper) { cropper.destroy(); cropper = null; }
        });
    }, 'image/jpeg', 0.9);
}

// MODAL IDIOMAS
document.addEventListener("DOMContentLoaded", () => {
    const langModal = document.getElementById("langModal");
    document.getElementById("openLangModal")?.addEventListener("click", e => {
        e.preventDefault(); langModal.style.display = "flex";
    });
    document.getElementById("closeLangModal")?.addEventListener("click", () => {
        langModal.style.display = "none";
    });
    window.addEventListener("click", e => {
        if (e.target === langModal) langModal.style.display = "none";
    });
});

<?php if (isset($_GET['sucesso'])): ?>
Swal.fire({ 
    icon: 'success', 
    title: 'Atualizado!', 
    text: '<?= $_GET['sucesso'] ?>', 
    confirmButtonColor: '#000', 
    timer: 2000, 
    showConfirmButton: false 
}).then(() => {
    window.history.replaceState({}, document.title, 'perfileng.php');
});
<?php endif; ?>

<?php if (isset($_GET['erro'])): ?>
Swal.fire({ icon: 'error', title: 'Erro', text: '<?= $_GET['erro'] ?>', confirmButtonColor: '#000' });
<?php endif; ?>
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
}

.search-input.active {
    width: 200px;
    opacity: 1;
    padding: 5px 12px;
    border: 1px solid #ddd;
    margin-right: 5px;
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

       
<!-- MODAL DE RECORTE -->
<div id="modalRecorte" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); z-index:999999; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:12px; padding:25px; max-width:600px; width:90%; max-height:90vh; overflow:auto;">
        <h3 id="tituloRecorte" style="margin:0 0 15px; font-family:'Poppins',sans-serif; font-size:16px;">Recortar Imagem</h3>
        <div style="max-height:400px; overflow:hidden;">
            <img id="imagemRecorte" style="max-width:100%; display:block;">
        </div>
        <div style="display:flex; gap:10px; margin-top:20px; justify-content:flex-end;">
            <button onclick="cancelarRecorte()" style="padding:10px 20px; border:1px solid #ddd; background:#fff; cursor:pointer; font-family:'Poppins',sans-serif; font-size:13px; border-radius:6px;">Cancelar</button>
            <button onclick="confirmarRecorte()" style="padding:10px 20px; background:#000; color:#fff; border:none; cursor:pointer; font-family:'Poppins',sans-serif; font-size:13px; font-weight:600; border-radius:6px;">Confirmar Recorte</button>
        </div>
    </div>
</div>

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
                        <li><a href="#">Luxury Accessories</a></li>
                        <li><a href="#">Sports Clothing</a></li>
                        <li><a href="#">Men's Shoes</a></li>
                        <li><a href="#">Women's Shoes</a></li>
                        <li><a href="#">Popular Dresses</a></li>
                        <li><a href="#">Gym Accessories</a></li>
                        <li><a href="#">Training Shoes</a></li>
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