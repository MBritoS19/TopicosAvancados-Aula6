<?php

/**
 * Define as constantes para a conexão com o banco de dados.
 * Estas configurações são usadas pelo Docker Compose.
 */

// O nome do host do banco de dados. No Docker Compose, este é o nome do serviço do MySQL.
define('DB_HOST', 'db');

// O nome do banco de dados, conforme definido no docker-compose.yml.
define('DB_NAME', 'britinho');

// O usuário do banco de dados, conforme definido no docker-compose.yml.
define('DB_USER', 'user_britinho');

// A senha para o usuário do banco de dados, conforme definido no docker-compose.yml.
define('DB_PASS', 'StrongPassword123');

// O charset a ser utilizado na conexão.
define('DB_CHARSET', 'utf8mb4');

?>