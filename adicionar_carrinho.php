<?php
if (!empty($_POST["id"])) {
    if (!isset($_SESSION["carrinho"])) {
        $_SESSION["carrinho"] = [];
    }

    $id = intval($_POST["id"]);

    include("config.php");
    $stmt = $ligacao->prepare("SELECT nome, preco FROM discos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $disco = $resultado->fetch_assoc();
    $stmt->close();
    $ligacao->close();

    if ($disco) {
        $nome  = $disco["nome"];
        $preco = floatval($disco["preco"]);

        if (isset($_SESSION["carrinho"][$id])) {
            $_SESSION["carrinho"][$id]["quantidade"]++;
        } else {
            $_SESSION["carrinho"][$id] = [
                "nome"      => $nome,
                "preco"     => $preco,
                "quantidade"=> 1
            ];
        }

        echo "<p style='color:green;font-weight:bold'>Adicionado!</p>";
        echo "<p>" . htmlspecialchars($nome) . " — " . number_format($preco, 2) . "$</p>";
    }
}

echo "<p><a href='index.php?opcao=discos'>← Voltar aos discos</a></p>";
?>
