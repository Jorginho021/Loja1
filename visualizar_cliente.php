<?php
require_once "dao/ClienteDAO.php";
require_once "models/Cliente.php";

$clienteDAO = new ClienteDAO();
$cliente = null;
$erro = false;
$mensagem_erro = "";

// Verificar se o ID foi enviado pela URL
if (!isset($_GET['id'])) {
    header("Location: clientes.php");
    exit;
}

$id = intval($_GET['id']);

try {
    $cliente = $clienteDAO->buscarPorId($id);
    
    if (!$cliente) {
        $erro = true;
        $mensagem_erro = "Cliente não encontrado!";
    }
} catch (PDOException $e) {
    $erro = true;
    $mensagem_erro = "Erro ao buscar cliente no banco de dados!";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visualizar Cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>👁️ Visualizar Cliente</h1>
        <p>Detalhes do cliente</p>
    </header>

    <main>
        <?php if ($erro): ?>
            <div class="mensagem erro">
                <h2>❌ <?= $mensagem_erro; ?></h2>
            </div>
            
            <section class="formulario-section" style="text-align: center;">
                <a href="clientes.php" class="btn-voltar" style="display: inline-block; margin-top: 10px;">
                    ← Voltar para Listagem
                </a>
            </section>
        <?php else: ?>
            <section class="formulario-section">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <h3>📋 Informações do Cliente</h3>
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
                            <p>
                                <strong>ID:</strong><br>
                                <span style="font-size: 1.2rem; color: #66fcf1;"><?= htmlspecialchars($cliente->getId()); ?></span>
                            </p>
                            <hr style="margin: 15px 0; border: none; border-top: 1px solid #ddd;">
                            <p>
                                <strong>Nome:</strong><br>
                                <span style="font-size: 1.1rem;"><?= htmlspecialchars($cliente->getNome()); ?></span>
                            </p>
                            <hr style="margin: 15px 0; border: none; border-top: 1px solid #ddd;">
                            <p>
                                <strong>Email:</strong><br>
                                <span style="font-size: 1.1rem;">
                                    <a href="mailto:<?= htmlspecialchars($cliente->getEmail()); ?>">
                                        <?= htmlspecialchars($cliente->getEmail()); ?>
                                    </a>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div>
                        <h3>🎯 Ações</h3>
                        <div style="background: linear-gradient(135deg, #1f2833 0%, #45a29e 100%); padding: 20px; border-radius: 8px; color: #c5c6c7; border: 1px solid #45a29e;">
                            <p style="margin-top: 0;">Escolha uma ação para este cliente:</p>
                            
                            <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 15px;">
                                <a href="editar_cliente.php?id=<?= $cliente->getId(); ?>" 
                                   class="btn btn-editar" style="text-align: center;">
                                    ✏️ Editar Cliente
                                </a>
                                
                                <a href="excluir_cliente.php?id=<?= $cliente->getId(); ?>" 
                                   class="btn btn-excluir" style="text-align: center;">
                                    🗑️ Excluir Cliente
                                </a>
                                
                                <a href="clientes.php" 
                                   class="btn-voltar" style="text-align: center; justify-content: center;">
                                    ← Voltar para Listagem
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="formulario-section" style="margin-top: 30px;">
                <h3>📌 Resumo</h3>
                <div style="background: #0b0c10; padding: 15px; border-left: 4px solid #66fcf1; border-radius: 4px; color: #c5c6c7;">
                    <p><strong>Cliente ID #<?= $cliente->getId(); ?></strong> - <?= htmlspecialchars($cliente->getNome()); ?></p>
                    <p style="margin: 0; font-size: 0.9rem; color: #66fcf1;">
                        📧 <?= htmlspecialchars($cliente->getEmail()); ?>
                    </p>
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
