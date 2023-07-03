```sql
ALTER TABLE accounts AUTO_INCREMENT=1;
SET @COUNT = 0;
UPDATE accounts SET account_id = @COUNT:=@COUNT+1;
```