<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Http\Resources\GameResource;
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

    public function gamesByUser(Request $request)
    {
        $user = $request->user();

        return GameResource::collection($user->games);
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
        $user = $request->user();

        $game = Game::create([
            'title' => $validated['game']['title'],
            'description' => $validated['game']['description'],
            'author_id' => $user->id,
        ]);

        $questions = $validated['questions'];

        foreach ($questions as $key => $question) {
            if (!empty($question)) {
                $questionRow = Question::create([
                    'game_id' => $game->id,
                    'text' => $questions[$key]['title'],
                    'media' => 'somemedia',
                    'question_type_id' => 1,
                    'time_limit' => $questions[$key]['timeLimit'],
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
