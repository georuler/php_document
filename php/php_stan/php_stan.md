## php_stan larastan 사용법
- larastan 설치
```code
composer require nunomaduro/larastan:^2.0 --dev
```

- 프로젝트 내 phpstan.neon.dist 파일 생성 및 작성
```code
includes:
    - ./vendor/nunomaduro/larastan/extension.neon

parameters:
    paths:
        # 검사하고자하는 폴더 지정
        - app/Http/Controllers


    # The level 8 is the highest level
    # 레벨 은 0~8 까지 이며, 0단계에서 레벨 순서를 올려 검사 실행
    level: 8

#    ignoreErrors:
#        - '#Unsafe usage of new static#'
    bootstrapFiles:
#        - _ide_helper.php
#        - _ide_helper_models.php

    excludePaths:
        - app/Providers/NovaServiceProvider.php
        - app/Nova/Resource.php
        - app/Http/Middleware/Authenticate.php
        - app/Nova/Actions/FlushUserSessionAction.php
        - app/Nova/Actions/PermitIpAction.php

    checkMissingIterableValueType: false

```

- phpstan analyse 실행
```code
 ./vendor/bin/phpstan analyse
```