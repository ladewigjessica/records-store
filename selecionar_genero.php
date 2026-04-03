<style>
    body{color:black}
</style>
<?php


    $ligacao = new mysqli("localhost","root","","records");
    
    $result=$ligacao->query("select * from genero");
   
    echo "Genero: <select name='id_genero'>";
    while( $linha = $result->fetch_array())
    {
      
        $id=$linha["id_genero"];
        $genero=$linha["genero"];
        echo"<option value= '$id'>$genero</option>";

    }

    echo "</select>";
?>