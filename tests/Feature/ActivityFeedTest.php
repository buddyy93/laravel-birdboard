<?php

namespace Tests\Feature;

use Facades\Tests\Feature\Setup\ProjectFactory;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    /** @test */
    public function creating_a_project_record_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

        $this->assertEquals('Project created', $project->activity[0]->log);
    }

    /** @test */
    public function updating_a_project_record_activity()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);

        $this->assertEquals('Project updated', $project->activity->last()->log);
    }

    /** @test */
    public function creating_a_task_record_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('some task');

        $this->assertCount(2, $project->activity);

        $this->assertEquals('Project\'s task created', $project->activity[1]->log);
    }

    /** @test */
    public function completing_a_task_record_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->complete();

        $this->assertCount(3, $project->activity);

        $this->assertEquals('Project\'s task completed', $project->activity[2]->log);
    }
}
