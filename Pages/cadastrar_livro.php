<?php
$conectar = mysql_connect('localhost','root','');
$banco    = mysql_select_db("livraria");

if (isset($_POST['gravar'])) {

    function salvarImagem($arquivo, $diretorio) {
        if ($arquivo['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
            $nome_final = md5(uniqid()) . '.' . $extensao;
            move_uploaded_file($arquivo['tmp_name'], $diretorio . $nome_final);
            return $nome_final;
        }
        return null;
    }

    $diretorio = "../Assets/img/";

    $codigo = $_POST['codigo'];
    $titulo = $_POST['titulo'];
    $numero_paginas = $_POST['numero_paginas'];
    $ano = $_POST['ano'];
    $codigo_autor = $_POST['codigo_autor'];
    $codigo_categoria = $_POST['codigo_categoria'];
    $codigo_editora = $_POST['codigo_editora'];
    $resenha = $_POST['resenha'];
    $tamanho = $_POST['tamanho'];
    $preco = $_POST['preco'];
    $nome_foto_capa = salvarImagem($_FILES['foto_capa'], $diretorio);
    $nome_foto_contracapa = salvarImagem($_FILES['foto_contracapa'], $diretorio);

    $sql = "INSERT INTO livro (codigo, titulo, numero_paginas ano, codigo_autor, codigo_categoria, codigo_editora, codigo_tipo, resenha, tamanho, preco, foto_capa, foto_contracapa)
            VALUES ('$codigo', '$titulo', '$numero_paginas', '$ano', '$codigo_autor', '$codigo_categoria', '$codigo_editora', '$codigo_tipo', '$resenha', '$tamanho', '$preco', '$nome_foto_capa', '$nome_foto_contracapa')";
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
    $titulo = $_POST['titulo'];
    $numero_paginas = $_POST['numero_paginas'];
    $ano = $_POST['ano'];
    $codigo_autor = $_POST['codigo_autor'];
    $codigo_categoria = $_POST['codigo_categoria'];
    $codigo_editora = $_POST['codigo_editora'];
    $resenha = $_POST['resenha'];
    $tamanho = $_POST['tamanho'];
    $preco = $_POST['preco'];
    $foto_capa = $_FILES['foto_capa'];
    $foto_contracapa = $_FILES['foto_contracapa'];

  $sql = "DELETE FROM livro WHERE codigo = '$codigo'";

  $resultado = mysql_query($sql);

  if ($resultado === TRUE)
  {
     echo 'Exclusão realizada com sucesso';
  }
  else
  {
     echo 'Erro ao excluir dados.';
  }
}

if (isset($_POST['alterar']))
{
    $codigo = $_POST['codigo'];
    $titulo = $_POST['titulo'];
    $numero_paginas = $_POST['numero_paginas'];
    $ano = $_POST['ano'];
    $codigo_autor = $_POST['codigo_autor'];
    $codigo_categoria = $_POST['codigo_categoria'];
    $codigo_editora = $_POST['codigo_editora'];
    $resenha = $_POST['resenha'];
    $tamanho = $_POST['tamanho'];
    $preco = $_POST['preco'];
    $foto_capa = $_FILES['foto_capa'];
    $foto_contracapa = $_FILES['foto_contracapa'];

    $sql = "UPDATE livro SET 
            titulo = '$titulo',
            numero_paginas = '$numero_paginas',
            ano = '$ano',
            codigo_autor = '$codigo_autor',
            codigo_categoria = '$codigo_categoria',
            codigo_editora = '$codigo_editora',
            resenha = '$resenha',
            tamanho = '$tamanho',
            preco = '$preco',
            foto_capa = '$foto_capa',
            foto_contracapa = '$foto_contracapa'
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
   $sql = mysql_query("SELECT codigo, descricao, cor, tamanho, preco, codigo_marca, codigo_categoria, codigo_tipo, foto_1, foto_2 FROM produto");
   
   if (mysql_num_rows($sql) == 0)
         {echo "Desculpe, mas sua pesquisa não retornou resultados.";}
   else
        {
        echo "<b>Produtos Cadastrados:</b><br><br>";
        while ($resultado = mysql_fetch_object($sql))
 	        {
                echo "Código          : " . $codigo . "<br>";
                echo "Título          : " . $titulo . "<br>";
                echo "Número de Páginas: " . $numero_paginas . "<br>";
                echo "Ano             : " . $ano . "<br>";
                echo "Autor (Código)  : " . $codigo_autor . "<br>";
                echo "Categoria (Código): " . $codigo_categoria . "<br>";
                echo "Editora (Código): " . $codigo_editora . "<br>";
                echo "Resenha         : " . nl2br($resenha) . "<br>";
                echo "Tamanho         : " . $tamanho . "<br>";
                echo "Preço           : R$ " . number_format($preco, 2, ',', '.') . "<br>";
                echo '<img src="../Assets/img/'.$resultado->foto_capa.'"height="200" width="200"/>'."  ";
                echo '<img src="../Assets/img/'.$resultado->foto_contracapa.'"height="200" width="200"/>'."  ";
            }
        }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro Livro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="formulario"> 
        <h1>Cadastrar Livros</h1>
        <form name="formulario" method="POST" action="cadastroproduto.php" enctype="multipart/form-data">
            <label>Codigo:</label>
            <input type="text" name="codigo" id="codigo" size="10">
            <br>
            <label>Título:</label>
            <input type="text" name="titulo" id="titulo" size="30">
            <br>
            <label>Número de Páginas:</label>
            <input type="text" name="numero_paginas" id="numero_paginas" size="10">
            <br>
            <label>Ano de lançamento:</label>
            <input type="text" name="ano" id="ano" size="10">
            <br>
            <label>Código Autor:</label>
            <input type="text" name="codigo_autor" id="codigo_autor" size="10">
            <br>
            <label>Código Categoria:</label>
            <input type="text" name="codigo_categoria" id="codigo_categoria" size="10">
            <br>
            <label>Código Editora:</label>
            <input type="text" name="codigo_editora" id="codigo_editora" size="10">
            <br>
            <label>Resenha:</label>
            <input type="text" name="resenha" id="resenha" size="50">
            <br>
            <label>Preço:</label>
            <input type="text" name="preco" id="preco" size="10">
            <br>
            <label>Preco:</label>
            <input type="text" name="preco" id="preco" size="30">
            <br>
            <label>Foto da Capa</label>
            <input type="file" name="foto_capa" id="foto_capa">
            <br>
            <label>Foto da Contracapa</label>
            <input type="file" name="foto_contracapa" id="foto_contracapa">
            <br>
            <input type="submit" name="gravar" value="Gravar">
            <input type="submit" name="excluir" value="Excluir">
            <input type="submit" name="alterar" value="Alterar">
            <input type="submit" name="pesquisar" value="Pesquisar">
        </form>
    </div>
</body>
</html>
