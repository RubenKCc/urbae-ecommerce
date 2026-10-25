<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>

<body>


<!-- MODAL DE DADOS DE PAGAMENTO -->
<div id="modalPagamento" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; padding:30px; border-radius:8px; width:400px; position:relative; font-family:'Poppins', sans-serif;">
        <h3 id="tituloPagamento" style="margin-bottom:20px; border-bottom:1px solid #eee; padding-bottom:10px;">Dados de Pagamento</h3>
        
        <form id="formDadosPagamento" action="gerir-carrinho.php" method="GET">
            <input type="hidden" name="carrinho_estado" value="1">
            <input type="hidden" name="carrinho_id" id="inputCarrinhoId">
            <input type="hidden" name="metodo" id="inputMetodo">

            <!-- Campos para Cartão (Mastercard) -->
            <div id="camposCartao" style="display:none;">
                <label style="font-size:12px; color:#666;">Número do Cartão</label>
                <input type="text" name="n_cartao" placeholder="0000 0000 0000 0000" style="width:100%; padding:10px; margin-bottom:15px; border:1px solid #ddd;">
                <div style="display:flex; gap:10px;">
                    <input type="text" name="validade" placeholder="MM/AA" style="flex:1; padding:10px; border:1px solid #ddd;">
                    <input type="text" name="cvv" placeholder="CVV" style="flex:1; padding:10px; border:1px solid #ddd;">
                </div>
            </div>

            <!-- Campos para Multibanco (Simulação) -->
            <div id="camposMB" style="display:none;">
                <p style="font-size:13px; color:#444; background:#f9f9f9; padding:10px; border-left:4px solid #2c8c5c;">
                    A entidade e referência serão geradas após confirmar.
                </p>
            </div>

            <!-- Botões -->
            <div style="margin-top:25px; display:flex; gap:10px;">
                <button type="button" onclick="fecharModal()" style="flex:1; padding:10px; background:#eee; border:none; cursor:pointer;">Cancelar</button>
                <button type="submit" style="flex:1; padding:10px; background:#000; color:#fff; border:none; cursor:pointer; font-weight:bold;">CONFIRMAR PAGAMENTO</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
