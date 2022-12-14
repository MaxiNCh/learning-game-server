<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastController extends Controller
{
    public function auth(Request $request)
    {
        $encodedUser = '';

        $user = auth()->user();
        if ($user) {
            $encodedUser = json_encode([
                'user_id' => $user->id,
                'user_info' => ['user_id' => $user->id, 'isHost' => true]
            ]);
        } else {
            $player = Auth::guard('lobby')->user();
            if ($player) {
                $encodedUser = json_encode([
                    'user_id' => $player->id,
                    'user_info' => ['playerId' => $player->id, 'isHost' => false, 'nickname' => $player->username]
                ]);
            }
        }

        $key = config('broadcasting.connections.pusher.key');

        $input = $request->input();
        $signature = "{$input['socket_id']}:{$input['channel_name']}:{$encodedUser}";
        $hash = hash_hmac('sha256', $signature, config('broadcasting.connections.pusher.secret'));

        return [
            "auth" => "{$key}:{$hash}",
            "channel_data" => $encodedUser,
        ];
    }
}
