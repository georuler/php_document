# 리눅스 백그라운드 실행
## nohup

- 터미널 오픈 상태에서 실행, 터미널 종료시 프로그램 종료
```bash
python FileName.py&
```

- 백그라운드에서 실행
```bash
nohup python filename.py &
nohup  python -u filename.py  >  로그파일명 &
```

- 백그라운드 프로그램 확인 및 종료
```bash
# 프로세스 아이디 확인
ps -ef | grep filename.py
kill {your ProcessId}
```