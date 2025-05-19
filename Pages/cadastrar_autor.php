<?php
// Cadastrar Autor
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
    $pais = $_POST['pais'];

    $sql = "INSERT INTO autor (codigo, nome, pais)
            VALUES ('$codigo', '$nome', '$pais')";
    $resultado = mysql_query($sql);

    if ($resultado) {
        echo "<p class='mensagem sucesso'>Autor cadastrado com sucesso.</p>";
    } else {
        echo "<p class='mensagem erro'>Falha ao gravar os dados do autor: " . mysql_error() . "</p>";
    }
}

if (isset($_POST['excluir']))
{
    $codigo = $_POST['codigo'];

    // Verificar se o código existe antes de excluir
    $verificar = mysql_query("SELECT * FROM autor WHERE codigo = '$codigo'");
    if (mysql_num_rows($verificar) > 0) {
        $sql = "DELETE FROM autor WHERE codigo = '$codigo'";
        $resultado = mysql_query($sql);

        if ($resultado === TRUE) {
            echo "<p class='mensagem sucesso'>Autor excluído com sucesso.</p>";
        } else {
            echo "<p class='mensagem erro'>Erro ao excluir autor: " . mysql_error() . "</p>";
        }
    } else {
        echo "<p class='mensagem erro'>Código de autor não encontrado.</p>";
    }
}

if (isset($_POST['alterar']))
{
   $codigo = $_POST['codigo'];
   $nome = $_POST['nome'];
   $pais = $_POST['pais'];

   // Verificar se o código existe antes de alterar
   $verificar = mysql_query("SELECT * FROM autor WHERE codigo = '$codigo'");
   if (mysql_num_rows($verificar) > 0) {
       $sql = "UPDATE autor SET nome='$nome', pais='$pais' WHERE codigo = '$codigo'";
       $resultado = mysql_query($sql);

       if ($resultado === TRUE) {
          echo "<p class='mensagem sucesso'>Dados do autor alterados com sucesso.</p>";
       } else {
          echo "<p class='mensagem erro'>Erro ao alterar dados do autor: " . mysql_error() . "</p>";
       }
   } else {
       echo "<p class='mensagem erro'>Código de autor não encontrado.</p>";
   }
}

if (isset($_POST['pesquisar']))
{
   $sql = mysql_query("SELECT codigo, nome, pais FROM autor");
   
   if (mysql_num_rows($sql) == 0) {
        echo "<p class='mensagem info'>Nenhum autor cadastrado.</p>";
   } else {
        echo "<div class='resultados'>";
        echo "<h2>Autores Cadastrados</h2>";
        while ($resultado = mysql_fetch_object($sql)) {
            echo "<div class='item'>";
            echo "<p><strong>Código:</strong> " . $resultado->codigo . "</p>";
            echo "<p><strong>Nome:</strong> " . $resultado->nome . "</p>";
            echo "<p><strong>País:</strong> " . $resultado->pais . "</p>";
            echo "</div>";
        }
        echo "</div>";
   }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Autores</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Assets/css/styles.css">
</head>
<body>
    <div id="formulario"> 
        <h1>Cadastrar Autores</h1>
        <form name="formulario" method="POST" action="cadastrar_autor.php" enctype="multipart/form-data">
            <label for="codigo">Código:</label>
            <input type="text" name="codigo" id="codigo" size="10">
            
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" size="50">
            
            <label for="pais">País:</label>
            <input type="text" name="pais" id="pais" size="30">
            
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