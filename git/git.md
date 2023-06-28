## 로컬 파일 추적 제외
- 추적 제외
```code
git update-index --skip-worktree file_path
```

- 제외 원복
```code
git update-index --no-skip-worktree file_path
```

```code
php/config/database.php
php/config/logging.php
php/config/session.php
php/config/view.php


//ssl 관련 파일 제외 처리
//2023-02-15
../docker/haproxy/qq010.co.kr/star_qq010_co_kr.key
```