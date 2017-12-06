<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Laravel\Passport\Passport;
use Tests\TestCase;

class VideosCanBeVotedTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_video_can_be_voted_when_authenticated()
    {
        Passport::actingAs(factory(User::class)->create(), []);

        /** @var Video $video */
        $video = factory(Video::class)->create([]);

        $this->post(
            sprintf('/api/votes/video/%s', $video->id),
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
            sprintf('/api/votes/video/%s', $video->id),
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
            'video_id' => $video->id,
        ]);

        $this->get(sprintf('/api/votes/video/%s', $video->id))
            ->assertStatus(200)
            ->assertJsonFragment(['video_id' => (string)$video->id]);
    }

    /** @test */
    public function users_can_vote_videos_when_authenticated()
    {
        /** @var Video $video */
        $video = factory(Video::class)->create([]);
        /** @var User $user */
        $user = factory(User::class)->create();
        
        Passport::actingAs($user, []);
        $this->post(
                sprintf('/api/votes/video/%s', $video->id),
                [
                    'vote' => Vote::VOTE_GOOD,
                ]
            )->assertStatus(201);

        $this->assertCount(1, $video->votes);
        $this->assertCount(1, $user->votes);
    }
    
    /** @test */
    public function videos_can_not_be_voted_if_not_authenticated()
    {
        /** @var Video $video */
        $video = factory(Video::class)->create([]);
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->post(
            sprintf('/api/votes/video/%s', $video->id),
            [
                'vote' => Vote::VOTE_GOOD,
            ]
        )->assertStatus(302);

        $this->assertCount(0, $video->votes);
        $this->assertCount(0, $user->votes);
    }
    
    /** @test */
    public function last_vote_of_a_user_to_a_video_should_remain_on_db()
    {
        Passport::actingAs(factory(User::class)->create(), []);

        /** @var Video $video */
        $video = factory(Video::class)->create([]);

        $this->post(
            sprintf('/api/votes/video/%s', $video->id),
            [
                'vote' => Vote::VOTE_GOOD,
            ]
        )->assertStatus(201);

        $this->post(
            sprintf('/api/votes/video/%s', $video->id),
            [
                'vote' => Vote::VOTE_BAD,
            ]
        )->assertStatus(201);

        $this->assertEquals(Vote::VOTE_BAD, $video->votes->first()->vote);
    }
}
