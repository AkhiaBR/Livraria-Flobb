<?php
// Configurações de login
header('Content-Type: text/html; charset=utf-8');

// Verificar se o formulário foi enviado
if (isset($_POST['Login'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    
    // Aqui você pode definir usuário e senha fixos ou conectar ao banco
    $usuario_correto = "admin";
    $senha_correta = "123456";
    
    if ($login == $usuario_correto && $senha == $senha_correta) {
        // Login correto - redirecionar para menu
        header("Location: menu.php");
        exit();
    } else {
        $erro = "Login ou senha incorretos!";
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
        
        <div class="info-login">
            <p><strong>Dados de acesso:</strong></p>
            <p>Login: admin</p>
            <p>Senha: 123456</p>
        </div>
    </div>
</body>
</html>