<?php
session_start();
if (!isset($_SESSION["utilizador"])) {
    header("Location: index.php");
    exit();
}

require ".ht_conexao-bd.php";

$user = $_SESSION["utilizador"];
$sql = "SELECT * FROM utilizadores WHERE utilizador = '$user'";
$res = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_assoc($res);
$id = $dados['id_utilizadores'];

// ─────────────────────────────────────────
// AÇÃO: FOTO DE PERFIL
// ─────────────────────────────────────────
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === 0) {
    $file = $_FILES['foto_perfil'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $permitidos)) {
        header("Location: perfil.php?erro=Formato+de+imagem+inválido");
        exit();
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        header("Location: perfil.php?erro=A+imagem+não+pode+ter+mais+de+2MB");
        exit();
    }

    $nome_ficheiro = 'perfil_' . $id . '.' . $ext;
    $destino = 'uploads_perfil/' . $nome_ficheiro;

    if (move_uploaded_file($file['tmp_name'], $destino)) {
        mysqli_query($conexao, "UPDATE utilizadores SET foto_perfil = '$nome_ficheiro' WHERE id_utilizadores = $id");
        header("Location: perfil.php?sucesso=Foto+de+perfil+atualizada");
        exit();
    } else {
        header("Location: perfil.php?erro=Erro+ao+guardar+a+imagem");
        exit();
    }
}

// ─────────────────────────────────────────
// AÇÃO: FOTO DE CAPA
// ─────────────────────────────────────────
if (isset($_FILES['foto_capa']) && $_FILES['foto_capa']['error'] === 0) {
    $file = $_FILES['foto_capa'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $permitidos)) {
        header("Location: perfil.php?erro=Formato+de+imagem+inválido");
        exit();
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        header("Location: perfil.php?erro=A+capa+não+pode+ter+mais+de+5MB");
        exit();
    }

    $nome_ficheiro = 'capa_' . $id . '.' . $ext;
    $destino = 'uploads_capa/' . $nome_ficheiro;

    if (move_uploaded_file($file['tmp_name'], $destino)) {
        mysqli_query($conexao, "UPDATE utilizadores SET foto_capa = '$nome_ficheiro' WHERE id_utilizadores = $id");
        header("Location: perfil.php?sucesso=Foto+de+capa+atualizada");
        exit();
    } else {
        header("Location: perfil.php?erro=Erro+ao+guardar+a+capa");
        exit();
    }
}

// ─────────────────────────────────────────
// AÇÃO: DADOS PESSOAIS
// ─────────────────────────────────────────
// ─────────────────────────────────────────
// AÇÃO: DADOS PESSOAIS
// ─────────────────────────────────────────
if (isset($_POST['acao']) && $_POST['acao'] === 'dados') {
    $utilizador_novo = mysqli_real_escape_string($conexao, trim($_POST['utilizador_novo'] ?? $dados['utilizador']));
    $descricao       = mysqli_real_escape_string($conexao, trim($_POST['descricao'] ?? ''));
    $morada          = mysqli_real_escape_string($conexao, $_POST['morada']); // Já tinhas isto aqui! 👍
    $idade           = isset($_POST['idade']) && $_POST['idade'] !== '' ? intval($_POST['idade']) : 'NULL';
    $genero          = mysqli_real_escape_string($conexao, trim($_POST['genero'] ?? ''));

    if (empty($utilizador_novo)) {
        header("Location: perfil.php?erro=O+nome+de+utilizador+não+pode+estar+vazio");
        exit();
    }

    // Verificar se nome já existe noutro utilizador
    $check = mysqli_query($conexao, "SELECT id_utilizadores FROM utilizadores WHERE utilizador = '$utilizador_novo' AND id_utilizadores != $id");
    if (mysqli_num_rows($check) > 0) {
        header("Location: perfil.php?erro=Este+nome+de+utilizador+já+está+em+uso");
        exit();
    }

    $idade_sql = ($idade === 'NULL') ? 'NULL' : $idade;

    // A QUERY ATUALIZADA COM A MORADA FICA ASSIM:
    mysqli_query($conexao, "UPDATE utilizadores SET 
        utilizador = '$utilizador_novo',
        descricao = '$descricao',
        idade = $idade_sql,
        genero = '$genero',
        morada = '$morada'
        WHERE id_utilizadores = $id");

    // Atualizar sessão com novo nome
    $_SESSION["utilizador"] = $utilizador_novo;

    header("Location: perfil.php?sucesso=Perfil+atualizado+com+sucesso");
    exit();
}

// ─────────────────────────────────────────
// AÇÃO: ALTERAR PASSWORD
// ─────────────────────────────────────────
if (isset($_POST['acao']) && $_POST['acao'] === 'password') {
    $password_atual     = $_POST['password_atual'];
    $password_nova      = $_POST['password_nova'];
    $password_confirmar = $_POST['password_confirmar'];

    if (md5($password_atual) !== $dados['password']) {
        header("Location: perfil.php?erro=Password+atual+incorreta");
        exit();
    }

    if (strlen($password_nova) < 6) {
        header("Location: perfil.php?erro=A+nova+password+deve+ter+pelo+menos+6+caracteres");
        exit();
    }

    if ($password_nova !== $password_confirmar) {
        header("Location: perfil.php?erro=As+passwords+não+coincidem");
        exit();
    }

    $nova_hash = md5($password_nova);
    mysqli_query($conexao, "UPDATE utilizadores SET password = '$nova_hash' WHERE id_utilizadores = $id");
    header("Location: perfil.php?sucesso=Password+alterada+com+sucesso");
    exit();
}

header("Location: perfil.php");
exit();
?>