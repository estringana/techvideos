<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVideoRequest;
use App\Video;
use Illuminate\Http\Request;

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
}
