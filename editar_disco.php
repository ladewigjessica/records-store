<?php
if (empty($_SESSION["username"]) || $_SESSION["admin"] != 1) {
    header("location:index.php");
    exit;
}

include("config.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle save
if (!empty($_POST["guardar"])) {
    $id    = intval($_POST["id"]);
    $nome  = $_POST["nome"];
    $preco = $_POST["preco"];
    $genero = intval($_POST["id_genero"]);

    $stmt = $ligacao->prepare("UPDATE discos SET nome = ?, preco = ?, id_generoFK = ? WHERE id = ?");
    $stmt->bind_param("sdii", $nome, $preco, $genero, $id);
    $stmt->execute();
    $stmt->close();

    header("location:index.php?opcao=discos");
    exit;
}

if ($id <= 0) {
    echo "<p>Disco inválido.</p>";
    return;
}

$stmt = $ligacao->prepare("SELECT * FROM discos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$disco = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$disco) {
    echo "<p>Disco não encontrado.</p>";
    return;
}

// Build genre dropdown with current genre pre-selected
$generos = $ligacao->query("SELECT id_genero, genero FROM genero ORDER BY genero");
$genero_options = "";
while ($g = $generos->fetch_assoc()) {
    $sel = intval($g["id_genero"]) === intval($disco["id_generoFK"]) ? " selected" : "";
    $label = htmlspecialchars($g["genero"], ENT_QUOTES);
    $genero_options .= "<option value='" . intval($g["id_genero"]) . "'{$sel}>{$label}</option>";
}
?>

<h2>Editar Disco</h2>

<fieldset>
    <legend><?= htmlspecialchars($disco["nome"]) ?></legend>
    <form action="index.php?opcao=editar_disco" method="POST">
        <input type="hidden" name="id" value="<?= intval($disco["id"]) ?>">

        <p><label>Nome:<br>
            <input type="text" name="nome" value="<?= htmlspecialchars($disco["nome"], ENT_QUOTES) ?>" required>
        </label></p>

        <p><label>Preço:<br>
            <input type="text" name="preco" value="<?= htmlspecialchars($disco["preco"], ENT_QUOTES) ?>" placeholder="0.00">
        </label></p>

        <p><label>Género:<br>
            <select name="id_genero"><?= $genero_options ?></select>
        </label></p>

        <button type="submit" name="guardar" value="1">Guardar alterações</button>
        <a href="index.php?opcao=discos" style="margin-left:1em">Cancelar</a>
    </form>
</fieldset>
