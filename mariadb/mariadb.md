## ubuntu mariadb install
- MariaDB Repository 추가 
```code
sudo apt-get install software-properties-common
```

```code
sudo apt-key adv --fetch-keys 'https://mariadb.org/mariadb_release_signing_key.asc'
```

```code
sudo add-apt-repository 'deb [arch=amd64,arm64,ppc64el] https://mirror.yongbok.net/mariadb/repo/10.5/ubuntu focal main'
```


- MariaDB server 설치
```code
sudo apt update
sudo apt install mariadb-server
```

- MariaDB client 설치
```code
sudo apt install mariadb-client

sudo service mysql start
```


- MariaDB secure 설정
```code
sudo mysql_secure_installation
```

## 동작 확인
```code
sudo mysql
sudo mariadb
```

## user info 확인
```sql
select host, user, password from mysql.user;

//db 생성

//계정 생성
create user 'test'@'%' identified by '1234';

//권한 설정
GRANT ALL PRIVILEGES ON *.* TO 'test'@'%' IDENTIFIED BY '1234';

//reload
FLUSH PRIVILEGES;
```


## 원격 접속을 위한 MaridDB 설정
- mysqld에 대한 default option 확인
```code
mysqld --print-defaults
```

- bind-address 확인

- 외부 접속을 위한 bind-address 변경
```code
sudo vi /etc/mysql/mariadb.conf.d/50-server.cnf

bind-address 0.0.0.0
```

- 계정생성
```sql
select host, user, password from mysql.user;

//db 생성
create database test;

//계정 생성
create user 'test'@'%' identified by '1234';

//권한 설정
grant all privileges on test.* to test@'%';

//reload
flush privileges;
```

- 외부 접속을 위한 ip확인
```code
ifconfig
```