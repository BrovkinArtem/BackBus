# BackBus
psql -h laravel_db -p 5432 -U postgres -d DBforBus - вход в базу данных докера

php artisan migrate - миграции

docker exec -it laravel_app bash - вход в контейнер докера

docker exec -it laravel_app php artisan serve --host=0.0.0.0 --port=8000 - локальный запуск приложения из докера

php artisan serve - запуск ларавел проекта
