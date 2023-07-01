## nginx default.conf 설정
```code
server {
    listen       80;
    server_name  test.com;
    root   /home;

    if ($http_x_forwarded_proto = 'http'){
        return 301 https://$host$request_uri;
    }

    #set same size as post_max_size(php.ini or php_admin_value).
    client_max_body_size 10M;

    access_log /var/log/nginx/test.com.access.log main;
    error_log  /var/log/nginx/test.com.error.log warn;


    location / {
    #try_files $uri $uri/ /index.php?$query_string;
        #index  index.php;
	#try_files $uri $uri/ =404;
	try_files $uri $uri/ /index.php?$query_string;
    }

    # Allow Lets Encrypt Domain Validation Program
    location ^~ /.well-known/acme-challenge/ {
        allow all;
    }

    # Block dot file (.htaccess .htpasswd .svn .git .env and so on.)
    location ~ /\. {
        deny all;
    }

    # Block (log file, binary, certificate, shell script, sql dump file) access.
    location ~* \.(log|binary|pem|enc|crt|conf|cnf|sql|sh|key)$ {
        deny all;
    }

    # Block access
    location ~* (composer\.json|composer\.lock|composer\.phar|contributing\.md|license\.txt|readme\.rst|readme\.md|readme\.txt|copyright|artisan|gulpfile\.js|package\.json|phpunit\.xml)$ {
        deny all;
    }

    location = /favicon.ico {
        log_not_found off;
        access_log off;
    }

    location = /robots.txt {
        log_not_found off;
        access_log off;
    }

    # Block .php file inside upload folder. uploads(wp), files(drupal), data(gnuboard).
    location ~* /(?:uploads|default/files|data)/.*\.php$ {
        deny all;
    }


	index index.php index.html index.htm;

	location ~ \.(php|phar)(/.*)?$ {
		try_files $uri $uri/ =404;
	    fastcgi_split_path_info ^(.+\.(?:php|phar))(/.*)$;
        if (!-f $document_root$fastcgi_script_name) {
            return 404;
        }
 

	    fastcgi_intercept_errors on;
	    fastcgi_index  index.php;
	    include        fastcgi_params;
	    fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
	    fastcgi_param  PATH_INFO $fastcgi_path_info;
	    fastcgi_pass   php-fpm;
	}
}
```


## https 활성화
```code
//버전확인
openssl version

mkdir /etc/nginx/certificate
cd /etc/nginx/certificate
openssl req -new -newkey rsa:4096 -x509 -sha256 -days 365 -nodes -out nginx-certificate.crt -keyout nginx.key

//실행후
Common Name (e.g. server FQDN or YOUR name) []: 본인 아이피 입력


//default.conf 수정

server {
        listen 80 default_server;
        listen [::]:80 default_server;
        server_name _;
        return 301 https://$host$request_uri;
}
server {
        listen 443 ssl default_server;
        listen [::]:443 ssl default_server;
        ssl_certificate /etc/nginx/certificate/nginx-certificate.crt;
        ssl_certificate_key /etc/nginx/certificate/nginx.key;
        root /var/www/html;
        index index.html index.htm index.nginx-debian.html;
        server_name _;
        location / {
                try_files $uri $uri/ =404;
        }
}
```