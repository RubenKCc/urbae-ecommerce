<?php
session_start();
require ".ht_conexao-bd.php";



/* 📦 PHPMailer */
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* 🔎 Verificar ID */
if (!isset($_GET["id"])) {
    die("Campanha inválida.");
}

$campanha_id = intval($_GET["id"]);

/* 📩 Buscar campanha */
$sqlCampanha = "SELECT * FROM newsletter_campanhas 
                WHERE id = $campanha_id AND enviada = 0";

$resultCampanha = mysqli_query($conexao, $sqlCampanha);

if (mysqli_num_rows($resultCampanha) == 0) {
    die("Campanha não encontrada ou já enviada.");
}

$campanha = mysqli_fetch_assoc($resultCampanha);

/* 📧 Buscar emails */
$resultEmails = mysqli_query($conexao, 
    "SELECT email FROM newsletter_subscritores WHERE ativo = 1");

if (mysqli_num_rows($resultEmails) == 0) {
    die("Sem subscritores.");
}

/* 🚀 Enviar um por um */
while ($row = mysqli_fetch_assoc($resultEmails)) {

    $mail = new PHPMailer(true);

    try {
        /* 🔐 CONFIGURAÇÃO SMTP GMAIL */
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alexandre.moreira.paulino@gmail.com';  // ← MUDA AQUI
        $mail->Password   = 'qphfmiedmnegtxsg';   // ← MUDA AQUI
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        /* 📌 Melhorar entrega */
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('alexandre.moreira.paulino@gmail.com', 'URBAE');
        $mail->addAddress($row["email"]);

        $mail->isHTML(true);
        $mail->Subject = $campanha["titulo"];

$mail->Body = "
        <div style='background-color: #f6f9fc; padding: 40px 0; font-family: sans-serif;'>
            <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #e1e4e8;'>
                
                <tr>
                    <td align='center' style='padding: 30px 0; background-color: #111111;'>
                        <h1 style='color: #ffffff; margin: 0; font-size: 28px; letter-spacing: 2px;'>URBAE</h1>
                    </td>
                </tr>

                <tr>
                    <td style='padding: 40px 30px;'>
                        <h2 style='color: #1a1a1a; font-size: 22px; margin-top: 0; font-weight: 600;'>
                            {$campanha["titulo"]}
                        </h2>
                        <p style='color: #4a4a4a; font-size: 16px; line-height: 1.8; margin-bottom: 25px;'>
                            " . nl2br($campanha["mensagem"]) . "
                        </p>
                        
                        <table border='0' cellpadding='0' cellspacing='0' style='margin-top: 20px;'>
                            <tr>
                                <td align='center' bgcolor='#111111' style='border-radius: 4px;'>
                                    <a href='http://localhost/PAP3%20minha/index.php' target='_blank' style='padding: 12px 25px; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: bold; display: inline-block;'>
                                        VISITAR A LOJA
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td align='center' style='padding: 25px 30px; background-color: #f8f9fa; border-top: 1px solid #eeeeee;'>
                        <p style='color: #888888; font-size: 12px; margin: 0;'>
                            &copy; " . date('Y') . " URBAE - Todos os direitos reservados.
                        </p>
                        <p style='color: #888888; font-size: 12px; margin: 8px 0 0;'>
                            Está a receber este email porque subscreveu a nossa newsletter.
                        </p>
                        <p style='margin: 12px 0 0;'>
                            <a href='http://localhost/PAP3%20minha/remover-subscricao.php?email=" . urlencode($row["email"]) . "' style='color: #d9534f; font-size: 11px; text-decoration: underline;'>
                                Não quero receber mais emails (Remover subscrição)
                            </a>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        ";
    //$mail->SMTPDebug = 2;
        $mail->send();

    } catch (Exception $e) {
        echo "Erro ao enviar para " . $row["email"] . "<br>";
    }
}

/* ✅ Marcar como enviada */
mysqli_query($conexao, 
    "UPDATE newsletter_campanhas SET enviada = 1 WHERE id = $campanha_id");

header("Location: editar-utilizadores.php?sucesso=1");
exit();?>
<?php if (isset($_GET["sucesso"])): ?>
    <p style="color:lightgreen;">
        Campanha enviada com sucesso!
    </p>
<?php endif; ?>