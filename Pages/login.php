<?php
header('Content-Type: text/html; charset=utf-8');
$conectar = mysql_connect('localhost','root','');
mysql_query("SET NAMES 'utf8'");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_results=utf8");
$banco = mysql_select_db("livraria");

if (isset($_POST['Login'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $sql = "select * from livraria.usuario where login = '$login' and senha = '$senha'";

    $resultado = mysql_query($sql);
        
    if (mysql_num_rows($resultado)<=0) {
        echo "<script language='javascript' type='text/javascript'>
                alert('Login e/ou senha incorretos');
                window.location.href='pagina_login.html';
            </script>";
    }
    else {
        setcookie('login',$login);
        header('Location:menu.php');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página de Login</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Assets/css/styles.css">
</head>
<body>
    <div id="formulario">
        <h1>Faça seu login</h1>
        
        <?php if (isset($erro)): ?>
            <p class="mensagem erro"><?php echo $erro; ?></p>
        <?php endif; ?>
        
        <form name="formulario" method="POST" action="login.php">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" size="20" required>
            
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" size="20" required>
            
            <div class="botoes">
                <input type="submit" name="Login" value="Entrar">
            </div>
        </form>
    </div>
</body>
</html>