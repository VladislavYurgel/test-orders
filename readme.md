## Тестовое задание

Разработать систему учета заказов

Пользователь создает заказ, добавляя в него несколько товаров
У заказа несколько статусов 
- Создан
- Обработан
- Передан курьеру
- Выполнен
- Отменен

Возможные переходы между статусами отображены на картинке ниже

<p align="center"><img src="https://i.ibb.co/Hg4gCQ0/test.jpg"></p>

## Задание

- Реализовать Rest API с возможностью:
    - создания заказа и добавления в него нескольких товаров.
    - смена статуса заказа
- Реализовать persistent-хранилище информации о заказах и товарах
- Реализовать консольные  команды, которые будут дублировать функционал Rest API

## Installation

This installation requires `docker-compose`

- Clone this repository to the local computer folder

```bash
git clone https://github.com/VladislavYurgel/test-orders
```

- Pull the latest updated from the `origin/master` branch

```bash
git pull origin master
```

- Go to the project folder

- Default host name is `smartsatu.test`, so modify the `hosts` file or always use the `localhost` url
    - Open `hosts` file and add the next row
    ``` bash
    127.0.0.1 smartsatu.test
    ```

- Run the docker containers

```bash
sudo make docker-start
```

- Install `laravel` vendor packages

```bash
sudo make composer install
```

- Copy `.env.example` as `.env` in the project root folder

```bash
cp ./.env.example ./.env
```

- Generate key for encoding, migrate the database and run the database seeders

```bash
docker-exec -it php bash

> php artisan key:generate
> php artisan migrate:fresh && php artisan db:seed
```

## Project Commands Instruction

- Show help of the `makefile`
```bash
sudo make help
```

- Run the project tests
```bash
sudo make tests
```

- Execute a command to add goods to the order

```bash
docker-exec -it php bash

> php artisan order:good:add --user=1 --id=1:2 --id=2:3 --id=3
```

- Execute a command to change the order status

```bash
docker-exec -it php bash

> php artisan order:status:change --user=1 --status=2
```

## API Usage Instruction

In the next specified url the `{url}` is understood as `localhost` or `smartsatu.test`

- API request for user login
    - Test credentials is:
        - `email` customer1@example.com
        - `password` 12dfD478
        
    - Request params:
        - `email` string
        - `password` string
        
    - When request is executed
        - Copy received JWT `{token}` and use it in the next request in `Authorization` header with `Bearer {token}` value
```text
http://{url}/api/auth/login
```

- API request to add a goods to the order
    - Request headers:
        - `Authorization` `Bearer {token}`
    - Request params:
        - Goods array with `good id` and `good quantity`, on ex. `goods[0][id]` and `goods[0][quantity]` 
```text
http://{url}/api/order/goods/add
```

- API request to change the order status
    - Request headers:
        - `Authorization` `Bearer {token}`
    - Request params:
        - `status` int
    - Available statuses:
        - 1 - Created
        - 2 - Processed
        - 3 - Courier
        - 4 - Completed
        - 5 - Canceled
        
```bash
http://{url}/api/order/status/change
```
