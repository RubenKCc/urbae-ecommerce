<?php
session_start();
//var_dump($_SESSION); exit();

// verificar se foi clicado um produto na galeria dos produtos
if ( ! isset($_GET["produto_id"]) ) {
	Header("Location: index.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Detalhe do produto</title>
<style>
* {
	box-sizing: border-box;
}

.galeria {
	width: 100%;
	display: flex;
	flex-wrap: wrap;
	align-items: flex-start;
	justify-content: center;
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

$sql = "select * from produtos where id=" . $_GET["produto_id"];
			
$resultado = mysqli_query($conexao, $sql);
if (! $resultado ) {
	$_SESSION["erro"] = "Não foi possível obter os dados do produto";
	Header("Location: produtos.php");
	exit();
}

if ( $registo = mysqli_fetch_array( $resultado ) ) {
?>
	<div class="galeria">
		<div class="produto">
			<p> <?php echo $registo["designacao"]; ?> </p>
			<p> <?php echo $registo["preco"] . " €"; ?> </p>
			<p> <a href="gerir-carrinho.php?adicionar_item=true&produto_id=<?php echo $_GET['produto_id']?>"> Adicionar ao carrinho </a></p>
		</div>
	</div>
<?php
}
?>

<div id="mensagem" style="color:blue"></div>
<div id="erro" style="color:red"></div>

<?php

// apresentar eventuais mensagens informativas
if ( isset($_SESSION["mensagem"]) ) {
	echo "<script>
				document.getElementById('mensagem').innerHTML	= '" . $_SESSION["mensagem"] . "';
		 </script>";
	unset($_SESSION["mensagem"]);
}

// verificar se houve erro e dar a respetiva mensagem
if ( isset($_SESSION["erro"]) ) {
	echo "<script>
				document.getElementById('erro').innerHTML	= '" . $_SESSION["erro"] . "';
		 </script>";
	unset($_SESSION["erro"]);
}
?>

</body>

</html>