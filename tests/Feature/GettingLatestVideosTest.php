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

    /** @test */
    public function it_get_the_list_of_videos_order_by_last_added_first()
    {

        /** @var Video $video01 */
        $video01 = factory(Video::class)->create([
            'created_at' => '2017-01-01',
        ]);
        /** @var Video $video02 */
        $video02 = factory(Video::class)->create([
            'created_at' => '2017-01-02',
        ]);
        /** @var Video $video03 */
        $video03 = factory(Video::class)->create([
            'created_at' => '2017-01-03',
        ]);

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
