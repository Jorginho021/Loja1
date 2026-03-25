<?php
require_once "dao/ClienteDAO.php";
require_once "dao/ProdutoDAO.php";
require_once "dao/PedidoDAO.php";
require_once "models/Pedido.php";

$clienteDAO = new ClienteDAO();
$produtoDAO = new ProdutoDAO();
$pedidoDAO = new PedidoDAO();

$mensagem = null;
$tipo_mensagem = null;
$erro_db = false;
$clientes = [];
$produtos = [];
$pedido_temp = null;

// Buscar clientes e produtos
try {
    $clientes = $clienteDAO->listar();
    $produtos = $produtoDAO->listar();
} catch (PDOException $e) {
    $erro_db = true;
    $mensagem = "⚠️ Erro ao carregar dados!";
    $tipo_mensagem = "erro";
}

// Processar criação de pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['criar_pedido'])) {
    try {
        $cliente_id = intval($_POST['cliente_id'] ?? 0);
        $cliente_nome = $_POST['cliente_nome'] ?? '';
        $produtos_pedido = $_POST['produtos'] ?? [];

        if ($cliente_id > 0 && !empty($produtos_pedido)) {
            $pedido = new Pedido(null, $cliente_id, $cliente_nome);

            foreach ($produtos_pedido as $index => $produto_id) {
                if (!empty($produto_id)) {
                    $produto = $produtoDAO->buscarPorId($produto_id);
                    $quantidade = intval($_POST['quantidade'][$index] ?? 1);

                    if ($produto && $quantidade > 0) {
                        $pedido->adicionarProduto(
                            $produto->getId(),
                            $produto->getNome(),
                            $produto->getPreco(),
                            $quantidade
                        );
                    }
                }
            }

            if ($pedido->contarItens() > 0) {
                $pedidoId = $pedidoDAO->inserir($pedido);
                if ($pedidoId) {
                    $mensagem = "✅ Pedido criado com sucesso! ID: #" . $pedidoId;
                    $tipo_mensagem = "sucesso";
                    $pedido_temp = $pedidoDAO->buscarPorId($pedidoId);
                } else {
                    $mensagem = "❌ Erro ao criar pedido!";
                    $tipo_mensagem = "erro";
                }
            } else {
                $mensagem = "❌ Pedido deve ter pelo menos um produto!";
                $tipo_mensagem = "erro";
            }
        } else {
            $mensagem = "❌ Selecione um cliente e produtos!";
            $tipo_mensagem = "erro";
        }
    } catch (PDOException $e) {
        $mensagem = "❌ Erro ao acessar o banco de dados!";
        $tipo_mensagem = "erro";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Criar Pedido</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .item-pedido {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 10px;
            align-items: center;
        }
        .item-pedido select,
        .item-pedido input {
            padding: 8px;
            border: 2px solid #45a29e;
            border-radius: 4px;
        }
        .item-pedido button {
            padding: 8px 12px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .resumo-pedido {
            background: linear-gradient(135deg, #45a29e 0%, #66fcf1 100%);
            color: #0b0c10;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .resumo-pedido h3 {
            margin-top: 0;
        }
        .item-resumo {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .total-resumo {
            font-size: 1.3rem;
            font-weight: bold;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>
    <header>
        <h1>🛒 Criar Novo Pedido</h1>
        <p>Selecione um cliente e adicione produtos</p>
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

        <?php if (!$erro_db && !$pedido_temp): ?>
            <section class="formulario-section">
                <h2>📝 Novo Pedido</h2>
                <form method="POST" class="formulario">
                    <div class="form-grupo">
                        <label for="cliente_id">Cliente:</label>
                        <select id="cliente_id" name="cliente_id" required onchange="atualizarNome()">
                            <option value="">-- Selecione um cliente --</option>
                            <?php foreach ($clientes as $c): ?>
                                <option value="<?= $c['id']; ?>" data-nome="<?= htmlspecialchars($c['nome']); ?>">
                                    <?= htmlspecialchars($c['nome']); ?> (<?= htmlspecialchars($c['email']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" id="cliente_nome" name="cliente_nome">
                    </div>

                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">
                        <h3>Adicionar Produtos</h3>
                        <div id="produtos-container">
                            <div class="item-pedido">
                                <select name="produtos[]" class="produto-select" onchange="atualizarPreco(this)">
                                    <option value="">-- Selecione um produto --</option>
                                    <?php foreach ($produtos as $p): ?>
                                        <option value="<?= $p['id']; ?>" data-preco="<?= $p['preco']; ?>" data-nome="<?= htmlspecialchars($p['nome']); ?>">
                                            <?= htmlspecialchars($p['nome']); ?> - R$ <?= number_format($p['preco'], 2, ',', '.'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="number" name="quantidade[]" value="1" min="1" placeholder="Quantidade">
                                <button type="button" onclick="removerItem(this)">✕</button>
                            </div>
                        </div>
                        <button type="button" onclick="adicionarProduto()" style="margin-top: 10px;" class="btn btn-primary">➕ Adicionar Outro Produto</button>
                    </div>

                    <button type="submit" name="criar_pedido" class="btn btn-primary" style="width: 100%; padding: 12px;">🛒 Criar Pedido</button>
                </form>
            </section>
        <?php endif; ?>

        <?php if ($pedido_temp): ?>
            <section class="listagem-section">
                <h2>✅ Pedido Criado com Sucesso!</h2>
                
                <div class="resumo-pedido">
                    <h3>📋 Resumo do Pedido</h3>
                    <p><strong>Pedido ID:</strong> #<?= $pedido_temp->getId(); ?></p>
                    <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido_temp->getClienteNome()); ?></p>
                    <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido_temp->getDataCriacao())); ?></p>
                    
                    <div style="margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.3); padding-top: 15px;">
                        <h4>Produtos:</h4>
                        <?php foreach ($pedido_temp->getProdutos() as $item): ?>
                            <div class="item-resumo">
                                <span><?= htmlspecialchars($item['nome']); ?> x<?= $item['quantidade']; ?></span>
                                <span>R$ <?= number_format($item['subtotal'], 2, ',', '.'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="total-resumo">
                        Total: <?= $pedido_temp->calcularTotalFormatado(); ?>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <a href="pedidos.php" class="btn btn-primary" style="display: inline-block; margin: 10px;">📋 Ver Todos os Pedidos</a>
                    <a href="criar_pedido.php" class="btn btn-editar" style="display: inline-block; margin: 10px;">🛒 Criar Novo Pedido</a>
                    <a href="index.php" class="btn-voltar" style="display: inline-block; margin: 10px;">🏠 Voltar ao Início</a>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>💻 Desenvolvido com PHP orientado a objetos e banco de dados MySQL</p>
    </footer>

    <script>
        function atualizarNome() {
            const select = document.getElementById('cliente_id');
            const nome = select.options[select.selectedIndex].getAttribute('data-nome');
            document.getElementById('cliente_nome').value = nome || '';
        }

        function adicionarProduto() {
            const container = document.getElementById('produtos-container');
            const novoItem = document.createElement('div');
            novoItem.className = 'item-pedido';
            novoItem.innerHTML = `
                <select name="produtos[]" class="produto-select" onchange="atualizarPreco(this)">
                    <option value="">-- Selecione um produto --</option>
                    <?php foreach ($produtos as $p): ?>
                        <option value="<?= $p['id']; ?>" data-preco="<?= $p['preco']; ?>" data-nome="<?= htmlspecialchars($p['nome']); ?>">
                            <?= htmlspecialchars($p['nome']); ?> - R$ <?= number_format($p['preco'], 2, ',', '.'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="quantidade[]" value="1" min="1" placeholder="Quantidade">
                <button type="button" onclick="removerItem(this)">✕</button>
            `;
            container.appendChild(novoItem);
        }

        function removerItem(btn) {
            btn.parentElement.remove();
        }

        function atualizarPreco(select) {
            // Aqui poderíamos fazer lógica adicional se needed
        }
    </script>
    <?php include 'voltar_inicio.php'; ?>
</body>
</html>
