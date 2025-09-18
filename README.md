# Api Greeg Go Delivery 

<p>Resources: </p>
<ul>
  <li>Laravel 11</li>
  <li>Composer</li>
  <li>PHP 8.3</li>
</ul>


## install laravel

```
# git clone git@github.com:stafiilo/api.greengo.delivery.git
```
```
sudo chown -R www-data:www-data /var/www/api.greengo.delivery/
```
```
sudo chmod -R 755 /var/www/api.greengo.delivery/
```
```
chmod -R 777 /var/www/api.greengo.delivery/public/upload/
```
## laravel key
```
composer update
```
```
php artisan key:generate
```
## connect to MySql
```
php artisan migrate
```
```
php artisan db:seed 
```


