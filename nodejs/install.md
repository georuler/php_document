## ubuntu install
- 저장소 버전 확인
```command
sudo apt-get -s install nodejs
```

- 저장소 추가
```shell
cd ~
curl -sL https://deb.nodesource.com/setup_14.x -o nodesource_setup.sh
```

- 설치
```shell
sudo bash nodesource_setup.sh 
sudo apt-get install nodejs
```

- npm 사용 오류시 실행
```shell
sudo apt-get install build-essential
```