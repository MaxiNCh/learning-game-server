<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Lobby;
use App\Models\LobbyPlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function close(Lobby $lobby)
    {
        if (empty($lobby)) {
            return response('Lobby not found', 404);
        }

        $lobby->status = 'CLOSE';
        $lobby->save();

        return response('Game closed');
    }

    public function checkPincode(Request $request)
    {
        $pincode = $request->input('pincode');

        if (empty($pincode)) {
            return response(['messsage' => 'Pincode is empty'], 404);
        }

        $lobby = Lobby::Where('pincode', $pincode)->where('status', 'INIT')->first();

        if (!$lobby) {
            return response(['messsage' => 'Lobby not found'], 404);
        }

        return ['lobbyId' => $lobby->id];
    }

    public function joinGame(Request $request)
    {
        $validated = $request->validate([
            'nickname' => 'string',
            'lobbyId' => 'numeric',
        ]);

        $lobby = Lobby::find($validated['lobbyId']);

        $lobbyPlayer = LobbyPlayer::where('lobby_id', $validated['lobbyId'])->where('username', $validated['nickname'])->first();

        if ($lobbyPlayer) {
            return response(['message' => 'Player with such nickname already exists'], 409);
        }

        if ($lobby) {
            $player = LobbyPlayer::create([
                'username' => $validated['nickname'],
                'lobby_id' => $validated['lobbyId'],
            ]);

            Auth::guard('lobby')->login($player);
            $request->session()->regenerate();

            return response(['message' => 'Player created']);
        }
    }
}
