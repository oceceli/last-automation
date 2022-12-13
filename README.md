# Demo
https://erp.oceceli.com/  

superuser@superuser.com  
secureadmin2021  

# An ERP-like automation system



## Kurulum - Install

Docker will install mysql, app and nginx automatically.

```
git clone https://github.com/oceceli/last-automation.git
cd last-automation
```

Docker and docker-compose must be installed

```
docker-compose up -d --build
```

inside app container:

```
docker-compose exec app bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan optimize
chown -R www-data:www-data /var/www/html
```


If something gone wrong try these:
```
php artisan optimize:clear
```

It will be serving at 
```
localhost:80
```
