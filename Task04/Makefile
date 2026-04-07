install:
	cp -n .env.example .env || true
	composer install
	mkdir -p database
	touch database/database.sqlite
	php artisan key:generate
	php artisan migrate --force