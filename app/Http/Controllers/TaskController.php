<?php

namespace App\Http\Controllers;

use App\Http\Model\TaskHasUserModel;
use App\Http\Model\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {

    }

    public function taskList()
    {
        $data = [];
        $taskHasUsers = TaskHasUserModel::orderBy("year","asc")
            ->orderBy("week","asc")->get();

        foreach ($taskHasUsers as $taskHasUser) {
            $dto = new Carbon();
            $dto->setISODate( $taskHasUser->year,$taskHasUser->week);
            $data["tasks"][$dto->format("d.m.Y")][$taskHasUser->user_id][] = $taskHasUser;
        }


        $data["users"] = UserModel::all();


        return view("tasklist",$data);
    }
}
