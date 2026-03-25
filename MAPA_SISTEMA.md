# 📦 Mapa do Sistema Loja01

## 📊 Arquivos Criados e Estrutura Completa

### 🗃️ Configuração

- **config/Database.php** - Gerenciador de conexão PDO com auto-criação de banco

### 📐 Modelos (Models)

- **models/Cliente.php** - Classe com: id, nome, email + validação
- **models/Produto.php** - Classe com: id, nome, descrição, preço, estoque + formatação
- **models/Pedido.php** - Classe com: id, cliente, produtos[], cálculos, resumo

### 💾 Acesso a Dados (DAO)

- **dao/ClienteDAO.php** - CRUD para clientes
- **dao/ProdutoDAO.php** - CRUD para produtos
- **dao/PedidoDAO.php** - Operações de pedidos com cascata

### 👥 Módulo de Clientes

- **clientes.php** - Lista e formulário de cadastro
- **cadastro_cliente.php** - Formulário alternativo de cadastro
- **visualizar_cliente.php** - Detalha um cliente
- **editar_cliente.php** - Edita cliente
- **excluir_cliente.php** - Remove cliente com confirmação

### 📦 Módulo de Produtos

- **produtos.php** - Lista e formulário de cadastro
- **editar_produto.php** - Edita produto
- **excluir_produto.php** - Remove produto com confirmação

### 🛒 Módulo de Pedidos

- **criar_pedido.php** - Cria novo pedido com seleção de cliente e produtos
- **pedidos.php** - Lista todos os pedidos
- **visualizar_pedido.php** - Detalha um pedido completo
- **excluir_pedido.php** - Remove pedido com confirmação

### 🎨 Apresentação

- **style.css** - Estilos responsivos com gradientes e animações

### 📑 Sistema

- **index.php** - Dashboard e página inicial
- **setup.php** - Cria banco, tabelas e dados iniciais
- **teste_Conexao.php** - Verifica conexão com BD

### 📚 Documentação

- **DOCUMENTACAO.md** - Guia completo de uso (funções, arquitetura, exemplos)
- **INSTALL.md** - Instruções passo-a-passo de instalação
- **README.md** - Arquivo original (agora melhorado)

---

## ✨ Funcionalidades Implementadas

### ✅ Clientes

- [x] Listar clientes
- [x] Cadastrar cliente
- [x] Visualizar cliente por ID
- [x] Editar cliente
- [x] Excluir cliente com confirmação
- [x] Validação de email único

### ✅ Produtos

- [x] Listar produtos
- [x] Cadastrar produto
- [x] Editar produto
- [x] Excluir produto com confirmação
- [x] Validação de preço e estoque
- [x] Indicador visual de estoque baixo

### ✅ Pedidos

- [x] Criar pedido com cliente
- [x] Adicionar múltiplos produtos ao pedido
- [x] Calcular total automaticamente
- [x] Listar pedidos
- [x] Visualizar pedido completo com detalhes
- [x] Excluir pedido com confirmação
- [x] Status do pedido (pendente/concluído)
- [x] Resumo formatado

### ✅ Segurança

- [x] PDO com Prepared Statements
- [x] Validação de entrada
- [x] HTML encoding para XSS
- [x] UTF-8 charset
- [x] Foreign keys com cascata

### ✅ Design & UX

- [x] Responsivo (mobile/tablet/desktop)
- [x] Cores intuitivas
- [x] Animações suaves
- [x] Ícones visuais
- [x] Mensagens de feedback
- [x] Confirmações antes de deletar

---

## 🗄️ Banco de Dados

### 4 Tabelas Criadas

1. **clientes** - 5 registros de exemplo
2. **produtos** - 6 registros de exemplo
3. **pedidos** - Estrutura com FK
4. **itens_pedidos** - Itens dos pedidos

### Relações

```
clientes (1) ──────→ (N) pedidos
                       ↓
clientes (1) ──────→ (N) itens_pedidos ←────── (N) produtos
```

---

## 🚀 Como Começar

1. **Abrir navegador:** `http://localhost/Loja01`
2. **Clicar:** 🔧 Executar Setup
3. **Pronto!** Sistema com dados prontos para teste

---

## 📍 Ordem de Navegação Recomendada

1. **index.php** - Conheça o dashboard
2. **clientes.php** - Manage clientes (veja os 5 exemplos)
3. **produtos.php** - Gerencie produtos (veja os 6 exemplos)
4. **criar_pedido.php** - Crie um pedido escolhendo cliente e produtos
5. **pedidos.php** - Veja a lista de pedidos
6. **visualizar_pedido.php?id=1** - Detalhes completos com resumo

---

## 💡 Diagramas Rápidos

### Fluxo de Criar Pedido

```
criar_pedido.php
   ↓
Selecionar cliente (dropdown)
   ↓
Adicionar produtos (form dinâmico)
   ↓
Definir quantidades
   ↓
Calcular total (JS + PHP)
   ↓
Inserir via PedidoDAO
   ↓
Exibir resumo com exibirResumo()
```

### Arquitetura Geral

```
User Request
    ↓
[View - .php file]
    ↓
[Model - Classe Cliente/Produto/Pedido]
    ↓
[DAO - ClienteDAO/ProdutoDAO/PedidoDAO]
    ↓
[Database - config/Database.php]
    ↓
[MySQL - loja_01 database]
```

---

## 🎯 Checklist de Teste Completo

- [ ] Setup executado com sucesso
- [ ] Dashboard mostra 5 clientes, 6 produtos, 0-X pedidos
- [ ] Cadastrar novo cliente funcionando
- [ ] Listar clientes mostram todos com ações
- [ ] Visualizar cliente mostra detalhes
- [ ] Editar cliente atualiza dados
- [ ] Deletar cliente com confirmação
- [ ] Cadastrar novo produto funcionando
- [ ] Editar produto funcionando
- [ ] Deletar produto com confirmação
- [ ] Criar pedido com cliente e produtos
- [ ] Cálculo de total correto
- [ ] Listar pedidos mostra todos
- [ ] Visualizar pedido mostra todos detalhes + resumo
- [ ] Deletar pedido com confirmação

---

## 📞 Recursos de Ajuda

- **DOCUMENTACAO.md** - Detalhes de cada função
- **INSTALL.md** - Troubleshooting e setup
- **teste_Conexao.php** - Diagnosticar problemas
- **Código comentado** - Veja inline comments em cada arquivo

---

**Sistema completo e pronto para uso! 🎉**
