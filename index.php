<?php
require_once "models/Cliente.php";
require_once "models/Produto.php";
require_once "models/Pedido.php";
require_once "dao/ClienteDAO.php";
require_once "dao/ProdutoDAO.php";
require_once "dao/PedidoDAO.php";

$clientes = [];
$produtos = [];
$pedidos = [];
$erro = false;
$mensagem_erro = "";

try {
    $clienteDAO = new ClienteDAO();
    $clientes = $clienteDAO->listar();
    
    $produtoDAO = new ProdutoDAO();
    $produtos = $produtoDAO->listar();
    
    $pedidoDAO = new PedidoDAO();
    $pedidos = $pedidoDAO->listar();
} catch (PDOException $e) {
    $erro = true;
    $mensagem_erro = "Tabelas não encontradas! Você precisa executar o setup primeiro.";
} catch (Exception $e) {
    $erro = true;
    $mensagem_erro = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>🛒 Gestão de Clientes - Início</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>🛒 Sistema de Gestão de Clientes</h1>
        <p>📌 Bem-vindo ao CRUD Completo em PHP</p>
    </header>

    <main>
        <?php if ($erro): ?>
            <div class="mensagem erro">
                <h2>⚠️ Configuração Necessária</h2>
                <p>O banco de dados ainda não foi configurado.</p>
                <p><strong>Ação Necessária:</strong> Execute o setup para criar as tabelas.</p>
            </div>
            
            <section class="formulario-section" style="text-align: center;">
                <h3>🔧 Clique no botão abaixo para configurar:</h3>
                <a href="setup.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 12px 30px; margin: 20px 0;">
                    ⚙️ Executar Setup
                </a>
            </section>
        <?php else: ?>
            <section class="formulario-section">
                <h2>👋 Bem-vindo!</h2>
                <p>Este é um sistema de gerenciamento de clientes desenvolvido com:</p>
                <ul>
                    <li>✅ PHP Orientado a Objetos</li>
                    <li>✅ MySQL com PDO</li>
                    <li>✅ Padrão DAO</li>
                    <li>✅ Proteção contra SQL Injection</li>
                    <li>✅ Design Responsivo</li>
                </ul>
            </section>

            <section class="listagem-section">
                <h2>📊 Estatísticas</h2>
                
                <?php
                $totalClientes = count($clientes);
                $totalProdutos = count($produtos);
                $totalPedidos = count($pedidos);
                ?>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div style="background: linear-gradient(135deg, #66fcf1 0%, #45a29e 100%); color: #0b0c10; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="margin: 0; font-size: 2rem;"><?= $totalClientes; ?></h3>
                        <p style="margin: 0; opacity: 0.9;">Clientes Cadastrados</p>
                    </div>
                    <div style="background: linear-gradient(135deg, #66fcf1 0%, #45a29e 100%); color: #0b0c10; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="margin: 0; font-size: 2rem;"><?= $totalProdutos; ?></h3>
                        <p style="margin: 0; opacity: 0.9;">Produtos Cadastrados</p>
                    </div>
                    <div style="background: linear-gradient(135deg, #66fcf1 0%, #45a29e 100%); color: #0b0c10; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="margin: 0; font-size: 2rem;"><?= $totalPedidos; ?></h3>
                        <p style="margin: 0; opacity: 0.9;">Pedidos Criados</p>
                    </div>
                </div>

                <h3>🔗 Acesso Rápido</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                    <a href="clientes.php" class="btn btn-primary" style="text-align: center; padding: 12px;">👥 Ir para Clientes</a>
                    <a href="produtos.php" class="btn btn-primary" style="text-align: center; padding: 12px;">📦 Ir para Produtos</a>
                    <a href="criar_pedido.php" class="btn btn-primary" style="text-align: center; padding: 12px;">🛒 Criar Novo Pedido</a>
                    <a href="pedidos.php" class="btn btn-primary" style="text-align: center; padding: 12px;">📋 Listar Pedidos</a>
                </div>
            </section>

            <section class="formulario-section" style="margin-top: 30px;">
                <h2>🎯 Funcionalidades do Sistema</h2>
                <table class="tabela-clientes" style="margin-top: 15px;">
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>Operações</th>
                            <th>Atalho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>👥 Clientes</strong></td>
                            <td>Cadastrar, Listar, Visualizar, Editar, Excluir</td>
                            <td><a href="clientes.php" style="color: #66fcf1; text-decoration: underline;">clientes.php</a></td>
                        </tr>
                        <tr>
                            <td><strong>📦 Produtos</strong></td>
                            <td>Cadastrar, Listar, Editar, Excluir</td>
                            <td><a href="produtos.php" style="color: #66fcf1; text-decoration: underline;">produtos.php</a></td>
                        </tr>
                        <tr>
                            <td><strong>🛒 Pedidos</strong></td>
                            <td>Criar, Listar, Visualizar, Excluir</td>
                            <td><a href="pedidos.php" style="color: #66fcf1; text-decoration: underline;">pedidos.php</a></td>
                        </tr>
                        <tr>
                            <td><strong>⚙️ Sistema</strong></td>
                            <td>Padrão DAO, Segurança PDO, Design Responsivo</td>
                            <td><a href="setup.php" style="color: #66fcf1; text-decoration: underline;">setup.php</a></td>
                        </tr>
                    </tbody>
                </table>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        <p>💻 Desenvolvido com PHP orientado a objetos e banco de dados MySQL</p>
    </footer>
    <?php include 'voltar_inicio.php'; ?>
</body>
</html>