## artisan command 트레이트 생성 

- 커맨드 생성
```shell
php artisan make:command TraitMakeCommand
```

- 클래스 작성
```php
// GeneratorCommand 를 상속받아 처리함.
class TraitMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Trait';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'trait.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Traits';
    }
}
```

- stub 파일 추가 app/console/commands/stubs
```stub
<?php
namespace DummyNamespace;

trait DummyClass
{
    //
}
```

- 트레이트 생성
```shell
php artisan make:trait TestTrait
```