## Requisitos

* PHP 8.2 ou superior
* MySQL 8 ou superior
* Composer


## Como rodar o projeto


Duplicar o arquivo  ".env.exemple" e renomear para ".env" <br>
Alterar no arquivo .env as credenciais do banco de dados<br>

instalar as dependências do PHP
```
composer install
```

Gerar a chave no arquivo .env
```
php artisan key:generate
```

iniciar o projeto criado com o Laravel
```
php artisan serve
```

Para acessar a API, é recomendado utilizar o Insomnia (ou outro programa de sua preferência)
para simular requisições á API.
```
http://127.0.0.1:8000/api/users
```


## Sequencia para criar o projeto
Criar o projeto com Laravel
```
composer create-project laravel/larevel .
```

Alterar no arquivo .env as credenciais do banco de dados<br>

Criar o arquivo de rotas para API
```
php artisan install:api
```


Criar seed
```

php artisan make:seeder NomeDaSeeder
php artisan make:seeder UserSeeder
```

Executar as seeds
```
php artisan db:seed
```