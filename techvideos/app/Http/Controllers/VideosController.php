<?php

namespace App\Http\Controllers;

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
        $video->author = $request->input('author');
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
        /** @var Label $label */
        $label = null;
        /** @var Video $video */
        $video = Video::findOrFail($videoId);
        try {
            $label = Label::where('label', $labelName)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            $label = new Label();
            $label->label = $labelName;
            $label->save();
        }
        $video->addLabel($label);

        return response('', 201);
    }
}
