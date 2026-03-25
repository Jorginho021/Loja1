<?php
require_once "dao/PedidoDAO.php";
require_once "models/Pedido.php";

$pedidoDAO = new PedidoDAO();
$erro_db = false;
$pedidos = [];

// Buscar todos os pedidos
try {
    $pedidos = $pedidoDAO->listar();
} catch (PDOException $e) {
    $erro_db = true;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestão de Pedidos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>📦 Gestão de Pedidos</h1>
        <p>Listagem e Gerenciamento de Pedidos</p>
    </header>

    <main>
        <div style="margin-bottom: 20px;">
            <a href="index.php" class="btn-voltar">← Voltar para Página Principal</a>
        </div>

        <section class="formulario-section" style="text-align: center;">
            <a href="criar_pedido.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 12px 30px;">🛒 Criar Novo Pedido</a>
        </section>

        <section class="listagem-section">
            <h2>📋 Todos os Pedidos</h2>

            <?php if (empty($pedidos)): ?>
                <p class="sem-dados">Nenhum pedido criado ainda.</p>
            <?php else: ?>
                <div class="tabela-responsiva">
                    <table class="tabela-clientes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $p): ?>
                                <tr>
                                    <td data-label="ID"><strong>#<?= $p['id']; ?></strong></td>
                                    <td data-label="Cliente"><?= htmlspecialchars($p['cliente_nome']); ?></td>
                                    <td data-label="Total" style="color: #28a745; font-weight: bold;">R$ <?= number_format($p['total'], 2, ',', '.'); ?></td>
                                    <td data-label="Status">
                                        <span style="background: <?= $p['status'] === 'pendente' ? '#66fcf1' : '#45a29e'; ?>; color: #0b0c10; padding: 5px 10px; border-radius: 4px; font-weight: 600;">
                                            <?= ucfirst($p['status']); ?>
                                        </span>
                                    </td>
                                    <td data-label="Data"><?= date('d/m/Y H:i', strtotime($p['data_criacao'])); ?></td>
                                    <td data-label="Ações" class="acoes">
                                        <a href="visualizar_pedido.php?id=<?= $p['id']; ?>" class="btn btn-editar" style="background: #007bff;">👁️ Ver</a>
                                        <a href="excluir_pedido.php?id=<?= $p['id']; ?>" class="btn btn-excluir" onclick="return confirm('Excluir este pedido?');">🗑️ Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="total-clientes">Total de pedidos: <strong><?= count($pedidos); ?></strong></p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>💻 Desenvolvido com PHP orientado a objetos e banco de dados MySQL</p>
    </footer>
    <?php include 'voltar_inicio.php'; ?>
</body>
</html>
