<?php
session_start();
require ".ht_conexao-bd.php";

// Página para voltar após login (se não houver, vai para o index.php)
$voltar = $_POST['redirect'] ?? 'index.php';

// Se já está logado ou botão não foi clicado, redireciona
if (isset($_SESSION["utilizador"]) || isset($_SESSION["admin"]) || !isset($_POST["botaoLogin"])) {
    header("Location: $voltar");
    exit();
}

// Receber dados do formulário
$utilizador = $_POST["utilizador"];
$password   = $_POST["password"];

// Verificar se o utilizador existe
$sql = "SELECT * FROM utilizadores WHERE utilizador='$utilizador'";
$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
    $_SESSION["erro"] = "Não foi possível obter os dados do utilizador.";
    header("Location: $voltar");
    exit();
}

if ($registo = mysqli_fetch_array($resultado)) {

    // Conta ativa? (id_estado 0 = desativada)
    if ($registo["id_estado"] == 0) {
        $_SESSION["erro"] = "A conta encontra-se desativada.";
        header("Location: $voltar");
        exit();
    }

    // Verificar password usando a função PASSWORD() do MySQL
    $sql = "SELECT * FROM utilizadores 
            WHERE utilizador='$utilizador' AND password=PASSWORD('$password')";
    $resultado = mysqli_query($conexao, $sql);

    if ($registo = mysqli_fetch_array($resultado)) {
        
        // --- LOGIN COM SUCESSO ---
        
        // 1. Guarda o nome do utilizador
        $_SESSION["utilizador"] = $registo["utilizador"];
        
        // 2. Guarda o ID do tipo (0 para admin, 1 para user, etc)
        $_SESSION["id_tipos_utilizador"] = $registo["tipos_utilizador_id_tipos_utilizador"];
        
        // 3. GUARDA O EMAIL (Essencial para o PHPMailer funcionar!)
        $_SESSION["email"] = $registo["email"];

        // 4. Se for Admin (tipo 0), cria também a sessão de admin
        if ($_SESSION["id_tipos_utilizador"] == 0) {
            $_SESSION["admin"] = $registo["utilizador"];
        }

        header("Location: $voltar");
        exit();

    } else {
        $_SESSION["erro"] = "A palavra-passe está incorreta.";
        header("Location: $voltar");
        exit();
    }

} else {
    $_SESSION["erro"] = "O utilizador não existe.";
    header("Location: $voltar");
    exit();
}
?>