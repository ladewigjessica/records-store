<style>
    .disco-detalhe {
        max-width: 480px;
        margin: 2em auto;
        text-align: center;
    }
    .disco-detalhe img {
        width: 100%;
        max-width: 400px;
        border-radius: 4px;
        margin-bottom: 1em;
    }
    .disco-detalhe h2 {
        margin: 0.4em 0;
    }
    .disco-detalhe .genero {
        color: #666;
        margin-bottom: 0.4em;
    }
    .disco-detalhe .preco {
        font-size: 1.4em;
        font-weight: bold;
        margin-bottom: 1em;
    }
    .disco-detalhe .back-link {
        display: inline-block;
        margin-top: 1em;
        color: #555;
        text-decoration: none;
        font-size: 0.9em;
    }
    .disco-detalhe .back-link:hover {
        text-decoration: underline;
    }
</style>

<?php
    include("config.php");

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id <= 0) {
        echo "<p>Disco não encontrado.</p>";
        return;
    }

    $stmt = $ligacao->prepare(
        "SELECT d.*, g.genero FROM discos d
         JOIN genero g ON g.id_genero = d.id_generoFK
         WHERE d.id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $disco  = $result->fetch_assoc();

    if (!$disco) {
        echo "<p>Disco não encontrado.</p>";
        return;
    }

    $nome_safe   = htmlspecialchars($disco["nome"],   ENT_QUOTES);
    $imagem_safe = htmlspecialchars($disco["imagem"], ENT_QUOTES);
    $genero_safe = htmlspecialchars($disco["genero"], ENT_QUOTES);
?>

<div class="disco-detalhe">
    <img src="<?= $imagem_safe ?>" alt="<?= $nome_safe ?>">
    <h2><?= $nome_safe ?></h2>
    <p class="genero"><?= $genero_safe ?></p>
    <p class="preco"><?= floatval($disco["preco"]) ?>$</p>

    <form action="index.php?opcao=adicionar_carrinho" method="POST">
        <input type="hidden" name="id"    value="<?= intval($disco["id"]) ?>">
        <input type="hidden" name="nome"  value="<?= $nome_safe ?>">
        <input type="hidden" name="preco" value="<?= floatval($disco["preco"]) ?>">
        <button type="submit">Adicionar ao carrinho</button>
    </form>

    <a class="back-link" href="index.php?opcao=discos">&larr; Voltar aos discos</a>
</div>
