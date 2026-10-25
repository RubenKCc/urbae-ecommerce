<?php
session_start();

// Importação das classes do PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 1. Identificar a página de origem para o redirecionamento (contact.php ou contacteng.php)
$origem = $_SERVER['HTTP_REFERER'] ?? 'index.php';

// Verifica se o pedido é POST e se o utilizador está autenticado
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_SESSION['utilizador']) || isset($_SESSION['admin']))) {
    
    // Captura o nome da sessão ou do formulário
    $nome_cliente = $_SESSION['utilizador'] ?? $_SESSION['admin'] ?? $_POST['nome'] ?? 'Cliente';
    
    // Captura o e-mail do cliente (Prioridade para o formulário para poderes responder ao Noddy!)
    $email_cliente = $_POST['email'] ?? $_SESSION['email'] ?? 'email-desconhecido@urbae.pt'; 
    
    $assunto_form = $_POST['assunto'] ?? 'Sem Assunto';
    $mensagem_corpo = nl2br($_POST['mensagem'] ?? '');

    $mail = new PHPMailer(true);

    try {
        // --- Configuração do Servidor SMTP ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alexandre.moreira.paulino@gmail.com'; 
        $mail->Password   = 'qphfmiedmnegtxsg'; // A tua App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // --- Definições do Remetente e Destinatário ---
        $mail->setFrom('alexandre.moreira.paulino@gmail.com', 'URBAE Website');
        $mail->addAddress('alexandre.moreira.paulino@gmail.com'); 

        // O SEGREDO: Configura o "Responder para" com o e-mail do cliente
        $mail->addReplyTo($email_cliente, $nome_cliente); 

        // --- Conteúdo da Mensagem com CSS Profissional ---
        $mail->isHTML(true);
        $mail->Subject = "Formulario de Contacto: " . $assunto_form;
        
        $mail->Body = "
            <div style='background-color: #f4f4f4; padding: 30px; font-family: sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); border: 1px solid #ddd;'>
                    
                    <div style='background-color: #2c3e50; padding: 25px; text-align: center;'>
                        <h1 style='color: #ffffff; margin: 0; font-size: 22px; font-weight: 300; letter-spacing: 2px;'>URBAE CONTACTO</h1>
                    </div>

                    <div style='padding: 35px;'>
                        <p style='color: #666; font-size: 15px;'>Recebeu uma nova mensagem do site. Aqui estão os detalhes:</p>
                        
                        <div style='background-color: #f9f9f9; padding: 20px; border-radius: 8px; border-left: 5px solid #3498db; margin: 25px 0;'>
                            <p style='margin: 8px 0; color: #333;'><strong>👤 Nome:</strong> {$nome_cliente}</p>
                            <p style='margin: 8px 0; color: #333;'><strong>📧 E-mail:</strong> <a href='mailto:{$email_cliente}' style='color: #3498db; text-decoration: none;'>{$email_cliente}</a></p>
                            <p style='margin: 8px 0; color: #333;'><strong>📝 Assunto:</strong> {$assunto_form}</p>
                        </div>

                        <p style='font-weight: bold; color: #333; margin-top: 30px;'>Mensagem:</p>
                        <div style='line-height: 1.6; color: #555; background-color: #fff; border: 1px inset #eee; padding: 15px; border-radius: 4px;'>
                            {$mensagem_corpo}
                        </div>
                    </div>

                    <div style='background-color: #eeeeee; padding: 15px; text-align: center;'>
                        <p style='font-size: 12px; color: #888; margin: 0;'>Enviado automaticamente pelo servidor de Alexandre Paulino.</p>
                    </div>
                </div>
            </div>
        ";

        $mail->send();

        // Redirecionamento com status de sucesso
        $url_sucesso = (strpos($origem, 'contacteng.php') !== false) ? "contacteng.php?status=success" : "contact.php?status=success";
        header("Location: $url_sucesso");
        exit();

    } catch (Exception $e) {
        // Mostra o erro se o PHPMailer falhar
        echo "<h1>Erro no Envio:</h1>";
        echo $mail->ErrorInfo; 
        die(); 
    }
} else {
    // Redireciona se tentarem acesso direto ao ficheiro
    header("Location: $origem");
    exit();
}
?>