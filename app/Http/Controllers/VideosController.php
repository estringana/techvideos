<?php

namespace App\Http\Controllers;

use App\Commands\AddLabelToVideoCommand;
use App\Http\Requests\CreateVideoRequest;
use App\Label;
use App\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

        return response('',201);
    }

    public function view($videoId)
    {
        /** @var Video $video */
        $video = Video::findOrFail($videoId);

        return view('videos.view', ['video' => $video]);
    }

    public function addLabel(int $videoId, string $labelName)
    {
        $command = new AddLabelToVideoCommand($videoId, $labelName);
        $command->execute();

        return response('', 201);
    }
}
