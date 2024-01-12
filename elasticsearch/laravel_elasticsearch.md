### 1. Laravel 및 Scout 패키지 설치

1.  Laravel Scout 패키지 설치:
    
    ```bash
    composer require laravel/scout
    ```
    
2.  Scout Elasticsearch 드라이버 설치:
    
    ```bash
    composer require babenkoivan/scout-elasticsearch-driver
    ```
    
3.  `.env` 파일에서 `SCOUT_DRIVER`를 `elasticsearch`로 설정:
    
    ```code
    SCOUT_DRIVER=elasticsearch
    ```
    

### 2. Elasticsearch 서비스 설정

1.  Elasticsearch 서버 주소 및 인덱스 설정:
    
    config/scout.php 파일에서 다음과 같이 Elasticsearch 설정을 추가합니다.
    
    ```php
    'elasticsearch' => [     
        'index' => env('ELASTICSEARCH_INDEX', 'default'),
        'hosts' => [env('ELASTICSEARCH_HOST', 'http://localhost'),], 
    ],
    ```
    
    
    `.env` 파일에서 Elasticsearch 호스트 및 인덱스 이름을 설정합니다.
    
    ```code 
    ELASTICSEARCH_HOST=http://localhost:9200 
    ELASTICSEARCH_INDEX=your_index_name
    ```
    

### 3. 모델 준비

1.  `AppModelsYourModel` 모델에 `Searchable` 트레이트를 추가:
    
    ```php
    use Searchable;
    ```
    
    
2.  모델의 `searchable` 메서드를 구현하여 검색할 데이터를 지정:
    
    ```php
    public function toSearchableArray() {     // 검색 가능한 데이터를 반환     
        return [
            'title' => $this->title,
            'content' => $this->content,
        ]; 
    }
    ```
    
    
    

### 4. 인덱스 생성 및 검색

1.  인덱스 생성:
    
    ```bash
    php artisan scout:import "AppModelsYourModel"
    ```
    
    
2.  검색 실행:
    
    ```php
    YourModel::search('your_keyword')->get();    
    ```