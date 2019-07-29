<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Feature\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function a_user_has_projects()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_associated_projects()
    {
        $john = $this->signIn();

        ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->associatedProjects());

        $sally = factory(User::class)->create();

        ProjectFactory::ownedBy($sally)->create()->invite($john);

        $this->assertCount(2, $john->associatedProjects());

    }
}
