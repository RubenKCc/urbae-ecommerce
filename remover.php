<?php
session_start();

//var_dump($_SESSION); echo "</br></br>";var_dump($_POST); exit();

	 // não foi clicado o botão Remover
if ( ! isset( $_POST["botaoRemover"]) ||
	// não existe sessão iniciada
	( ! isset($_SESSION["utilizador"]) ||
		// o utilizador não é um administrador
		$_SESSION["id_tipos_utilizador"] != 0 )) {
	Header("Location: index.php");
	exit();
}

// impedir a remoção de "admin"
if ( $_POST["utilizador"] == "admin" ) {
	Header("Location: index.php");
	exit();
}

require ".ht_conexao-bd.php";

$sql = "delete from utilizadores
		where utilizador='" .
		$_POST["utilizador"] . "'";
		
//echo $sql; exit();
			
$resultado = mysqli_query($conexao, $sql);
if (! $resultado ) {
	//echo "<script>alert('Não foi possível obter os dados do utilizador.')</script>";
	$_SESSION["erro"] = "Não foi possível remover o utilizador.";
	Header("Location: editar-utilizadores.php");	
	exit();
}

Header("Location: editar-utilizadores.php");	

?>