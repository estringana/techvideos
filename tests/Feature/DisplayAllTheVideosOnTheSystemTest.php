<?php

namespace Tests\Feature;

use App\Video;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DisplayAllTheVideosOnTheSystemTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_display_all_the_videos_on_the_system()
    {
        /** @var Collection $videos */
        $videos = factory(Video::class, 3)->create();

        $this->get('/videos')
            ->assertStatus(200)
            ->assertJson($videos->toArray());
    }

    /** @test */
    public function it_should_return_none_if_there_is_no_videos_on_the_system()
    {
        $this->get('/videos')
            ->assertStatus(200)
            ->assertJson([]);
    }
}
