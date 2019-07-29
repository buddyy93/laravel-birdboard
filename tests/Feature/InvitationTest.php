<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Feature\Setup\ProjectFactory;
use Tests\TestCase;

class InvitationTest extends TestCase
{

    /** @test */
    public function a_project_can_invite_an_user()
    {
        $project = ProjectFactory::create();

        $project->invite($anotherUser = factory(User::class)->create());

        $this->signIn($anotherUser);

        $this->post($project->path() . '/tasks', $task = ['body' => 'hello']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
