<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Feature\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function a_user_can_create_a_project()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->raw();

        $this->post('/projects', $project)->assertRedirect('/projects/1');

        $project = Project::whereTitle($project['title'])->first();

        $this->assertDatabaseHas('projects', ['title' => $project->title]);

        $this->get($project->path())
            ->assertSee($project->title);

    }

    /** @test */
    public function a_project_require_a_title()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['title' => '']);
        $this->post('projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_require_a_description()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('projects', $attributes)->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_project_require_an_owner()
    {
        $attributes = factory('App\Project')->raw();
        $this->post('projects', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $project = factory('App\Project')->create(['owner_id' => $user->id]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_update_a_project()
    {
        $project = ProjectFactory::create();

        $originalTitle = $project->title;

        $project->update(['title' => 'changed']);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('project_updated', $activity->log);
            $expected = [
                'before' => [
                    'title' => $originalTitle
                ],
                'after'  => [
                    'title' => 'changed'
                ]
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    /** @test */
    public function an_authorized_user_can_delete_a_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $this->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function unauthorized_user_cannot_delete_project()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_see_all_the_projects_they_have_been_invited_to()
    {
        $user = $this->signIn();

        $project = ProjectFactory::create();

        $project->invite($user);

        $this->get('/projects')
            ->assertSee($project->title);
    }
}
