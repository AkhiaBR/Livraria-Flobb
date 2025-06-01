<!DOCTYPE html>
<html>
<head>
    <title>Menu Principal - Sistema Livraria</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../Assets/css/styles.css">
</head>
<body>
    <div id="formulario">
        <h1>Sistema de Livraria - Menu Principal</h1>
        
        <div class="menu-opcoes">
            <h2>O que você deseja cadastrar?</h2>
            
            <div class="opcoes-grid">
                <div class="opcao-card">
                    <h3>📖 Autor</h3>
                    <p>Cadastrar, alterar, excluir e pesquisar autores</p>
                    <a href="cadastrar_autor.php" class="btn-opcao">Gerenciar Autores</a>
                </div>
                
                <div class="opcao-card">
                    <h3>📂 Categoria</h3>
                    <p>Cadastrar, alterar, excluir e pesquisar categorias</p>
                    <a href="cadastrar_categoria.php" class="btn-opcao">Gerenciar Categorias</a>
                </div>
                
                <div class="opcao-card">
                    <h3>🏢 Editora</h3>
                    <p>Cadastrar, alterar, excluir e pesquisar editoras</p>
                    <a href="cadastrar_editora.php" class="btn-opcao">Gerenciar Editoras</a>
                </div>
                
                <div class="opcao-card">
                    <h3>📚 Livro</h3>
                    <p>Cadastrar, alterar, excluir e pesquisar livros</p>
                    <a href="cadastrar_livro.php" class="btn-opcao">Gerenciar Livros</a>
                </div>
            </div>
            
            <div class="botoes">
                <a href="login.php" class="btn-sair">Sair do Sistema</a>
            </div>
        </div>
    </div>
</body>
</html>