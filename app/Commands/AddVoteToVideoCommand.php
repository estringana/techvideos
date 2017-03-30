<?php
namespace App\Commands;

use App\Exceptions\InvalidVoteException;
use App\Video;
use App\Vote;

class AddVoteToVideoCommand
{
    protected $videoId;
    protected $vote;

    /**
     * AddLabelToVideo constructor.
     */
    public function __construct(int $videoId, string $vote)
    {
        $this->validateVote($vote);

        $this->videoId = $videoId;
        $this->vote = $vote;
    }

    protected function getVote()
    {
        $vote = new Vote();
        $vote->vote = $this->vote;
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
