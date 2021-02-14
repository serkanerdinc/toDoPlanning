<?php

namespace App\Console\Commands;

use App\Http\Model\ProviderModel;
use App\Http\Model\TaskModel;
use App\Library\TaskInterface;
use Illuminate\Console\Command;

class ImportTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Providerlardaki dataları indiriyoruz';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskInterface $task)
    {
        parent::__construct();
        $this->task = $task;
    }

    private $task;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $providers = ProviderModel::where(["is_active"=>1])->get();
        foreach ($providers as $provider) {
            //provider tablosunda parametreler virgül(,) ile parçalanıyor.
            $parameters = explode(",",$provider->parameters);

            $tasks = $this->task->taskList($provider->endpoint,$parameters);
            foreach ($tasks as $task) {
                $taskCount = TaskModel::where(["provider"=>$provider->id,"name"=>$task->name])->count();
                //Varsa tekrar oluşturulmaması için kontrol
                if($taskCount==0){
                    $taskObject = new TaskModel();
                    $taskObject->provider           = $provider->id;
                    $taskObject->name               = $task->name;
                    $taskObject->level              = $task->level;
                    $taskObject->estimated_duration = $task->estimated_duration;
                    $taskObject->save();
                }
            }
        }

    }
}
