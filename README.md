# An ERP-like automation system



## Kurulum - Install

Docker; mysql, app ve nginx'i otomatik olarak kuracak.<br/>Docker will install mysql, app and nginx automatically.

```
git clone https://github.com/oceceli/last-automation.git
cd last-automation
```

Docker ve docker-compose kurulu olmalı<br/>Docker and docker-compose must be installed

```
docker-compose up -d --build
docker-compose exec app bash
```

app container içerisinde:<br/>inside app container:

```
composer install
php artisan key:generate
php artisan migrate --seed
chown -R www-data:www-data /var/www
```

Bir sorun olursa şunları deneyin:<br/>
If something gone wrong try these:
```
php artisan storage:link
php artisan route:cache
php artisan route:clear
php artisan config:cache
php artisan config:clear
php artisan optimize
```
