# Projeto: Dashboard de Clientes com PHP, MySQL e Docker Compose

Este projeto implementa uma aplicação web que exibe um dashboard de clientes. A arquitetura é orquestrada com Docker Compose e dividida em três contêineres independentes:

1.  **Aplicação**: Um contêiner com **Apache + PHP** para executar o código da aplicação.
2.  **Banco de Dados**: Um contêiner com **MySQL** para armazenar os dados, com persistência garantida por um volume Docker.
3.  **Gerenciador de Banco**: Um contêiner com **phpMyAdmin** para facilitar a administração visual do banco de dados.

Esta abordagem desacoplada torna a aplicação mais organizada, escalável e fácil de manter.

## Pré-requisitos

Antes de começar, garanta que você tenha o [Docker](https://www.docker.com/get-started) e o Docker Compose instalados em sua máquina.

## Como Executar o Projeto

Siga os passos abaixo para subir todo o ambiente de forma automatizada.

1.  **Clone o Repositório:**
    ```bash
    git clone [https://github.com/mbrito19/meu-dashboard-php-mysql-aula05.git](https://github.com/mbrito19/meu-dashboard-php-mysql-aula05.git)
    cd meu-dashboard-php-mysql-aula05
    ```

2.  **Inicie os Serviços:**
    Execute o seguinte comando na raiz do projeto (onde o arquivo `docker-compose.yml` está localizado):
    ```bash
    docker-compose up -d
    ```
    * O comando `-d` (detached) executa os contêineres em segundo plano.
    * O Docker Compose irá automaticamente construir a imagem da aplicação, baixar as imagens do MySQL e phpMyAdmin, criar a rede, o volume e iniciar os três contêineres na ordem correta.

## Como Acessar a Aplicação

Após a execução do comando, os serviços estarão disponíveis nos seguintes endereços:

* **Dashboard de Clientes (Aplicação PHP):**
    * Acesse: **[http://localhost](http://localhost)**

* **phpMyAdmin (Gerenciador do Banco de Dados):**
    * Acesse: **[http://localhost:8080](http://localhost:8080)**
    * **Servidor:** `db`
    * **Usuário:** `user_britinho`
    * **Senha:** `StrongPassword123`

## Como Parar os Serviços

Para parar todos os contêineres relacionados a este projeto, execute o seguinte comando na raiz do projeto:

```bash
docker-compose down
```

Se desejar remover também o volume de dados do MySQL (apagando todos os dados), utilize:
```bash
docker-compose down -v
```

## Estrutura do Repositório

```
/
├── docker-compose.yml      # Orquestra todos os serviços
├── Dockerfile              # Define a imagem da aplicação PHP + Apache
├── init.sql                # Script de criação e população do banco
|
├── /src/                   # Contém o código-fonte da aplicação PHP
│   ├── index.php
│   ├── database.php
│   ├── config.php
│   └── style.css
|
└── README.md               # Esta documentação
```