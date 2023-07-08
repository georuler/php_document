## ubuntu php remove
```command
sudo apt-get remove –purge php*
sudo apt-get purge php*
sudo apt-get autoremove
sudo apt-get autoclean
sudo apt-get remove dbconfig-php
sudo apt-get dist-upgrade
```

## ubuntu mysql remove
```command
sudo apt-get remove –purge mysql*
sudo apt-get purge mysql*
sudo apt-get autoremove.
sudo apt-get autoclean.
sudo apt-get remove dbconfig-php.
sudo apt-get dist-upgrade.
```

## ubuntu php 최신 버전 설치

- 저장소 업데이트
```command
sudo apt-get update
```

- 저장소 php 버전 확인
```command
sudo apt-get -s install php-fpm
```

- 저장소 추가 및 설치
```command
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
apt-get install php-fpm
```

## composer remove & 최신 버전 설치
- compoer remove
```command
sudo apt-get remove composer -y
```

- compoer download & composer exe run
```command
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php composer-setup.php --install-dir=/usr/bin --filename=composer
```

- compoer update check
```command
sudo composer self-update --preview
```

## 라라벨 설치 전 php extension install
```code
sudo apt-get install -y php8.1 php8.1-xml php8.1-curl php8.1-gd php8.1-fileinfo php8.1-mysqli
```

## php 특정 버전 선택
```code
sudo update-alternatives --config php
```