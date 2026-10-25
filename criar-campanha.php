<?php
session_start();
require ".ht_conexao-bd.php";

if (!isset($_SESSION["utilizador"]) || $_SESSION["id_tipos_utilizador"] != 0) {
    header("Location: index.php");
    exit();
}

$titulo = mysqli_real_escape_string($conexao, $_POST["titulo"]);
$mensagem = mysqli_real_escape_string($conexao, $_POST["mensagem"]);

$sql = "INSERT INTO newsletter_campanhas (titulo, mensagem)
        VALUES ('$titulo', '$mensagem')";

mysqli_query($conexao, $sql);

header("Location: admin-campanhas.php");
exit();
?>