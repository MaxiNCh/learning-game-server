<?php

namespace App\Http\Requests;

use App\Rules\AtLeastOneIsCorrect;
use App\Rules\AtLeastOneIsIncorrect;
use App\Rules\AtLeastTwoAnswers;
use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'game.title' => ['required', 'max:255'],
            'game.description' => ['sometimes'],
            'questions' => ['required', 'array'],
            'questions.*' => ['sometimes'],
            'questions.*.title' => ['required'],
            'questions.*.timeLimit' => ['required'],
            'questions.*.answers' => [
                'required',
                'array',
                new AtLeastOneIsCorrect(),
                new AtLeastTwoAnswers(),
                new AtLeastOneIsIncorrect(),
            ],
            'questions.*.answers.*.text' => ['sometimes', 'max:255'],
            'questions.*.answers.*.isCorrect' => ['required', 'boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'game.title' => 'game title',
            'game.description' => 'game description',
            'questions.*.title' => 'question title',
            'questions.*.timeLimit' => 'time limit'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'questions.required' => 'The game must have at least one question',
            'questions.*.answers.required' => 'The question doesn\'t have any answers'

        ];
    }
}
