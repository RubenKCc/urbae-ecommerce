<?php
session_start();
require ".ht_conexao-bd.php";

// Função para atualizar o custo total
function atualizar_custo_carrinho($carrinho_id) {
    global $conexao;
    $sql = "update carrinho set preco_total_carrinho=
            (select sum(preco_total_itens) from carrinho_itens where carrinho_id=$carrinho_id)
            where id=$carrinho_id";
    return mysqli_query($conexao, $sql);
}

// 1. Verificar sessão
if ( ! isset($_SESSION["utilizador"]) ) {
    $_SESSION["mensagem"] = "Log in to make purchases.";
    Header("Location: indexeng.php");
    exit();
}

// ---------------------------------------------------------
// FINALIZAR COMPRA (ESTADO = 1)
// ---------------------------------------------------------
if (isset($_GET['carrinho_estado']) && $_GET['carrinho_estado'] == 1) {
    $carrinho_id = intval($_GET['carrinho_id']);
    $metodo = isset($_GET['metodo']) ? $_GET['metodo'] : "N/A";

    // A. VALIDAR STOCK
    $sql_check = "SELECT ci.quantidade as qtd_pedida, p.stock, p.designacao 
                  FROM carrinho_itens ci 
                  JOIN produtos p ON ci.produto_id = p.id 
                  WHERE ci.carrinho_id = $carrinho_id";
    $res_check = mysqli_query($conexao, $sql_check);

    while ($row = mysqli_fetch_assoc($res_check)) {
        if ($row['qtd_pedida'] > $row['stock']) {
            $_SESSION["erro_stock"] = "Insufficient stock: " . $row['designacao'];
            echo json_encode(['status' => 'erro_stock']);
            exit();
        }
    }

    // B. ABATER STOCK
    $res_itens = mysqli_query($conexao, "SELECT produto_id, quantidade FROM carrinho_itens WHERE carrinho_id = $carrinho_id");
    while ($item = mysqli_fetch_array($res_itens)) {
        mysqli_query($conexao, "UPDATE produtos SET stock = stock - " . $item['quantidade'] . " WHERE id = " . $item['produto_id']);
    }

    // C. ATUALIZAR ESTADO
    mysqli_query($conexao, "UPDATE carrinho SET estado = 1, datahora = NOW() WHERE id = $carrinho_id");

    // D. APAGAR ITENS
// D. GUARDAR HISTÓRICO DOS ITENS (antes de apagar)
$sql_hist = "SELECT ci.quantidade, ci.preco_total_itens, p.designacao, p.imagem, p.preco, p.id as pid
             FROM carrinho_itens ci
             JOIN produtos p ON ci.produto_id = p.id
             WHERE ci.carrinho_id = $carrinho_id";
$res_hist = mysqli_query($conexao, $sql_hist);
while ($h = mysqli_fetch_assoc($res_hist)) {
    $des   = mysqli_real_escape_string($conexao, $h['designacao']);
    $img   = mysqli_real_escape_string($conexao, $h['imagem'] ?? '');
    $qtd   = intval($h['quantidade']);
    $pid   = intval($h['pid']);
    $preco_u = floatval($h['preco']);
    $preco_t = floatval($h['preco_total_itens']);
    mysqli_query($conexao, "INSERT INTO historico_itens (carrinho_id, produto_id, designacao, imagem, quantidade, preco_unit, preco_total) 
                            VALUES ($carrinho_id, $pid, '$des', '$img', $qtd, $preco_u, $preco_t)");
}

// E. APAGAR ITENS
mysqli_query($conexao, "DELETE FROM carrinho_itens WHERE carrinho_id = $carrinho_id");

    
    // E. GERAR E ENVIAR FATURA
    $idioma = isset($_GET['idioma']) ? $_GET['idioma'] : 'pt';
    require_once 'gerar_faturaeng.php';
    gerar_e_enviar_fatura($carrinho_id, $conexao, $idioma);


    // F. RESPONDER SEM REDIRECT
    echo json_encode(['status' => 'ok']);
    exit();    
}

// ---------------------------------------------------------
// OPERAÇÃO B: REMOVER CARRINHO INTEIRO (LIMPAR)
// ---------------------------------------------------------
if ( isset($_GET["remover_carrinho"]) ) {
    $cid = $_GET["remover_carrinho"];
    mysqli_query($conexao, "delete from carrinho_itens where carrinho_id=$cid");
    mysqli_query($conexao, "delete from carrinho where id=$cid");
    Header("Location: carrinhoeng.php");
    exit();
}

// ---------------------------------------------------------
// OPERAÇÃO C: ADICIONAR OU ALTERAR ITENS
// ---------------------------------------------------------
if ( ! isset($_GET["produto_id"]) ) {
    Header("Location: indexeng.php");
    exit();
}

$produto_id = $_GET["produto_id"];

// Lógica de verificar/criar carrinho e adicionar itens (O teu código original estava bem aqui)
$sql_c = "select id from carrinho where estado=0 and 
        utilizador_id=(select id_utilizadores from utilizadores where utilizador='" . $_SESSION["utilizador"] . "')";
$res_carrinho = mysqli_query($conexao, $sql_c);

if (mysqli_num_rows($res_carrinho) > 0) {
    $reg = mysqli_fetch_array($res_carrinho);
    $carrinho_id = $reg["id"];
} else {
    mysqli_query($conexao, "insert into carrinho (estado, datahora, preco_total_carrinho, utilizador_id) values
                 (0, now(), 0, (select id_utilizadores from utilizadores where utilizador='" . $_SESSION["utilizador"] . "'))");
    $carrinho_id = mysqli_insert_id($conexao);
}

$res_item = mysqli_query($conexao, "select id, quantidade from carrinho_itens where carrinho_id=$carrinho_id and produto_id=$produto_id");

if (mysqli_num_rows($res_item) == 0) {
    mysqli_query($conexao, "insert into carrinho_itens (quantidade, preco_total_itens, carrinho_id, produto_id)
                 values (1, (select preco from produtos where id=$produto_id), $carrinho_id, $produto_id)");
} else {
    $reg_i = mysqli_fetch_array($res_item);
    $nova_qtd = isset($_GET["adicionar_item"]) ? $reg_i["quantidade"] + 1 : $_GET["item_quantidade"];

    if ($nova_qtd <= 0) {
        mysqli_query($conexao, "delete from carrinho_itens where id=" . $reg_i["id"]);
    } else {
        mysqli_query($conexao, "update carrinho_itens set quantidade=$nova_qtd, 
                     preco_total_itens = ((select preco from produtos where id=$produto_id) * $nova_qtd)
                     where id=" . $reg_i["id"]);
    }
}

atualizar_custo_carrinho($carrinho_id);
Header("Location: carrinhoeng.php");
exit();
?>