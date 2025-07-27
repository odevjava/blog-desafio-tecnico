# Blog com Integração DummyJSON - Desafio Técnico.

Uma aplicação web de blog totalmente funcional construída com Laravel, que consome dados da API DummyJSON. O sistema permite visualizar posts, perfis de usuários, interagir com likes/dislikes e filtrar conteúdo de forma avançada. Este projeto foi desenvolvido como uma solução para o desafio técnico da XMX.

## ✨ Funcionalidades

- **Sincronização de Dados via API:** Um comando Artisan (`php artisan sync:api-data`) para popular o banco de dados local com usuários, posts e comentários da DummyJSON.
- **Listagem de Posts:** Página inicial com paginação (30 posts por página).
- **Detalhes do Post:** Visualização completa do post, incluindo corpo, tags, contador de views e seção de comentários.
- **Páginas de Usuário:**
  - Visualização do perfil completo do usuário.
  - Página dedicada para listar todos os posts de um usuário específico.
- **Sistema de Interação Avançado:**
  - Funcionalidade de **Like e Dislike** com lógica de "toggle" (clicar novamente desfaz a ação).
  - Interações são mutuamente exclusivas (um like remove um dislike e vice-versa).
  - O estado da interação (like/dislike) é salvo na sessão do usuário, proporcionando feedback visual consistente.
- **Filtros e Ordenação Complexos:**
  - Busca por **título** do post.
  - Filtro por **tag**.
  - Ordenação por **data de publicação** (mais recentes, mais antigos).
  - Ordenação por **popularidade** (mais curtidos, menos curtidos).
- **Navegação Intuitiva:** Links clicáveis em nomes de autores e contadores de comentários para uma experiência de usuário fluida.

## 🚀 Tecnologias Utilizadas

- **Backend:** Laravel 10.x, PHP 8.1+
- **Frontend:** Blade, Tailwind CSS 3.x, Vite
- **Banco de Dados:** MySQL (ou outro de sua preferência)
- **Integração:** Cliente HTTP do Laravel para consumo da API REST DummyJSON.

## ⚙️ Instalação e Configuração

Siga os passos abaixo para configurar e rodar o projeto em seu ambiente local.

### Pré-requisitos
- PHP 8.1 ou superior
- Composer
- Node.js e NPM
- Um servidor de banco de dados (ex: MySQL)

### Passos

1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/seu-usuario/seu-repositorio.git
    cd seu-repositorio
    ```

2.  **Instale as dependências PHP:**
    ```bash
    composer install
    ```

3.  **Instale as dependências de frontend:**
    ```bash
    npm install
    ```

4.  **Configure o ambiente:**
    - Copie o arquivo de exemplo `.env.example` para `.env`.
      ```bash
      cp .env.example .env
      ```
    - Gere uma nova chave de aplicação.
      ```bash
      php artisan key:generate
      ```

5.  **Configure o Banco de Dados:**
    - Abra o arquivo `.env` e atualize as variáveis de banco de dados (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, etc.).
    - Crie o banco de dados no seu servidor MySQL.

6.  **Execute as Migrations:**
    Este comando irá criar todas as tabelas necessárias no banco de dados.
    ```bash
    php artisan migrate
    ```

7.  **Sincronize os dados da API:**
    Este é o comando customizado para popular o banco de dados.
    ```bash
    php artisan sync:api-data
    ```

8.  **Inicie os servidores de desenvolvimento:**
    - Em um terminal, inicie o servidor do Laravel:
      ```bash
      php artisan serve
      ```
    - Em outro terminal, inicie o servidor do Vite para compilar os assets (CSS, JS):
      ```bash
      npm run dev
      ```

A aplicação estará disponível em `http://127.0.0.1:8000`.

## 🎬 Link da Apresentação

https://www.loom.com/share/87b7fd44cd0a4f40a1b3902c18a40084?sid=c3bcbd30-41c9-4aa2-b9a8-b66709fb14fd

---
