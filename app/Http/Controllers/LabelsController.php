<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLabelRequest;
use App\Label;
use Illuminate\Http\Request;

class LabelsController extends Controller
{
    public function create(CreateLabelRequest $request)
    {
        $label = new Label();
        $label->name = $request->input('name');
        $label->save();

        return response('', 201);
    }
}
