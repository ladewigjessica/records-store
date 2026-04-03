<style>
    * { box-sizing: border-box; }
    img {
        width: 20vw;
        padding: 0.3em;
        cursor: pointer;
        align-items: center;
        justify-content: center;
    }
    .genre-filter {
        margin-bottom: 1.5em;
    }
    .genre-filter select {
        padding: 0.4em 0.8em;
        font-size: 1em;
        border: 2px solid #555;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<?php
    include("config.php");

    // --- Genre filter dropdown ---
    $selected_genero = isset($_GET['genero']) ? intval($_GET['genero']) : 0;

    $generos = $ligacao->query("SELECT id_genero, genero FROM genero ORDER BY genero");

    echo "<div class='genre-filter'>";
    echo "<form method='GET' action='index.php'>";
    echo "<input type='hidden' name='opcao' value='discos'>";
    echo "<select name='genero' onchange='this.form.submit()'>";
    echo "<option value='0'" . ($selected_genero === 0 ? " selected" : "") . ">All</option>";
    while ($g = $generos->fetch_assoc()) {
        $selected = ($selected_genero === intval($g['id_genero'])) ? " selected" : "";
        $label    = htmlspecialchars($g['genero'], ENT_QUOTES);
        $id       = intval($g['id_genero']);
        echo "<option value='{$id}'{$selected}>{$label}</option>";
    }
    echo "</select>";
    echo "</form>";
    echo "</div>";

    // --- Disc query (filtered or all) ---
    if ($selected_genero > 0) {
        $stmt = $ligacao->prepare("SELECT * FROM discos WHERE id_generoFK = ?");
        $stmt->bind_param("i", $selected_genero);
        $stmt->execute();
        $disco = $stmt->get_result();
    } else {
        $disco = $ligacao->query("SELECT * FROM discos");
    }

    // --- Disc grid ---
    echo "<p align='center'>";
    while ($discos = $disco->fetch_assoc()) {
        $nome_safe   = htmlspecialchars($discos["nome"],   ENT_QUOTES);
        $imagem_safe = htmlspecialchars($discos["imagem"], ENT_QUOTES);
        $disc_id = intval($discos["id"]);
        echo "<div style='display:inline-block;text-align:center;vertical-align:top'>";
        echo "<a href='index.php?opcao=disco_detalhe&id={$disc_id}'>";
        echo "<img src='{$imagem_safe}' alt='{$nome_safe}'>";
        echo "</a>";
        echo "<br>{$nome_safe}<br>";
        echo $discos["preco"] . "$<br>";
        if (!empty($_SESSION["admin"]) && $_SESSION["admin"] == 1) {
            echo "<a href='index.php?opcao=editar_disco&id={$disc_id}'>Editar</a>";
        }
        echo "<br><br>";
        echo "</div>";
    }

    if ($disco->num_rows === 0) {
        echo "<p>No discs found for this genre.</p>";
    }

    echo "</p>";
?>
