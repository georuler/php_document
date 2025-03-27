## 쿼리 속도 측정
- 쿼리가 실행되는 동안 시간, CPU 사용량, 블록 I/O 등의 정보가 포함

```sql

SET profiling = 1;

SELECT * FROM your_table WHERE your_column = 'value';

SHOW PROFILE FOR QUERY 1;

```