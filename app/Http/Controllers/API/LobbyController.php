<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Lobby;
use Illuminate\Support\Facades\Gate;

class LobbyController extends Controller
{
    public function create(Game $game)
    {
        Gate::authorize('create-lobby', $game);

        return Lobby::create([
            'game_id'  => $game->id,
            'host_id'  => auth()->user()->id,
            'pincode'  => rand(0, 99999999),
            'status'   => 'INIT',
        ]);
    }
}
