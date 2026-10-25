<?php
$conexao = mysqli_connect("localhost", "root", "", "bd_site");

if ( ! $conexao ) {
	// para debug
	//echo mysqli_connect_error() . "</br>" . mysqli_connect_errno();
	
	$_SESSION["erro"] = "Não foi possível ligar à base de dados.";
	Header("Location: index.php");	
	exit();
}

mysqli_set_charset( $conexao, "utf8");

?>