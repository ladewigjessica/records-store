<?php
if (empty($_SESSION["username"])) {
    header("location:index.php");
    exit;
}

$erro    = "";
$sucesso = "";

if (!empty($_POST["alterar"])) {
    $atual    = $_POST["password_atual"];
    $nova     = $_POST["password_nova"];
    $confirma = $_POST["password_confirma"];

    if ($nova !== $confirma) {
        $erro = "A nova password e a confirmação não coincidem.";
    } else {
        include("config.php");
        $stmt = $ligacao->prepare("SELECT password FROM utilizadores WHERE login = ?");
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$row || !password_verify($atual, $row["password"])) {
            $erro = "Password atual incorreta.";
        } else {
            $hash = password_hash($nova, PASSWORD_DEFAULT);
            $stmt = $ligacao->prepare("UPDATE utilizadores SET password = ? WHERE login = ?");
            $stmt->bind_param("ss", $hash, $_SESSION["username"]);
            $stmt->execute();
            $stmt->close();
            $sucesso = "Password alterada com sucesso.";
        }
    }
}
?>

<h2>Alterar Password</h2>

<?php if ($erro):   ?><p style="color:red"><?= htmlspecialchars($erro) ?></p><?php endif; ?>
<?php if ($sucesso): ?><p style="color:green"><?= htmlspecialchars($sucesso) ?></p><?php endif; ?>

<form action="index.php?opcao=alterar_password" method="POST">
    <p><label>Password atual:<br><input type="password" name="password_atual" required></label></p>
    <p><label>Nova password:<br><input type="password" name="password_nova" required></label></p>
    <p><label>Confirmar nova password:<br><input type="password" name="password_confirma" required></label></p>
    <button type="submit" name="alterar" value="1">Alterar password</button>
</form>
