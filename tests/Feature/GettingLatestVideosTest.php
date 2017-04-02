<?php

namespace Tests\Feature;

use App\Video;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GettingLatestVideosTest extends TestCase
{
    use DatabaseMigrations;

    protected function getVideoWithCreatedAt($created_at): Video
    {
        return factory(Video::class)->create([
            'created_at' => $created_at,
        ]);
    }

    /** @test */
    public function it_get_the_list_of_videos_order_by_last_added_first()
    {
        $video01 = $this->getVideoWithCreatedAt('2017-01-01');
        $video02 = $this->getVideoWithCreatedAt('2017-01-02');
        $video03 = $this->getVideoWithCreatedAt('2017-01-03');

        /** @var TestResponse $response */
        $this->get('/videos/latest')
            ->assertStatus(200)
            ->assertJson([
                $video03->toArray(),
                $video02->toArray(),
                $video01->toArray(),
            ]);
    }
}
