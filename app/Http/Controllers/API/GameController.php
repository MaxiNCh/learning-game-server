<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        $game = Game::create([
            'title' => $request->input('game.title'),
            'description' => $request->input('game.description'),
        ]);

        $questions = $request->input('questions');

        foreach ($questions as $question) {
            if (!empty($question)) {
                $timeLimit = strstr($question['timeLimit'], ' ', true);

                $questionRow = Question::create([
                    'game_id' => $game->id,
                    'text' => $question['title'],
                    'media' => 'somemedia',
                    'question_type_id' => 1,
                    'time_limit' => $timeLimit,
                ]);

                $answers = $question['answers'];

                foreach ($answers as $answer) {
                    if (!empty($answer['text'])) {
                        Answer::create([
                            'question_id' => $questionRow->id,
                            'text' => $answer['text'],
                            'is_correct' => $answer['isCorrect'],
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
