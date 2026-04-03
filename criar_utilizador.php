
<fieldset> <legend>Criar conta:</legend>
<form action="criar_utilizador.php" method="post">
    
    <p>Username: <input type="text" name="login">
    </p>
    <p>E-mail: <input type="email" name="email">
    </p>
    <p>Password: <input type="password" name="password">
    </p>
    <p>
    <button>Criar</button>
    </p>
</form>
</fieldset>

<?php

if (!empty($_POST["login"]))  
{
   
    $ligacao = new mysqli("localhost","root","","records");

    $login = $_POST["login"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);


    $stmt = $ligacao->prepare("INSERT INTO utilizadores(login, email, password) VALUES(?, ?, ?)");
    $stmt->bind_param("sss", $login, $email, $password);
    $stmt->execute();
    $stmt->close();
    $ligacao->close();
   
    echo "Conta Criada com Sucesso!";
    echo '<br><br><a href="login.php">Fazer login</a>';
}

?>
