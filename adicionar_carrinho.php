<?php
session_start();
// 1. Conexão com a tua variável exata: $conexao
require ".ht_conexao-bd.php"; 

if (!isset($_SESSION["utilizador"])) {
    echo "not_logged_in";
    exit();
}

if (isset($_POST['id_produto'])) {
    // Usando $conexao conforme o teu ficheiro enviado
    $produto_id = mysqli_real_escape_string($conexao, $_POST['id_produto']);
    $utilizador = $_SESSION["utilizador"];

    // 2. Obter ID do Utilizador
    $sql_user = "SELECT id_utilizadores FROM utilizadores WHERE utilizador = '$utilizador'";
    $res_user = mysqli_query($conexao, $sql_user);
    $user_data = mysqli_fetch_assoc($res_user);
    $user_id = $user_data['id_utilizadores'];

    // 3. Obter Preço do Produto
    $sql_prod = "SELECT preco FROM produtos WHERE id = '$produto_id'";
    $res_prod = mysqli_query($conexao, $sql_prod);
    $prod_data = mysqli_fetch_assoc($res_prod);
    $preco_unitario = $prod_data['preco'];

    // 4. Verificar Carrinho Ativo (estado 0)
    $sql_car = "SELECT id FROM carrinho WHERE utilizador_id = '$user_id' AND estado = 0";
    $res_car = mysqli_query($conexao, $sql_car);

    if (mysqli_num_rows($res_car) > 0) {
        $carrinho_id = mysqli_fetch_assoc($res_car)['id'];
    } else {
        // Criar novo carrinho se não existir
        mysqli_query($conexao, "INSERT INTO carrinho (utilizador_id, estado, preco_total_carrinho) VALUES ('$user_id', 0, 0)");
        $carrinho_id = mysqli_insert_id($conexao);
    }

    // 5. Adicionar Item ou Atualizar Quantidade
    $sql_item = "SELECT id, quantidade FROM carrinho_itens WHERE carrinho_id = '$carrinho_id' AND produto_id = '$produto_id'";
    $res_item = mysqli_query($conexao, $sql_item);

    if (mysqli_num_rows($res_item) > 0) {
        $item_data = mysqli_fetch_assoc($res_item);
        $nova_qtd = $item_data['quantidade'] + 1;
        $novo_subtotal = $nova_qtd * $preco_unitario;
        mysqli_query($conexao, "UPDATE carrinho_itens SET quantidade = '$nova_qtd', preco_total_itens = '$novo_subtotal' WHERE id = " . $item_data['id']);
    } else {
        mysqli_query($conexao, "INSERT INTO carrinho_itens (carrinho_id, produto_id, quantidade, preco_total_itens) VALUES ('$carrinho_id', '$produto_id', 1, '$preco_unitario')");
    }

    // 6. Atualizar Total do Carrinho
    $sql_total = "SELECT SUM(preco_total_itens) as total FROM carrinho_itens WHERE carrinho_id = '$carrinho_id'";
    $res_total = mysqli_query($conexao, $sql_total);
    $total_geral = mysqli_fetch_assoc($res_total)['total'];
    mysqli_query($conexao, "UPDATE carrinho SET preco_total_carrinho = '$total_geral' WHERE id = '$carrinho_id'");

    // 7. Incrementar vendidos
    mysqli_query($conexao, "UPDATE produtos SET vendidos = vendidos + 1 WHERE id = '$produto_id'");

    echo "sucesso";
    exit();
}
?>