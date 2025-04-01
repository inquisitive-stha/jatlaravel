# Laravel API Installation

* Make sure docker is installed


* If you need to run commands run as
```bash
 docker compose exec --user laravel jatlaravel_app composer <command>
```


# To set up

* Clone the repository
```bash
docker compose build
docker compose up -d
```

```bash
docker compose exec --user laravel jatlaravel_app bash
```

```bash
# Install dependencies
composer install
cp .env.example .env
php artisan key:generate
```