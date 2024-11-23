# mohito_recruitment
Cookbook App - Laravel 11 | InertiaJS | React | TS | SSR

## Środowisko uruchomieniowe
1. PHP 8.3.x
1. NodeJS 20.x.x
1. MySQL 8.x

## Technologie
1. [Laravel 11](https://laravel.com/docs/11.x)
1. [InertiaJS](https://inertiajs.com/)
1. [ReactJS](https://react.dev/)
1. [TypeScript](https://www.typescriptlang.org/)

## Jak uruchomić aplikację?
1. Zaciągnij repozytorium,
1. Zainstaluj paczki za pomocą `composer install` oraz `npm install`,
1. Utwórz bazę danych,
1. Skopiuj konfigurację pliku `.env.example` do pliku `.env` oraz wprowadź prawidłowe dane do połączenia się z Twoją bazą danych, dodatkowo pamiętaj o wprowadzeniu prawidłowego adresu URL aplikacji dla `APP_URL`,
1. Zbuduj aplikację przy użyciu `npm run build`,
1. Wykonaj migrację za pomocą `php artisan migrate`,
1. Wywołaj ręcznie komendę pobierającą dane z API: `php artisan app:fetch-and-sync-recipes`,
1. Otwórz aplikację pod wybranym hostem,

## Wsparcie dla SSR
Aplikacja posiada wsparcie dla SSR, aby korzystać z jego dobrodziejstw należy uruchomić polecenie `php artisan inertia:start-ssr`

## Synchronizacja danych z API
Aplikacja posiada zdefiniowany route konsolowy który jest odpowiedzialny za synchronizację danych z API. W środowisku produkcyjnym możemy zaimplementować jego działanie na dwa sposoby:
1. Wykorzystać crontab i zdefiniować go np. `* * * * * php /var/www/mohito/repo/artisan schedule:run >> /dev/null 2>&1`
1. Zainstalować i skonfigurować `supervisor`, utworzyć plik konfiguracyjny programu oraz wykorzystać `schedule:work` jako długożyjący proces.

## O projekcie
1. Logika biznesowa odpowiedzialna za połączenie z API jest zawarta w odseparowanym serwisie,
1. Przepis, kategoria, kuchnia oraz tagi to osobne encje odpowiednio ze sobą połączone,
1. Komentarz jest osobną encją połączoną z przepisem,
1. Dla przepisu jest utworzony dedykowany `Observer` mający na celu tworzenie slug'a na podstawie tytułu dania,
1. Wykorzystałem DTO dla warstwy pośredniczącej w prezentacji danych przekazywanych do modeli,
1. Modele nie są bezpośrednio odpowiedzialne za wykonywanie zadań takich jak pobieranie czy aktualizacja danych, zostało to oddelegowane do repozytoriów,
1. Aplikacja to startowy [Breeze Kit](https://laravel.com/docs/11.x/starter-kits#breeze-and-inertia)
1. Aplikacja posiada spełnione wszystkie założenia, pobieranie i synchronizacja danych, wyświetlanie przepisów na liście wraz z paginacją i wyszukiwaniem, dodawanie komentarzy wraz z ich walidacją oraz mechanizmem throttle, obsługa dodawania do ulubionych za pośrednictwem local storage,

## Przykładowy kod bloku serwerowego Nginx
```
    server {
        server_name mohi.to;
        root /var/www/mohi.to/html;

        http2 on;

        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-Content-Type-Options "nosniff";
        
        index index.php;

        charset utf-8;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }

        error_page 404 /index.php;

        location ~ \.php$ {
            fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            include fastcgi_params;
        }

        location ~ /\.(?!well-known).* {
            deny all;
        }

        location ~* \.(jpg|jpeg|png|gif|ico|svg|webp|ttf|woff|woff2|otf)$ {
            expires 12M;
        }

        location ~* \.(css|js)$ {
            expires 12M;
        }

        listen 443 ssl; # managed by Certbot
        ssl_certificate /etc/letsencrypt/live/mohi.to/fullchain.pem; # managed by Certbot
        ssl_certificate_key /etc/letsencrypt/live/mohi.to/privkey.pem; # managed by Certbot
        include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
        ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot
    }

    server {
        if ($host = mohi.to) {
            return 301 https://$host$request_uri;
        } # managed by Certbot

        server_name mohi.to;
        listen 80;
        return 404; # managed by Certbot
    }
```