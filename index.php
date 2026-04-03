
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records Store</title>
    <link rel="stylesheet" href="estilo.css">
    
</head>
<title>Records Store</title>
<div class="hero">
    <h1>Records Store</h1>
</div>
 

<body>
    
    <br>
    <h2>
        <?php
        if(!empty($_SESSION["username"]))
        echo "Bem vindo(a) ".$_SESSION["username"];
        ?>

    </h2>
    <header>
        <nav>
            <a href="index.php?opcao=discos">Discos</a>
            <?php
            $total_carrinho = 0;
            if (!empty($_SESSION["carrinho"]))
                foreach ($_SESSION["carrinho"] as $item)
                    $total_carrinho += $item["quantidade"];
            echo "<a href='index.php?opcao=carrinho'>Carrinho ({$total_carrinho})</a>";

            if (!empty($_SESSION["username"])) {
                echo '<a href="index.php?opcao=alterar_password">Alterar Password</a>';
                echo '<a href="index.php?opcao=logout">Logout</a>';
            } else {
                echo '<a href="index.php?opcao=login">Login</a>';
            }
            ?>
        </nav>

        <?php if (!empty($_SESSION["username"]) && $_SESSION["admin"] == 1): ?>
        <nav class="nav-admin">
            <a href="index.php?opcao=inserir_discos">Inserir Discos</a>
            <a href="index.php?opcao=inserir_genero">Inserir Genero</a>
        </nav>
        <?php endif; ?>
    </header>
    <main style="background:none; padding:0; margin:0 auto;">
        <?php
            $opcoes_validas = ["discos", "disco_detalhe", "login", "logout", "inserir_discos", "inserir_genero", "adicionar_carrinho", "carrinho", "alterar_password", "editar_disco"];
            $opcao = !empty($_GET["opcao"]) ? $_GET["opcao"] : "discos";
            if (in_array($opcao, $opcoes_validas))
                include "$opcao.php";
        ?>
    </main>

   

</body>