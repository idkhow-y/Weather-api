PHP API отримує погодні дані з Open-Meteo. Консольний Python-клієнт отримує їх через локальний HTTP-запит.
Підтримувані міста: Kyiv, Lviv, Odesa.
Встановлення
composer install
py -m pip install -r client/requirements.txt

Запуск
PHP-сервер:
php -S 127.0.0.1:8000 -t public
Python-клієнт (в іншому терміналі):
py client/weather_client.py
Використано: PHP, Composer, Guzzle, Python, Requests, Open-Meteo API.