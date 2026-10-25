<?php
session_start();
require ".ht_conexao-bd.php";

if (!isset($_SESSION["utilizador"]) || $_SESSION["id_tipos_utilizador"] != 0) {
    header("Location: index.php");
    exit();
}
?>

<h2>Criar Nova Campanha</h2>

<form action="criar-campanha.php" method="POST">
    <input type="text" name="titulo" placeholder="Título da campanha" required>
    <br><br>
    <textarea name="mensagem" placeholder="Mensagem da campanha" rows="6" required></textarea>
    <br><br>
    <button type="submit">Criar Campanha</button>
</form>