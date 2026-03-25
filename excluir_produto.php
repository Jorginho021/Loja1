<?php
require_once "dao/ProdutoDAO.php";

$produtoDAO = new ProdutoDAO();

if (!isset($_GET['id'])) {
    header("Location: produtos.php");
    exit;
}

$id = intval($_GET['id']);

if (isset($_POST['confirmar'])) {
    if ($produtoDAO->excluir($id)) {
        $mensagem = "✅ Produto excluído com sucesso! Redirecionando...";
        header("refresh:2;url=produtos.php");
    } else {
        $mensagem = "❌ Erro ao excluir produto!";
    }
} else {
    require_once "models/Produto.php";
    $produto = $produtoDAO->buscarPorId($id);
    
    if (!$produto) {
        header("Location: produtos.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excluir Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>🗑️ Excluir Produto</h1>
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
                    <p>Você realmente deseja excluir este produto?</p>

                    <div class="cliente-info">
                        <p><strong>ID:</strong> <?= $produto->getId(); ?></p>
                        <p><strong>Produto:</strong> <?= htmlspecialchars($produto->getNome()); ?></p>
                        <p><strong>Preço:</strong> R$ <?= number_format($produto->getPreco(), 2, ',', '.'); ?></p>
                    </div>

                    <p class="aviso">⚠️ <strong>Esta ação é permanente e não pode ser desfeita!</strong></p>

                    <form method="POST" class="formulario-confirmacao">
                        <button type="submit" name="confirmar" value="sim" class="btn btn-excluir">🗑️ Sim, excluir</button>
                        <a href="produtos.php" class="btn-voltar">← Cancelar</a>
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
