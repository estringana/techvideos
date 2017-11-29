<?php
namespace App\Commands;

use App\Exceptions\InvalidVoteException;
use App\User;
use App\Video;
use App\Vote;

class AddVoteToVideoCommand
{
    /** @var int  */
    protected $videoId;
    /** @var string  */
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

    protected function getVote()
    {
        $vote = new Vote();
        $vote->vote = $this->vote;
        $vote->user_id = $this->userId ?? null;
        return $vote;
    }

    public function execute()
    {
        /** @var Video $video */
        $video = Video::findOrFail($this->videoId);
        $video->addVote($this->getVote());
    }

    protected function validateVote(string $vote)
    {
        if (!in_array($vote, [Vote::VOTE_BAD, Vote::VOTE_GOOD])) {
            throw new InvalidVoteException();
        }
    }
}
