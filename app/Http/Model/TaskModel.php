<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    protected $table = "tasks";
    protected $fillable = ['provider','name'];
}
