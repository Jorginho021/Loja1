<?php
require_once 'dao/ClienteDAO.php';
require_once 'models/Cliente.php';

$clienteDAO = new ClienteDAO();
$mensagem = null;
$tipo_mensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                $_POST = array(); // Limpar formulário
            } else {
                $mensagem = "❌ Erro ao cadastrar cliente!";
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
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>📝 Cadastrar Novo Cliente</h1>
        <p>Preencha os dados abaixo</p>
    </header>

    <main>
        <!-- Exibir mensagens -->
        <?php if ($mensagem): ?>
            <div class="mensagem <?= $tipo_mensagem; ?>">
                <?= $mensagem; ?>
            </div>
        <?php endif; ?>

        <section class="formulario-section">
            <form method="post" class="formulario">
                <div class="form-grupo">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required placeholder="Digite o nome completo" 
                           value="<?= htmlspecialchars($_POST['nome'] ?? ''); ?>">
                </div>

                <div class="form-grupo">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Digite o email" 
                           value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>

                <div class="form-acoes">
                    <button type="submit" class="btn btn-primary">✅ Cadastrar</button>
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