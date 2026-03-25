<?php
require_once "dao/ProdutoDAO.php";
require_once "models/Produto.php";

$produtoDAO = new ProdutoDAO();
$mensagem = null;
$tipo_mensagem = null;
$erro_db = false;
$produtos = [];

// Processar formulário de cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    try {
        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $preco = floatval($_POST['preco'] ?? 0);
        $estoque = intval($_POST['estoque'] ?? 0);

        $produto = new Produto(null, $nome, $descricao, $preco, $estoque);
        $validacao = $produto->validar();

        if ($validacao === true) {
            if ($produtoDAO->inserir($produto)) {
                $mensagem = "✅ Produto cadastrado com sucesso!";
                $tipo_mensagem = "sucesso";
            } else {
                $mensagem = "❌ Erro ao cadastrar produto!";
                $tipo_mensagem = "erro";
            }
        } else {
            $mensagem = "❌ " . $validacao;
            $tipo_mensagem = "erro";
        }
    } catch (PDOException $e) {
        $erro_db = true;
        $mensagem = "❌ Erro ao acessar o banco de dados!";
        $tipo_mensagem = "erro";
    }
}

// Buscar todos os produtos
try {
    $produtos = $produtoDAO->listar();
} catch (PDOException $e) {
    $erro_db = true;
    $mensagem = "⚠️ Erro ao acessar o banco de dados!";
    $tipo_mensagem = "erro";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestão de Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>📦 Gestão de Produtos</h1>
        <p>Cadastro, Listagem e Edição de Produtos</p>
    </header>

    <main>
        <div style="margin-bottom: 20px;">
            <a href="index.php" class="btn-voltar">← Voltar para Página Principal</a>
        </div>

        <?php if ($mensagem): ?>
            <div class="mensagem <?= $tipo_mensagem; ?>">
                <?= $mensagem; ?>
            </div>
        <?php endif; ?>

        <?php if (!$erro_db): ?>
            <!-- Formulário de Cadastro -->
            <section class="formulario-section">
                <h2>➕ Cadastrar Novo Produto</h2>
                <form method="POST" class="formulario">
                    <div class="form-grupo">
                        <label for="nome">Nome do Produto:</label>
                        <input type="text" id="nome" name="nome" required placeholder="Digite o nome do produto">
                    </div>

                    <div class="form-grupo">
                        <label for="descricao">Descrição:</label>
                        <textarea id="descricao" name="descricao" placeholder="Digite a descrição do produto" rows="3"></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-grupo">
                            <label for="preco">Preço (R$):</label>
                            <input type="number" id="preco" name="preco" step="0.01" min="0" required placeholder="0.00">
                        </div>

                        <div class="form-grupo">
                            <label for="estoque">Estoque (un):</label>
                            <input type="number" id="estoque" name="estoque" min="0" required placeholder="0">
                        </div>
                    </div>

                    <button type="submit" name="salvar" class="btn btn-primary">✅ Cadastrar Produto</button>
                </form>
            </section>

            <!-- Listagem de Produtos -->
            <section class="listagem-section">
                <h2>📋 Produtos Cadastrados</h2>

                <?php if (empty($produtos)): ?>
                    <p class="sem-dados">Nenhum produto cadastrado ainda.</p>
                <?php else: ?>
                    <div class="tabela-responsiva">
                        <table class="tabela-clientes">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Descrição</th>
                                    <th>Preço</th>
                                    <th>Estoque</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $p): ?>
                                    <tr>
                                        <td data-label="ID"><?= $p['id']; ?></td>
                                        <td data-label="Produto"><strong><?= htmlspecialchars($p['nome']); ?></strong></td>
                                        <td data-label="Descrição"><?= substr(htmlspecialchars($p['descricao']), 0, 40); ?>...</td>
                                        <td data-label="Preço" style="color: #28a745; font-weight: bold;">R$ <?= number_format($p['preco'], 2, ',', '.'); ?></td>
                                        <td data-label="Estoque" style="text-align: center;">
                                            <span style="background: <?= $p['estoque'] > 5 ? '#45a29e' : '#66fcf1'; ?>; color: #0b0c10; padding: 5px 10px; border-radius: 4px; font-weight: 600;">
                                                <?= $p['estoque']; ?> un.
                                            </span>
                                        </td>
                                        <td data-label="Ações" class="acoes">
                                            <a href="editar_produto.php?id=<?= $p['id']; ?>" class="btn btn-editar">✏️ Editar</a>
                                            <a href="excluir_produto.php?id=<?= $p['id']; ?>" class="btn btn-excluir" onclick="return confirm('Excluir este produto?');">🗑️ Excluir</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="total-clientes">Total de produtos: <strong><?= count($produtos); ?></strong></p>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>💻 Desenvolvido com PHP orientado a objetos e banco de dados MySQL</p>
    </footer>
    <?php include 'voltar_inicio.php'; ?>
</body>
</html>
