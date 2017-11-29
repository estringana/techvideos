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

class VideosController extends Controller
{
    public function create(CreateVideoRequest $request)
    {
        $video = new Video();
        $video->name = $request->input('name');
        $video->description = $request->input('description');
        $video->speaker = $request->input('speaker');
        $video->link = $request->input('link');
        $video->save();

        return response('', 201);
    }

    public function view($videoId)
    {
        /** @var Video $video */
        $video = Video::findOrFail($videoId);

        return $video;
    }

    public function addLabel(AddLabelRequest $request, int $videoId)
    {
        $labelName = $request->input('name');
        $command = new AddLabelToVideoCommand($videoId, $labelName);
        $command->execute();

        return response('', 201);
    }

    public function getLabels(int $videoId)
    {
        return Video::findOrFail($videoId)
            ->labels;
    }

    public function getAll()
    {
        return Video::all();
    }

    public function addVote(AddVoteRequest $request, $videoId)
    {
        $command = new AddVoteToVideoCommand($videoId, $request->input('vote'), Auth::id());
        $command->execute();

        return response('', 201);
    }

    public function getVotes($videoId)
    {
        return Video::findOrFail($videoId)->votes;
    }

    public function latest()
    {
        return Video::latest();
    }
}
