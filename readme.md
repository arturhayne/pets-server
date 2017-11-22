## Instalação Tradicional ##

- Seguir a instalação dos pré requisitos via [README Instalação Pré Requisitos](docs/readme-install-prerequisites.md).

## Configurando o projeto ##


```sh
cd {pasta_do_projeto}
cp .env.development .env
```
- Ajuste o **.env** com as informações do banco de dados, email e etc...

```sh
cd {pasta_do_projeto}

composer global require "laravel/installer"
composer global require phpunit/phpunit

# Dando permissão nas pastas do laravel
chmod 777 -R storage
chmod 777 -R bootstrap/cache

# Instalando as dependencias
COMPOSER_PROCESS_TIMEOUT=2000 composer install

# Gerando as chaves
php artisan key:generate
php artisan jwt:secret

# Gerando os dados de usuários padrão no banco
php artisan migrate --seed
```

## Colocando para Rodar ##

```sh
cd {pasta_do_projeto}
npm run server (Este comando inicia o servidor php na porta 5000)
```

- Usuário administrador na API

  - email: **admin-base@prodeb.com** 
  - senha: **Prodeb01**
