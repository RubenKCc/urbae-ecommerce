<?php
require ".ht_conexao-bd.php";

if (isset($_GET['email'])) {
    $email = mysqli_real_escape_string($conexao, $_GET['email']);

    // Muda o estado para 0 (inativo)
    $sql = "UPDATE newsletter_subscritores SET ativo = 0 WHERE email = '$email'";
    
    if (mysqli_query($conexao, $sql)) {
        echo "<h1>Subscrição removida com sucesso.</h1>";
        echo "<p>Lamentamos vê-lo partir. Não receberá mais newsletters da URBAE.</p>";
        echo "<a href='index.php'>Voltar ao site</a>";
    } else {
        echo "Erro ao processar o pedido.";
    }
} else {
    header("Location: index.php");
}
?>