<?php

namespace App\Http\Controllers\Api;

use App\Commands\AddLabelToVideoCommand;
use App\Commands\AddVoteToVideoCommand;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddLabelRequest;
use App\Http\Requests\AddVoteRequest;
use App\Http\Requests\CreateVideoRequest;
use App\Video;
use Illuminate\Support\Facades\Auth;

class VotesController extends Controller
{
    public function create(AddVoteRequest $request, $videoId)
    {
        $command = new AddVoteToVideoCommand($videoId, $request->input('vote'), Auth::id());
        $command->execute();

        return response('', 201);
    }

    public function get($videoId)
    {
        return Video::findOrFail($videoId)->votes;
    }
}
