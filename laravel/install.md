## laravel 특정 버전 설치
```code
composer create-project laravel/laravel app-8 --prefer-dist 8.*
```

## 특정 버전 설치 후
- composer.json 수정
```code

    "require": {
        "php": "7.4.33",
        "fruitcake/laravel-cors": "^2.0",
        "guzzlehttp/guzzle": "^7.0.1",
        "laravel/framework": "^8.75",
        "laravel/sanctum": "^2.11",
        "laravel/tinker": "^2.5"
    },

    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "platform-check": false,
        "platfomr" : {
            "php" : "7.4.33"
        }
    },    

```

- composer update 실행
```code
composer update
```