<?php
require_once "dao/ClienteDAO.php";
require_once "models/Cliente.php";

$clienteDAO = new ClienteDAO();
$cliente = null;
$mensagem = null;
$tipo_mensagem = null;

// Verificar se o ID foi enviado pela URL
if (!isset($_GET['id'])) {
    header("Location: clientes.php");
    exit;
}

$id = intval($_GET['id']);
$cliente = $clienteDAO->buscarPorId($id);

if (!$cliente) {
    header("Location: clientes.php");
    exit;
}

// Processar formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $clienteAtualizado = new Cliente($id, $nome, $email);
    $validacao = $clienteAtualizado->validar();

    if ($validacao === true) {
        if ($clienteDAO->emailJaExiste($email, $id)) {
            $mensagem = "❌ Este email já está cadastrado para outro cliente!";
            $tipo_mensagem = "erro";
        } else {
            if ($clienteDAO->atualizar($clienteAtualizado)) {
                $mensagem = "✅ Cliente atualizado com sucesso! Redirecionando...";
                $tipo_mensagem = "sucesso";
                $cliente = $clienteAtualizado;
                // Redirecionar após 2 segundos
                header("refresh:2;url=clientes.php");
            } else {
                $mensagem = "❌ Erro ao atualizar cliente!";
                $tipo_mensagem = "erro";
            }
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
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>✏️ Editar Cliente</h1>
        <p>Atualize os dados do cliente</p>
    </header>

    <main>
        <!-- Exibir mensagens -->
        <?php if ($mensagem): ?>
            <div class="mensagem <?= $tipo_mensagem; ?>">
                <?= $mensagem; ?>
            </div>
        <?php endif; ?>

        <section class="formulario-section">
            <form method="POST" class="formulario">
                <input type="hidden" name="id" value="<?= $cliente->getId(); ?>">

                <div class="form-grupo">
                    <label for="id_display">ID do Cliente:</label>
                    <input type="text" id="id_display" value="<?= $cliente->getId(); ?>" disabled>
                </div>

                <div class="form-grupo">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($cliente->getNome()); ?>" required>
                </div>

                <div class="form-grupo">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($cliente->getEmail()); ?>" required>
                </div>

                <div class="form-acoes">
                    <button type="submit" name="atualizar" class="btn btn-primary">💾 Atualizar</button>
                    <a href="clientes.php" class="btn-voltar">← Voltar</a>
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
