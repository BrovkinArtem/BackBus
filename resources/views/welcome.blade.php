<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus API</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Bus API</h1>

    <h2>Поиск автобуса</h2>
    <form id="findBusForm">
        <label for="from">Откуда:</label>
        <input type="text" id="from" name="from" required><br>
        <label for="to">Куда:</label>
        <input type="text" id="to" name="to" required><br>
        <button type="submit">Найти автобусы</button>
    </form>

    <h3>Результат поиска:</h3>
    <div id="busResults"></div>

    <hr>

    <h2>Обновить маршрут</h2>
    <form id="updateRouteForm">
        <label for="route_id">ID маршрута:</label>
        <input type="number" id="route_id" name="route_id" required><br>
        <label for="stop_id">ID остановки:</label>
        <input type="number" id="stop_id" name="stop_id" required><br>
        <label for="direction">Направление:</label>
        <select id="direction" name="direction" required>
            <option value="forward">Вперед</option>
            <option value="backward">Назад</option>
        </select><br>
        <button type="submit">Обновить маршрут</button>
    </form>

    <h3>Результат обновления:</h3>
    <div id="updateResults"></div>

    <hr>

    <h2>Все маршруты</h2>
    <div id="allRoutes"></div>

    <script>
        // Функция для получения всех маршрутов
        function getAllRoutes() {
            $.ajax({
                url: 'http://127.0.0.1:8000/api/routes',
                type: 'GET',
                success: function(response) {
                    var routesHtml = '<ul>';
                    response.routes.forEach(function(route) {
                        var stopsHtml = route.stops.map(function(stop) {
                            return stop.name + ' (' + stop.direction + ')';
                        }).join(' -> ');
                        routesHtml += '<li>' + route.route_id + ': ' + stopsHtml + '</li>';
                    });
                    routesHtml += '</ul>';
                    $('#allRoutes').html(routesHtml);
                },
                error: function(error) {
                    $('#allRoutes').html('<p>Ошибка: не удалось загрузить маршруты</p>');
                }
            });
        }

        // Обработчик для формы поиска автобусов
        $('#findBusForm').on('submit', function(e) {
            e.preventDefault();

            var from = $('#from').val();
            var to = $('#to').val();

            $.ajax({
                url: 'http://127.0.0.1:8000/api/find-bus',
                type: 'GET',
                data: { from: from, to: to },
                success: function(response) {
                    $('#busResults').html('<pre>' + JSON.stringify(response, null, 2) + '</pre>');
                },
                error: function(error) {
                    $('#busResults').html('<p>Ошибка: ' + error.responseJSON.error + '</p>');
                }
            });
        });

        // Обработчик для формы обновления маршрута
        $('#updateRouteForm').on('submit', function(e) {
            e.preventDefault();

            var routeId = $('#route_id').val();
            var stopId = $('#stop_id').val();
            var direction = $('#direction').val();

            var data = {
                route_id: routeId,
                stops: [
                    {
                        stop_id: stopId,
                        direction: direction
                    }
                ]
            };

            $.ajax({
                url: 'http://127.0.0.1:8000/api/update-route',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function() {
                    $('#updateResults').html('<p>Данные обновлены, обновите страницу!</p>');
                    getAllRoutes();
                },
                error: function() {
                    $('#updateResults').html('<p>Данные обновлены, обновите страницу</p>');
                }
            });
        });

        // Загружаем все маршруты при загрузке страницы
        $(document).ready(function() {
            getAllRoutes();
        });
    </script>
</body>
</html>
