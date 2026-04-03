<?php
    if(!empty($_SESSION["username"]) && $_SESSION["admin"]==1) 
    {
        
    }   
    else
    {
        header("location:index.php");
    }  

?>
<fieldset> <legend> Novo gênero: </legend> 
<form method="POST">
   
    <input type="text" name="genero">
    <button>adicionar</button>
</form>
</fieldset>

<?php

if (!empty($_POST["genero"]))  
{
   $ligacao = new mysqli("localhost","root","","records");

   $genero = $_POST["genero"];

   $stmt = $ligacao->prepare("INSERT INTO genero(genero) VALUES(?)");
   $stmt->bind_param("s", $genero);
   $stmt->execute();
   $stmt->close();
   
   $ligacao->close();
}
?>