<?php
session_start();
require ".ht_conexao-bd.php";

// Só admin
if (!isset($_SESSION["utilizador"]) || $_SESSION["id_tipos_utilizador"] != 0) {
    header("Location: index.php");
    exit();
}
?>

<h1>Criar Campanha</h1>

<form action="criar-campanha.php" method="POST">
    <input type="text" name="titulo" placeholder="Título da campanha" required><br><br>
    <textarea name="mensagem" placeholder="Mensagem da campanha" required></textarea><br><br>
    <button type="submit">Criar Campanha</button>
</form>

<hr>

<h2>Campanhas Criadas</h2>

<?php
$result = mysqli_query($conexao, "SELECT * FROM newsletter_campanhas ORDER BY id DESC");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
    echo "<strong>".$row["titulo"]."</strong><br>";
    echo $row["mensagem"]."<br><br>";

    if ($row["enviada"] == 0) {
        echo "<a href='enviar-campanha.php?id=".$row["id"]."'>Enviar Campanha</a>";
    } else {
        echo "<span style='color:green;'>Já enviada</span>";
    }

    echo "</div>";
}
?>