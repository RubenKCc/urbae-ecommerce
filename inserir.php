<?php
session_start();

//var_dump($_SESSION); echo "</br></br>";var_dump($_POST); exit();

	 // não foi clicado o botão Inserir
if ( ! isset( $_POST["botaoInserir"]) ||
	// não existe sessão iniciada
	( ! isset($_SESSION["utilizador"]) ||
		// o utilizador não é um administrador
		$_SESSION["id_tipos_utilizador"] != 0 )) {
	Header("Location: index.php");
	exit();
}

require ".ht_conexao-bd.php";

$sql = "insert into utilizadores
	(id_utilizadores, utilizador, password, email, tipos_utilizador_id_tipos_utilizador, estado_conta) values
	(null, '" . $_POST["utilizador"] . "', password('" . $_POST["password"] . "'), '" .
	$_POST["email"] . "', '" . $_POST["id_tipos_utilizador"] . "', '" . $_POST["estado_conta"] ."')";
			
//echo $sql; exit();
try {			
	$resultado = mysqli_query($conexao, $sql);
}
catch (Exception $e) {
	// echo mysqli_errno($conexao) . mysqli_error($conexao); exit();
	$codigo_erro = mysqli_errno($conexao);
	if ($codigo_erro == 1062) {
		$_SESSION["erro"] = "O utilizador introduzido já existe.";
	}
	else {
		$_SESSION["erro"] = "Não foi possível inserir o utilizador.";
	}
	Header("Location: editar-utilizadores.php");	
	exit();
}

Header("Location: editar-utilizadores.php");	

?>