## ubuntu nginx install
- 저장소 업데이트 및 제거
```cmd
sudo apt update
```

```cmd
sudo apt upgrade
```

```cmd
sudo apt autoremove
```

- nginx 설치
```cmd
sudo apt install nginx
```

- nginx 제거
```cmd
sudo apt remove nginx
```


- nginx 실행
```cmd
# 시작
sudo systemctl start nginx

# 종료
sudo systemctl stop nginx

# 재시작
sudo systemctl restart nginx

# 리로드 (변경된 설정을 적용하는 경우 사용. 기존 연결을 끊지 않음.)
sudo systemctl reload nginx

# 기본적으로 서버 시작 시 nginx가 자동으로 실행되는데, 이를 막고 싶은 경우
sudo systemctl disable nginx

# 서버 시작 시 자동으로 nginx를 실행하고 싶은 경우
sudo systemctl enable nginx
```
