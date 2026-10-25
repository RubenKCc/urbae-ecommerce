<?php
require ".ht_conexao-bd.php";

// 1. Obter o e-mail e a página de origem
$email = isset($_POST["email"]) ? mysqli_real_escape_string($conexao, $_POST["email"]) : "";
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'index.php';

// --- A TUA LÓGICA DE SEPARADOR ---
$separador = (strpos($redirect, '?') !== false) ? '&' : '?';
// ---------------------------------

if (empty($email)) {
    header("Location: " . $redirect . $separador . "newsletter=erro");
    exit();
}

// 2. Verificar se o email já existe
$sql_check = "SELECT * FROM newsletter_subscritores WHERE email = '$email'";
$resultado = mysqli_query($conexao, $sql_check);

if (mysqli_num_rows($resultado) > 0) {
    $dados = mysqli_fetch_assoc($resultado);

    if ($dados['ativo'] == 1) {
        // Já está subscrito e ativo
        header("Location: " . $redirect . $separador . "newsletter=existe");
    } else {
        // Existe mas estava desativado, vamos reativar
        mysqli_query($conexao, "UPDATE newsletter_subscritores SET ativo = 1 WHERE email = '$email'");
        header("Location: " . $redirect . $separador . "newsletter=sucesso");
    }
} else {
    // 3. Inserir novo subscritor
    $sql_insert = "INSERT INTO newsletter_subscritores (email, ativo, data_subscricao) VALUES ('$email', 1, NOW())";
    
    if (mysqli_query($conexao, $sql_insert)) {
        header("Location: " . $redirect . $separador . "newsletter=sucesso");
    } else {
        header("Location: " . $redirect . $separador . "newsletter=erro");
    }
}
exit();
?>