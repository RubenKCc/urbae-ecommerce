<?php
session_start();

// Verificação de administrador
if ( ! isset($_SESSION["utilizador"]) || $_SESSION["id_tipos_utilizador"]!=0) {
    Header("Location: indexeng.php");
    exit();
}

require ".ht_conexao-bd.php";

// 1. QUERY ORIGINAL: Utilizadores
$sql = "select * from utilizadores, tipos_utilizador
        where utilizadores.tipos_utilizador_id_tipos_utilizador
        = tipos_utilizador.id_tipos_utilizador";
            
$resultado = mysqli_query($conexao, $sql);

// 2. NOVA QUERY: Campanhas por enviar (enviada = 0)
$sqlCampanhas = "SELECT * FROM newsletter_campanhas WHERE enviada = 0";
$resultadoCampanhas = mysqli_query($conexao, $sqlCampanhas);

if (! $resultado ) {
    $_SESSION["erro"] = "The data could not be obtained.";
    Header("Location: indexeng.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User and Campaign Management</title>
    <link rel="stylesheet" href="editar-utilizadores.css">
    <link rel="icon" type="image/png" href="URBAE COMPLETO.png">

    <style>
        /* Apenas o espaçamento e divisões do layout, sem forçar cores ou fontes */
        .topo-nav { margin-bottom: 25px; display: flex; gap: 20px; align-items: center; }
        .seccao-campanha { margin-bottom: 40px; border-bottom: 2px solid #333; padding-bottom: 25px; }
        .seccao-inserir { margin-bottom: 40px; border-bottom: 2px solid #ccc; padding-bottom: 30px; }
        .btn-enviar { background: #28a745; color: white; padding: 5px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .btn-enviar:hover { background: #218838; }
        .msg-vazia { color: #666; font-style: italic; }
    </style>
</head>
<body>

<h1>User Management</h1>

<!-- Links de Navegação no Topo -->
<div class="topo-nav">
    <a href="indexeng.php"> Homepage </a>
    <a href="admineng.php" style="text-decoration: none; background: #111; color: white; padding: 8px 16px; border-radius: 4px; font-size: 14px; font-family: 'Poppins', sans-serif;">
        <i class="fas fa-chart-line"></i> Back to Dashboard
    </a>
</div>

<!-- Secção de Campanhas Newsletter -->
<div class="seccao-campanha">
    <h2>Available Newsletter Campaigns</h2>
    <table>
        <tr>
            <th>Campaign Title</th>
            <th>Action</th>
        </tr>
        <?php 
        if(mysqli_num_rows($resultadoCampanhas) > 0) {
            while($campanha = mysqli_fetch_assoc($resultadoCampanhas)) {
                echo "<tr>
                        <td>{$campanha['titulo']}</td>
                        <td>
                            <a href='enviar-campanha.php?id={$campanha['id']}' 
                               class='btn-enviar' 
                               onclick=\"return confirm('Confirm sending to all subscribers?')\">
                               🚀 Send Now
                            </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2' class='msg-vazia'>No campaigns pending delivery.</td></tr>";
        }
        ?>
    </table>
</div>

<!-- Tabela para Inserir Novo Utilizador -->
<div class="seccao-inserir">
    <h2>Insert New User</h2>
    <table>
        <tr>
            <th>Username</th><th>Password</th>
            <th>Email</th><th>User Type</th><th>Account Status</th>
        </tr>
        <form id="formInserir" action='inserir.php' method='post' onsubmit='return inserir()'>
            <tr>
                <td> <input name='utilizador' type='text' /></td>
                <td> <input name='password' type='password' /></td>
                <td> <input name='email' type='text' /></td>
                <td> <select name='id_tipos_utilizador'>
                        <option value='0'> administrador </option>
                        <option value='1' selected> utilizador </option>
                     </select>
                </td>
                <td> <select name='estado_conta'>
                        <option value='0'> Inactive </option>
                        <option value='1' selected> Active </option>
                     </select>
                </td>
                <td> <button name='botaoInserir'> insert </button> </td>
            </tr>
        </form>
    </table>
</div>

<script>
var botaoAcao="";

function gravar(idForm) {
    document.getElementById(idForm).action = "gravar.php";
    botaoAcao = "gravar";
}

function acao() {
    if (botaoAcao == "gravar") {
        botaoAcao = "";
        return true;
    }
    else {
        return false;
    }
}

function inserir() {
    return true;
}
</script>

<!-- Lista de Utilizadores Existentes -->
<h2>Registered Users</h2>
<table>
    <tr>
        <th>Username</th><th>Password</th>
        <th>Email</th><th>User Type</th><th>Account Status</th>
    </tr>
<?php
while ( $registo = mysqli_fetch_array( $resultado ) ) {
    if ( $registo["utilizador"] == "admin" && $_SESSION["utilizador"] != "admin") {
        continue; 
    }
    
    echo "
    <form id='form" . $registo["id_utilizadores"] . "' action='' method='post' onsubmit='return acao()'>
        <tr>
            <td hidden> <input name='id_utilizadores' type='text' value='" . $registo["id_utilizadores"] . "' /></td>
            <td> <input name='utilizador' type='text' value='" . $registo["utilizador"] . "' /></td>
            <td> <input name='password' type='password' /></td>
            <td> <input name='email' type='text' value='" . $registo["email"] . "' /></td>
            <td> <select name='id_tipos_utilizador'>
                    <option value='0' " . (($registo["id_tipos_utilizador"]=='0') ? " selected " : "") . "> administrador </option>
                    <option value='1' " . (($registo["id_tipos_utilizador"]=='1') ? " selected " : "") . "> utilizador </option>
                 </select>
            </td>
            <td> <select name='estado_conta'>
                    <option value='0' " . (($registo["estado_conta"]=='0') ? " selected " : "") . "> Inactive </option>
                    <option value='1' " . (($registo["estado_conta"]=='1') ? " selected " : "") . "> Active </option>
                 </select>
            </td>
            <td hidden> <button></button> </td>
            <td> <button name='botaoGravar' onclick='gravar(\"form" . $registo["id_utilizadores"] . "\")'> Save </button> </td>
        </tr>
    </form>";
}
?>
</table>

<div id="erro" style="color:red; margin-top:20px;"></div>

<?php
if ( isset($_SESSION["erro"]) ) {
    echo "<script>document.getElementById('erro').innerHTML = '" . $_SESSION["erro"] . "'</script>";
    unset($_SESSION["erro"]);
}
?>

</body>
</html>