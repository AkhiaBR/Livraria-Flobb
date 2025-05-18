<?php
// Conexão com o servidor e banco: 
$conectar = mysql_connect('localhost','root','');
$banco    = mysql_select_db("livraria");

if (isset($_POST['gravar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];

    $sql = "INSERT INTO autor (codigo, nome, pais)
            VALUES ('$codigo', '$nome', '$pais')";
    $resultado = mysql_query($sql);

    if ($resultado) {
        echo "Dados informados cadastrados com sucesso.";
    } else {
        echo "Falha ao gravar os dados informados.";
    }
}

if (isset($_POST['excluir']))
{
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $pais = $_POST['pais'];

    $sql = "DELETE FROM autor WHERE codigo = '$codigo'";

    $resultado = mysql_query($sql);

    if ($resultado === TRUE)
    {
        echo 'Exclusão realizada com Sucesso';
    }
    else
    {
        echo 'Erro ao excluir dados.';
    }
}

if (isset($_POST['alterar']))
{
   $codigo = $_POST['codigo'];
   $nome = $_POST['nome'];
   $pais = $_POST['pais'];

   $sql = "UPDATE autor SET nome='$nome', pais='$pais'
            WHERE codigo = '$codigo'";
   $resultado = mysql_query($sql);

  if ($resultado === TRUE)
  {
     echo 'Dados alterados com Sucesso';
  }
  else
  {
     echo 'Erro ao alterar dados.';
  }
}

if (isset($_POST['pesquisar']))
{
   $sql = mysql_query("SELECT codigo, nome, pais FROM autor");
   
   if (mysql_num_rows($sql) == 0)
         {echo "Desculpe, mas sua pesquisa não retornou resultados.";}
   else
        {
        echo "<b>Autores Cadastrados:</b><br><br>";
        while ($resultado = mysql_fetch_object($sql))
 	        {
                echo "Codigo: ".$resultado->codigo." "."<br>";
                echo "Nome: ".$resultado->nome." "."<br>";
                echo "País: ".$resultado->pais." "."<br>";
            }
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
    <div class="formulario_cadastro_db"> 
        <h1>Cadastrar Autores</h1>
        <form name="formulario_cadastro_db" method="POST" action="cadastrar_autor.php" enctype="multipart/form-data">
            <label>Codigo:</label>
            <input type="text" name="codigo" id="codigo" size="10">
            <label>Nome:</label>
            <input type="text" name="nome" id="nome" size="10">
            <label>País:</label>
            <input type="text" name="pais" id="pais" size="10">
            <input type="submit" name="gravar" value="Gravar">
            <input type="submit" name="excluir" value="Excluir">
            <input type="submit" name="alterar" value="Alterar">
            <input type="submit" name="pesquisar" value="Pesquisar">
        </form>
    </div>
</body>
</html>