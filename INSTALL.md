# 🚀 Guia de Instalação - Loja01

## 📋 Pré-requisitos

Antes de começar, certifique-se que você tem:

- ✅ **PHP** 7.4 ou superior
- ✅ **MySQL** 5.7 ou superior
- ✅ **Apache** com mod_rewrite habilitado
- ✅ **XAMPP** instalado (recomendado para desenvolvimento)

---

## 🛠️ Passo 1: Preparar o Ambiente (XAMPP)

### Windows/Mac/Linux

1. **Baixe e instale XAMPP**
   - Acesse: https://www.apachefriends.org/pt_BR/index.html
   - Selecione sua versão do sistema operacional
   - Execute o instalador

2. **Inicie os serviços**
   - Abra o **XAMPP Control Panel**
   - Clique em **Start** (Iniciar) para:
     - ✅ Apache
     - ✅ MySQL

---

## 📁 Passo 2: Clonar/Copiar o Projeto

### Opção A: Se você já tem os arquivos

1. **Crie uma pasta para o projeto**

   ```
   C:\xampp\htdocs\Loja01
   ```

2. **Copie todos os arquivos do projeto**
   - Coloque todos os `.php`, `.css`, `.md` e pastas `config/`, `models/`, `dao/`

3. **Verifique a estrutura**
   ```
   Loja01/
   ├── config/Database.php
   ├── models/Cliente.php
   ├── dao/ClienteDAO.php
   ├── clientes.php
   ├── index.php
   └── ... (outros arquivos)
   ```

### Opção B: Com Git (se disponível)

```bash
cd C:\xampp\htdocs
git clone https://seu-repositorio.git Loja01
cd Loja01
```

---

## 🔧 Passo 3: Configurar o Banco de Dados

### Verificar Credenciais

1. **Abra** `config/Database.php`
2. **Confirme as credenciais padrão:**

   ```php
   const DB_HOST = 'localhost';
   const DB_USER = 'root';        // Usuário padrão XAMPP
   const DB_PASS = '';            // Senha vazia por padrão
   const DB_NAME = 'loja_01';
   ```

3. **Se precisar alterar:**
   - Edite as constantes com suas credenciais
   - Salve o arquivo

### ⚠️ Importante

- XAMPP por padrão tem usuário `root` SEM senha
- Se você configurou senha, atualize em `config/Database.php`

---

## 🌐 Passo 4: Acessar a Aplicação

1. **Abra seu navegador**
2. **Digite a URL:**

   ```
   http://localhost/Loja01
   ```

3. **Você verá:**
   - Se BD não configurado: Botão para executar Setup
   - Se BD pronto: Dashboard com estatísticas

---

## ⚙️ Passo 5: Executar o Setup

1. **Na página inicial, clique em:**

   ```
   🔧 Executar Setup
   ```

2. **Ou acesse diretamente:**

   ```
   http://localhost/Loja01/setup.php
   ```

3. **O Sistema irá:**
   - ✅ Criar banco de dados `loja_01`
   - ✅ Criar 4 tabelas
   - ✅ Inserir dados de exemplo
   - ✅ Mostrar confirmação

---

## ✅ Verificação Final

Após o Setup, verifique se tudo funciona:

1. **Ir para Clientes**
   - Acesse: `http://localhost/Loja01/clientes.php`
   - Verifique se os clientes de exemplo aparecem na tabela

2. **Ir para Produtos**
   - Acesse: `http://localhost/Loja01/produtos.php`
   - Verifique se os produtos aparecem na tabela

3. **Criar um Pedido**
   - Clique em "🛒 Criar Novo Pedido"
   - Selecione um cliente
   - Adicione um produto
   - Confirme e veja o resumo

4. **Listar Pedidos**
   - Clique em "📋 Listar Pedidos"
   - Verifique se o pedido criado aparece

Se tudo funciona, **Parabéns! 🎉 A instalação foi bem-sucedida!**

---

## 🐛 Troubleshooting

### ❌ "Erro ao conectar ao banco"

**Causa:** MySQL não está rodando ou credenciais incorretas

**Solução:**

1. Abra XAMPP Control Panel
2. Verifique se MySQL está rodando (verde = funcionando)
3. Se não, clique em "Start"
4. Confirme credenciais em `config/Database.php`

### ❌ "Página em branco"

**Causa:** Erro PHP não está sendo exibido

**Solução:**

1. Adicione no início de `index.php`:

   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

2. Verifique arquivo de erro:
   - Windows: `C:\xampp\apache\logs\error.log`
   - Linux/Mac: `/Applications/XAMPP/logs/apache_error.log`

### ❌ "Arquivo não encontrado (404)"

**Causa:** Caminho incorreto

**Verificação:**

1. Confirme que pasta está em `C:\xampp\htdocs\Loja01`
2. Digite exato: `http://localhost/Loja01/`
3. Não use `http://localhost:80/` ou variações

### ❌ "Caracteres estranhos" (acentuação errada)

**Causa:** Charset não é UTF-8

**Solução:**

1. Edite `config/Database.php`
2. Altere:
   ```php
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $pdo->exec("SET CHARACTER SET utf8mb4");
   ```

### ❌ "Permissão negada" ao criar arquivos

**Causa:** Permissões de pasta insuficientes

**Solução:**

- Windows: Clic direito → Propriedades → Segurança → Permitir todos
- Linux/Mac: `chmod -R 755 Loja01/`

---

## 📊 Testando Conexão

Se ainda tiver problemas, use o arquivo de teste:

1. **Acesse:**

   ```
   http://localhost/Loja01/teste_Conexao.php
   ```

2. **Ele mostra:**
   - Versão do PHP
   - Disponibilidade do PDO
   - Status de conexão com MySQL

3. **Se vier erro vermelha:**
   - Verifique o erro específico
   - Corrija conforme descrito acima

---

## 🔄 Reinicializar o Banco

Se precisar recomeçar do zero:

1. **Acesse:**

   ```
   http://localhost/Loja01/setup.php?reset=true
   ```

2. **Ou execute manualmente:**
   - Abra phpMyAdmin
   - Delete a base `loja_01`
   - Acesse setup.php novamente

---

## 📱 Testando em Outro Computador

Para acessar de outro PC/celular na rede:

1. **Descubra seu IP:**
   - Windows: `ipconfig` no cmd
   - Linux/Mac: `ifconfig` ou `ipconfig getifaddr en0`
   - Ex: `192.168.1.100`

2. **De outro device, acesse:**

   ```
   http://192.168.1.100/Loja01
   ```

3. **Se não funcionar:**
   - Verifique firewall
   - Confirme que Apache está escutando em todas as interfaces

---

## ✨ Próximos Passos

- 📖 Leia `DOCUMENTACAO.md` para entender todas funcionalidades
- 💻 Explore o código-fonte em `models/`, `dao/`, `config/`
- 🛠️ Modifique conforme suas necessidades
- 🔐 Configure senhas em produção

---

## 📞 Dúvidas Frequentes

**P: Posso mudar o banco de dados?**
R: Sim! Edite as constantes em `config/Database.php`

**P: Como faço backup dos dados?**
R: Use phpMyAdmin → Exportar a base `loja_01` em SQL

**P: Posso usar em produção?**
R: Com cuidado! Adicione autenticação e altere senhas padrão

**P: Quanto tempo demora o setup?**
R: Menos de 1 segundo normalmente

**P: Os dados de exemplo podem ser deletados?**
R: Sim! Você tem acesso total ao sistema CRUD

---

**✅ Você está pronto para começar! Boa sorte! 🚀**
