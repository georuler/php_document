## docker install

### 도커 설치 전 패키지 설치
```bash

sudo apt-get install curl apt-transport-https
sudo apt-get install software-properties-common gnupg lsb-release ca-certificates
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
sudo apt install docker-ce docker-ce-cli containerd.io
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"

```

### 도커 설치
```bash
sudo apt-get install docker-ce docker-ce-cli containerd.io
sudo docker -v
sudo docker ps
```


### Dockerfile 생성
```bash
sudo vi Dockerfile

붙여넣기
FROM php:8.1.3-fpm

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions gd mysqli
```


### docker-compose.yml 생성
```bash
sudo vi docker-compose.yml

붙여 넣기
#version: "3.7"

services:
    mariadb:
        image: mariadb:latest
        restart: unless-stopped
        environment:
            - MYSQL_ROOT_PASSWORD=q1w2e3r4
        ports:
            - "3309:3306"
        volumes:
            - ./var_lib_mysql/:/var/lib/mysql
    php:
        image: php:8.1.3-fpm-gd-mysqli
        restart: unless-stopped
        depends_on:
            - mariadb
        volumes:
            - ./php/php.ini:/etc/php.ini
            - ./var_www_html/:/var/www/html
    nginx:
        image: nginx:latest
        restart: unless-stopped
        depends_on:
            - php
        ports:
            - "9999:80"
            #- "443:443"
        volumes:
            - ./nginx/default.conf:/etc/nginx/conf.d/default.conf
            - ./var_www_html/:/var/www/html
```


### php 폴더 생성 및 php.ini 복사
```bash
sudo mkdir php
cd php
sudo cp /etc/php/8.1/fpm/php.ini /home/dev/php/php.ini
```
- 서버 또는 php 설치되지 않았을 경우 php.ini 복사하여 붙여넣기

### nginx 폴더 및 default.conf 생성
```bash
sudo mkdir nginx
cd nginx
vi default.conf


붙여넣기

server {
    #listen 443 ssl;

    #ssl_certificate     [ssl_certificate 경로];
    #ssl_certificate_key [ssl_certificate_key 경로];

    listen 80;

    #error_log  /var/log/nginx/error.log;
    #access_log /var/log/nginx/access.log;

    root /var/www/html/laravel/public;
    #root /var/www/html;
    server_name localhost;
    index index.php index.html;
    client_max_body_size 32m;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }    
    
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
}  
```

- root 경로 자신의 경로에 맞게 변경


### docker-compose install
```bash
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

sudo chmod +x /usr/local/bin/docker-compose
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
sudo docker-compose --version
sudo docker-compose up -d
```

### docker php8.1.3 & extension 이미지 빌드
```bash
sudo docker build -t "php:8.1.3-fpm-gd-mysqli" .
```


### docker-compose 실행
```bash
sudo docker-compose up -d
```

### docker-compose 상태 확인
```bash
sudo docker-compose ps
```