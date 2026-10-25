<?php
session_start();
require ".ht_conexao-bd.php";

$token = $_GET['token'] ?? '';

if (empty($token)) {
    header("Location: index.php");
    exit();
}

// Verificar se o token é válido e não expirou
$token_safe = mysqli_real_escape_string($conexao, $token);
$sql = "SELECT id_utilizadores FROM utilizadores WHERE reset_token = '$token_safe' AND reset_token_expira > " . time();
$res = mysqli_query($conexao, $sql);

if (mysqli_num_rows($res) == 0) {
    $_SESSION["erro_recuperar"] = "Link inválido ou expirado. Tenta novamente.";
    header("Location: recuperar_password.php");
    exit();
}

// Processar nova password
if (isset($_POST["botaoRedefinir"])) {
    $nova_password   = $_POST["nova_password"];
    $confirmar       = $_POST["confirmar_password"];

    if ($nova_password !== $confirmar) {
        $erro = "As passwords não coincidem.";
    } elseif (strlen($nova_password) < 6) {
        $erro = "A password deve ter pelo menos 6 caracteres.";
    } else {
        $sql = "UPDATE utilizadores SET password = PASSWORD('$nova_password'), reset_token = NULL, reset_token_expira = NULL WHERE reset_token = '$token_safe'";
        if (mysqli_query($conexao, $sql)) {
            $_SESSION["sucesso"] = "Password redefinida com sucesso! Já podes iniciar sessão.";
            header("Location: index.php");
            exit();
        } else {
            $erro = "Erro ao redefinir a password. Tenta novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Password — URBÆ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .redefinir-box {
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
            border: 1px solid #eee;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }
        .redefinir-box h2 { margin-bottom: 10px; }
        .redefinir-box p { color: #666; font-size: 14px; margin-bottom: 25px; }
        .redefinir-box input {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        .redefinir-box button {
            width: 100%;
            padding: 12px;
            background: #000;
            color: #fff;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }
        .redefinir-box button:hover { background: #333; }
        .erro { color: red; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="redefinir-box">
        <h2>Nova Password</h2>
        <p>Define a tua nova password para a conta URBÆ.</p>

        <?php if (isset($erro)): ?>
            <div class="erro"><?= $erro ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <input type="password" name="nova_password" placeholder="Nova password" required>
            <input type="password" name="confirmar_password" placeholder="Confirmar password" required>
            <button type="submit" name="botaoRedefinir" value="1">Redefinir Password</button>
        </form>
    </div>
</body>
</html>