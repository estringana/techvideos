<?php

namespace App\Commands;

use App\Exceptions\InvalidVoteException;
use App\Video;
use App\Vote;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddVoteToVideoCommand
{
    /** @var int */
    protected $videoId;
    /** @var string */
    protected $vote;
    /** @var  int */
    private $userId;

    /**
     * AddLabelToVideo constructor.
     */
    public function __construct(int $videoId, string $vote, int $userId = null)
    {
        $this->validateVote($vote);

        $this->videoId = $videoId;
        $this->vote = $vote;
        $this->userId = $userId;
    }

    protected function getPreviousVote(): ?Vote
    {
       return Vote::where('user_id', $this->userId)
            ->where('video_id', $this->videoId)
           ->first();
    }

    protected function createNewVote(): Vote
    {
        $vote = new Vote();
        $vote->user_id = $this->userId ?? null;

        return $vote;
    }

    protected function getVote(): Vote
    {
        return $this->getPreviousVote() ?? $this->createNewVote();
    }

    public function execute()
    {
        /** @var Video $video */
        $video = Video::findOrFail($this->videoId);
        $vote = $this->getVote();
        $vote->vote = $this->vote;
        $video->addVote($vote);
    }

    protected function validateVote(string $vote)
    {
        if (!in_array($vote, [Vote::VOTE_BAD, Vote::VOTE_GOOD])) {
            throw new InvalidVoteException();
        }
    }
}
