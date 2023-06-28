## docker install
- (docker window install)[https://docs.docker.com/desktop/install/windows-install/]

## image pull
- 이미지 다운로드
```bash
docker pull mariadb
docker pull nginx
docker pull php:8.1.3-fpm
```

## Dockerfile 생성 및 php 이미지 빌드
- Dockerfile 생성
```bash
FROM php:8.1.3-fpm

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions gd mysqli fileinfo
```

- dock build 실행
```bash
docker build -t "php:8.1-fpm-gd-mysqli" .
```

## docker compose 작성
- docker-compose.yml
- version: "3.7"

```bash
services:
    mariadb:
        image: mariadb:latest
        restart: unless-stopped
        environment:
            - MYSQL_ROOT_PASSWORD=[mariadb 루트로 설정할 비밀번호]
        ports:
            - "3306:3306"
        volumes:
            - ./var_lib_mysql/:/var/lib/mysql
    php:
        image: php:8.1-fpm-gd-mysqli
        restart: unless-stopped
        depends_on:
            - mariadb
        volumes:
            - ./var_www_html/:/var/www/html
    nginx:
        image: nginx:latest
        restart: unless-stopped
        depends_on:
            - php
        ports:
            - "80:80"
            - "443:443"
        volumes:
            - ./nginx/nginx.conf:/etc/nginx/nginx.conf
            - ./var_www_html/:/var/www/html
```

## nginx conf 추가
```bash
location ~ \.php$ {
    try_files $uri =404;
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_pass php:9000;
    fastcgi_index index.php;
    #include snippets/fastcgi-php.conf;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_param PATH_INFO $fastcgi_path_info;
}
```

## container exe
```bash
docker-compose up -d
```