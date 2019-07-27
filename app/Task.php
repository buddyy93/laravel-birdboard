<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordActivity;

    protected $guarded = [];

    protected $touches = ['project'];

    public static $recordavleEvents = ['created', 'updated'];

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::created(function ($task) {
//            $task->project->recordActivity('Project\'s task created');
//        });
//    }


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return $this->project->path() . '/tasks/' . $this->id;
    }

    public function complete()
    {
        $this->update(['completed' => true]);

        $this->recordActivity('task_completed');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);

        $this->recordActivity('task_incompleted');
    }

}
