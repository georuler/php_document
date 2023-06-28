## oracle docker
- 도커 접속
```bash
docker-compose exec oracle11g bash
```

- 설정 포트 확인
```bash
netstat -nlpt
```

- 오라클 접속을 위해서 os 계정을 oracle로 변경
```bash
su oracle

//오라클 디렉토리 이동
cd $ORACLE_HOME
```

- sqlplus 접속 
```bash
bin/sqlplus / as sysdba

//database 확인
SELECT status FROM v$instance;
```

- 사용자 계정 추가
```sql
create user 계정명 identified by 비밀번호
grant connect, resource, dba to 계정명;

//grant dba to 원하는계정명 with admin option;
```

- 상태 확인
```bash
//서비스 상태
lsnrctl service

//시작
lsnrctl start

//종료
lsnrctl stop
```