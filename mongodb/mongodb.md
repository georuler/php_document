## MongoDB 상태 확인
- stat
```code
docker-compose exec mongodb sh -c 'mongostat --username=root --password=database12!@  --authenticationDatabase=admin'
```

- top
```code
docker-compose exec mongodb sh -c 'mongotop --username=root --password=database12!@  --authenticationDatabase=admin'
```

## select Query
- row data 객체가 아닐경우
```code
db.api.find({ctn:"01099991212"}).sort({_id:-1}).limit(100)
```

- row data 객체일 경우
```code
db.api.find({data.category.sub_category: "TEST"}).sort({_id:-1}).limit(100)
```

 