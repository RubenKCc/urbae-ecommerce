<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Recover Password — URBÆ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .recuperar-box {
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
            border: 1px solid #eee;
            text-align: center;
            font-family: 'Poppins', sans-serif;
        }
        .recuperar-box h2 { margin-bottom: 10px; }
        .recuperar-box p { color: #666; font-size: 14px; margin-bottom: 25px; }
        .recuperar-box input {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        .recuperar-box button {
            width: 100%;
            padding: 12px;
            background: #000;
            color: #fff;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }
        .recuperar-box button:hover { background: #333; }
        .erro { color: red; font-size: 13px; margin-bottom: 15px; }
        .sucesso { color: green; font-size: 13px; margin-bottom: 15px; }
        .voltar { display: block; margin-top: 15px; font-size: 13px; color: #666; text-decoration: none; }
        .voltar:hover { color: #000; }
    </style>
</head>
<body>
    <div class="recuperar-box">
        <h2>Recover Password</h2>
        <p>Enter your email and we will send you a link to reset your password.</p>

        <?php if (isset($_SESSION["erro_recuperar"])): ?>
            <div class="erro"><?= $_SESSION["erro_recuperar"] ?></div>
            <?php unset($_SESSION["erro_recuperar"]); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION["sucesso_recuperar"])): ?>
            <div class="sucesso"><?= $_SESSION["sucesso_recuperar"] ?></div>
            <?php unset($_SESSION["sucesso_recuperar"]); ?>
        <?php endif; ?>

        <form method="POST" action="processar_recuperareng.php">
            <input type="email" name="email" placeholder="Your email" required>
            <button type="submit">Send Link</button>
        </form>

        <a href="indexeng.php" class="voltar">← Back to Home</a>
    </div>
</body>
</html>