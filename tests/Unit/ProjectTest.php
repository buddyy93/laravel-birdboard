<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Feature\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_has_a_path()
    {
        $user = factory('App\User')->create();

        $project = factory('App\Project')->create(['owner_id' => $user->id]);

        $this->assertEquals("projects/{$project->id}", $project->path());

    }

    /** @test */
    public function it_has_a_task()
    {
        $user = factory('App\User')->create();

        $project = factory('App\Project')->create(['owner_id' => $user->id]);

        $task = $project->addTask('testing');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function it_can_invite_user()
    {
        $project = ProjectFactory::create();

        $project->invite($user = factory(User::class)->create());

        $this->assertTrue($project->members->contains($user));
    }
}
