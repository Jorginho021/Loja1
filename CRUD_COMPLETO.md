# 🛒 CRUD Completo - Gestão de Clientes em PHP

## 📋 Descrição

Esta aplicação implementa um **CRUD completo** (Create, Read, Update, Delete) para gerenciamento de clientes usando:

- **PHP 7.4+** com Orientação a Objetos
- **MySQL** com PDO
- **Arquitetura MVC** (Model-View-Controller)
- **Padrão DAO** (Data Access Object)

---

## 🎯 Funcionalidades

✅ **Create** - Cadastrar novo cliente  
✅ **Read** - Listar clientes, buscar por ID e visualizar detalhes  
✅ **Update** - Editar dados do cliente  
✅ **Delete** - Excluir cliente (com confirmação)  
✅ **Validação** - Email único e campos obrigatórios  
✅ **Busca** - Visualizar cliente completo por ID  
✅ **Segurança** - Proteção contra SQL Injection via PDO  
✅ **Responsivo** - Design adaptado para celular e desktop

---

## 📁 Estrutura do Projeto

```
projeto_loja/
│
├── config/
│   └── Database.php              # Configuração da conexão com o banco
│
├── models/
│   └── Cliente.php               # Classe do modelo Cliente
│
├── dao/
│   └── ClienteDAO.php            # Camada de acesso aos dados
│
├── clientes.php                  # Listagem e cadastro de clientes
├── visualizar_cliente.php        # Visualizar detalhes do cliente por ID
├── editar_cliente.php            # Página para editar cliente
├── excluir_cliente.php           # Página para excluir cliente
├── setup.php                     # Script para criar a tabela
├── style.css                     # Estilos CSS
├── index.php                     # Página inicial
│
└── CRUD_COMPLETO.md              # Este arquivo
```

---

## 🚀 Como Usar

### 1️⃣ Configuração do Banco de Dados

Abra `config/Database.php` e ajuste as credenciais:

```php
private $host = "localhost";
private $db_name = "loja_01";      // Mude o nome se necessário
private $user = "root";             // Seu usuário MySQL
private $password = "";             // Sua senha MySQL
```

### 2️⃣ Executar Setup

1. Acesse no navegador: `http://localhost/Loja01/setup.php`
2. O script irá:
   - Criar a banco de dados `loja_01` (se não existir)
   - Criar a tabela `clientes`
   - Inserir dados de exemplo

### 3️⃣ Acessar a Aplicação

Abra no navegador: `http://localhost/Loja01/clientes.php`

---

## 🧩 Componentes

### 📝 Classe `Cliente` (models/Cliente.php)

Representa um cliente com seus atributos e validações.

```php
$cliente = new Cliente(1, "João Silva", "joao@email.com");
echo $cliente->getNome(); // João Silva
```

### 🔌 Classe `Database` (config/Database.php)

Gerencia a conexão com o banco de dados usando PDO.

```php
$db = new Database();
$conn = $db->getConnection();
```

### 📊 Classe `ClienteDAO` (dao/ClienteDAO.php)

Implementa todas as operações CRUD:

```php
$dao = new ClienteDAO();

// CREATE
$dao->inserir($cliente);

// READ
$clientes = $dao->listar();
$cliente = $dao->buscarPorId(1);

// UPDATE
$dao->atualizar($cliente);

// DELETE
$dao->excluir(1);
```

---

## 🔐 Segurança

A aplicação usa **PDO com prepared statements** para evitar SQL Injection:

```php
$sql = "SELECT * FROM clientes WHERE id = :id";
$stmt = $this->conn->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();
```

Isso garante que os valores sejam escapados adequadamente.

---

## 📱 Responsividade

O CSS foi otimizado para:

- 📱 Celulares (< 768px)
- 💻 Tablets (768px - 1024px)
- 🖥️ Desktops (> 1024px)

---

## 🧪 Fluxo de Uso

### ✏️ Cadastrar Cliente

1. Acesse `clientes.php`
2. Preencha o formulário (Nome e Email)
3. Clique em "Cadastrar"
4. Cliente aparece na tabela abaixo

### 📖 Listar Clientes

Automaticamente exibida em `clientes.php`

### �️ Visualizar Cliente por ID

1. Na tabela de clientes, clique no botão **👁️ Ver** de um cliente
2. Uma página com os detalhes do cliente será exibida
3. Você pode:
   - Visualizar ID, Nome e Email
   - Clicar em **Editar** para modificar
   - Clicar em **Excluir** para remover
   - Voltar para lista de clientes

> **Nota**: O método `buscarPorId($id)` do DAO retorna um objeto `Cliente` com os dados do banco de dados.

### 🔧 Editar Cliente

1. Clique no botão **✏️ Editar** de um cliente
2. Modifique os dados
3. Clique em **Atualizar**

### 🗑️ Excluir Cliente

1. Clique no botão **🗑️ Excluir** de um cliente
2. Confirme a exclusão (ação irreversível!)
3. Cliente é removido do banco

---

## 🎓 Conceitos Aprendidos

Esta aplicação ilustra:

1. **Orientação a Objetos**: Classes, properties, methods
2. **PDO**: Conexão segura com banco de dados
3. **Prepared Statements**: Proteção contra SQL Injection
4. **Padrão DAO**: Separação entre lógica e dados
5. **Validação**: Dados com regras de negócio
6. **HTML/CSS**: Formulários responsivos
7. **JavaScript**: Confirmação com `confirm()`

---

## 🐛 Troubleshooting

### ❌ Erro: "SQLSTATE[HY000]: General error..."

**Causa**: Banco de dados não criado ou credenciais erradas  
**Solução**: Verifique `config/Database.php` e execute `setup.php`

### ❌ Erro: "Class not found"

**Causa**: Caminho incorreto nos `require_once`  
**Solução**: Verifique os paths em `dao/ClienteDAO.php`

### ❌ Erro ao excluir cliente

**Causa**: Chave estrangeira (se houver relacionamentos)  
**Solução**: Exclua primeiro os relacionamentos

---

## 💡 Dicas

- Use o navegador (F12) para inspecionar formulários e CSS
- Teste com dados inválidos para ver as validações
- Modifique a query SQL em `ClienteDAO::listar()` para ordenar diferente
- Estenda a classe `Cliente` com mais atributos (telefone, endereço, etc.)

---

## 📚 Referências

- [PDO Documentation](https://www.php.net/manual/en/book.pdo.php)
- [PHP OOP](https://www.php.net/manual/en/language.oop5.php)
- [HTML Forms](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form)
- [CSS Grid](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Grid_Layout)

---

## 👨‍💻 Autor

Desenvolvido como projeto educacional em PHP com banco de dados.

**Data**: Março de 2026

---

**Quer adicionar mais funcionalidades? Considere:**

- ✅ Autenticação de usuários
- ✅ Upload de fotografia do cliente
- ✅ Histórico de pedidos
- ✅ Sistema de permissões (admin/user)
- ✅ Relatórios em PDF
