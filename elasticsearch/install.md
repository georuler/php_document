## install
- 공식 Elasticsearch GPG 키 추가:

```sh
wget -qO - https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
```

- APT 저장소 추가:

```sh
sudo sh -c 'echo "deb https://artifacts.elastic.co/packages/7.x/apt stable main" > /etc/apt/sources.list.d/elastic-7.x.list'
```

- 시스템 패키지 업데이트:

```sh
sudo apt-get update
```

- Elasticsearch 설치:

```sh
sudo service elasticsearch start
```

- Elasticsearch 서비스 실행:

```sh
sudo service elasticsearch start
```

- 부팅 등록
```sh
sudo systemctl enable elasticsearch
```