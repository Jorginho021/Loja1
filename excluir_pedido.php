<?php
require_once "dao/PedidoDAO.php";

$pedidoDAO = new PedidoDAO();

if (!isset($_GET['id'])) {
    header("Location: pedidos.php");
    exit;
}

$id = intval($_GET['id']);

if (isset($_POST['confirmar'])) {
    if ($pedidoDAO->excluir($id)) {
        $mensagem = "✅ Pedido excluído com sucesso! Redirecionando...";
        header("refresh:2;url=pedidos.php");
    } else {
        $mensagem = "❌ Erro ao excluir pedido!";
    }
} else {
    $pedido = $pedidoDAO->buscarPorId($id);
    
    if (!$pedido) {
        header("Location: pedidos.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excluir Pedido</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>🗑️ Excluir Pedido</h1>
        <p>Atenção: esta ação não pode ser desfeita!</p>
    </header>

    <main>
        <?php if (isset($mensagem)): ?>
            <div class="mensagem <?= strpos($mensagem, '✅') !== false ? 'sucesso' : 'erro'; ?>">
                <?= $mensagem; ?>
            </div>
        <?php else: ?>
            <section class="confirmacao-section">
                <div class="confirmacao-box">
                    <h2>⚠️ Confirmar Exclusão</h2>
                    <p>Você realmente deseja excluir este pedido?</p>

                    <div class="cliente-info">
                        <p><strong>ID do Pedido:</strong> #<?= $pedido->getId(); ?></p>
                        <p><strong>Cliente:</strong> <?= htmlspecialchars($pedido->getClienteNome()); ?></p>
                        <p><strong>Total:</strong> <?= $pedido->calcularTotalFormatado(); ?></p>
                        <p><strong>Produtos:</strong> <?= $pedido->contarItens(); ?></p>
                    </div>

                    <p class="aviso">⚠️ <strong>Esta ação é permanente e não pode ser desfeita!</strong></p>

                    <form method="POST" class="formulario-confirmacao">
                        <button type="submit" name="confirmar" value="sim" class="btn btn-excluir">🗑️ Sim, excluir</button>
                        <a href="pedidos.php" class="btn-voltar">← Cancelar</a>
                    </form>
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
