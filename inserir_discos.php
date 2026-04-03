<?php
    if(!empty($_SESSION["username"]) && $_SESSION["admin"]==1) 
    {
        
    }   
    else
    {
        header("location:index.php");
    }  

?>
<fieldset>
    <legend>Novo Disco:</legend>
<form action= "index.php?opcao=inserir_discos"  method="POST" enctype="multipart/form-data">
    <p>Nome: <input type="text" name="nome" required></p>
    <p>Preço: <input type="text" name="preco" placeholder="0.00"></p>
    <p>Imagem: <input type="file" name="imagem"></p>
    <p><?php include("selecionar_genero.php"); ?></p>
    <button>Adicionar</button>
</form>
</fieldset>

<?php

if(!empty($_POST["nome"]))
{
    echo "Novo Disco Carregado com Sucesso ";
   
    echo "<br><br>";

    $ligacao = new mysqli("localhost","root","","records");

    $nome = $_POST["nome"];
    $preco = $_POST["preco"];
    $id_genero = $_POST["id_genero"];
    $imagem = "imagens/".$_FILES["imagem"]["name"];

    $stmt = $ligacao->prepare("INSERT INTO discos(nome, preco, id_generoFK, imagem) VALUES(?, ?, ?, ?)");
    $stmt->bind_param("sdis", $nome, $preco, $id_genero, $imagem);
    $stmt->execute();
    $stmt->close();
    $ligacao->close();
 
} 

?>