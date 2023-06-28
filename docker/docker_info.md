### 도커?
- 하드웨어 자원 모두를 가상화 하지 않고, 프로세스만 격리 시켜 구축하는 시스템
- vm 에 비해 용량과 속도 부분에서 우위

### linux docker 설치
```bash
curl -fsSL https://get.docker.com/ | sudo sh
sudo apt-get install docker.io
```

### docker version
```bash
docker version
```

### 로그인 사용자 docker 명령어 사용권한 설정
```bash
sudo usermod -aG docker $USER
```

### 도커 이미지, 컨테이너
- image 확인
```bash
docker images
```

- image 삭제
```bash
# 개별
docker rmi 이미지 ID

# 전체 -f 옵션을 사용하면 삭제 수락 패스
docker image prune -af
```

- container 확인
```bash
docker ps
```

- container 삭제
```bash
docker rm 컨테이너 ID

# 강제 삭제 -f 추가
docker rm -f 컨테이너 ID
```

- container 중지
```bash
docker stop 컨테이너 ID
```



### 도커 허브에 이미지 업로드 
```bash
# 만약 docker login 명령어로 정상적으로 로그인 했음에도 docker push 명령어 사용 후 
# denied: requested access to the resource is denied 와 같은 에러가 발생하는 경우가 있다.
# 그럴 땐 [username] 부분과 로그인한 ID가 동일한지 확인한다.
docker login
-> ID 입력
-> PW 입력
Login Succeeded 출력 시 로그인 성공

docker tag [image_name]:[tag] [username]/[want_name]:[tag]
docker push [username]/[want_name]:[tag]

ex)
docker tag myimage:1.0 testuser/myimageupload:1.0
docker push testuser/myimageupload:1.0
```