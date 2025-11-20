# Teste Técnico Loop – Sistema de Agendamento de Visitas

Sistema completo de agendamento de visitas para veículos, desenvolvido como teste técnico para a vaga de Engenheiro(a) Full-Stack. A aplicação utiliza backend em PHP com arquitetura limpa, frontend em React + MUI e infraestrutura containerizada com Docker.

## Sobre o Projeto

O sistema permite que usuários:
- Consultem veículos disponíveis
- Visualizem horários de agendamento
- Realizem agendamentos de visita através de uma API REST

---


## Tecnologias Utilizadas

### Backend
- **PHP 8.3** — Linguagem base da aplicação
- **Composer** — Gerenciamento de dependências
- **PHP-DI** — Container de injeção de dependências
- **FastRoute** — Biblioteca de roteamento
- **Pest** — Framework de testes automatizados
- **Mockery** — Criação de mocks para testes unitários
- **php-dotenv** — Gerenciamento de variáveis de ambiente
- **PDO** — Camada nativa de acesso ao MySQL

### Frontend
- **React + Vite** — Base da interface
- **TypeScript** — Tipagem estática
- **Material UI (MUI)** — Sistema de componentes e design
- **Emotion** — Engine de estilização do MUI
- **React Router DOM** — Roteamento da aplicação
- **React Query** — Gerenciamento de estado e cache

### Infraestrutura
- **MySQL 8** — Banco de dados relacional
- **Docker Compose** — Orquestração de containers
- **phpMyAdmin** — Interface web para gerenciamento do banco
- **Railway** — Hospedagem do backend
- **Vercel** — Hospedagem do frontend

---

## Postman Collection

A API possui uma coleção do Postman para facilitar os testes durante o desenvolvimento.

**[🔗 Acessar Coleção Postman](https://web.postman.co/workspace/My-Workspace~97512eae-740b-4d13-80ea-58cb9b4e941e/collection/43215784-95c979e1-8b62-437f-80e4-52d59fb21496?action=share&source=copy-link&creator=43215784)**

---

## Testes e Análise Estática

### Executando Testes (Pest)

Os testes automatizados garantem a qualidade e confiabilidade do código.

```bash
cd backend
composer test
```

### Executando Análise Estática (PHPStan)

A análise estática detecta erros de tipagem e garante boas práticas.

```bash
cd backend
composer stan
```

> 💡 Ambos os comandos são executados dentro do container Docker através de scripts definidos no `composer.json`, garantindo consistência entre ambientes.

---

## Como Executar o Projeto

### Início Rápido

Execute o script de setup que configura todo o ambiente automaticamente:

```bash
./setup.sh
```

Este comando irá:
- ✅ Subir todos os containers (API, MySQL, phpMyAdmin e Frontend)
- ✅ Instalar dependências do backend
- ✅ Executar migrações do banco de dados
- ✅ Popular o banco com dados iniciais (seeders)
- ✅ Deixar o ambiente completamente pronto para uso

---

## Decisões Arquiteturais

### Separação de Responsabilidades
Utilização clara de Domain, Infrastructure, Application e camada de Interface (API).

### Value Objects
Garantia de consistência e validação automática através de:
- Email
- Preço
- Localização
- Horário (SlotHour)

### DTOs para Entrada de Dados
Evita acoplamento e garante validação de inputs antes de chegar no domínio.

### Repository Pattern
Abstração do acesso ao banco de dados, permitindo troca de implementação futura.

### Inversão de Dependência (PHP-DI)
Domínio completamente desacoplado dos detalhes de infraestrutura.

### Frontend Desacoplado
- Hooks dedicados para operações da API
- React Query para cache, loading e tratamento de erros
- Componentes reutilizáveis e modulares

---

## Diagrama de Arquitetura e Fluxo

Antes de iniciar o desenvolvimento, foi criado um diagrama no Excalidraw para organizar as entidades, relacionamentos, fluxo de informações e as principais decisões arquiteturais do sistema.

Isso ajudou a estruturar:

- entidades do domínio (Vehicle, Slot, Appointment, Location)
- fluxo do usuário no front-end
- dependências entre serviços
- endpoints da API
- responsabilidades de cada camada
- regras de negócio relacionadas a datas e horários

**Diagrama (Excalidraw):**  
![architecture-diagram](./docs/diagrama.png)

