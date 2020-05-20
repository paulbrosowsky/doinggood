## Anforderungen

- PHP >= 7.2.5
- Apache / NGINX
- Composer
- NodeJS 12

## Installation

Erselle eine `.env` Datei von `.env.example`.

```
APP_NAME=DoingGoodCommunity
APP_ENV=local
APP_DEBUG=true
APP_URL=http://doinggood.test
```

Beckend:
```
composer install

php artisan key:generate

APP-Key wird in `.env` automatisch eingetragen
APP_KEY= **DEIN SCHLÜSSEL**

Erstelle neue Datenbank (e.g. SQL-Editor or mysql via terminal)
z.B. doinggood

In `.env` eintragen

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=doinggood
DB_USERNAME=**DEIN_USER**
DB_PASSWORD=***DEIN_PASSWORD**

Datenbank füllen:

php artisan migrate
php artisan db:seed

```

Frontend:
NodeJs sollte global installiert sein
https://nodejs.org/en/

```
npm install

npm run hot // runs the app in hot reload mode
npm run dev // compiles the app in dev mode
npm run watch // compiles the app in dev mode every time files change
npm run prod // compiles the app in production mode
```