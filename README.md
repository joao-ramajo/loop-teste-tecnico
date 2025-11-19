# Teste Técnico Loop – Sistema de Agendamento de Visitas

Repositório destinado a realização do teste técnico para a vaga de Engenheiro(a) Full-Stack.

---

### Tecnologias Utilizadas

#### Backend
- **PHP 8.3** — Linguagem base da aplicação
- **Composer** — Gerenciamento de dependências
- **PHP-DI** — Container de injeção de dependências
- **FastRoute** — Lib de Roteamento
- **Pest** — Testes automatizados
- **Mockery** — Biblioteca utilizada nos testes unitários para criação de mocks
- **php-dotenv** — Gerenciamento de variáveis de ambiente
- **PDO** — Camada nativa de acesso ao banco de dados utilizada para comunicação com o MySQL

#### Infraestrutura
- **MySQL 8** — Banco de dados relacional
- **Docker Compose** — Orquestração dos containers
- **phpMyAdmin** — Interface web para visualização e gerenciamento do banco de dados

#### Frontend
- **React + Vite** — Base da interface
- **TypeScript** — Tipagem estática

> A listagem reflete os pacotes instalados no momento do desenvolvimento deste README, podendo ser adicionado ou removido conforme o desenvolvimento.

---

### Postman Collection

A API possui uma coleção do Postman para facilitar os testes dos endpoints durante o desenvolvimento.

**Acesse a coleção aqui:**  
[Coleção Postman](https://web.postman.co/workspace/My-Workspace~97512eae-740b-4d13-80ea-58cb9b4e941e/collection/43215784-95c979e1-8b62-437f-80e4-52d59fb21496?action=share&source=copy-link&creator=43215784)

---

### Execução de Testes e Análise Estática

Durante o desenvolvimento deste projeto, foram utilizados testes automatizados e análise estática de código para garantir a qualidade da aplicação.

> Para executar estes comandos você deve estar dentro de pasta `/backend`

#### Testes (Pest)

Os testes podem ser executados utilizando os scripts do Composer, que realizam a execução dentro do container Docker.

**Executar testes:**
```bash
composer test
```

#### Análise Estática (phpstan)

A análise estática garante a detecção antecipada de erros de tipagem e boas práticas no código.

**Executar análise estática:**
```bash
composer stan
```

> Ambos os comandos acima são executados dentro do container Docker por meio dos scripts definidos no composer.json, garantindo um ambiente consistente entre máquinas diferentes.

---
Aqui está a seção completa **“Como executar o projeto”** em Markdown, já formatada para encaixar no seu README perfeitamente:

---

````md
---

### Como executar o projeto

Para rodar o ambiente completo (backend + MySQL + phpMyAdmin), basta utilizar o Docker Compose.

Na raiz do projeto, execute:

```bash
docker compose up -d
````

Isso iniciará:

* API em PHP
* MySQL
* phpMyAdmin

A API ficará disponível em:

```bash
http://localhost:8080
```

O frontend ficará disponível em:

```bash
http://localhost:5174
```