# 📚 Guia de Uso da API ClienteDAO

## Visão Geral

O `ClienteDAO` (Data Access Object) é responsável por todas as operações no banco de dados relacionadas a clientes.

---

## 🚀 Como Usar

### 1️⃣ Instanciar o DAO

```php
require_once "dao/ClienteDAO.php";

$dao = new ClienteDAO();
```

---

## 📝 Operações Disponíveis

### ✅ CREATE - Inserir Cliente

```php
require_once "models/Cliente.php";

$cliente = new Cliente(null, "João Silva", "joao@email.com");
$resultado = $dao->inserir($cliente);

if ($resultado) {
    echo "Cliente inserido com sucesso!";
} else {
    echo "Erro ao inserir cliente!";
}
```

---

### 📖 READ - Listar Todos os Clientes

```php
$clientes = $dao->listar();

foreach ($clientes as $cliente) {
    echo $cliente['id'] . " - " . $cliente['nome'] . "<br>";
}
```

**Retorna:** Array associativo com todos os clientes

```php
[
    ["id" => 1, "nome" => "João", "email" => "joao@email.com"],
    ["id" => 2, "nome" => "Maria", "email" => "maria@email.com"]
]
```

---

### 🔍 READ - Buscar Cliente por ID

```php
$cliente = $dao->buscarPorId(1);

if ($cliente) {
    echo "Nome: " . $cliente->getNome();
    echo "Email: " . $cliente->getEmail();
} else {
    echo "Cliente não encontrado!";
}
```

**Retorna:** Objeto `Cliente` ou `null` se não encontrado

---

### ✏️ UPDATE - Atualizar Cliente

```php
// Buscar cliente
$cliente = $dao->buscarPorId(1);

// Modificar dados
$cliente->setNome("João Silva Atualizado");
$cliente->setEmail("joao_novo@email.com");

// Atualizar no banco
$resultado = $dao->atualizar($cliente);

if ($resultado) {
    echo "Cliente atualizado com sucesso!";
}
```

---

### 🗑️ DELETE - Excluir Cliente

```php
$resultado = $dao->excluir(1);

if ($resultado) {
    echo "Cliente excluído com sucesso!";
} else {
    echo "Erro ao excluir cliente!";
}
```

---

### 🔐 Verificar Email Duplicado

```php
// Verificar se email existe
if ($dao->emailJaExiste("joao@email.com")) {
    echo "Email já cadastrado!";
} else {
    echo "Email disponível!";
}

// Ao atualizar, ignorar próprio email
if ($dao->emailJaExiste("novo@email.com", 1)) {
    echo "Email já cadastrado!";
} else {
    echo "Email disponível!";
}
```

---

## 🎯 Exemplo Completo

```php
<?php
require_once "dao/ClienteDAO.php";
require_once "models/Cliente.php";

$dao = new ClienteDAO();

// CREATE - Inserir novo cliente
$novoCliente = new Cliente(null, "Pedro", "pedro@email.com");
$dao->inserir($novoCliente);

// READ - Listar todos
$todos = $dao->listar();
echo "Total de clientes: " . count($todos);

// READ - Buscar específico por ID
$cliente = $dao->buscarPorId(1);
if ($cliente) {
    echo "Cliente encontrado: " . $cliente->getNome();
}

// UPDATE - Atualizar
$cliente->setNome("Pedro Silva");
$dao->atualizar($cliente);

// DELETE - Excluir
$dao->excluir(1);
?>
```

---

## 🔒 Segurança

Todos os métodos usam **prepared statements** para evitar SQL Injection:

```php
$sql = "SELECT * FROM clientes WHERE id = :id";
$stmt = $this->conn->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$stmt->execute();
```

---

## 📊 Estrutura de Dados

### Cliente (Array Associativo da Listagem)

```php
[
    "id"       => 1,
    "nome"     => "João Silva",
    "email"    => "joao@email.com",
    "criado_em" => "2026-03-25 14:30:00"
]
```

### Cliente (Objeto)

```php
$cliente = new Cliente($id, $nome, $email);

// Getters
$cliente->getId();
$cliente->getNome();
$cliente->getEmail();

// Setters
$cliente->setNome($novoNome);
$cliente->setEmail($novoEmail);

// Validação
$resposta = $cliente->validar();
// Retorna: true | "Mensagem de erro"
```

---

## 🐛 Tratamento de Erros

```php
try {
    $cliente = $dao->buscarPorId($id);

    if (!$cliente) {
        echo "Cliente não encontrado!";
    }
} catch (PDOException $e) {
    echo "Erro no banco de dados: " . $e->getMessage();
}
```

---

## 💡 Dicas

1. **Sempre validar antes de inserir/atualizar:**

   ```php
   $resposta = $cliente->validar();
   if ($resposta === true) {
       $dao->inserir($cliente);
   }
   ```

2. **Usar buscarPorId() antes de atualizar:**

   ```php
   $cliente = $dao->buscarPorId($id);
   if ($cliente) {
       $cliente->setNome("Novo Nome");
       $dao->atualizar($cliente);
   }
   ```

3. **Verificar email antes de inserir/atualizar:**
   ```php
   if (!$dao->emailJaExiste($email)) {
       $dao->inserir($cliente);
   }
   ```

---

## 📖 Referências

- [ClienteDAO.php](dao/ClienteDAO.php)
- [Cliente.php](models/Cliente.php)
- [Database.php](config/Database.php)
- [CRUD_COMPLETO.md](CRUD_COMPLETO.md)
