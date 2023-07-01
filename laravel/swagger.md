## php l5-swagger install

- [l5-swagger](https://github.com/DarkaOnLine/L5-Swagger)


## config
- filePath : app/config/l5-swagger.php

```php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'L5 Swagger UI',
            ],

            'routes' => [
                /*
                 * Route for accessing api documentation interface
                 * 
                 * 아티즌 콘솔로 로컬서버 구동시 하기 url로 접근 가능
                 * http://127.0.0.1/api/documentation 
                */
                'api' => 'api/documentation',
            ],
            'paths' => [
                /*
                 * Edit to include full URL in ui for assets
                */
                'use_absolute_path' => env('L5_SWAGGER_USE_ABSOLUTE_PATH', false),

                /*
                 * File name of the generated json documentation file
                */
                'docs_json' => 'api-docs.json',

                /*
                 * File name of the generated YAML documentation file
                */
                'docs_yaml' => 'api-docs.yaml',

                /*
                * Set this to `json` or `yaml` to determine which documentation file to use in UI
                */
                'format_to_use_for_docs' => env('L5_FORMAT_TO_USE_FOR_DOCS', 'json'),

                /*
                 * Absolute paths to directory containing the swagger annotations are stored.
                */
                'annotations' => [
                    base_path('app'),

                    //annotation 내용이 추가된 폴다가 존재할 경우, dirPath 추가 처리
                    base_path('packages/localPackages'),
                ],

            ],
        ],
    ],

    ...
    //필요 시 server 정보 추가
    'constants' => [
            'L5_SWAGGER_CONST_HOST' => env('APP_URL', 'http://my-default-host.com'),

            //local server host
            'L5_SWAGGER_CONST_LOCAL_HOST' => 'http://127.0.0.1:8000',

            //dev server host
            'L5_SWAGGER_CONST_DEV_HOST' => 'https://test.com',
    ],
];

```


## 기본 주석 추가
- filePath : app/Http/Controllers/Controller.php

- @OA\Info, @OA\Server annotation 은 각각의 컨트롤러에서 정의 가능하나,
공통의 내용일 경우 baseController에서 등록 하여 처리함

```php

/**
 * 
 * 자신이 만들고자 하는 api 정보 작성
 * @OA\Info(
 *      version="1.0.0",
 *      title="OpenApi Demo Documentation",
 *      description="L5 Swagger OpenApi description",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * app/config/l5-swagger.php 파일의 설정값을 기준으로 등록 처리
 * 
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Dev API Server"
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_LOCAL_HOST,
 *      description="Local API Server"
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_DEV_HOST,
 *      description="Dev API Server"
 * )
*/

```


## UserController 기준으로 작성법 설명
- filePath : app/Http/Controllers/UserController.php

```php
/**
 * 공통 스키마 작성
 * @OA\Schema(
 *      schema="userSchema",
 *      @OA\Property(type="integer", format="uint64", property="id", description="user pk"),
 *      @OA\Property(type="string", maxLength=255, property="name", description="이름"),
 *      @OA\Property(type="string", maxLength=255, property="email", description="이메일"),
 *      @OA\Property(type="string", property="email_verified_at", description="이메일 확인 일"),
 *      @OA\Property(type="string", maxLength=255, property="password", description="비밀번호"),
 *      @OA\Property(type="string", maxLength=100, property="remember_token", description="토큰"),
 *      @OA\Property(type="string", format="date-time", property="created_at", description="등록일"),
 *      @OA\Property(type="string", format="date-time", property="updated_at", description="수정일"),
 * )
 * 
 * 공통 response 스키마
 * @OA\Schema(
 *      schema="defaultResponseSchema",
 *      @OA\Property(property="success", type="boolean", example="true"),
 *      @OA\Property(property="message", type="string", example="method call message"),
 * )
 * 
 */
class UserController extends Controller
{

    /**
     * get method 호출의 경우 파리마터로 작성하지 않으면, 오류가 발생하므로, 필히 파라미터로 작성
     * @OA\Get(
     *      path="/api/users", //필수
     *      operationId="getUserRows", //선택
     *      tags={"users"}, //필수
     *      summary="회원", //선택
     *      description="회원 리스트", //선택
     * 
     *      //parameter query string
     *      @OA\Parameter(name="id", in="query", description="user pk", required=false,
     *          @OA\Schema(type="integer")
     *      ),
     * 
     *      @OA\Parameter(name="name", in="query", description="이메일", required=false,
     *          @OA\Schema(type="string")
     *      ),
     * 
     *      @OA\Parameter(
     *         name="created_at[]",
     *         in="query",
     *         description="기간검색",
     *         required=false,
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(type="string")
     *         )
     *      ),
     *
     *      @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(type="object",
     *                  property="data",
     *                  @OA\Property(type="boolean", property="status"),
     *                  @OA\Property(type="array",
     *                      property="rows",
     *                      @OA\Items(
     *                          type="object",
     *                          ref="#/components/schemas/userSchema"   //공통 스키마 사용
     *                      )
     *                  ),
     *              )
     *          ),
     *      )
     * )
     */
    public function index(Request $request) : void
    {

    }

    /**
     * @OA\Post(
     *      path="/api/users",
     *      operationId="postUser",
     *      tags={"users"},
     *      summary="회원",
     *      description="회원 등록",
     * 
     *      @OA\RequestBody(
     *          required=true,
     *          
     *          // 하기 내용대로 작성할 경우 form-data, application/json 선택 가능한 selectBox 노출
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",    //form data 일 경우 
     *              @OA\Schema(
     *                 required={"name, email"},
     *                 ref="#/components/schemas/userSchema"
     *              )
     *          ),
     *          @OA\MediaType(
     *              mediaType="application/json",       // json data 일 경우
     *              @OA\Schema(
     *                 required={"name, email"},
     *                 ref="#/components/schemas/userSchema"
     *              )
     *          )
     *      ),
     * 
     *      @OA\Response(
     *         response=200,
     *         description="response true",
     *         @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="method call message"),
     *         )
     *      )
     *  )
     */    
    public function store(Request $request)
    {
        
    }

    /**
     * @OA\Get(
     *      path="/api/users/{id}",
     *      operationId="getUserView",
     *      tags={"users"},
     *      summary="회원",
     *      description="회원 상세",
     * 
     *      // 파라미터가 path일 경우
     *      @OA\Parameter(
     *          description="id",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *  
     *      @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             ref="#/components/schemas/userSchema"
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/api/users",
     *      operationId="putUser",
     *      tags={"users"},
     *      summary="회원 정보 수정",
     *      description="회원 정보 수정",
     * 
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              required={"id"},
     *              
     *              //공통 스키마를 사용할 경우
     *              allOf={
     *                      @OA\Schema(ref="#/components/schemas/userSchema"),
     *              },
     * 
     *              //공통 스키마 사용과 추가된 스키마가 있을경우
     *              allOf={
     *                      //공통 스키마에 id 값이 있으므로, 현재 추가된 스키마는 예제용임을 인지
     *                      @OA\Schema(
     *                          @OA\Property(type="integer", property="id", description="user pk"),
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/userSchema"),
     *              },
     * 
     *              //개별 스키마를 사용할 경우
     *              @OA\Property(type="integer", property="id", description="user pk"),
     *              @OA\Property(type="string", maxLength=255, property="name", description="이름"),
     *              @OA\Property(type="string", maxLength=255, property="email", description="이메일"),
     *              @OA\Property(type="string", maxLength=255, property="password", description="비밀번호"),
     *              @OA\Property(type="string", maxLength=100, property="remember_token", description="토큰"),
     *         ),
     *      ),
     * 
     *      @OA\Response(
     *         response=200,
     *         description="response true",
     *         @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="method call message"),
     *         )
     *      )
     * )
     */    
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @OA\Patch(
     *      path="/api/users",
     *      operationId="patchUser",
     *      tags={"users"},
     *      summary="회원 정보 부분 수정",
     *      description="회원 정보 부분 수정",
     * 
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              required={"id"},
     *              
     *              @OA\Property(type="integer", property="id", description="user pk"),
     *              @OA\Property(type="string", maxLength=255, property="name", description="이름"),
     *              @OA\Property(type="string", maxLength=255, property="email", description="이메일"),
     *              @OA\Property(type="string", maxLength=255, property="password", description="비밀번호"),
     *              @OA\Property(type="string", maxLength=100, property="remember_token", description="토큰"),
     *         ),
     *      ),
     * 
     *      @OA\Response(
     *         response=200,
     *         description="response true",
     *         @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example="true"),
     *              @OA\Property(property="message", type="string", example="method call message"),
     *         )
     *      )
     * )
     */ 
    public function patch(Request $request) 
    {

    }

    /**
     * @OA\Delete(
     *      path="/api/users",
     *      operationId="deleteUser",
     *      tags={"users"},
     *      summary="회원 정보 삭제",
     *      description="회원 정보 삭제",
     *      
     *      @OA\RequestBody(
     *          required=false,
     *          description="parameters",
     *          @OA\JsonContent(
     *               required={"whereIn"},
     *               @OA\Property(property="whereIn", type="object", example="[1,2,3]", description="시퀀스 배열"),
     *          ),
     *      )
     * 
     *      @OA\Response(
     *         response=200,
     *         description="response true",
     *         @OA\JsonContent(
     *              //response schema가 공통일 경우, 공통으로 작성한 response schema를 사용
     *              ref="#/components/schemas/defaultResponseSchema"
     *         )
     *      )
     * )
     */
    public function destroy($id)
    {
        //
    }
}

```

## generate
- 주석 작성 완료후 php artisan l5-swagger:generate 실행