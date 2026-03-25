<?php
require_once "dao/ProdutoDAO.php";
require_once "models/Produto.php";

$produtoDAO = new ProdutoDAO();
$produto = null;
$mensagem = null;
$tipo_mensagem = null;

// Verificar se o ID foi enviado
if (!isset($_GET['id'])) {
    header("Location: produtos.php");
    exit;
}

$id = intval($_GET['id']);
$produto = $produtoDAO->buscarPorId($id);

if (!$produto) {
    header("Location: produtos.php");
    exit;
}

// Processar atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = floatval($_POST['preco'] ?? 0);
    $estoque = intval($_POST['estoque'] ?? 0);

    $produtoAtualizado = new Produto($id, $nome, $descricao, $preco, $estoque);
    $validacao = $produtoAtualizado->validar();

    if ($validacao === true) {
        if ($produtoDAO->atualizar($produtoAtualizado)) {
            $mensagem = "✅ Produto atualizado com sucesso!";
            $tipo_mensagem = "sucesso";
            $produto = $produtoAtualizado;
            header("refresh:2;url=produtos.php");
        } else {
            $mensagem = "❌ Erro ao atualizar produto!";
            $tipo_mensagem = "erro";
        }
    } else {
        $mensagem = "❌ " . $validacao;
        $tipo_mensagem = "erro";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>✏️ Editar Produto</h1>
        <p>Atualize os dados do produto</p>
    </header>

    <main>
        <?php if ($mensagem): ?>
            <div class="mensagem <?= $tipo_mensagem; ?>">
                <?= $mensagem; ?>
            </div>
        <?php endif; ?>

        <section class="formulario-section">
            <form method="POST" class="formulario">
                <div class="form-grupo">
                    <label for="id_display">ID do Produto:</label>
                    <input type="text" id="id_display" value="<?= $produto->getId(); ?>" disabled>
                </div>

                <div class="form-grupo">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($produto->getNome()); ?>" required>
                </div>

                <div class="form-grupo">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" rows="3"><?= htmlspecialchars($produto->getDescricao()); ?></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-grupo">
                        <label for="preco">Preço (R$):</label>
                        <input type="number" id="preco" name="preco" step="0.01" value="<?= $produto->getPreco(); ?>" required>
                    </div>

                    <div class="form-grupo">
                        <label for="estoque">Estoque (un):</label>
                        <input type="number" id="estoque" name="estoque" value="<?= $produto->getEstoque(); ?>" required>
                    </div>
                </div>

                <div class="form-acoes">
                    <button type="submit" name="atualizar" class="btn btn-primary">💾 Atualizar</button>
                    <a href="produtos.php" class="btn-voltar">← Voltar</a>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>💻 Desenvolvido com PHP orientado a objetos e banco de dados MySQL</p>
    </footer>
    <?php include 'voltar_inicio.php'; ?>
</body>
</html>
