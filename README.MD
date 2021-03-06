Функционал:
-------------

- Добавлена возможность создания нового пользователя
- Добавленна API аутентификация использовал пакет Laravel Sanctum
- Добавленна возможность совершить транзакцию с помощью API запросов
- Добавлен сервис который обращается к внешним API для получаения данных об актуальных курсах по НЦ РФ (обновление курса произходит раз в минуту) - источник данных - https://cdn.cur.su/api/cbr.json
- Реализован функционал Soft Delete для пользователей - т.е. при удаление пользователя данные о его балансе сохраняются


Описание:
---------

- Интеграция сервиса Laravel Horizon (балансировщик нагрузки, менеджер очередей) и Redis помогло перенести транзакции в очередь для выполнения, это дало возможность контролировать выполнение каждой транзакции и в случаи ошибки, получить детальную информацию по ошибке, далее попробовать заново провести транзакцию из кабинета - http://3.142.52.142:777/horizon/dashboard
- Интеграция Pusher и протокола Socket помогли получать в режиме реального времени сообщения о новых транзакциях на главной странице сайта
- Благодаря Docker контейнеризации получилось создать локально микросервисную архитектуру приложения
- Благодаря AWS Elastic Conainer Servece - получилось загрузить контейнеры в облако и перенести микросервисы в AWS. Это дало возможность контроля производительности за каждым сервисом по отдельности благодаря балансировщику нагрузки ресурсов системы и в случаи чего расширять производительность отдельно взятых контейнеров для отдельного конткретного сервиса

Видеопрезентация:
-------------------------

- https://youtu.be/APpZLyMw5Z4



Cхема базы данных:
-------------
![alt text](/artifacts/database_v4.png)    

Стек:
-----------

- Laravel
- VueJS
- Pusher
- Docker
- AWS
- Redis


Из дополнительного:
---------------------

- Swagger (OpenApi) и Postman документация 

Сайт:
-------------

- http://3.142.52.142:777

phpMyAdmin (работа с бд):
---------------

- panel: http://3.142.52.142:4
- server: uae-test.czvk7mg7iqhg.us-east-2.rds.amazonaws.com
- user: root
- password: CY3fu5Y0Zx28HjgCulxB1HjKAVVrWA6ZfAqn0H3k

Laravel Horizons (работа с очередями):
---------------------------

- http://3.142.52.142:777/horizon/dashboard

OpenAPI документация (публичная API документация):
---------------------------

- http://3.142.52.142:5

email: admin@admin.com
password: admin@admin.com

email: bill@moderator.com
password: bill@moderator.com


Интрукция для развертрываения проекта
------------------------

- Обратите внимания что для работы приложения на локальном ПК необхомо устрановить Docker и поддержку makefile 

Запустите консольную команду для развретываения проекта на локальном ПК:
> make start 

Доп. задание:
----------------------

Написать SQL запрос, который вернет сумму, полученную по причине refund за последние 7 дней:

`
SELECT SUM(`value`) as sum
FROM `transactions`
WHERE `reason_for_change`='refund'
AND `created_at` > now() - interval 1 week;
`