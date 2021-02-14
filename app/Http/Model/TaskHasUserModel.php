<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class TaskHasUserModel extends Model
{
    protected $table = "task_has_user";

    protected $appends = [
        "UserName",
        "task"
    ];

    public function getUserNameAttribute()
    {
        return $this->hasMany(UserModel::class, "id", "user_id")->first()->name;
    }
    public function getTaskAttribute()
    {
        return $this->hasMany(TaskModel::class, "id", "task_id")->first();
    }
}
