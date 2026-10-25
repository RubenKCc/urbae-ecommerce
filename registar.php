<?php
session_start();
require ".ht_conexao-bd.php";

if (!isset($_POST["botaoRegistar"]) && !isset($_POST["botaoVerificar"])) {
    header("Location: index.php");
    exit();
}

$voltar = $_POST['redirect'] ?? 'index.php';

/* ======================================================
   ETAPA 2 — VERIFICAR CÓDIGO
   ====================================================== */
if (isset($_POST["botaoVerificar"])) {
    $codigo_inserido = trim($_POST["codigo"]);

    if (!isset($_SESSION["codigo_verificacao"]) || !isset($_SESSION["registo_pendente"])) {
        $_SESSION["erro_registo"] = "Sessão expirada. Tente registar novamente.";
        header("Location: $voltar");
        exit();
    }

    if (time() > $_SESSION["codigo_expira"]) {
        unset($_SESSION["codigo_verificacao"]);
        unset($_SESSION["codigo_expira"]);
        unset($_SESSION["registo_pendente"]);
        $_SESSION["erro_registo"] = "O código expirou. Tenta registar novamente.";
        header("Location: " . ($_SESSION["redirect_apos_verificacao"] ?? "index.php"));
        exit();
    }

    if ($codigo_inserido !== (string)$_SESSION["codigo_verificacao"]) {
        $_SESSION["erro_verificacao"] = "Código incorreto. Tente novamente.";
        header("Location: verificar_codigo.php");
        exit();
    }

    $dados = $_SESSION["registo_pendente"];
    $utilizador = $dados["utilizador"];
    $email      = $dados["email"];
    $password   = $dados["password"];

    $sql = "INSERT INTO utilizadores 
            (utilizador, email, password, id_estado, tipos_utilizador_id_tipos_utilizador, estado_conta)
            VALUES 
            ('$utilizador', '$email', PASSWORD('$password'), 1, 1, 1)";

    if (mysqli_query($conexao, $sql)) {
        unset($_SESSION["codigo_verificacao"]);
        unset($_SESSION["registo_pendente"]);
        $_SESSION["sucesso"] = "Conta criada com sucesso! Já pode iniciar sessão.";
        header("Location: $voltar");
    } else {
        $_SESSION["erro_registo"] = "Erro ao criar conta.";
        header("Location: $voltar");
    }
    exit();
}

/* ======================================================
   ETAPA 1 — VALIDAR E ENVIAR CÓDIGO
   ====================================================== */
$utilizador = mysqli_real_escape_string($conexao, $_POST["utilizador"]);
$email      = mysqli_real_escape_string($conexao, $_POST["email"]);
$password   = $_POST["password"];


// Validação de password
if (strlen($password) < 8) {
    $_SESSION["erro_registo"] = "A password deve ter pelo menos 8 caracteres.";
    header("Location: $voltar");
    exit();
}
if (!preg_match('/[A-Z]/', $password)) {
    $_SESSION["erro_registo"] = "A password deve ter pelo menos uma letra maiúscula.";
    header("Location: $voltar");
    exit();
}
if (!preg_match('/[0-9]/', $password)) {
    $_SESSION["erro_registo"] = "A password deve ter pelo menos um número.";
    header("Location: $voltar");
    exit();
}
if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
    $_SESSION["erro_registo"] = "A password deve ter pelo menos um caractere especial (!@#$%...).";
    header("Location: $voltar");
    exit();
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["erro_registo"] = "O email inserido não é válido.";
    header("Location: $voltar");
    exit();
}

$sql = "SELECT id_utilizadores FROM utilizadores WHERE utilizador = '$utilizador'";
if (mysqli_num_rows(mysqli_query($conexao, $sql)) > 0) {
    $_SESSION["erro_registo"] = "O utilizador já existe.";
    header("Location: $voltar");
    exit();
}

$sql = "SELECT id_utilizadores FROM utilizadores WHERE email = '$email'";
if (mysqli_num_rows(mysqli_query($conexao, $sql)) > 0) {
    $_SESSION["erro_registo"] = "Este email já está a ser utilizado.";
    header("Location: $voltar");
    exit();
}

$codigo = rand(100000, 999999);
$_SESSION["codigo_verificacao"] = $codigo;
$_SESSION["codigo_expira"] = time() + 600;
$_SESSION["registo_pendente"] = [
    "utilizador" => $utilizador,
    "email"      => $email,
    "password"   => $password
];
$_SESSION["redirect_apos_verificacao"] = $voltar;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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
    $mail->Subject = 'Código de Verificação — URBÆ';
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
                            <h2 style='color:#000000; font-size:20px; margin:0 0 15px 0;'>Código de Verificação</h2>
                            <p style='color:#555555; font-size:15px; line-height:1.6; margin:0 0 30px 0;'>
                                Recebemos um pedido de criação de conta no site <strong>URBÆ</strong>.<br>
                                Usa o código abaixo para confirmar que és tu.
                            </p>
                            <div style='background-color:#f4f4f4; border-left: 4px solid #000000; padding: 20px 30px; text-align:center; margin-bottom:30px;'>
                                <p style='margin:0 0 8px 0; color:#888; font-size:13px; text-transform:uppercase; letter-spacing:2px;'>O teu código é</p>
                                <p style='margin:0; font-size:36px; font-weight:bold; color:#000000; letter-spacing:10px;'>$codigo</p>
                            </div>
                            <p style='color:#888888; font-size:13px; line-height:1.6; margin:0;'>
                                Este código expira em <strong>10 minutos</strong>.<br>
                                Se não pediste a criação de conta, podes ignorar este email.
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
    $mail->AltBody = "Código de verificação URBÆ: $codigo\n\nEste código expira em 10 minutos.";

    $mail->send();
    header("Location: verificar_codigo.php");
    exit();

} catch (Exception $e) {
    $_SESSION["erro_registo"] = "Erro PHPMailer: " . $mail->ErrorInfo;
    header("Location: $voltar");
    exit();
}
?>