<?php
require_once "dao/ClienteDAO.php";
require_once "models/Cliente.php";

$clienteDAO = new ClienteDAO();
$mensagem = null;
$tipo_mensagem = null;
$erro_db = false;
$clientes = [];

// Processar formulário de cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar'])) {
    try {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');

        $cliente = new Cliente(null, $nome, $email);
        $validacao = $cliente->validar();

        if ($validacao === true) {
            if ($clienteDAO->emailJaExiste($email)) {
                $mensagem = "❌ Este email já está cadastrado!";
                $tipo_mensagem = "erro";
            } else {
                if ($clienteDAO->inserir($cliente)) {
                    $mensagem = "✅ Cliente cadastrado com sucesso!";
                    $tipo_mensagem = "sucesso";
                } else {
                    $mensagem = "❌ Erro ao cadastrar cliente!";
                    $tipo_mensagem = "erro";
                }
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

// Buscar todos os clientes
try {
    $clientes = $clienteDAO->listar();
} catch (PDOException $e) {
    $erro_db = true;
    if (strpos($e->getMessage(), "doesn't exist") !== false) {
        $mensagem = "⚠️ Tabela não encontrada! Execute o setup primeiro.";
    } else {
        $mensagem = "❌ Erro ao acessar o banco de dados!";
    }
    $tipo_mensagem = "erro";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestão de Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>🛒 Gestão de Clientes</h1>
        <p>Cadastro, Listagem, Edição e Exclusão</p>
    </header>

    <main>
        <div style="margin-bottom: 20px;">
            <a href="index.php" class="btn-voltar">← Voltar para Página Principal</a>
        </div>

        <!-- Exibir mensagens -->
        <?php if ($mensagem): ?>
            <div class="mensagem <?= $tipo_mensagem; ?>">
                <?= $mensagem; ?>
                <?php if ($erro_db): ?>
                    <br><br>
                    <a href="setup.php" class="btn btn-primary" style="display: inline-block; margin-top: 10px;">
                        ⚙️ Clique aqui para executar o Setup
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!$erro_db): ?>
            <!-- Formulário de Cadastro -->
            <section class="formulario-section">
                <h2>📝 Cadastrar Novo Cliente</h2>
                <form method="POST" class="formulario">
                    <div class="form-grupo">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" required placeholder="Digite o nome completo">
                    </div>

                    <div class="form-grupo">
                        <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Digite o email">
                </div>

                <button type="submit" name="salvar" class="btn btn-primary">Cadastrar</button>
            </form>
        </section>

        <!-- Listagem de Clientes -->
        <section class="listagem-section">
            <h2>📋 Clientes Cadastrados</h2>

            <?php if (empty($clientes)): ?>
                <p class="sem-dados">Nenhum cliente cadastrado ainda.</p>
            <?php else: ?>
                <div class="tabela-responsiva">
                    <table class="tabela-clientes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $c): ?>
                                <tr>
                                    <td data-label="ID"><?= htmlspecialchars($c['id']); ?></td>
                                    <td data-label="Nome"><?= htmlspecialchars($c['nome']); ?></td>
                                    <td data-label="Email"><?= htmlspecialchars($c['email']); ?></td>
                                    <td data-label="Ações" class="acoes">
                                        <a href="visualizar_cliente.php?id=<?= $c['id']; ?>" class="btn btn-editar" style="background: #007bff;">👁️ Ver</a>
                                        <a href="editar_cliente.php?id=<?= $c['id']; ?>" class="btn btn-editar">✏️ Editar</a>
                                        <a href="excluir_cliente.php?id=<?= $c['id']; ?>" class="btn btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este cliente?');">🗑️ Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <p class="total-clientes">Total de clientes: <strong><?= count($clientes); ?></strong></p>
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
