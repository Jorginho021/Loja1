# 📱 Sistema de Gestão Loja01 - Documentação Completa

<div style="margin-bottom: 20px;">
  <a href="index.php" class="btn-voltar" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(135deg, #66fcf1 0%, #45a29e 100%); color: #0b0c10; border: none; border-radius: 6px; font-weight: 600; font-size: 1rem; cursor: pointer; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 252, 241, 0.3);">
    ← Voltar para Página Principal
  </a>
</div>

## 🎯 Visão Geral

Bem-vindo ao **Loja01**, um sistema profissional de gestão e-commerce desenvolvido em PHP com MySQL. O sistema gerencia:

- ✅ **Clientes** - Cadastro, busca e gestão de informações
- ✅ **Produtos** - Catálogo com preços e estoque
- ✅ **Pedidos** - Criação de pedidos com múltiplos produtos
- ✅ **Cálculos automáticos** - Totais e subtotais com formatação em Real (R$)

---

## 🛠️ Stack Tecnológico

| Tecnologia | Versão | Função                             |
| ---------- | ------ | ---------------------------------- |
| **PHP**    | 7.4+   | Backend orientado a objetos        |
| **MySQL**  | 5.7+   | Banco de dados relacional          |
| **PDO**    | Nativo | Abstração de banco de dados segura |
| **CSS**    | 3      | Design responsivo e animações      |
| **HTML5**  | 5      | Estrutura semântica                |

---

## 📁 Estrutura de Arquivos

```
Loja01/
├── config/
│   └── Database.php          # Gerenciador de conexão PDO
├── models/
│   ├── Cliente.php           # Classe modelo de Cliente
│   ├── Produto.php           # Classe modelo de Produto
│   └── Pedido.php            # Classe modelo de Pedido
├── dao/
│   ├── ClienteDAO.php        # Operações de banco de dados - Clientes
│   ├── ProdutoDAO.php        # Operações de banco de dados - Produtos
│   └── PedidoDAO.php         # Operações de banco de dados - Pedidos
├── index.php                 # Página de boas-vindas e dashboard
├── clientes.php              # Gestão de clientes
├── cadastro_cliente.php      # Formulário de cadastro (alternativo)
├── visualizar_cliente.php    # Exibe detalhes de um cliente
├── editar_cliente.php        # Edita dados do cliente
├── excluir_cliente.php       # Deleta cliente (com confirmação)
├── produtos.php              # Gestão de produtos
├── editar_produto.php        # Edita dados do produto
├── excluir_produto.php       # Deleta produto (com confirmação)
├── criar_pedido.php          # Cria novo pedido
├── pedidos.php               # Lista todos os pedidos
├── visualizar_pedido.php     # Exibe detalhes completos do pedido
├── excluir_pedido.php        # Deleta pedido (com confirmação)
├── setup.php                 # Cria tabelas e insere dados iniciais
├── style.css                 # Estilos e responsividade
├── teste_Conexao.php         # Teste básico de conexão com BD
└── README.md                 # Este arquivo
```

---

## 🚀 Como Começar

### 1️⃣ Primeiro Acesso

Ao abrir **http://localhost/Loja01/**, você será redirecionado para a página inicial onde verá dois cenários:

**Se o banco de dados não está configurado:**

```
❌ Configuração Necessária
O banco de dados ainda não foi configurado.
Execute o setup para criar as tabelas.
[⚙️ Executar Setup]
```

**Se o banco de dados está pronto:**

```
📊 Dashboard com:
- Total de clientes
- Total de produtos
- Total de pedidos
```

### 2️⃣ Executar o Setup

Clique em **[⚙️ Executar Setup]** ou vá para `http://localhost/Loja01/setup.php`

Isso irá:

1. ✅ Criar o banco de dados `loja_01` (se não existir)
2. ✅ Criar 4 tabelas:
   - `clientes` - Informações de clientes
   - `produtos` - Catálogo de produtos
   - `pedidos` - Cabeçalho dos pedidos
   - `itens_pedidos` - Itens dentro de cada pedido
3. ✅ Inserir dados de exemplo para testes

---

## 📚 Navegação Principal

### 👥 Módulo de Clientes

**Arquivo:** `clientes.php`

**Funcionalidades:**

- ✅ Listar todos os clientes
- ✅ Cadastrar novo cliente (nome + email)
- ✅ Visualizar detalhes de um cliente
- ✅ Editar informações do cliente
- ✅ Excluir cliente com confirmação

**Fluxo:**

```
clientes.php
├── + Novo Cliente → formulário
├── Listar → tabela com ações
├── Visualizar → visualizar_cliente.php
├── Editar → editar_cliente.php
└── Excluir → excluir_cliente.php (com confirmação)
```

**Exemplo de uso:**

1. Acesse `http://localhost/Loja01/clientes.php`
2. Preencha o formulário com nome e email
3. Clique em "✅ Cadastrar"
4. Veja na tabela abaixo

### 📦 Módulo de Produtos

**Arquivo:** `produtos.php`

**Funcionalidades:**

- ✅ Listar todos os produtos
- ✅ Cadastrar novo produto (nome, descrição, preço, estoque)
- ✅ Editar produto
- ✅ Excluir produto com confirmação

**Fluxo:**

```
produtos.php
├── + Novo Produto → formulário
├── Listar → tabela com ações
├── Editar → editar_produto.php
└── Excluir → excluir_produto.php (com confirmação)
```

**Preços e Estoques:**

- Preços em Real (R$) com 2 casas decimais
- Estoque com código de cores:
  - 🟢 Verde: Estoque > 5 unidades
  - 🟡 Amarelo: Estoque ≤ 5 unidades

### 🛒 Módulo de Pedidos

**Arquivo:** `criar_pedido.php` e `pedidos.php`

**Criando um Pedido:**

1. Acesse `http://localhost/Loja01/criar_pedido.php`
2. Selecione um cliente na lista
3. Clique em "➕ Adicionar Produto"
4. Escolha o produto e quantidade
5. Clique em "✅ Confirmar Pedido"
6. Veja o resumo com total calculado automaticamente

**Listando Pedidos:**

1. Acesse `http://localhost/Loja01/pedidos.php`
2. Tabela mostra: ID, Cliente, Total, Status, Data
3. Clique em "👁️ Ver" para detalhar
4. Clique em "🗑️ Excluir" para remover (com confirmação)

**Visualizando Detalhes:**

1. Acesse `visualizar_pedido.php?id=1`
2. Veja:
   - ID do pedido
   - Nome do cliente
   - Status (Pendente/Concluído)
   - Data e hora
   - Lista de produtos com quantidades
   - Preços unitários e subtotais
   - **Total em destaque**
   - Resumo formatado completo

---

## 🔐 Segurança

O sistema implementa as melhores práticas de segurança:

### ✅ PDO com Prepared Statements

Todas as queries usam **prepared statements** com `bindValue()` para prevenir SQL Injection:

```php
// ❌ INSEGURO (não é assim no sistema)
$resultado = $pdo->query("SELECT * FROM clientes WHERE id = $_GET[id]");

// ✅ SEGURO (assim funciona no sistema)
$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
```

### ✅ Validação de Entrada

Todos os dados são validados antes de serem salvos:

- Nomes não podem estar vazios
- Emails verificados para formato válido
- Preços devem ser > 0
- Estoques devem ser >= 0

### ✅ HTML Encoding

Usar `htmlspecialchars()` para exibir dados do banco, prevenindo XSS:

```php
echo htmlspecialchars($cliente->getNome());
```

### ✅ Charset UTF-8

Banco de dados e conexão configurados com UTF-8 para suportar acentuação.

---

## 🏗️ Arquitetura

### Padrão MVC + DAO

```
Requisição HTTP
    ↓
[Página PHP - Controller]
    ├─ Processa dados
    ├─ Valida entrada
    └─ Chama DAO
        ↓
    [DAO - Data Access Object]
        ├─ Executa SQL
        └─ Retorna dados
            ↓
        [Model - Dados/Lógica]
            ├─ Getters/Setters
            ├─ Validação
            └─ Formatação
                ↓
        [View - HTML/CSS]
            └─ Exibe resultado
```

### Classes Principais

#### **Cliente (models/Cliente.php)**

```php
class Cliente {
    private $id;
    private $nome;
    private $email;

    // Validação: nome não vazio, email válido
    public function validar() { ... }
}
```

#### **Produto (models/Produto.php)**

```php
class Produto {
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $estoque;

    // Formatação: preco em R$ X.XXX,XX
    public function getPrecoFormatado() { ... }
}
```

#### **Pedido (models/Pedido.php)**

```php
class Pedido {
    private $id;
    private $clienteId;
    private $clienteNome;
    private $produtos = [];

    // Adiciona produto ao pedido
    public function adicionarProduto($id, $nome, $preco, $qtd) { ... }

    // Calcula total automaticamente
    public function calcularTotal() { ... }

    // Formata em R$
    public function calcularTotalFormatado() { ... }

    // Exibe resumo formatado
    public function exibirResumo() { ... }
}
```

#### **ClienteDAO (dao/ClienteDAO.php)**

```php
class ClienteDAO {
    public function inserir(Cliente $cliente);  // CREATE
    public function listar();                   // READ (todos)
    public function buscarPorId($id);          // READ (um)
    public function atualizar(Cliente $cliente); // UPDATE
    public function excluir($id);              // DELETE
}
```

---

## 📊 Banco de Dados

### Tabela: clientes

```sql
CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
```

### Tabela: produtos

```sql
CREATE TABLE produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT,
  preco DECIMAL(10,2) NOT NULL,
  estoque INT DEFAULT 0,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
```

### Tabela: pedidos

```sql
CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_id INT NOT NULL,
  cliente_nome VARCHAR(100),
  total DECIMAL(10,2) DEFAULT 0,
  status VARCHAR(20) DEFAULT 'pendente',
  data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (cliente_id) REFERENCES clientes(id)
    ON DELETE CASCADE
)
```

### Tabela: itens_pedidos

```sql
CREATE TABLE itens_pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT NOT NULL,
  produto_id INT NOT NULL,
  produto_nome VARCHAR(100),
  preco DECIMAL(10,2),
  quantidade INT,
  subtotal DECIMAL(10,2),
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
    ON DELETE CASCADE,
  FOREIGN KEY (produto_id) REFERENCES produtos(id)
)
```

---

## 💻 Como Usar os DAOs

### Exemplo 1: Listar todos os clientes

```php
require_once "dao/ClienteDAO.php";

$clienteDAO = new ClienteDAO();
$clientes = $clienteDAO->listar();

foreach ($clientes as $cliente) {
    echo $cliente['nome']; // ou use getters se for objeto
}
```

### Exemplo 2: Buscar cliente por ID

```php
$cliente = $clienteDAO->buscarPorId(1);
if ($cliente) {
    echo $cliente->getNome();
}
```

### Exemplo 3: Cadastrar novo cliente

```php
require_once "models/Cliente.php";

$cliente = new Cliente(null, "João Silva", "joao@email.com");

if ($cliente->validar() === true) {
    $id = $clienteDAO->inserir($cliente);
    echo "Cliente cadastrado com ID: $id";
}
```

### Exemplo 4: Criar um pedido com múltiplos produtos

```php
require_once "models/Pedido.php";
require_once "dao/PedidoDAO.php";

$pedido = new Pedido(null, 1, "João Silva"); // cliente_id=1

// Adicionar produtos
$pedido->adicionarProduto(1, "Mouse", 150.00, 2);
$pedido->adicionarProduto(2, "Teclado", 450.00, 1);

echo "Total: " . $pedido->calcularTotalFormatado(); // R$ 750,00

$pedidoDAO = new PedidoDAO();
$pedidoDAO->inserir($pedido);
```

---

## 🎨 Design e Responsividade

O sistema é **totalmente responsivo** e funciona em:

- 📱 Smartphones
- 📱 Tablets
- 💻 Desktops

**Features de Design:**

- ✅ Gradientes modernas
- ✅ Animações suaves
- ✅ Cores intuitivas (verde=ativo, vermelho=deletar, azul=info)
- ✅ Tabelas com breakpoints para celular
- ✅ Formulários grandes e fáceis de usar
- ✅ Mensagens de sucesso/erro destacadas

---

## 🐛 Troubleshooting

### ❌ "Tabela não encontrada"

**Solução:** Execute `setup.php` primeiro

### ❌ "Erro ao conectar ao banco de dados"

**Solução:**

1. Verifique se MySQL está rodando
2. Confirme credenciais em `config/Database.php`
3. Verifique permissões de pasta (todos devem ter acesso)

### ❌ "Caracteres acentuados aparecendo errados"

**Solução:** Sistema já usa UTF-8, mas pode ser editado em `config/Database.php`

### ❌ Página em branco

**Solução:**

1. Verifique `error_log` do Apache
2. Teste em `teste_Conexao.php`
3. Confirme PHP versão é 7.4+

---

## 📝 Dados Iniciais

Após executar `setup.php`, o sistema vem com dados de exemplo:

**5 Clientes:**

- João Silva (joao@email.com)
- Maria Santos (maria@email.com)
- Pedro Costa (pedro@email.com)
- Ana Oliveira (ana@email.com)
- Carlos Souza (carlos@email.com)

**6 Produtos:**

- Notebook Dell (R$ 3.500,00)
- Mouse Gamer (R$ 150,00)
- Teclado Mecânico (R$ 450,00)
- Monitor 24" (R$ 800,00)
- Webcam HD (R$ 200,00)
- Headset Wireless (R$ 280,00)

Você pode deletar e criar seus próprios dados!

---

## 📖 Referências Rápidas

| Ação               | URL                            |
| ------------------ | ------------------------------ |
| Home               | `/`                            |
| Dashboard          | `/index.php`                   |
| Listar Clientes    | `/clientes.php`                |
| Cadastrar Cliente  | `/cadastro_cliente.php`        |
| Gerenciar Produtos | `/produtos.php`                |
| Criar Pedido       | `/criar_pedido.php`            |
| Listar Pedidos     | `/pedidos.php`                 |
| Setup Inicial      | `/setup.php`                   |
| Ver Cliente        | `/visualizar_cliente.php?id=1` |
| Ver Pedido         | `/visualizar_pedido.php?id=1`  |
| Editar Cliente     | `/editar_cliente.php?id=1`     |
| Editar Produto     | `/editar_produto.php?id=1`     |
| Deletar Cliente    | `/excluir_cliente.php?id=1`    |
| Deletar Produto    | `/excluir_produto.php?id=1`    |
| Deletar Pedido     | `/excluir_pedido.php?id=1`     |

---

## ✨ Funcionalidades Avançadas

- 🔒 **Segurança**: PDO + Prepared Statements
- 🗄️ **Banco de dados**: Foreign keys + Cascading deletes
- 📊 **Cálculos**: Totais automáticos e formatação em Real
- 📱 **Responsivo**: Mobile-first design
- 🎨 **Moderno**: Gradientes e animações
- ♿ **Acessível**: HTML5 semântico
- 📝 **Validação**: Cliente e servidor

---

## 🚀 Próximas Melhorias

Ideias para expandir o sistema:

- Adicionar autenticação de usuários
- Gerar relatórios em PDF
- Integração com gateway de pagamento
- Histórico de alterações
- Dashboard com gráficos
- API REST para integração mobile

---

## 📞 Suporte

Para dúvidas ou problemas:

1. Verifique este README
2. Teste em `teste_Conexao.php`
3. Consulte os comentários no código-fonte

---

**✅ Sistema desenvolvido com PHP 7.4+ | MySQL 5.7+ | Design Responsivo**

**Última atualização:** Dezembro 2024
