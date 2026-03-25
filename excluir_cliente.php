<?php
require_once "dao/ClienteDAO.php";

$clienteDAO = new ClienteDAO();

// Verificar se o ID foi enviado pela URL
if (!isset($_GET['id'])) {
    header("Location: clientes.php");
    exit;
}

$id = intval($_GET['id']);

// Verificar confirmação de exclusão
if (isset($_POST['confirmar'])) {
    if ($clienteDAO->excluir($id)) {
        $mensagem = "✅ Cliente excluído com sucesso! Redirecionando...";
        header("refresh:2;url=clientes.php");
    } else {
        $mensagem = "❌ Erro ao excluir cliente!";
    }
} else {
    // Buscar cliente para exibir dados antes de excluir
    require_once "models/Cliente.php";
    $cliente = $clienteDAO->buscarPorId($id);
    
    if (!$cliente) {
        header("Location: clientes.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excluir Cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>🗑️ Excluir Cliente</h1>
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
                    <p>Você realmente deseja excluir este cliente?</p>

                    <div class="cliente-info">
                        <p><strong>ID:</strong> <?= htmlspecialchars($cliente->getId()); ?></p>
                        <p><strong>Nome:</strong> <?= htmlspecialchars($cliente->getNome()); ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($cliente->getEmail()); ?></p>
                    </div>

                    <p class="aviso">⚠️ <strong>Esta ação é permanente e não pode ser desfeita!</strong></p>

                    <form method="POST" class="formulario-confirmacao">
                        <button type="submit" name="confirmar" value="sim" class="btn btn-excluir">🗑️ Sim, excluir cliente</button>
                        <a href="clientes.php" class="btn-voltar">← Cancelar</a>
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
