<?php
session_start();
//var_dump($_SESSION); exit();
?>

<!DOCTYPE html>
<html lang="pt">
<title>Produtos</title>
<link rel="icon" type="image/png" href="URBAE COMPLETO.png">

<head>
<meta charset="UTF-8">
<title>Produtos</title>
<style>
* {
	box-sizing: border-box;
}

.galeria {
	width: 60%;
	display: flex;
	flex-wrap: wrap;
	align-items: flex-start;
	justify-content: space-between;
	row-gap: 15px;
}

div.produto {
	display: flex;
	justify-content: center;
	flex-direction: column;
	border: solid 1px #000000;
	padding: 8px;
}

div.produto p {
	text-align: center;
}
</style>
</head>

<body>

<?php

require "menu.php";

require ".ht_conexao-bd.php";

$sql = "select * from produtos";
			
$resultado = mysqli_query($conexao, $sql);
if (! $resultado ) {
	$_SESSION["erro"] = "Não foi possível obter os dados dos produtos";
	Header("Location: index.php");
	exit();
}

?>

<div class="galeria">

<?php
while ( $registo = mysqli_fetch_array( $resultado ) ) {
?>
	<div class="produto">
		<p> <?php echo $registo["designacao"]; ?> </p>
		<p> <?php echo $registo["preco"] . " €"; ?> </p>
		<p> <a href="detalhe_produto.php?produto_id=<?php echo $registo["id"]; ?>"> Mais informações </a></p>
	</div>
<?php
}
?>

</body>

</html>