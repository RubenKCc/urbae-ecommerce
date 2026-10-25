<?php
session_start();
if (!isset($_SESSION["codigo_verificacao"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Verificar Email - URBÆ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .verificar-box {
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
            border: 1px solid #eee;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }
        .verificar-box h2 { margin-bottom: 10px; }
        .verificar-box p { color: #666; font-size: 14px; margin-bottom: 25px; }
        .verificar-box input {
            width: 100%;
            padding: 12px;
            font-size: 20px;
            text-align: center;
            letter-spacing: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }
        .verificar-box button {
            width: 100%;
            padding: 12px;
            background: #000;
            color: #fff;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }
        .verificar-box button:hover { background: #333; }
        .erro { color: red; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="verificar-box">
        <h2>Verificar Email</h2>
        <p>Enviámos um código de 6 dígitos para o teu email.<br>Insere-o abaixo para confirmar a tua conta.</p>

        <?php if (isset($_SESSION["erro_verificacao"])): ?>
            <div class="erro"><?= $_SESSION["erro_verificacao"] ?></div>
            <?php unset($_SESSION["erro_verificacao"]); ?>
        <?php endif; ?>

        <form method="POST" action="registar.php">
            <input type="hidden" name="redirect" value="<?= $_SESSION['redirect_apos_verificacao'] ?? 'index.php' ?>">
            <input type="text" name="codigo" maxlength="6" placeholder="000000" required autofocus>
            <button type="submit" name="botaoVerificar" value="1">Confirmar</button>
        </form>
    </div>
</body>
</html>