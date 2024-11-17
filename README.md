# BackBus
psql -h laravel_db -p 5432 -U postgres -d DBforBus - вход в базу данных докера (пароль: cpokyxa11111)

php artisan migrate - миграции

docker exec -it laravel_app bash - вход в контейнер докера

docker exec -it laravel_app php artisan serve --host=0.0.0.0 --port=8000 - локальный запуск приложения из докера

php artisan serve - запуск ларавел проекта

php artisan db:seed --class=StopsTableSeeder - запуск сидера

php artisan migrate:refresh - перезапуск миграций

Пример работы приложения:
Запрос прямо в браузере
http://127.0.0.1:8000/api/find-bus?from=ул.%20Пушкина&to=ул.%20Ленина

Через url-кодировщик передаём данные
curl -X GET "http://127.0.0.1:8000/api/find-bus?from=%D1%83%D0%BB.%20%D0%9F%D1%83%D1%88%D0%BA%D0%B8%D0%BD%D0%B0&to=%D1%83%D0%BB.%20%D0%9B%D0%B5%D0%BD%D0%B8%D0%BD%D0%B0"





