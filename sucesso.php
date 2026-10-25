<?php
session_start();
require ".ht_conexao-bd.php";

$carrinho_id = intval($_GET['carrinho_id']);
$res = mysqli_query($conexao, "SELECT preco_total_carrinho FROM carrinho WHERE id = $carrinho_id");
$carrinho = mysqli_fetch_assoc($res);
$total = $carrinho ? number_format($carrinho['preco_total_carrinho'], 2, ',', '.') : '0,00';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Pagamento Multibanco - URBÆ</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f9f9f9; }

        .pagamento-box {
            max-width: 480px;
            margin: 60px auto;
            padding: 40px;
            border: 1px solid #eee;
            text-align: center;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }

        .mb-logo { width: 100px; margin-bottom: 20px; }

        .pagamento-box h3 {
            font-size: 20px;
            font-weight: 600;
            color: #000;
            margin-bottom: 25px;
        }

        .dados-mb {
            background: #f4f4f4;
            padding: 20px 25px;
            border-radius: 8px;
            text-align: left;
            border-left: 4px solid #00457C;
            margin-bottom: 20px;
        }

        .linha {
            margin: 12px 0;
            font-size: 16px;
            color: #333;
        }

        .encomenda-num {
            font-size: 13px;
            color: #999;
            margin-bottom: 20px;
        }

        .pagamento-box p {
            font-size: 13px;
            color: #666;
            margin-bottom: 25px;
        }

        .btn-voltar {
            display: inline-block;
            padding: 12px 30px;
            background: #000;
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: background 0.3s;
        }

        .btn-voltar:hover { background: #333; }
    </style>
</head>
<body>
    <div class="pagamento-box">
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Multibanco.svg" class="mb-logo" alt="Multibanco">

        <h3>Dados para Pagamento</h3>

        <p class="encomenda-num">Nº Encomenda: <strong>#<?= str_pad($carrinho_id, 6, "0", STR_PAD_LEFT) ?></strong></p>

        <div class="dados-mb">
            <div class="linha"><strong>Entidade:</strong> 12345</div>
            <div class="linha"><strong>Referência:</strong> <?= str_pad($carrinho_id, 9, "0", STR_PAD_LEFT) ?></div>
            <div class="linha"><strong>Montante:</strong> <?= $total ?> €</div>
        </div>

        <p>Utilize os dados acima para pagar no Multibanco ou Homebanking.<br>Tens <strong>24 horas</strong> para efetuar o pagamento.</p>

        <a href="index.php" class="btn-voltar">Voltar à Loja</a>
    </div>

    <script>
        Swal.fire({
            icon: 'success',
            title: 'Encomenda Registada!',
            text: 'Tens 24h para efetuar o pagamento por Multibanco.',
            confirmButtonColor: '#2c8c5c'
        });
    </script>
</body>
</html>