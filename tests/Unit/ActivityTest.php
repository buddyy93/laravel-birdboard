<?php

namespace Tests\Unit;

use Facades\Tests\Feature\Setup\ProjectFactory;
use Tests\TestCase;

class ActivityTest extends TestCase
{

    /** @test */
    public function it_has_a_creator()
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $this->assertEquals($user->id, $project->activity->first()->user->id);
    }
}
