## 텔레그램 봇 메세지 발송 이벤트
- event 생성
```shell
php artisan make:event TelegramEvent
```
- TelegramEvent
```php
class TelegramEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    //수신할 메세징 정의
    public $sendMsg;

    public function __construct($sendMsg)
    {
        //initialize
        $this->sendMsg = $sendMsg;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('telegram-channel'),
        ];
    }
}
```

- listener 생성
```shell
php artisan make:listener TelegramEventListener
```
- TelegramEventListener
```php
class TelegramEventListener
{

    public function __construct()
    {
        //
    }

    public function handle(TelegramEvent $event): void
    {
        // Log::info($event->sendMsg->chat_id);
        // Log::info($event->sendMsg->text);

        //job 실행
        TelegramEventJob::dispatch($event->sendMsg);
    }
}
```

- EventServiceProvider 등록
```php
protected $listen = [
    TelegramEvent::class => [
        TelegramEventListener::class
    ]
];
```

- job 설정 .env
```env
QUEUE_CONNECTION=database
```

- queue 테이블 생성
```shell
php artisan queue:table
php artisan queue:failed-table

// 마이그레이션 실행
php artisan migrate
```

- job 생성
```shell
php artisan make:event TelegramEventJob
```

```php
class TelegramEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //발송 메세지
    public $sendMsg;

    public function __construct($sendMsg)
    {
        //init
        $this->sendMsg = $sendMsg;
    }

    public function handle(): void
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'Link', 'url' => '']
                ]
            ]
        ];
        $encodedKeyboard = json_encode($keyboard);
    
        $response = Http::withOptions([
            'verify' => false,
        ])->post('https://api.telegram.org/bot'.$this->sendMsg->bot_token.'/sendMessage', [
            'chat_id' => $this->sendMsg->chat_id,
            'text' => $this->sendMsg->text,
            'reply_markup' => $encodedKeyboard
        ]);
    }
}
```

- event 등록
```php
$msg = [
    'bot_token' => 'xxx',
    'chat_id' => 'xxx',
    'text' => 'test',
];
event(new TelegramEvent((object) $msg));
```

- queue 실행
```shell
nohup php artisan queue:work --daemon >> storage/logs/laravel.log &
```


