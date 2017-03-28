<?php

namespace Tests\Feature;

use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideosCanBeAccessedTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_should_return_success_response_when_visiting_a_video()
    {
        $video = factory(Video::class)->create();

        $this->get('/videos/' . $video->id)->assertStatus(200)
            ->assertJson(
                [
                    'name' => $video->name,
                    'description' => $video->description,
                    'speaker' => $video->speaker,
                    'link' => $video->link,
                ]
            );
    }

    /** @test */
    public function it_should_return_404_error_when_accessing_to_a_video_which_dont_exists()
    {
        $this->get('/videos/12345')->assertStatus(404);
    }
}
