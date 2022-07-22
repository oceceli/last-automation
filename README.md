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
chown -R www-data:www-data /var/www/html
php artisan optimize
```


If something gone wrong try these:
```
php artisan config:clear
php artisan route:clear
```

It will be serving at 
```
localhost:80
```
