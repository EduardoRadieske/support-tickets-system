# 🎟️ PHP Support Tickets System

## 🎯 Objetivo do Projeto
Desenvolver um **sistema de tickets de suporte** em **PHP Vanilla** onde usuários possam abrir chamados sobre problemas ou dúvidas, acompanhar o status e interagir com a equipe de suporte, enquanto administradores gerenciam e respondem aos tickets.

---

## 🧩 Requisitos Funcionais

### 🔐 Autenticação e Usuários
- Cadastro de usuários com nome, e-mail e senha (armazenada com hash).
- Login e logout utilizando sessões PHP.
- Perfis de usuário:
  - `Cliente`: abre e acompanha tickets.
  - `Administrador`: responde, fecha e gerencia tickets.

### 🎟️ Tickets
- Abertura de ticket: título, descrição, prioridade (baixa, média, alta).
- Status: `aberto` → `em andamento` → `resolvido` (ou `cancelado`).
- Upload de anexo opcional (imagem, PDF, etc.).
- Histórico de mensagens (cliente ↔ suporte).
- Datas automáticas de criação e atualização.
- Fechamento de ticket exclusivo para administradores.

### 💬 Mensagens
- Cada ticket possui um histórico de mensagens associadas.
- Identificação do remetente (usuário/admin) e data/hora.
- Exibição em ordem cronológica.

### 🧭 Painéis

#### Painel do Cliente
- Criar novo ticket.
- Ver lista de tickets abertos e encerrados.
- Acompanhar histórico de mensagens.
- Adicionar mensagem a um ticket.

#### Painel do Administrador
- Visualizar todos os tickets (com filtros por status e prioridade).
- Responder mensagens.
- Alterar status do ticket.
- Fechar ticket.
- (Opcional) Reatribuir ticket a outro admin.

---

## 🧱 Requisitos Técnicos
- PHP *vanilla* (sem frameworks).
- Banco de dados MySQL/MariaDB (via PDO).
- Estrutura mínima em padrão **MVC manual**:
  ```
  /app
    /controllers
    /models
    /views
  /public
    index.php
  /config
  ```
- Gerenciamento de sessão para autenticação.
- Validações de entrada e saída.
- Layout simples, responsivo (HTML + CSS).

---

## ⚙️ Fluxo de Uso (Workflow)

1. **Login**
   - Usuário acessa o sistema e faz login.
   - Sessão é criada e perfil é identificado.

2. **Cliente abre ticket**
   - Clica em “Novo Ticket”.
   - Preenche título, descrição, prioridade e (opcional) anexa um arquivo.
   - Ticket é salvo no BD com status `aberto`.

3. **Admin visualiza novos tickets**
   - Admin acessa painel → lista de tickets abertos.
   - Clica no ticket → visualiza detalhes e mensagens.
   - Adiciona resposta → status muda para `em andamento`.

4. **Troca de mensagens**
   - Cliente visualiza resposta.
   - Pode responder novamente → notificando admin.

5. **Encerramento**
   - Admin altera status para `resolvido`.
   - Ticket vai para aba “Encerrados”.

6. **Consulta de histórico**
   - Usuários podem visualizar tickets antigos e histórico de mensagens.

---

## 🗂️ Estrutura de Dados

### Tabela: users
| Campo | Tipo | Descrição |
|--------|------|------------|
| id | INT PK | Identificador |
| name | VARCHAR | Nome do usuário |
| email | VARCHAR | E-mail |
| password | VARCHAR | Senha (hash) |
| role | ENUM('admin','client') | Perfil |
| created_at | DATETIME | Data de criação |

### Tabela: tickets
| Campo | Tipo | Descrição |
|--------|------|------------|
| id | INT PK | Identificador |
| user_id | INT FK | Autor do ticket |
| title | VARCHAR | Título |
| description | TEXT | Descrição |
| priority | ENUM('low','medium','high') | Prioridade |
| status | ENUM('open','in_progress','resolved') | Estado |
| created_at | DATETIME | Criação |
| updated_at | DATETIME | Última atualização |

### Tabela: messages
| Campo | Tipo | Descrição |
|--------|------|------------|
| id | INT PK | Identificador |
| ticket_id | INT FK | Ticket relacionado |
| user_id | INT FK | Autor da mensagem |
| message | TEXT | Conteúdo da mensagem |
| created_at | DATETIME | Data da mensagem |

---

## 🚀 Extras (para aumentar o desafio)
- Notificação visual de novos tickets.
- Upload de anexos com validação de tipo/tamanho.
- Filtros e pesquisa de tickets.
- Dashboard com contagem de tickets por status.
- Middleware simples para autenticação.
- Exportação de relatório CSV.

---

## 🧭 Fluxo de Desenvolvimento (sugestão)
1. Criar estrutura de pastas (MVC manual).
2. Implementar conexão com banco (PDO).
3. Criar autenticação e controle de sessão.
4. Implementar CRUD de tickets.
5. Implementar sistema de mensagens.
6. Criar painéis separados (cliente/admin).
7. Adicionar melhorias e extras.
