<?php
session_start();

//var_dump($_SESSION); echo "</br></br>";var_dump($_POST); exit();


if (
	// não foi clicado o botão Gravar
	! isset( $_POST["botaoGravar"]) ||
	// não existe sessão iniciada
	! isset($_SESSION["utilizador"]) ||
	// o utilizador não é um administrador
	$_SESSION["id_tipos_utilizador"] != 0 
    ) {
	Header("Location: index.php");
	exit();
}

// impedir a edição de "admin" por alguém que não
// seja o próprio admin
if ( $_POST["utilizador"] == "admin" &&
	$_SESSION["utilizador"] != "admin") {
	Header("Location: index.php");
	exit();
}

require ".ht_conexao-bd.php";

$sql = "update utilizadores set
        utilizador='" . $_POST["utilizador"] . "',
        email='" . $_POST["email"] . "',
        tipos_utilizador_id_tipos_utilizador=" . $_POST["id_tipos_utilizador"] .
        ( ($_POST["password"] != "") ? ", password=password('" . $_POST["password"] . "')" : "" ) .
        ", estado_conta=" . $_POST["estado_conta"] .
        " where id_utilizadores=" . $_POST["id_utilizadores"];

		
//echo $sql; exit();
			
$resultado = mysqli_query($conexao, $sql);
if (! $resultado ) {
	//echo "<script>alert('Não foi possível obter os dados do utilizador.')</script>";
	$_SESSION["erro"] = "Não foi possível editar os dados do utilizador.";
	Header("Location: editar-utilizadores.php");	
	exit();
}

Header("Location: editar-utilizadores.php");	

?>