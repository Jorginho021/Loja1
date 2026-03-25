<?php
require_once 'config/Database.php';

try {
    $db = (new Database())->getConnection();

    // ============== TABELA CLIENTES ==============
    $sql = "
    CREATE TABLE IF NOT EXISTS clientes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $db->exec($sql);

    // ============== TABELA PRODUTOS ==============
    $sql = "
    CREATE TABLE IF NOT EXISTS produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(150) NOT NULL,
        descricao TEXT,
        preco DECIMAL(10, 2) NOT NULL,
        estoque INT DEFAULT 0,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $db->exec($sql);

    // ============== TABELA PEDIDOS ==============
    $sql = "
    CREATE TABLE IF NOT EXISTS pedidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cliente_id INT NOT NULL,
        cliente_nome VARCHAR(100) NOT NULL,
        total DECIMAL(10, 2) NOT NULL DEFAULT 0,
        status VARCHAR(50) DEFAULT 'pendente',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $db->exec($sql);

    // ============== TABELA ITENS PEDIDOS ==============
    $sql = "
    CREATE TABLE IF NOT EXISTS itens_pedidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pedido_id INT NOT NULL,
        produto_id INT NOT NULL,
        produto_nome VARCHAR(150) NOT NULL,
        preco DECIMAL(10, 2) NOT NULL,
        quantidade INT NOT NULL,
        subtotal DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
        FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    $db->exec($sql);

    // ============== DADOS DE EXEMPLO ==============
    $db->exec("DELETE FROM itens_pedidos");
    $db->exec("DELETE FROM pedidos");
    $db->exec("DELETE FROM produtos");
    $db->exec("DELETE FROM clientes");

    // Inserir clientes
    $seedClientes = "
    INSERT INTO clientes (nome, email) VALUES
    ('Jorge Silva','jorge@gmail.com'),
    ('Maria Santos','maria@gmail.com'),
    ('Pedro Oliveira','pedro@gmail.com'),
    ('Carlos Costa','carlos@gmail.com'),
    ('Arthur Pereira','arthur@gmail.com');
    ";
    $db->exec($seedClientes);

    // Inserir produtos
    $seedProdutos = "
    INSERT INTO produtos (nome, descricao, preco, estoque) VALUES
    ('Notebook Dell', 'Notebook Dell Inspiron 15, Intel Core i5', 3500.00, 10),
    ('Mouse Gamer', 'Mouse Gamer RGB com 8 botões programáveis', 150.00, 25),
    ('Teclado Mecânico', 'Teclado Mecânico RGB com switches Cherry MX', 450.00, 15),
    ('Monitor 24\"', 'Monitor LG 24 polegadas Full HD', 800.00, 8),
    ('Webcam HD', 'Webcam Logitech HD 1080p', 200.00, 20),
    ('Headset Wireless', 'Headset sem fio com microfone de ruído', 280.00, 12);
    ";
    $db->exec($seedProdutos);

    $sucesso = true;

} catch (PDOException $e) {
    $erro = $e->getMessage();
    $sucesso = false;
}

// Buscar dados para mostrar
if ($sucesso) {
    $clientes = $db->query("SELECT * FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
    $produtos = $db->query("SELECT * FROM produtos")->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Setup - Configuração Inicial</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>🔧 Configuração Inicial do Sistema</h1>
        <p>Inicializando banco de dados</p>
    </header>

    <main>
        <?php if ($sucesso): ?>
            <div class="mensagem sucesso">
                <h2>✅ Configuração Finalizada com Sucesso!</h2>
                <p>Todas as tabelas foram criadas e dados de exemplo foram inseridos.</p>
            </div>

            <!-- Clientes -->
            <section class="formulario-section">
                <h3>👥 Clientes Inseridos:</h3>
                <div class="tabela-responsiva">
                    <table class="tabela-clientes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $row): ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= $row['nome']; ?></td>
                                    <td><?= $row['email']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="total-clientes">Total: <strong><?= count($clientes); ?> clientes</strong></p>
            </section>

            <!-- Produtos -->
            <section class="formulario-section">
                <h3>📦 Produtos Inseridos:</h3>
                <div class="tabela-responsiva">
                    <table class="tabela-clientes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produto</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $row): ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td><?= $row['nome']; ?></td>
                                    <td>R$ <?= number_format($row['preco'], 2, ',', '.'); ?></td>
                                    <td><?= $row['estoque']; ?> un.</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="total-clientes">Total: <strong><?= count($produtos); ?> produtos</strong></p>
            </section>

            <section class="formulario-section" style="text-align: center; margin-top: 30px;">
                <h3>🚀 Próximos Passos:</h3>
                <div style="margin: 20px 0;">
                    <a href="index.php" class="btn btn-primary">🏠 Ir para Início</a>
                    <a href="clientes.php" class="btn btn-editar">👥 Gestão de Clientes</a>
                    <a href="produtos.php" class="btn btn-editar">📦 Gestão de Produtos</a>
                    <a href="pedidos.php" class="btn btn-editar">🛒 Gestão de Pedidos</a>
                </div>
            </section>

        <?php else: ?>
            <div class="mensagem erro">
                <h2>❌ Erro na Configuração</h2>
                <p><strong>Mensagem de erro:</strong></p>
                <p style="background: #1f2833; padding: 15px; border-radius: 5px; color: #c5c6c7; border-left: 3px solid #66fcf1;">
                    <?= htmlspecialchars($erro); ?>
                </p>
            </div>

            <section class="formulario-section">
                <h3>🔍 Dicas de Resolução:</h3>
                <ul>
                    <li>✓ Verifique se o MySQL está rodando (XAMPP)</li>
                    <li>✓ Confirme o usuário e senha no arquivo <code>config/Database.php</code></li>
                    <li>✓ Certifique-se de que a porta MySQL é 3306</li>
                    <li>✓ Se ainda não funcionar, crie o banco manualmente e execute novamente</li>
                </ul>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>💻 Desenvolvido com PHP orientado a objetos e banco de dados MySQL</p>
    </footer>
</body>
</html>
