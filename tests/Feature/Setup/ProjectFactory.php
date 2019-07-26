<?php
declare(strict_types=1);


namespace Tests\Feature\Setup;

use App\Project;
use App\Task;
use App\User;

class ProjectFactory
{
    protected $task_count = 0;

    protected $user;

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function withTasks($count)
    {
        $this->task_count = $count;

        return $this;
    }

    public function create()
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->user ?: factory(User::class)
        ]);

        factory(Task::class, $this->task_count)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }

    public function raw()
    {
        return factory(Project::class)->raw([
            'owner_id' => $this->user ?: factory(User::class)
        ]);
    }
}
