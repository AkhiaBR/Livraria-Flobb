<?php
// Cadastrar Editora
header('Content-Type: text/html; charset=utf-8');
$conectar = mysql_connect('localhost','root','');
mysql_query("SET NAMES 'utf8'");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_results=utf8");
$banco = mysql_select_db("livraria");

if (isset($_POST['gravar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    $sql = "INSERT INTO editora (codigo, nome)
            VALUES ('$codigo', '$nome')";
    $resultado = mysql_query($sql);

    if ($resultado) {
        echo "<p class='mensagem sucesso'>Editora cadastrada com sucesso.</p>";
    } else {
        echo "<p class='mensagem erro'>Falha ao gravar os dados da editora: " . mysql_error() . "</p>";
    }
}

if (isset($_POST['excluir']))
{
    $codigo = $_POST['codigo'];

    // Verificar se o código existe antes de excluir
    $verificar = mysql_query("SELECT * FROM editora WHERE codigo = '$codigo'");
    if (mysql_num_rows($verificar) > 0) {
        $sql = "DELETE FROM editora WHERE codigo = '$codigo'";
        $resultado = mysql_query($sql);

        if ($resultado === TRUE) {
            echo "<p class='mensagem sucesso'>Editora excluída com sucesso.</p>";
        } else {
            echo "<p class='mensagem erro'>Erro ao excluir editora: " . mysql_error() . "</p>";
        }
    } else {
        echo "<p class='mensagem erro'>Código de editora não encontrado.</p>";
    }
}

if (isset($_POST['alterar']))
{
   $codigo = $_POST['codigo'];
   $nome = $_POST['nome'];

   // Verificar se o código existe antes de alterar
   $verificar = mysql_query("SELECT * FROM editora WHERE codigo = '$codigo'");
   if (mysql_num_rows($verificar) > 0) {
       $sql = "UPDATE editora SET nome='$nome' WHERE codigo = '$codigo'";
       $resultado = mysql_query($sql);

       if ($resultado === TRUE) {
          echo "<p class='mensagem sucesso'>Dados da editora alterados com sucesso.</p>";
       } else {
          echo "<p class='mensagem erro'>Erro ao alterar dados da editora: " . mysql_error() . "</p>";
       }
   } else {
       echo "<p class='mensagem erro'>Código de editora não encontrado.</p>";
   }
}

if (isset($_POST['pesquisar']))
{
   $sql = mysql_query("SELECT codigo, nome FROM editora");
   
   if (mysql_num_rows($sql) == 0) {
        echo "<p class='mensagem info'>Nenhuma editora cadastrada.</p>";
   } else {
        echo "<div class='resultados'>";
        echo "<h2>Editoras Cadastradas</h2>";
        while ($resultado = mysql_fetch_object($sql)) {
            echo "<div class='item'>";
            echo "<p><strong>Código:</strong> " . $resultado->codigo . "</p>";
            echo "<p><strong>Nome:</strong> " . $resultado->nome . "</p>";
            echo "</div>";
        }
        echo "</div>";
   }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Editoras</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Assets/css/styles.css">
</head>
<body>
    <div id="formulario"> 
        <h1>Cadastrar Editoras</h1>
        <form name="formulario" method="POST" action="cadastrar_editora.php" enctype="multipart/form-data">
            <label for="codigo">Código:</label>
            <input type="text" name="codigo" id="codigo" size="10">
            
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" size="50">
            
            <div class="botoes">
                <input type="submit" name="gravar" value="Gravar">
                <input type="submit" name="excluir" value="Excluir">
                <input type="submit" name="alterar" value="Alterar">
                <input type="submit" name="pesquisar" value="Pesquisar">
            </div>
        </form>
    </div>
</body>
</html>