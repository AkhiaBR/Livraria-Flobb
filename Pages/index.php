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
    <link rel="stylesheet" href="../Assets/css/styles.css">
</head>
<body>
    <!-- Header -->
    <header class="header-home">
        <div class="header-container">
            <div class="logo">
                <h1>📚 Livraria Flobb</h1>
            </div>
            <nav class="header-nav">
                <a href="login.php" class="btn-login">👤 Login</a>
                <button class="btn-carrinho" onclick="toggleCarrinho()">
                    🛒 Carrinho (<span id="carrinho-count">0</span>)
                </button>
            </nav>
        </div>
    </header>

    <!-- Banner Carrossel -->
    <section class="carousel-banner">
        <div class="carousel-container">
            <div class="carousel-track" id="carouselTrack">
                <div class="carousel-slide active">
                    <div class="slide-content">
                        <div class="slide-text">
                            <h2>📚 Novidades da Semana</h2>
                            <p>Descubra os lançamentos mais esperados e bestsellers que acabaram de chegar!</p>
                        </div>
                        <div class="slide-image">
                            <div class="book-stack">
                                <div class="book book1">📖</div>
                                <div class="book book2">📚</div>
                                <div class="book book3">📘</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="carousel-slide">
                    <div class="slide-content">
                        <div class="slide-text">
                            <h2>🔥 Promoções Imperdíveis</h2>
                            <p>Até 50% de desconto em livros selecionados. Aproveite esta oportunidade única!</p>
                        </div>
                        <div class="slide-image">
                            <div class="promo-badge">
                                <span class="discount">-50%</span>
                                <div class="promo-books">
                                    <div class="promo-book">📗</div>
                                    <div class="promo-book">📙</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="carousel-slide">
                    <div class="slide-content">
                        <div class="slide-text">
                            <h2>⭐ Mais Vendidos</h2>
                            <p>Conheça os títulos que estão conquistando os leitores em todo o Brasil!</p>
                        </div>
                        <div class="slide-image">
                            <div class="bestseller-crown">
                                <div class="crown">👑</div>
                                <div class="bestseller-books">
                                    <div class="bestseller-book gold">🏆</div>
                                    <div class="bestseller-book silver">🥈</div>
                                    <div class="bestseller-book bronze">🥉</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="carousel-btn prev" onclick="previousSlide()">&#8249;</button>
            <button class="carousel-btn next" onclick="nextSlide()">&#8250;</button>
            
            <div class="carousel-dots">
                <span class="dot active" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
        </div>
    </section>

    <!-- Carrinho de Comprass -->
    <div id="carrinho-modal" class="carrinho-modal">
        <div class="carrinho-content">
            <div class="carrinho-header">
                <h3>🛒 Seu Carrinho de Compras</h3>
                <span class="carrinho-close" onclick="toggleCarrinho()">&times;</span>
            </div>
            <div class="carrinho-body">
                <div id="carrinho-items"></div>
                <div class="carrinho-total">
                    <strong>Total: R$ <span id="carrinho-total">0,00</span></strong>
                </div>
                <div class="carrinho-actions">
                    <button class="btn-limpar" onclick="limparCarrinho()">Limpar Carrinho</button>
                    <button class="btn-finalizar" onclick="finalizarCompra()">Finalizar Compra</button>
                </div>
            </div>
        </div>
    </div>

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
            <form name="filtros" method="post" action="" class="filtros-form">
                <div class="filtro-group">
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
                
                <div class="filtro-group">
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
                
                <div class="filtro-group">
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
                
                <div class="filtro-group">
                    <input type="submit" name="pesquisar" value="🔍 Pesquisar" class="btn-pesquisar">
                </div>
            </form>
        </section>

        <!-- Resultados -->
        <section class="resultados-section">
            <?php
            // Inicializa variaveis de filtro
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
                        echo '<img src="../Assets/img/' . $livro['foto_capa'] . '" alt="Capa - ' . htmlspecialchars($livro['titulo']) . '" class="capa-principal" />';
                    } else {
                        echo '<div class="sem-imagem">📖<br>Sem Capa</div>';
                    }
                    
                    if ($livro['foto_contracapa']) {
                        echo '<img src="../Assets/img/' . $livro['foto_contracapa'] . '" alt="Contracapa - ' . htmlspecialchars($livro['titulo']) . '" class="contracapa" />';
                    }
                    echo '</div>';
                    
                    // Informações do livro
                    echo '<div class="livro-info">';
                    echo '<h3>' . htmlspecialchars($livro['titulo']) . '</h3>';
                    
                    echo '<div class="livro-detalhes">';
                    echo '<p><strong>📝 Autor:</strong> ' . htmlspecialchars($livro['nome_autor']) . '</p>';
                    echo '<p><strong>📚 Categoria:</strong> ' . htmlspecialchars($livro['nome_categoria']) . '</p>';
                    echo '<p><strong>🏢 Editora:</strong> ' . htmlspecialchars($livro['nome_editora']) . '</p>';
                    echo '<p><strong>📄 Páginas:</strong> ' . $livro['numero_paginas'] . ' | <strong>📅 Ano:</strong> ' . $livro['ano'] . '</p>';
                    echo '</div>';
                    
                    // Resenha
                    if ($livro['resenha']) {
                        $resenha_resumida = strlen($livro['resenha']) > 120 ? 
                            substr($livro['resenha'], 0, 120) . '...' : $livro['resenha'];
                        echo '<div class="livro-resenha">';
                        echo htmlspecialchars($resenha_resumida);
                        echo '</div>';
                    }
                    
                    // Preço e botão de compra
                    echo '<div class="livro-compra">';
                    echo '<div class="preco">';
                    echo '<span class="preco-valor">R$ ' . number_format($livro['preco'], 2, ',', '.') . '</span>';
                    echo '</div>';
                    
                    echo '<button class="btn-comprar" onclick="adicionarAoCarrinho(' . 
                         $livro['codigo'] . ', \'' . 
                         addslashes(htmlspecialchars($livro['titulo'])) . '\', ' . 
                         $livro['preco'] . ', \'' . 
                         ($livro['foto_capa'] ? '../Assets/img/' . $livro['foto_capa'] : '') . '\')">';
                    echo '🛒 Adicionar ao Carrinho';
                    echo '</button>';
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

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>📚 Livraria Flobb</h4>
                <p>Sua livraria online de confiança</p>
            </div>
            <div class="footer-section">
                <h4>📞 Contato</h4>
                <p>📧 contato@livrariaflobb.com</p>
                <p>📞 (11) 1234-5678</p>
            </div>
            <div class="footer-section">
                <h4>🕒 Horário</h4>
                <p>Segunda a Sexta: 8h às 18h</p>
                <p>Sábado: 8h às 14h</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Livraria Flobb - Todos os direitos reservados</p>
        </div>
    </footer>

    <script>
        // Sistema de Carrinho de Compras
        let carrinho = [];

        function toggleCarrinho() {
            const modal = document.getElementById('carrinho-modal');
            modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
        }

        function adicionarAoCarrinho(id, titulo, preco, imagem) {
            // Verifica se o item já existe no carrinho
            const itemExistente = carrinho.find(item => item.id === id);
            
            if (itemExistente) {
                itemExistente.quantidade++;
            } else {
                carrinho.push({
                    id: id,
                    titulo: titulo,
                    preco: preco,
                    imagem: imagem,
                    quantidade: 1
                });
            }
            
            atualizarCarrinho();
            
            const btn = event.target;
            const textoOriginal = btn.textContent;
            btn.textContent = '✅ Adicionado!';
            btn.style.backgroundColor = '#28a745';
            
            setTimeout(() => {
                btn.textContent = textoOriginal;
                btn.style.backgroundColor = '';
            }, 1500);
        }

        function removerDoCarrinho(id) {
            carrinho = carrinho.filter(item => item.id !== id);
            atualizarCarrinho();
        }

        function alterarQuantidade(id, novaQuantidade) {
            if (novaQuantidade <= 0) {
                removerDoCarrinho(id);
                return;
            }
            
            const item = carrinho.find(item => item.id === id);
            if (item) {
                item.quantidade = novaQuantidade;
                atualizarCarrinho();
            }
        }

        function atualizarCarrinho() {
            const carrinhoItems = document.getElementById('carrinho-items');
            const carrinhoCount = document.getElementById('carrinho-count');
            const carrinhoTotal = document.getElementById('carrinho-total');
            
            // Atualiza contador
            const totalItens = carrinho.reduce((sum, item) => sum + item.quantidade, 0);
            carrinhoCount.textContent = totalItens;
            
            // Atualiza total
            const total = carrinho.reduce((sum, item) => sum + (item.preco * item.quantidade), 0);
            carrinhoTotal.textContent = total.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
            
            // Atualiza lista de items
            if (carrinho.length === 0) {
                carrinhoItems.innerHTML = '<p class="carrinho-vazio">Seu carrinho está vazio</p>';
            } else {
                carrinhoItems.innerHTML = carrinho.map(item => `
                    <div class="carrinho-item">
                        <div class="item-info">
                            ${item.imagem ? `<img src="${item.imagem}" alt="${item.titulo}" class="item-thumb">` : '<div class="item-thumb-placeholder">📖</div>'}
                            <div class="item-details">
                                <h4>${item.titulo}</h4>
                                <p>R$ ${item.preco.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</p>
                            </div>
                        </div>
                        <div class="item-controls">
                            <button onclick="alterarQuantidade(${item.id}, ${item.quantidade - 1})">-</button>
                            <span>${item.quantidade}</span>
                            <button onclick="alterarQuantidade(${item.id}, ${item.quantidade + 1})">+</button>
                            <button class="btn-remover" onclick="removerDoCarrinho(${item.id})">🗑️</button>
                        </div>
                    </div>
                `).join('');
            }
        }

        function limparCarrinho() {
            if (confirm('Tem certeza que deseja limpar o carrinho?')) {
                carrinho = [];
                atualizarCarrinho();
            }
        }

        function finalizarCompra() {
            if (carrinho.length === 0) {
                alert('Seu carrinho está vazio!');
                return;
            }
            
            const total = carrinho.reduce((sum, item) => sum + (item.preco * item.quantidade), 0);
            alert(`Compra finalizada!\nTotal: R$ ${total.toLocaleString('pt-BR', { minimumFractionDigits: 2 })}\n\nObrigado por escolher a Livraria Flobb!`);
            
            carrinho = [];
            atualizarCarrinho();
            toggleCarrinho();
        }

        window.onclick = function(event) {
            const modal = document.getElementById('carrinho-modal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }

        // Sistema do Carrossel
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dots = document.querySelectorAll('.dot');
        
        function showSlide(index) {
            // Remove classe active de todos os slides e dots
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            // Adiciona classe active ao slide e dot atual
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }
        
        function nextSlide() {
            currentSlideIndex = (currentSlideIndex + 1) % slides.length;
            showSlide(currentSlideIndex);
        }
        
        function previousSlide() {
            currentSlideIndex = (currentSlideIndex - 1 + slides.length) % slides.length;
            showSlide(currentSlideIndex);
        }
        
        function currentSlide(index) {
            currentSlideIndex = index - 1;
            showSlide(currentSlideIndex);
        }
        
        // Auto-play do carrossel
        let autoSlide = setInterval(nextSlide, 5000);
        
        // Pausa o auto-play quando o mouse está sobre o carrossel
        document.querySelector('.carousel-banner').addEventListener('mouseenter', () => {
            clearInterval(autoSlide);
        });
        
        // Retoma o auto-play quando o mouse sai do carrossel
        document.querySelector('.carousel-banner').addEventListener('mouseleave', () => {
            autoSlide = setInterval(nextSlide, 5000);
        });

        atualizarCarrinho();
    </script>
</body>
</html>