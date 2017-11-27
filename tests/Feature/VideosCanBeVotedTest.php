<?php

namespace Tests\Feature;

use App\Video;
use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class VideosCanBeVotedTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_video_can_be_voted()
    {
        /** @var Video $video */
        $video = factory(Video::class)->create([]);

        $this->post(
            sprintf('/api/videos/%s/votes', $video->id),
            [
                'vote' => Vote::VOTE_GOOD,
            ]
        )->assertStatus(201);

        $this->assertCount(1, $video->votes);
    }

    /** @test */
    public function a_video_can_only_be_voted_with_good_or_bad()
    {
        /** @var Video $video */
        $video = factory(Video::class)->create([]);

        $this->post(
            sprintf('/api/videos/%s/votes', $video->id),
            [
                'vote' => 'RamdomString',
            ]
        )->assertStatus(302);

        $this->assertCount(0, $video->votes);
    }

    /** @test */
    public function it_should_be_possible_to_get_all_the_votes_of_a_given_video()
    {
        /** @var Video $video */
        $video = factory(Video::class)->create([]);
        /** @var Collection $votes */
        $votes = factory(Vote::class)->create([
            'video_id' => (string)$video->id,
        ]);

        $this->get(sprintf('/api/videos/%s/votes', $video->id))
            ->assertStatus(200)
            ->assertJsonFragment($votes->toArray());
    }
}
