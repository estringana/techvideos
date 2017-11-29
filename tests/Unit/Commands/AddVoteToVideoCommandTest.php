<?php

namespace Tests\Unit\Commands;

use App\Commands\AddVoteToVideoCommand;
use App\Exceptions\InvalidVoteException;
use App\User;
use App\Video;
use App\Vote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AddVoteToVideoCommandTest extends TestCase
{
    use DatabaseMigrations;

   /** @test */
   public function it_can_add_votes_to_videos()
   {
       $video = factory(Video::class)->create([]);
       $command = new AddVoteToVideoCommand($video->id, Vote::VOTE_BAD);
       $command->execute();

        $this->assertCount(1, $video->votes);
   }

    /** @test */
    public function it_can_add_votes_to_videos_which_had_already_votes()
    {
        $video = factory(Video::class)->create([]);
        factory(Vote::class, 5)->create([
            'video_id' => $video->id,
        ]);
        $command = new AddVoteToVideoCommand($video->id, Vote::VOTE_BAD);
        $command->execute();

        $this->assertCount(6, $video->votes);
    }

    /** @test */
    public function it_can_only_add_valid_votes()
    {
        $notRelevant = 12345;
        $this->expectException(InvalidVoteException::class);

        new AddVoteToVideoCommand($notRelevant, 'InvalidVote');
    }

    /** @test */
    public function videos_can_be_voted_anonimously()
    {
        $video = factory(Video::class)->create();
        $command = new AddVoteToVideoCommand($video->id, Vote::VOTE_BAD);
        $command->execute();

        $this->assertNull($video->votes->first()->user_id);
    }

    /** @test */
    public function videos_can_be_voted_by_a_user()
    {
        $video = factory(Video::class)->create();
        $user = factory(User::class)->create();
        $command = new AddVoteToVideoCommand($video->id, Vote::VOTE_BAD, $user->id);
        $command->execute();

        $this->assertEquals($video->votes->first()->user_id, $user->id);
    }
}
