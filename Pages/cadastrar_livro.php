<?php

header('Content-Type: text/html; charset=utf-8');
$conectar = mysql_connect('localhost','root','');
mysql_query("SET NAMES 'utf8'");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_results=utf8");
$banco = mysql_select_db("livraria");

// Função para salvar imagens: (fora das condicionais para não ser repetida)
function salvarImagem($arquivo, $diretorio) {
    if ($arquivo['error'] === UPLOAD_ERR_OK) {
        // Verifica se o diretório existe, se não, cria outro:
        if (!file_exists($diretorio) && !is_dir($diretorio)) {
            mkdir($diretorio, 0755, true);
        }
        
        // Verifica extensões permitidas
        $extensoes_permitidas = array('jpg', 'jpeg', 'png', 'gif');
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        
        if (in_array($extensao, $extensoes_permitidas)) {
            $nome_final = md5(uniqid()) . '.' . $extensao;
            $caminho_completo = $diretorio . $nome_final;
            
            if (move_uploaded_file($arquivo['tmp_name'], $caminho_completo)) {
                return $nome_final;
            }
        }
    }
    return null;
}

if (isset($_POST['gravar'])) {
    $diretorio = "../Assets/img/";

    $codigo = $_POST['codigo'];
    $titulo = $_POST['titulo'];
    $numero_paginas = $_POST['numero_paginas'];
    $ano = $_POST['ano'];
    $codigo_autor = $_POST['codigo_autor'];
    $codigo_categoria = $_POST['codigo_categoria'];
    $codigo_editora = $_POST['codigo_editora'];
    $resenha = $_POST['resenha'];
    $preco = $_POST['preco'];
    
    // Tratamento das imagens
    $nome_foto_capa = salvarImagem($_FILES['foto_capa'], $diretorio);
    $nome_foto_contracapa = salvarImagem($_FILES['foto_contracapa'], $diretorio);
    
    // Se não houver imagens, usar strings vaziasa
    $nome_foto_capa = $nome_foto_capa ?: '';
    $nome_foto_contracapa = $nome_foto_contracapa ?: '';

    $sql = "INSERT INTO livro (codigo, titulo, numero_paginas, ano, codigo_autor, codigo_categoria, codigo_editora, resenha, preco, foto_capa, foto_contracapa)
            VALUES ('$codigo', '$titulo', '$numero_paginas', '$ano', '$codigo_autor', '$codigo_categoria', '$codigo_editora', '$resenha', '$preco', '$nome_foto_capa', '$nome_foto_contracapa')";
    $resultado = mysql_query($sql);

    if ($resultado) {
        echo "<p class='mensagem sucesso'>Livro cadastrado com sucesso.</p>";
    } else {
        echo "<p class='mensagem erro'>Falha ao gravar os dados do livro: " . mysql_error() . "</p>";
    }
}

if (isset($_POST['excluir']))
{
    $codigo = $_POST['codigo'];

    // Verificar se o código existe antes de excluir
    $verificar = mysql_query("SELECT * FROM livro WHERE codigo = '$codigo'");
    if (mysql_num_rows($verificar) > 0) {
        $sql = "DELETE FROM livro WHERE codigo = '$codigo'";
        $resultado = mysql_query($sql);

        if ($resultado === TRUE) {
            echo "<p class='mensagem sucesso'>Livro excluído com sucesso.</p>";
        } else {
            echo "<p class='mensagem erro'>Erro ao excluir livro: " . mysql_error() . "</p>";
        }
    } else {
        echo "<p class='mensagem erro'>Código de livro não encontrado.</p>";
    }
}

if (isset($_POST['alterar']))
{
    $diretorio = "../Assets/img/";
    
    $codigo = $_POST['codigo'];
    $titulo = $_POST['titulo'];
    $numero_paginas = $_POST['numero_paginas'];
    $ano = $_POST['ano'];
    $codigo_autor = $_POST['codigo_autor'];
    $codigo_categoria = $_POST['codigo_categoria'];
    $codigo_editora = $_POST['codigo_editora'];
    $resenha = $_POST['resenha'];
    $preco = $_POST['preco'];
    
    // Verificar se o livro existe
    $verificar = mysql_query("SELECT * FROM livro WHERE codigo = '$codigo'");
    if (mysql_num_rows($verificar) > 0) {
        // Obter dados atuais do livro
        $dados_atuais = mysql_fetch_assoc($verificar);
        
        // Tratamento das imagens
        $nome_foto_capa = $dados_atuais['foto_capa'];
        $nome_foto_contracapa = $dados_atuais['foto_contracapa'];
        
        // Verifica se foram enviadas novas imagens
        if ($_FILES['foto_capa']['size'] > 0) {
            $nova_foto_capa = salvarImagem($_FILES['foto_capa'], $diretorio);
            if ($nova_foto_capa) {
                $nome_foto_capa = $nova_foto_capa;
            }
        }
        
        if ($_FILES['foto_contracapa']['size'] > 0) {
            $nova_foto_contracapa = salvarImagem($_FILES['foto_contracapa'], $diretorio);
            if ($nova_foto_contracapa) {
                $nome_foto_contracapa = $nova_foto_contracapa;
            }
        }

        $sql = "UPDATE livro SET 
                titulo = '$titulo',
                numero_paginas = '$numero_paginas',
                ano = '$ano',
                codigo_autor = '$codigo_autor',
                codigo_categoria = '$codigo_categoria',
                codigo_editora = '$codigo_editora',
                resenha = '$resenha',
                preco = '$preco',
                foto_capa = '$nome_foto_capa',
                foto_contracapa = '$nome_foto_contracapa'
                WHERE codigo = '$codigo'";
        $resultado = mysql_query($sql);

        if ($resultado === TRUE) {
            echo "<p class='mensagem sucesso'>Dados do livro alterados com sucesso.</p>";
        } else {
            echo "<p class='mensagem erro'>Erro ao alterar dados do livro: " . mysql_error() . "</p>";
        }
    } else {
        echo "<p class='mensagem erro'>Código de livro não encontrado.</p>";
    }
}

if (isset($_POST['pesquisar']))
{
   $sql = mysql_query("SELECT l.*, a.nome AS nome_autor, c.nome AS nome_categoria, e.nome AS nome_editora 
                      FROM livro l
                      LEFT JOIN autor a ON l.codigo_autor = a.codigo
                      LEFT JOIN categoria c ON l.codigo_categoria = c.codigo
                      LEFT JOIN editora e ON l.codigo_editora = e.codigo");
   
   if (mysql_num_rows($sql) == 0) {
        echo "<p class='mensagem info'>Nenhum livro cadastrado.</p>";
   } else {
        echo "<div class='resultados'>";
        echo "<h2>Livros Cadastrados</h2>";
        while ($resultado = mysql_fetch_object($sql)) {
            echo "<div class='livro'>";
            echo "<h3>" . $resultado->titulo . "</h3>";
            echo "<p><strong>Código:</strong> " . $resultado->codigo . "</p>";
            echo "<p><strong>Número de Páginas:</strong> " . $resultado->numero_paginas . "</p>";
            echo "<p><strong>Ano:</strong> " . $resultado->ano . "</p>";
            echo "<p><strong>Autor:</strong> " . $resultado->nome_autor . " (Código: " . $resultado->codigo_autor . ")</p>";
            echo "<p><strong>Categoria:</strong> " . $resultado->nome_categoria . " (Código: " . $resultado->codigo_categoria . ")</p>";
            echo "<p><strong>Editora:</strong> " . $resultado->nome_editora . " (Código: " . $resultado->codigo_editora . ")</p>";
            echo "<p><strong>Resenha:</strong> " . nl2br($resultado->resenha) . "</p>";
            echo "<p><strong>Preço:</strong> R$ " . number_format($resultado->preco, 2, ',', '.') . "</p>";
            
            if ($resultado->foto_capa) {
                echo "<div class='imagens'>";
                echo "<div class='imagem'>";
                echo "<p>Capa:</p>";
                echo "<img src='../Assets/img/" . $resultado->foto_capa . "' height='200' width='150' alt='Capa do livro'/>";
                echo "</div>";
                
                if ($resultado->foto_contracapa) {
                    echo "<div class='imagem'>";
                    echo "<p>Contracapa:</p>";
                    echo "<img src='../Assets/img/" . $resultado->foto_contracapa . "' height='200' width='150' alt='Contracapa do livro'/>";
                    echo "</div>";
                }
                echo "</div>";
            }
            echo "</div>";
        }
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Livro</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Assets/css/styles.css">
</head>
<body>
    <div id="formulario"> 
        <h1>Cadastrar Livros</h1>
        <form name="formulario" method="POST" action="cadastrar_livro.php" enctype="multipart/form-data">
            <label for="codigo">Código:</label>
            <input type="text" name="codigo" id="codigo" size="10">
            
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" size="50">
            
            <label for="numero_paginas">Número de Páginas:</label>
            <input type="text" name="numero_paginas" id="numero_paginas" size="10">
            
            <label for="ano">Ano de lançamento:</label>
            <input type="text" name="ano" id="ano" size="10">
            
            <label for="codigo_autor">Código Autor:</label>
            <input type="text" name="codigo_autor" id="codigo_autor" size="10">
            
            <label for="codigo_categoria">Código Categoria:</label>
            <input type="text" name="codigo_categoria" id="codigo_categoria" size="10">
            
            <label for="codigo_editora">Código Editora:</label>
            <input type="text" name="codigo_editora" id="codigo_editora" size="10">
            
            <label for="resenha">Resenha:</label>
            <textarea name="resenha" id="resenha" rows="5" cols="50"></textarea>
            
            <label for="preco">Preço:</label>
            <input type="text" name="preco" id="preco" size="10">
            
            <label for="foto_capa">Foto da Capa:</label>
            <input type="file" name="foto_capa" id="foto_capa">
            
            <label for="foto_contracapa">Foto da Contracapa:</label>
            <input type="file" name="foto_contracapa" id="foto_contracapa">
            
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