# HTTP - WIN

    RAIZ:
        X:/HTTP
        X:/Repository
        X:/Workspaces

## Apache (Diretórios)
### - conf/httpd.conf
    /HTTP
        /apache2.4
        /php_ts (Apache Handler) - OFF
        /php_nts (CGI/FastCGI) - ON
    /Workspaces
### - service/adm-apache-*.bat
    /HTTP/apache2.4

## Nginx
### - conf/nginx.conf
    /Workspaces
    PHP Upstream - 127.0.0.1:9000
### - service/nginx-*.bat
    %cd%
## PHP-FPM
### service/php-fcgi-start.bat
    %cd%
    php-cgi - 127.0.0.1:9000

## Redis
### - service/adm-redis-*.bat
    /HTTP/redis3.2

## Ports
### vhosts
    - 80 | 81 | 82 | 83 | 84
    - 8080 | 8081 | 8082 | 8083 | 8084
    - 443
    - 8080
### others
    - 8888 (Service)
    - 9000 (PHP)
    - 6379 (Redis)

## Service
    Start Services
    Status: localhost:8888


