<?php
session_start();
//var_dump($_SESSION); exit();
// verificar se existe uma sessão iniciada
if ( ! isset($_SESSION["utilizador"]) ) {
	$_SESSION["mensagem"] = "Inicie sessão para ver o histórico de compras.";
	Header("Location: index.php");
}
?>

<!DOCTYPE html>
<title>Histórico de Compras</title>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Histórico de compras</title>
<style>
* {
	box-sizing: border-box;
}

.carrinho {
	width: 80%;
	margin: auto;
	display: flex;
	align-items: flex-start;
	row-gap: 15px;
	justify-content: center;
	flex-direction: column;
	border: solid 1px #000000;
	padding: 8px;
}

.item_carrinho {
	width: 90%;
	display: flex;
	align-items: flex-start;
	justify-content: space-between;
	flex-direction: row;
	border: solid 1px #000000;
	padding: 8px;
}

.item_carrinho a {
	text-decoration: none;
}

.carrinho_footer {
	width: 90%;
	display: flex;
	align-items: flex-start;
	justify-content: space-between;
	flex-direction: row;
	border: solid 1px #000000;
	background-color: #eeeeee;
	padding: 8px;
}

.carrinho_footer a {
	text-decoration: none;
}

</style>

</head>

<body>

<?php
require "menu.php";

require ".ht_conexao-bd.php";

// obter os carrinhos finalizados
$sql_historico = "select * from carrinho where carrinho.estado=1 and carrinho.utilizador_id=
			(select id_utilizadores from utilizadores where utilizador = '" . $_SESSION["utilizador"] . "')
			order by datahora desc";

$resultado_historico = mysqli_query($conexao, $sql_historico);
if (! $resultado_historico ) {
	$_SESSION["erro"] = "Não foi possível obter o histórico de compras.1";
	Header("Location: index.php");
	exit();
}

if (mysqli_num_rows($resultado_historico) == 0) {
	echo "<h2 style='text-align: center'> Sem compras efetuadas. </h3>";
	exit();
}

// listar todos os carrinhos finalizados
while ( $registo_historico = mysqli_fetch_array( $resultado_historico) ) {
	// obter os itens de cada carrinho
	$sql = "select * from carrinho_itens, carrinho, produtos where 
				carrinho.id=carrinho_itens.carrinho_id and produtos.id = carrinho_itens.produto_id
				and carrinho.id=" . $registo_historico["id"];
		
	$resultado = mysqli_query($conexao, $sql);
	if (! $resultado ) {
		$_SESSION["erro"] = "Não foi possível obter o histórico de compras.2";
		Header("Location: index.php");
		exit();
	}

?>

	<div class="carrinho">

	<?php
	while ( $registo = mysqli_fetch_array( $resultado ) ) {
	?>
		<div class="item_carrinho">
			<div>
				<?php echo $registo["designacao"]; ?>
			</div>
			<div>
			<?php echo $registo["quantidade"]; ?>				
			</div>
			<div>
				<?php echo $registo["preco_total_itens"] . " €"; ?>
			</div>
		</div>
	<?php
	}
	?>

		<div class="carrinho_footer">
			<div>
				Total: <?php echo $registo_historico["preco_total_carrinho"] . " €";?>
			</div>
			<div>
				Data: <?php echo $registo_historico["datahora"];?>
			</div>
		</div>

	</div>

<?php
}  // while exterior
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