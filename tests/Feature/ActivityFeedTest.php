<?php

namespace Tests\Feature;

use App\Task;
use Facades\Tests\Feature\Setup\ProjectFactory;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    /** @test */
    public function creating_a_project_record_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

        $this->assertEquals('project_created', $project->activity[0]->log);
    }

    /** @test */
    public function updating_a_project_record_activity()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);

        $this->assertEquals('project_updated', $project->activity->last()->log);
    }

    /** @test */
    public function creating_a_task_record_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('some task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('task_created', $activity->log);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('some task', $activity->subject->body);
        });
    }

    /** @test */
    public function completing_a_task_record_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->complete();
        $this->assertCount(4, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('task_completed', $activity->log);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }
}
