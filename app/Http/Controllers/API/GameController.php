<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Models\Answer;
use App\Models\Game;
use App\Models\Question;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all();

        return $games;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $validated = $request->validated();

        $game = Game::create([
            'title' => $validated['game']['title'],
            'description' => $validated['game']['description'],
        ]);

        $questions = $validated['questions'];

        foreach ($questions as $key => $question) {
            if (!empty($question)) {
                $timeLimit = strstr($questions[$key]['timeLimit'], ' ', true); // приходит "n seconds", оставляем только n

                $questionRow = Question::create([
                    'game_id' => $game->id,
                    'text' => $questions[$key]['title'],
                    'media' => 'somemedia',
                    'question_type_id' => 1,
                    'time_limit' => $timeLimit,
                ]);

                $answers = $questions[$key]['answers'];

                foreach ($answers as $answerKey => $answer) {
                    if (!empty($answer['text'])) {
                        Answer::create([
                            'question_id' => $questionRow->id,
                            'text' => $answers[$answerKey]['text'],
                            'is_correct' => $answers[$answerKey]['isCorrect'],
                            'media' => 'somemedia',
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}