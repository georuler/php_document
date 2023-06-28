## 설치 패키지 확인
- 전체
```code
dpkg -l
```

- 패키지별
```code
dpkg -l | php
```

## 권한 변경
```code
sudo chmod 777 test.sh
```

## 소유권 변경
```code
chown {소유권자}:{그룹식별자} {소유권을 변경하고 싶은 파일명}
```

## find 명령어
```code
find [경로] [-name] [파일 및 디렉토리 명] [-type d/f]

//test.php 파일 찾기
find / -name test.php -type f

//php 폴더 찾기
find / -name php -type d
```

## 실시간 로그 확인
```code
tail -f filename
```