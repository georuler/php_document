## 라라벨 로컬 패키지 개발
- 라라벨 내 packages 폴더 생성

## package tree
```code
├── docs                                # Documentation files
├── src                                 # Source files
│   ├── app                             
│   │   ├── http                        
│   │   │   └── controller              
│   │   └── traits                      
│   ├── config                          
│   ├── resources                       # xml blade
│   ├── routes                          # api route
│   └── SabangNetServiceProvider.php     
├── composer.json
└── README.md
```

### docs
- package 관련 문서 작성

### src
- app/http/controller

- 사방넷 문의 수집 및 등록 관련 컨트롤러 작성
- SabangNetQnaController.php

```php
class SabangNetQnaController
{
    use SabangNetTrait;

    public function __construct()
    {
        $this->searchXmlUrl = env('APP_URL').'/api/sabangNets/qna/searchXml';
        $this->createXmlUrl = env('APP_URL').'/api/sabangNets/qna/createXml';

        $this->searchApiUrl = $this->apiUrl.'/xml_cs_info.html?xml_url='.$this->searchXmlUrl;
        $this->createApiUrl = $this->apiUrl.'/xml_cs_ans.html?xml_url='.$this->createXmlUrl;
    }

    /**
     * 검색
     *
     * @param Request $request
     * @return void
     */
    public function searchXml(Request $request) : mixed
    {
        $this->data['CS_ST_DATE'] = $request->CS_ST_DATE ?? date('Ymd');
        $this->data['CS_ED_DATE'] = $request->CS_ED_DATE ?? date('Ymd');
        $this->data['CS_STATUS'] = $request->CS_STATUS ?? '';

        return response()->view('Xml::searchQna', $this->data)->header('Content-Type', 'text/xml');
    }

    /**
     * 등록
     *
     * @param Request $request
     * @return void
     */
    public function createXml(Request $request) : mixed
    {
        $this->data['NUM'] = $request->NUM ?? '';
        $this->data['CS_RE_CONTENT'] = $request->CS_RE_CONTENT ?? '';

        return response()->view('Xml::createQna', $this->data)->header('Content-Type', 'text/xml');
    }

    public function index(Request $request) : mixed
    {
        try
        {
            $response = Http::get($this->searchApiUrl);
            $resXml = simplexml_load_string($response->body());
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }

        return $resXml;
    }

    public function store(Request $request) : mixed
    {
        try
        {
            $response = Http::post($this->createApiUrl);
            $resXml = simplexml_load_string($response->body());
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }

        return $resXml;
    }
}
```