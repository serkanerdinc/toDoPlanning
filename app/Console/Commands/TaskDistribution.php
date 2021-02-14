<?php

namespace App\Console\Commands;

use App\Http\Model\TaskHasUserModel;
use App\Http\Model\TaskModel;
use App\Http\Model\UserModel;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Console\Command;

class TaskDistribution extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:distribution';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Görev paylaşımı';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $weeklyWorkingTime = 45;
        $users = UserModel::all();

        foreach ($users as $user) {
            $levelUser[$user->level][] = $user->id;
        }

        $lastWeek = date("W");

        $tasks = TaskModel::select("tasks.*")
            ->leftJoin("task_has_user","task_has_user.task_id","=","tasks.id")
            ->whereNull("task_has_user.task_id")
            ->orderBy("level","DESC")
            ->orderBy("id","ASC")
            ->get();

        foreach ($tasks as $task) {
            //Leveldeki personelleri bul hangisinde daha az iş var ise ona ata
            //Eğer süre olarak var olan levelden büyüklerin işleri daha önce bitiyorsa onlara aktar

            $week = 53;
            $year = 0;
            $lastDuration = $weeklyWorkingTime;
            foreach ($levelUser[$task->level] as $user_id) {
                $hasUser = TaskHasUserModel::where(["user_id"=>$user_id])
                    ->orderBy("year","DESC")
                    ->orderBy("week","DESC")
                    ->first();

                if($hasUser){
                    $duration = TaskHasUserModel::where(["year"=>$hasUser->year,"week"=>$hasUser->week,"user_id"=>$user_id])
                        ->groupBy('user_id')
                        ->sum('estimated_duration');
                    if($week > $hasUser->week){
                        $taskUser = $user_id;
                        $week = $hasUser->week;
                        $year = $hasUser->year;
                        $lastDuration = $duration;
                    }
                    elseif($week == $hasUser->week){
                        if($lastDuration>$duration){
                            $taskUser = $user_id;
                            $week = $hasUser->week;
                            $year = $hasUser->year;
                            $lastDuration = $duration;
                        }
                    }
                }
                else{
                    $week = (int)date("W");
                    $year = date("Y");
                    $taskUser = $user_id;
                    break;
                }
            }
            $weekTotalDuration = TaskHasUserModel::where(["year"=>$year,"week"=>$week,"user_id"=>$taskUser])
                ->groupBy('user_id')
                ->sum('estimated_duration');

            $usersAbove = UserModel::where("level",">",$task->level)->get();
            foreach ($usersAbove as $item) {
                $aboveDuration = TaskHasUserModel::where(["year"=>$year,"week"=>$week,"user_id"=>$item->id])
                    ->groupBy('user_id')
                    ->sum('estimated_duration');
                if($aboveDuration<$weekTotalDuration){
                    $taskUser = $item->id;
                }
            }


            $RemainingTime = $weeklyWorkingTime-($weekTotalDuration+$task->estimated_duration);
            $estimatedDurationRemaining = 0;
            if($RemainingTime>=0){
                $estimatedDuration = $task->estimated_duration;
            }
            else{
                $estimatedDuration = $task->estimated_duration+$RemainingTime;
                $estimatedDurationRemaining = $task->estimated_duration-$estimatedDuration;
            }

            if($estimatedDuration>0){
                $taskHasUser = new TaskHasUserModel();
                $taskHasUser->task_id           = $task->id;
                $taskHasUser->user_id           = $taskUser;
                $taskHasUser->year              = $year;
                $taskHasUser->week              = $week;
                $taskHasUser->estimated_duration= $estimatedDuration;
                $taskHasUser->save();
            }

            if($estimatedDurationRemaining>0){

                $dto = new Carbon();
                $dto->setISODate( $year,$week);
                $dto->modify('+1 week');

                $taskHasUser = new TaskHasUserModel();
                $taskHasUser->task_id           = $task->id;
                $taskHasUser->user_id           = $taskUser;
                $taskHasUser->year              = $dto->format("Y");
                $taskHasUser->week              = $dto->format("W");
                $taskHasUser->estimated_duration= $estimatedDurationRemaining;
                $taskHasUser->save();
            }

        }
    }
}
