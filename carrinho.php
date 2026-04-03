<?php
if (!isset($_SESSION["carrinho"])) {
    $_SESSION["carrinho"] = [];
}

// Handle remove single item
if (!empty($_POST["remover"])) {
    $id = intval($_POST["remover"]);
    unset($_SESSION["carrinho"][$id]);
}

// Handle clear entire cart
if (isset($_POST["limpar"])) {
    $_SESSION["carrinho"] = [];
}

// Handle checkout
if (isset($_POST["finalizar"])) {
    if (empty($_SESSION["username"])) {
        $_SESSION["redirect_after_login"] = "index.php?opcao=carrinho";
        header("location:index.php?opcao=login");
        exit;
    }
    $_SESSION["carrinho"] = [];
    $_SESSION["compra_concluida"] = true;
}
?>

<h2>Carrinho</h2>

<?php if (!empty($_SESSION["compra_concluida"])): ?>
    <?php unset($_SESSION["compra_concluida"]); ?>
    <p><strong>Pagamento em desenvolvimento. Obrigado pela sua compra!</strong></p>
<?php elseif (empty($_SESSION["carrinho"])): ?>
    <p>O carrinho está vazio.</p>
<?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        foreach ($_SESSION["carrinho"] as $id => $item):
            $subtotal = $item["preco"] * $item["quantidade"];
            $total += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($item["nome"]) ?></td>
                <td><?= number_format($item["preco"], 2) ?>$</td>
                <td><?= intval($item["quantidade"]) ?></td>
                <td><?= number_format($subtotal, 2) ?>$</td>
                <td>
                    <form action="index.php?opcao=carrinho" method="POST">
                        <input type="hidden" name="remover" value="<?= intval($id) ?>">
                        <button type="submit">Remover</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="2"><strong><?= number_format($total, 2) ?>$</strong></td>
            </tr>
        </tfoot>
    </table>

    <br>
    <form action="index.php?opcao=carrinho" method="POST" style="display:inline">
        <button type="submit" name="limpar" value="1">Limpar carrinho</button>
    </form>
    <form action="index.php?opcao=carrinho" method="POST" style="display:inline;margin-left:0.5em">
        <button type="submit" name="finalizar" value="1">Finalizar compra</button>
    </form>
<?php endif; ?>

<p><a href="index.php?opcao=discos">← Voltar aos discos</a></p>
