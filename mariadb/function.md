```sql
DELIMITER $$
CREATE FUNCTION func_expenditure_total_price(IN json_objects JSON) RETURNS int
BEGIN
	declare expenditure_total_price int;
	select sum(cast(REGEXP_REPLACE(total_price, ",", '') as int)) from json_table(json_objects, '$[*]' 
	  columns(
	   cnt varchar(10) path '$.expenditure_count', 
	   price varchar(10) path '$.expenditure_price',
	   tax varchar(10) path '$.expenditure_tax',
	   total_price varchar(10) path '$.expenditure_total_price' )
	) as jt into expenditure_total_price;
	
	return expenditure_total_price;
END;
$$
DELIMITER ;
```