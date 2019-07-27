<?php
declare(strict_types=1);


namespace App;

trait RecordActivity
{
    public $oldAttributes = [];

    public static function bootRecordActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });
            if ($event === 'updated')
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
        }
    }

    function activityDescription($description)
    {
        return strtolower(class_basename($this)) . "_{$description}";
    }

    public function recordActivity($log)
    {
        $this->activity()->create([
            'log'        => $log,
            'changes'    => $this->getActivityChanges(),
            'project_id' => class_basename($this) === "Project" ? $this->id : $this->project_id
        ]);
    }

    protected function getActivityChanges()
    {
        if ($this->wasChanged())
            return [
                'before' => array_diff($this->oldAttributes, $this->getAttributes()),
                'after'  => $this->getChanges()
            ];
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public static function recordableEvents()
    {
        if (isset(static::$recordavleEvents)) {
            return static::$recordavleEvents;
        }

        return ['created', 'updated', 'deleted'];
    }
}
