<?php
header('Content-Type: text/html; charset=utf-8');

// Conecta ao banco de dados
$conectar = mysql_connect('localhost','root','');
if (!$conectar) {
    die('Erro na conexão: ' . mysql_error());
}

mysql_query("SET NAMES 'utf8'");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_results=utf8");

$banco = mysql_select_db("livraria");
if (!$banco) {
    die('Erro ao selecionar banco: ' . mysql_error());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livraria Flobb - Sua Livraria Online</title>
    <link rel="stylesheet" href="Assets/css/styles.css">
</head>
<body>
    <!-- Header -->
    <header class="header-home">
        <div class="header-container">
            <div class="logo">
                <h1>📚 Livraria Flobb</h1>
            </div>
            <nav class="header-nav">
                <a href="cadastrar_livro.php" class="btn-login">🔐 Área Administrativa</a>
            </nav>
        </div>
    </header>

    <!-- Banner -->
    <section class="banner">
        <div class="banner-content">
            <h2>Bem-vindo à Livraria Flobb</h2>
            <p>Descubra um mundo de conhecimento e aventuras. Encontre os melhores livros, das mais variadas categorias e autores renomados.</p>
        </div>
    </section>

    <!-- Container Principal -->
    <div class="container-home">
        <!-- Filtros -->
        <section class="filtros">
            <h3>🔍 Encontre seu Livro Ideal</h3>
            <form name="filtros" method="post" action="">
                <div>
                    <label for="autor">Autor:</label>
                    <select name="autor" id="autor">
                        <option value="">Todos os Autores</option>
                        <?php
                            $query_autores = mysql_query("SELECT codigo, nome FROM autor ORDER BY nome");
                            while ($autor = mysql_fetch_array($query_autores)) {
                                $selected = (isset($_POST['autor']) && $_POST['autor'] == $autor['codigo']) ? 'selected' : '';
                                echo '<option value="' . $autor['codigo'] . '" ' . $selected . '>' . $autor['nome'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                
                <div>
                    <label for="categoria">Categoria:</label>
                    <select name="categoria" id="categoria">
                        <option value="">Todas as Categorias</option>
                        <?php
                            $query_categorias = mysql_query("SELECT codigo, nome FROM categoria ORDER BY nome");
                            while ($categoria = mysql_fetch_array($query_categorias)) {
                                $selected = (isset($_POST['categoria']) && $_POST['categoria'] == $categoria['codigo']) ? 'selected' : '';
                                echo '<option value="' . $categoria['codigo'] . '" ' . $selected . '>' . $categoria['nome'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                
                <div>
                    <label for="editora">Editora:</label>
                    <select name="editora" id="editora">
                        <option value="">Todas as Editoras</option>
                        <?php
                            $query_editoras = mysql_query("SELECT codigo, nome FROM editora ORDER BY nome");
                            while ($editora = mysql_fetch_array($query_editoras)) {
                                $selected = (isset($_POST['editora']) && $_POST['editora'] == $editora['codigo']) ? 'selected' : '';
                                echo '<option value="' . $editora['codigo'] . '" ' . $selected . '>' . $editora['nome'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                
                <div>
                    <input type="submit" name="pesquisar" value="Pesquisar" class="btn-pesquisar">
                </div>
            </form>
        </section>

        <!-- Resultados -->
        <section class="resultados-section">
            <?php
            // Inicializa variáveis de filtro
            $autor_filtro = null;
            $categoria_filtro = null;
            $editora_filtro = null;

            // Define filtros se a pesquisa foi realizada
            if (isset($_POST['pesquisar'])) {
                $autor_filtro = !empty($_POST['autor']) ? $_POST['autor'] : null;
                $categoria_filtro = !empty($_POST['categoria']) ? $_POST['categoria'] : null;
                $editora_filtro = !empty($_POST['editora']) ? $_POST['editora'] : null;
            }

            // Monta a query SQL
            $sql = "SELECT 
                        l.codigo, l.titulo, l.numero_paginas, l.ano, l.resenha, l.preco, 
                        l.foto_capa, l.foto_contracapa,
                        a.nome AS nome_autor, 
                        c.nome AS nome_categoria, 
                        e.nome AS nome_editora
                    FROM 
                        livro l
                        LEFT JOIN autor a ON l.codigo_autor = a.codigo
                        LEFT JOIN categoria c ON l.codigo_categoria = c.codigo
                        LEFT JOIN editora e ON l.codigo_editora = e.codigo
                    WHERE 1=1";

            // Adiciona filtros à query
            if ($autor_filtro) {
                $sql .= " AND l.codigo_autor = '$autor_filtro'";
            }
            if ($categoria_filtro) {
                $sql .= " AND l.codigo_categoria = '$categoria_filtro'";
            }
            if ($editora_filtro) {
                $sql .= " AND l.codigo_editora = '$editora_filtro'";
            }

            $sql .= " ORDER BY l.titulo";

            $resultado = mysql_query($sql);

            // Verifica se há resultados
            if (mysql_num_rows($resultado) > 0) {
                // Mensagem diferente dependendo se houve filtro
                if (isset($_POST['pesquisar'])) {
                    echo "<h2>📖 Resultados da Pesquisa</h2>";
                } else {
                    echo "<h2>📚 Nosso Catálogo de Livros</h2>";
                }

                echo '<div class="livros-grid">';

                while ($livro = mysql_fetch_assoc($resultado)) {
                    echo '<div class="livro-card">';
                    
                    // Imagens do livro
                    echo '<div class="livro-imagens">';
                    if ($livro['foto_capa']) {
                        echo '<img src="Assets/img/' . $livro['foto_capa'] . '" alt="Capa - ' . htmlspecialchars($livro['titulo']) . '" />';
                    } else {
                        echo '<div style="width: 50%; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #888;">Sem Capa</div>';
                    }
                    
                    if ($livro['foto_contracapa']) {
                        echo '<img src="Assets/img/' . $livro['foto_contracapa'] . '" alt="Contracapa - ' . htmlspecialchars($livro['titulo']) . '" />';
                    } else {
                        echo '<div style="width: 50%; background-color: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #888;">Sem Contracapa</div>';
                    }
                    echo '</div>';
                    
                    // Informações do livro
                    echo '<div class="livro-info">';
                    echo '<h3>' . htmlspecialchars($livro['titulo']) . '</h3>';
                    
                    echo '<div class="livro-detalhes">';
                    echo '<p><strong>Autor:</strong> ' . htmlspecialchars($livro['nome_autor']) . '</p>';
                    echo '<p><strong>Categoria:</strong> ' . htmlspecialchars($livro['nome_categoria']) . ' | <strong>Editora:</strong> ' . htmlspecialchars($livro['nome_editora']) . '</p>';
                    echo '<p><strong>Páginas:</strong> ' . $livro['numero_paginas'] . ' | <strong>Ano:</strong> ' . $livro['ano'] . '</p>';
                    echo '</div>';
                    
                    // Resenha (limitada)
                    if ($livro['resenha']) {
                        $resenha_resumida = strlen($livro['resenha']) > 150 ? 
                            substr($livro['resenha'], 0, 150) . '...' : $livro['resenha'];
                        echo '<div class="livro-resenha">';
                        echo htmlspecialchars($resenha_resumida);
                        echo '</div>';
                    }
                    
                    // Preço
                    echo '<div class="preco">';
                    echo 'R$ ' . number_format($livro['preco'], 2, ',', '.');
                    echo '</div>';
                    
                    echo '</div>'; // fim livro-info
                    echo '</div>'; // fim livro-card
                }

                echo '</div>'; // fim livros-grid
            } else {
                if (isset($_POST['pesquisar'])) {
                    echo '<div class="mensagem info">';
                    echo '<h2>😔 Nenhum livro encontrado</h2>';
                    echo '<p>Não encontramos livros com os filtros selecionados. Tente uma nova busca!</p>';
                    echo '</div>';
                } else {
                    echo '<div class="mensagem info">';
                    echo '<h2>📚 Catálogo em Construção</h2>';
                    echo '<p>Nosso catálogo está sendo preparado com muito carinho. Em breve teremos muitos livros incríveis para você!</p>';
                    echo '</div>';
                }
            }
            ?>
        </section>
    </div>

    <!-- Footer simples -->
    <footer style="background-color: #1a237e; color: white; text-align: center; padding: 30px 20px; margin-top: 50px;">
        <p>&copy; 2025 Livraria Flobb - Todos os direitos reservados</p>
        <p>📧 contato@livrariaflobb.com | 📞 (11) 1234-5678</p>
    </footer>
</body>
</html>