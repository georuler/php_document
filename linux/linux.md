## ssh 접속 설정
- ssh version 확인
```shell
ssh --version
```

- ssh keygen 실행
```shell
// Key-pair 생성
ssh-keygen -t rsa -m pem

// Key-pair 파일명 변경
mv id_rsa id_rsa.pem
mv id_rsa.pub authorized_keys

// Server에 authorized_keys 파일 생성 (파일이 없는 경우)
mkdir ~/.ssh/
chmod 700 ~/.ssh/
touch ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys

// Server의 authorized_keys 파일에 내용 추가
// (위에서 생성된 id_rsa.pub 파일의 내용을 authorized_keys 파일 마지막에 추가)
vi ~/.ssh/authorized_keys
```

- ssh 실행
```shell
sudo service ssh start
```

- ssh 실행 오류시
```code
sshd: no hostkeys available -- exiting.

sudo ssh-keygen -A
```

- sshd_config 설정 수정
```shell
sudo vi /etc/ssh/sshd_config

Port 주석제외
PermiRootLogin no
```