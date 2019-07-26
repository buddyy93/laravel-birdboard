<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    /** @test */
    public function a_project_has_task()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(factory('App\Project')->raw());

        $this->post($project->path() . '/tasks', ['body' => 'testing']);

        $this->get($project->path())->assertSee('testing');
    }

    /** @test */
    public function guest_cannot_Add_Task_to_project()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'testing'])->assertRedirect('login');
    }

    /** @test */
    public function only_an_owner_can_update_task()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'testing'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'testing']);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task = $project->addTask('hello task');
        $this->patch($task->path(), [
            'body'      => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body'      => 'changed',
            'completed' => true
        ]);
    }
}
