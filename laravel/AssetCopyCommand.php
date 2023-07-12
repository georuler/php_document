<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class AssetCopyCommand extends Command
{
    /**
     * The name and signature of the console command.
     * 
     * php artisan make:project-copy Georuler georulers
     *
     * @var string
     */
    protected $signature = 'make:asset-copy {name} {dir} {--resource=true} {--component=true}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model, controller, resource, component';
    /**
     * @var \App\Console\Commands\Filesystem
     */
    public $files;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dir = trim($this->argument('dir'));
        $fileName = trim($this->argument('name'));

        $fileNameArray = [
            'model' => 'BoardNotice',
            'controller' => 'BoardNoticeController',
            'resource' => [
                'list' => 'notice.blade.php',
                'view' => 'noticeView.blade.php',
                'form' => 'noticeForm.blade.php',
            ],
            'component' => [
                'list' => 'BoardNotice.js',
                'form' => 'BoardNoticeForm.js',
            ],
        ];        
        
        if (empty($fileName)) {
            $this->error('만드실 파일명을 입력해 주세요.');
            return false;
        }
        
        //model create
        $modelFile = $this->files->get(app_path('Models/BoardNotice.php'));
        $modelMakeFile = app_path('Models/' . $fileName . '.php');
        if ($this->files->exists($modelMakeFile)) {
            $this->error($modelMakeFile.'해당 파일은 이미 존재합니다.');
            // return false;
        }

        $searchArray = [
            'BoardNotice'
        ];

        $replaceArray = [
            $fileName,
        ];

        $modelReplace = str_replace($searchArray, $replaceArray, $modelFile);
        $this->files->put($modelMakeFile, $modelReplace);
        
        $this->comment('모델 생성 완료~');

        // controller create
        $controllerFile = $this->files->get(app_path('Http/Controllers/'.$fileNameArray['controller'].'.php'));
        $controllerMakeFile = app_path('Http/Controllers/'.$fileName.'Controller.php');
        if ($this->files->exists($controllerMakeFile)) {
            $this->error($controllerMakeFile.'해당 파일은 이미 존재합니다.');
            // return false;
        }

        $searchArray = [
            'BoardNotice',
            'boardNotice'
        ];

        $replaceArray = [
            $fileName,
            Str::camel($fileName)
        ];

        $controllerReplace = str_replace($searchArray, $replaceArray, $controllerFile);
        $this->files->put($controllerMakeFile, $controllerReplace);
        
        $this->comment('컨트롤러 생성 완료~');

        if($this->option('resource') == "true") {
            // resource create
            foreach($fileNameArray['resource'] as $key => $val) {
                $resourceFile = $this->files->get(resource_path('views/boards/'.$val));
                $this->files->ensureDirectoryExists(resource_path('views/'.$dir));

                $resourceFileName = Str::substr($dir, 0, -1);

                if($key == "view") {
                    $resourceFileName = Str::substr($dir, 0, -1)."View";
                } else if($key == "form") {
                    $resourceFileName = Str::substr($dir, 0, -1)."Form";
                }

                $resourceMakeFile = resource_path('views/'.$dir.'/'.$resourceFileName.'.blade.php'); 
            
                if ($this->files->exists($resourceMakeFile)) {
                    $this->error('해당 파일은 이미 존재합니다.');
                    return false;
                }

                $searchArray = [
                    'BoardNotice',
                    'boardNotice'
                ];

                $replaceArray = [
                    $fileName,
                    Str::camel($fileName)
                ];

                $controllerReplace = str_replace($searchArray, $replaceArray, $resourceFile);
                $this->files->put($resourceMakeFile, $controllerReplace);            
            }

            $this->comment('리소스 생성 완료~');
        }
        
        if($this->option('component') == "true") {
            // component create
            foreach($fileNameArray['component'] as $key => $val) {
                $componentFile = $this->files->get(public_path('src/components/boards/'.$val));
                $this->files->ensureDirectoryExists(public_path('src/components/'.$dir));

                $componentFileName = Str::substr($dir, 0, -1);

                if($key == "form") {
                    $componentFileName = Str::substr($dir, 0, -1)."Form";
                }

                $componentMakeFile = public_path('src/components/'.$dir.'/'.Str::ucfirst($componentFileName).'.js'); 
            
                if ($this->files->exists($componentMakeFile)) {
                    $this->error('해당 파일은 이미 존재합니다.');
                    return false;
                }

                $searchArray = [
                    'BoardNotice',
                    'boardNotice'
                ];

                $replaceArray = [
                    $fileName,
                    Str::camel($fileName)
                ];

                $controllerReplace = str_replace($searchArray, $replaceArray, $componentFile);
                $this->files->put($componentMakeFile, $controllerReplace);
            }
            
            $this->comment('컴포넌트 생성 완료~');
        }
    }
}