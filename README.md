# Satya Sunarya-Backend Software Enginee

## note : 

- Minimum versi php 7.4
- Laravel yang digunakan v6
- MySql yang digunakan 5.7.33
- Penggunaan token pada task 3,4,5 dengan bearer token dengan Authorization type : Bearer token, atau dengan header Authorization : Bearer <api_token>
- <api_token> didapat dari hasil login
- Karena ada fitur upload csv, maka dibutuhkan beberapa config di php.ini

## settingan php.ini : 
- max_input_time = 6000
- memory_limit = 1G
- post_max_size = 200mb
- max_execution_time = 36000
- max_input_time = 6000

## Instruksi Install

- Clone project dari
```
$ git clone https://github.com/pointer29/nobi-backend-test.git
```

- Setelah clone jalankan perintah 
```
$ composer install
```

- Lakukan copy .env.example menjadi .env

- Jalankan perintah 
```
$ php artisan key:generate
```

- Setting .env
- Import database dari folder /other/nobitest.sql
- Import database dari collection postman dari folder /other/api-list_collection.json
