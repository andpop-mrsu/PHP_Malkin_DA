# Prime Game

**Prime Game** — это вэб-игра с использованием базы данных, в которой игроку выдается случайное целое число, он должен определить, является ли оно простым. После ввода ответа программа должна вывести соответствующее сообщение. Если число не является простым, то дополнительно вывести его нетривиальные делители.

## Установка через Github
```sh
git clone https://github.com/JesusStar/PHP_Malkin_DA
```
## Процесс запуска приложения

1. Запуск локального веб-сервера командой:  
   `php -S localhost:3000 -t public`

2. Открытие в браузере страницы:  
   [http://localhost:3000/](http://localhost:3000/)

3. Введите имя в окно.

4. Нажмите на кнопку "Начать игру".

5. Введите ответ в соответствующее поле и нажмите "Ответить".

6. Чтобы получить новое число необходимо нажать на кнопку "Новая игра".

## Процесс запуска приложения
Для работы приложения необходимо подключить SQLite3

Для этого в файле php.ini нужно добавить строчку `extension=sqlite3` без комментирования






