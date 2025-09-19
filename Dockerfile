# Usa a imagem oficial do PHP 8.2 com Apache como base.
# Esta imagem já vem com Apache configurado para servir arquivos de /var/www/html.
FROM php:8.2-apache

# Instala as dependências do sistema e as extensões PHP necessárias.
# - pdo_mysql: Essencial para o PHP se comunicar com o banco de dados MySQL.
# - zip: Extensão útil para manipulação de arquivos .zip.
# - opcache: Melhora a performance do PHP armazenando scripts pré-compilados em memória.
RUN apt-get update && \
    apt-get install -y zlib1g-dev libzip-dev unzip && \
    docker-php-ext-install pdo_mysql zip opcache

# Define o diretório de trabalho padrão para o Apache.
WORKDIR /var/www/html

# Copia os arquivos da aplicação do diretório 'src' local para o diretório de trabalho no contêiner.
# Este passo garante que a imagem contenha o código e possa ser executada de forma independente.
COPY ./src /var/www/html/

# A imagem base 'php:8.2-apache' já define o CMD ["apache2-foreground"],
# então não precisamos declará-lo novamente. O Apache iniciará automaticamente.