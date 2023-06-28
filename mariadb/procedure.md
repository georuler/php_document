## procedure 생성
```sql
DELIMITER ;;
CREATE PROCEDURE insert_test(IN count INT)
BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE (i <= count) DO
		  		INSERT INTO board_notices (user_id, `use`, `subject`, content, created_at, updated_at)
          VALUES (1, 'Y', 'test', 'test', NOW(), NOW());
        SET i = i + 1;
    END WHILE;
END;;
DELIMITER ;
```


## procedure 실행
```sql
CALL insert_test(100);
```

## procedure 삭제
```sql
DROP PROCEDURE insert_test;
```
