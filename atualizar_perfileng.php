<?php
session_start();
if (!isset($_SESSION["utilizador"])) {
    header("Location: indexeng.php");
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
        header("Location: perfileng.php?erro=Invalid+format+of+image");
        exit();
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        header("Location: perfileng.php?erro=Image+size+exceeds+2MB+limit");
        exit();
    }

    $nome_ficheiro = 'perfil_' . $id . '.' . $ext;
    $destino = 'uploads_perfil/' . $nome_ficheiro;

    if (move_uploaded_file($file['tmp_name'], $destino)) {
        mysqli_query($conexao, "UPDATE utilizadores SET foto_perfil = '$nome_ficheiro' WHERE id_utilizadores = $id");
        header("Location: perfileng.php?sucesso=Foto+de+perfil+atualizada");
        exit();
    } else {
        header("Location: perfileng.php?erro=Erro+ao+guardar+a+imagem");
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
        header("Location: perfileng.php?error=Invalid+format+of+image");
        exit();
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        header("Location: perfileng.php?erro=Image+size+exceeds+5MB+limit");
        exit();
    }

    $nome_ficheiro = 'capa_' . $id . '.' . $ext;
    $destino = 'uploads_capa/' . $nome_ficheiro;

    if (move_uploaded_file($file['tmp_name'], $destino)) {
        mysqli_query($conexao, "UPDATE utilizadores SET foto_capa = '$nome_ficheiro' WHERE id_utilizadores = $id");
        header("Location: perfileng.php?sucesso=Updated+cover+successfully");
        exit();
    } else {
        header("Location: perfileng.php?erro=Error+while+saving+the+cover");
        exit();
    }
}

// ─────────────────────────────────────────
// AÇÃO: DADOS PESSOAIS
// ─────────────────────────────────────────
// ─────────────────────────────────────────
// AÇÃO: DADOS PESSOAIS
// ─────────────────────────────────────────
// ─────────────────────────────────────────
// AÇÃO: DADOS PESSOAIS
// ─────────────────────────────────────────
if (isset($_POST['acao']) && $_POST['acao'] === 'dados') {
    $utilizador_novo = mysqli_real_escape_string($conexao, trim($_POST['utilizador_novo'] ?? $dados['utilizador']));
    $descricao       = mysqli_real_escape_string($conexao, trim($_POST['descricao'] ?? ''));
    $morada          = mysqli_real_escape_string($conexao, $_POST['morada']); 
    $idade           = isset($_POST['idade']) && $_POST['idade'] !== '' ? intval($_POST['idade']) : 'NULL';
    $genero          = mysqli_real_escape_string($conexao, trim($_POST['genero'] ?? ''));

    if (empty($utilizador_novo)) {
        // CORRIGIDO: perfileng.php + Mensagem em Inglês
        header("Location: perfileng.php?erro=Username+cannot+be+empty");
        exit();
    }

    // Verificar se nome já existe noutro utilizador
    $check = mysqli_query($conexao, "SELECT id_utilizadores FROM utilizadores WHERE utilizador = '$utilizador_novo' AND id_utilizadores != $id");
    if (mysqli_num_rows($check) > 0) {
        // CORRIGIDO: perfileng.php + Mensagem em Inglês
        header("Location: perfileng.php?erro=This+username+is+already+taken");
        exit();
    }

    $idade_sql = ($idade === 'NULL') ? 'NULL' : $idade;

    mysqli_query($conexao, "UPDATE utilizadores SET 
        utilizador = '$utilizador_novo',
        descricao = '$descricao',
        idade = $idade_sql,
        genero = '$genero',
        morada = '$morada'
        WHERE id_utilizadores = $id");

    // Atualizar sessão com novo nome
    $_SESSION["utilizador"] = $utilizador_novo;

    // CORRIGIDO: perfileng.php + Mensagem em Inglês
    header("Location: perfileng.php?sucesso=Profile+updated+successfully");
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
        header("Location: perfileng.php?error=Incorrect+current+password");
        exit();
    }

    if (strlen($password_nova) < 6) {
        header("Location: perfileng.php?error=New+password+must+be+at+least+6+characters");
        exit();
    }

    if ($password_nova !== $password_confirmar) {
        header("Location: perfileng.php?error=Passwords+do+not+match");
        exit();
    }

    $nova_hash = md5($password_nova);
    mysqli_query($conexao, "UPDATE utilizadores SET password = '$nova_hash' WHERE id_utilizadores = $id");
    header("Location: perfileng.php?sucesso=Password+changed+successfully");
    exit();
}

header("Location: perfileng.php");
exit();
?>