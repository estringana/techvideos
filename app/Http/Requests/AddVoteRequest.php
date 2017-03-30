<?php

namespace App\Http\Requests;

use App\Label;
use App\Vote;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddVoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vote' => [
                'required',
                Rule::in([Vote::VOTE_GOOD, Vote::VOTE_BAD])
            ]
        ];
    }
}
