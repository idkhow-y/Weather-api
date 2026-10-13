import requests

URL = "http://127.0.0.1:8000"

print("Доступні міста: Kyiv, Lviv, Odesa")
city = input("Введіть місто: ").strip().lower()

try:
    response = requests.get(
        URL,
        params={"city": city},
        timeout=10
    )

    response.raise_for_status()
    weather = response.json()

    print(f"\nПогода в місті {weather['city']}:")
    print(f"Температура: {weather['temperature']} °C")
    print(f"Вологість: {weather['humidity']} %")
    print(f"Швидкість вітру: {weather['wind_speed']} км/год")

except requests.HTTPError:
    if response.status_code == 400:
        print("Помилка: такого міста немає у списку.")
    else:
        print(f"Помилка сервера: HTTP {response.status_code}")

except requests.RequestException as error:
    print(f"Помилка з'єднання: {error}")