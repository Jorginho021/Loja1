# Loja1

📘 Projeto Loja — CRUD de Clientes com PHP (PDO)

Este projeto é um sistema simples de cadastro de clientes utilizando PHP orientado a objetos, PDO e MySQL, com foco em organização de código e segurança.

🚀 Funcionalidades

O sistema realiza um CRUD completo:

✅ Cadastrar clientes (CREATE)
📋 Listar clientes (READ)
✏️ Editar clientes (UPDATE)
🗑 Excluir clientes (DELETE)
🏗 Estrutura do Projeto
projeto_loja/
│
├── config/
│   └── Database.php        # Conexão com banco
│
├── models/
│   └── Cliente.php         # Classe Cliente (POO)
│
├── dao/
│   └── ClienteDAO.php      # Regras de acesso ao banco
│
├── clientes.php            # Cadastro + listagem
├── editar_cliente.php      # Edição de cliente
└── excluir_cliente.php     # Exclusão de cliente
🧠 Conceito Principal

O projeto utiliza separação em camadas, onde cada parte tem sua responsabilidade:

Model → representa os dados (Cliente)
DAO → faz comunicação com o banco
Páginas PHP → interface com o usuário

Isso deixa o código mais organizado, seguro e fácil de manter.

🗄 Banco de Dados

Execute o seguinte SQL para criar a tabela:

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);
🔌 Conexão com o Banco

A conexão é feita usando PDO, que permite maior segurança e controle:

Evita SQL Injection
Trabalha com Prepared Statements
Suporta múltiplos bancos
🔐 Segurança

O sistema usa:

prepare()
bindValue()

Isso impede ataques de SQL Injection, pois separa:

Estrutura da SQL
Dados do usuário

❌ Errado:

"SELECT * FROM clientes WHERE id = $id"

✅ Correto:

"SELECT * FROM clientes WHERE id = :id"
🔄 Fluxo da Aplicação
Usuário preenche formulário
Dados vão para $_POST
Objeto Cliente é criado
DAO recebe o objeto
PDO executa a query
Banco armazena ou retorna dados
Resultado é exibido na tela
🧪 Melhorias Sugeridas

Você pode evoluir o projeto com:

✔ Validação de dados (nome e email)
✔ Mensagens de erro mais claras
✔ Confirmação ao excluir cliente
✔ Estilização com CSS
✔ Sistema de login
✔ Exclusão lógica (status ou deleted_at)
🏆 Tecnologias Utilizadas
PHP
MySQL
PDO
HTML
📌 Objetivo do Projeto

Este projeto foi desenvolvido para aprendizado de:

Programação Orientada a Objetos (POO)
CRUD completo
Integração PHP + MySQL
Segurança básica em aplicações web
Organização de código (base para MVC)
👨‍💻 Autor
Jorge Cardoso de Jesus
Projeto desenvolvido para fins educacionais.
