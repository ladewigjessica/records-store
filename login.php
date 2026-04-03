<fieldset> <legend>Login:</legend>
<form action="index.php?opcao=login" method="post">
    
    <p>Username: <input type="text" name="login">
    </p>
    <p>Password: <input type="password" name="password">
    </p>
    <p> <a href= "criar_utilizador.php">Criar conta</a> </p>
    <p>
    <button>Entrar</button>
    </p>
</form>
</fieldset>

<?php
if(!empty($_POST["login"]))
    {
        include("config.php");
        $login=$_POST["login"];
        $password = $_POST["password"];
        $stmt = $ligacao->prepare("SELECT * FROM utilizadores WHERE login = ?");
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($utilizador = $resultado->fetch_assoc()) 
        {
            if (password_verify($password, $utilizador["password"]))
            {
                $_SESSION["userid"] = $utilizador["id"];
                $_SESSION["username"] = $utilizador["login"];
                $_SESSION["admin"] = $utilizador["admin"];
                $redirect = !empty($_SESSION["redirect_after_login"]) ? $_SESSION["redirect_after_login"] : "index.php";
                unset($_SESSION["redirect_after_login"]);
                header("location: " . $redirect);
                exit();
            }
            else 
            {
                echo "<p>Credenciais incorretas</p>";
            }
        }
        else 
        {
            echo "<p>Credenciais incorretas</p>";
        }
    }
?>