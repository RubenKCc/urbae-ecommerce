<?php
session_start();
require ".ht_conexao-bd.php";

if (!isset($_POST["email"])) {
    header("Location: recuperar_password.php");
    exit();
}

$email = mysqli_real_escape_string($conexao, $_POST["email"]);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["erro_recuperar"] = "Email inválido.";
    header("Location: recuperar_password.php");
    exit();
}

// Verificar se o email existe
$sql = "SELECT id_utilizadores FROM utilizadores WHERE email = '$email'";
$res = mysqli_query($conexao, $sql);

if (mysqli_num_rows($res) == 0) {
    // Por segurança, não revelamos se o email existe ou não
    $_SESSION["sucesso_recuperar"] = "Se o email existir, receberás um link em breve.";
    header("Location: recuperar_password.php");
    exit();
}

// Gerar token
$token = bin2hex(random_bytes(32));
$expira = time() + 3600; // 1 hora

// Guardar token na base de dados
$sql = "UPDATE utilizadores SET reset_token = '$token', reset_token_expira = $expira WHERE email = '$email'";
mysqli_query($conexao, $sql);

// Enviar email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$link = "http://localhost/PAP3%20minha/redefinir_password.php?token=$token";

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'alexandre.moreira.paulino@gmail.com';
    $mail->Password   = 'qphfmiedmnegtxsg';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('alexandre.moreira.paulino@gmail.com', 'URBÆ');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Redefinir Password — URBÆ';
    $mail->Body = "
<!DOCTYPE html>
<html>
<head><meta charset='UTF-8'></head>
<body style='margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, sans-serif;'>
    <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#f4f4f4; padding: 40px 0;'>
        <tr>
            <td align='center'>
                <table width='500' cellpadding='0' cellspacing='0' style='background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                    <tr>
                        <td style='background-color:#000000; padding: 30px; text-align:center;'>
                            <h1 style='color:#ffffff; margin:0; font-size:28px; letter-spacing:4px;'>URBÆ</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding: 40px 50px;'>
                            <h2 style='color:#000000; font-size:20px; margin:0 0 15px 0;'>Redefinir Password</h2>
                            <p style='color:#555555; font-size:15px; line-height:1.6; margin:0 0 30px 0;'>
                                Recebemos um pedido para redefinir a password da tua conta <strong>URBÆ</strong>.<br>
                                Clica no botão abaixo para definires uma nova password.
                            </p>
                            <div style='text-align:center; margin-bottom:30px;'>
                                <a href='$link' style='background-color:#000000; color:#ffffff; padding:14px 30px; text-decoration:none; font-size:14px; font-weight:bold; border-radius:4px; display:inline-block;'>
                                    Redefinir Password
                                </a>
                            </div>
                            <p style='color:#888888; font-size:13px; line-height:1.6; margin:0;'>
                                Este link expira em <strong>1 hora</strong>.<br>
                                Se não pediste a redefinição, podes ignorar este email.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style='background-color:#f9f9f9; padding: 20px 50px; text-align:center; border-top: 1px solid #eeeeee;'>
                            <p style='color:#aaaaaa; font-size:12px; margin:0;'>
                                &copy; 2024 URBÆ — Coimbra, Portugal<br>
                                <a href='mailto:urbaegeral@gmail.com' style='color:#aaaaaa;'>urbaegeral@gmail.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
";
    $mail->AltBody = "Clica neste link para redefinir a tua password: $link\n\nExpira em 1 hora.";

    $mail->send();
    $_SESSION["sucesso_recuperar"] = "Email enviado! Verifica a tua caixa de entrada.";
    header("Location: recuperar_password.php");
    exit();

} catch (Exception $e) {
    $_SESSION["erro_recuperar"] = "Erro ao enviar email: " . $mail->ErrorInfo;
    header("Location: recuperar_password.php");
    exit();
}
?>