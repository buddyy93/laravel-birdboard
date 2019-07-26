<?php

namespace Tests\Unit;

use Tests\TestCase;

class TaskTest extends TestCase
{

    /** @test */
    public function a_task_belongs_to_a_project()
    {
        $task = factory('App\Task')->create();

        $this->assertInstanceOf('App\Project', $task->project);
    }

    /** @test */
    public function a_task_has_path()
    {
        $task = factory('App\Task')->create();

        $this->assertEquals('projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }
}
