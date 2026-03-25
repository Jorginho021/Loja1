<?php
require_once "dao/PedidoDAO.php";

$pedidoDAO = new PedidoDAO();
$pedido = null;
$erro = false;

// Verificar se o ID foi enviado
if (!isset($_GET['id'])) {
    header("Location: pedidos.php");
    exit;
}

$id = intval($_GET['id']);

try {
    $pedido = $pedidoDAO->buscarPorId($id);
    if (!$pedido) {
        $erro = true;
    }
} catch (PDOException $e) {
    $erro = true;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visualizar Pedido</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .pedido-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-box {
            background: #0b0c10;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #66fcf1;
        }
        .info-box strong {
            display: block;
            margin-bottom: 5px;
            color: #66fcf1;
        }
        .info-box span {
            font-size: 1.2rem;
        }
        .item-lista {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        .item-lista strong {
            color: #0b0c10;
        }
        .item-lista span {
            color: #28a745;
            font-weight: bold;
        }
        .total-box {
            background: linear-gradient(135deg, #45a29e 0%, #66fcf1 100%);
            color: #0b0c10;
            padding: 20px;
            border-radius: 8px;
            text-align: right;
            font-size: 1.3rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>👁️ Visualizar Pedido</h1>
        <p>Detalhes completos do pedido</p>
    </header>

    <main>
        <?php if ($erro): ?>
            <div class="mensagem erro">
                <h2>❌ Pedido não encontrado!</h2>
            </div>
            <section class="formulario-section" style="text-align: center;">
                <a href="pedidos.php" class="btn-voltar">← Voltar para Pedidos</a>
            </section>
        <?php else: ?>
            <section class="listagem-section">
                <div class="pedido-info">
                    <div class="info-box">
                        <strong>Pedido ID:</strong>
                        <span>#<?= $pedido->getId(); ?></span>
                    </div>
                    <div class="info-box">
                        <strong>Cliente:</strong>
                        <span><?= htmlspecialchars($pedido->getClienteNome()); ?></span>
                    </div>
                    <div class="info-box">
                        <strong>Status:</strong>
                        <span style="background: #66fcf1; color: #0b0c10; padding: 5px 10px; border-radius: 4px; display: inline-block; font-weight: 600;">
                            <?= ucfirst($pedido->getStatus()); %>
                        </span>
                    </div>
                    <div class="info-box">
                        <strong>Data:</strong>
                        <span><?= date('d/m/Y H:i', strtotime($pedido->getDataCriacao())); ?></span>
                    </div>
                </div>

                <h3>📦 Produtos do Pedido:</h3>
                <?php foreach ($pedido->getProdutos() as $item): ?>
                    <div class="item-lista">
                        <strong><?= htmlspecialchars($item['nome']); ?></strong>
                        <span>
                            <?= $item['quantidade']; ?> x R$ <?= number_format($item['preco'], 2, ',', '.'); ?> = 
                            R$ <?= number_format($item['subtotal'], 2, ',', '.'); ?>
                        </span>
                    </div>
                <?php endforeach; ?>

                <div class="total-box">
                    <strong>Total:</strong> <?= $pedido->calcularTotalFormatado(); ?>
                </div>

                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #45a29e;">
                    <h3>Resumo Completo:</h3>
                    <pre style="background: #f5f5f5; padding: 15px; border-radius: 8px; overflow-x: auto;">
<?= nl2br(htmlspecialchars($pedido->exibirResumo())); ?>
                    </pre>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <a href="pedidos.php" class="btn-voltar">← Voltar para Pedidos</a>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>💻 Desenvolvido com PHP orientado a objetos e banco de dados MySQL</p>
    </footer>
    <?php include 'voltar_inicio.php'; ?>
</body>
</html>
