# accountingappAPI
Laravel API passport implemenatation example               

In order to use this app you need to connet it to your API client.

create a your database 

Set the database, database user and password in .env file

run 'php artisan migrate' command

run 'php artisan serve' command

Register and login 

after login you will be redirected to homepage

create a client to connect with your app
https://laravel.com/docs/5.7/passport 

then in your request set parameters 
'Accept' => 'json'
'Content-type' => 'json'
'Authorization' => 'Bearer ${your your access token that will be given after creating a client}'

now you can make requests to this app

the transaction contains these fields :
title -> string
amoun -> integer
in order to create transaction you should add these parameters in you request

POST      | api/transactions                       -> create transaction
GET|HEAD  | api/transactions                       -> get all transactions
GET|HEAD  | api/transactions/balance               -> get the balance
DELETE    | api/transactions/{id}                  -> delete transactin 
PUT|PATCH | api/transactions/{id}                  -> edit transaction
GET|HEAD  | api/transactions/{id}                  -> get transaction by id
GET|HEAD  | api/transactions/filter{query string}  -> filter transactions
query string options :
?expense          -> get all expenses
?income           -> get all incomes
?date=yyyy-mm-dd  -> transactions created on this date
?amount={integer} -> filter transactions by amount

you can combine filters : api/transactions/filter?income=&date=2018-11-10&amount=20000


 

