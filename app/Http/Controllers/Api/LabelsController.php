<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLabelRequest;
use App\Label;

class LabelsController extends Controller
{
    public function create(CreateLabelRequest $request)
    {
        $label = new Label();
        $label->name = $request->input('name');
        $label->save();

        return response('', 201);
    }

    public function view($labelName)
    {
        /** @var Label $label */
        $label = Label::findByName($labelName)
            ->firstOrfail();

        return $label->videos;
    }

    public function getAll()
    {
        return Label::all();
    }
}
