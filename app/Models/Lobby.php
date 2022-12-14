<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property string $id
 * @property Game $game
 * @property User $host
 * @property string $pincode
 * @property string $status
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 */
class Lobby extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function host()
    {
        return $this->belongsTo(User::class);
    }
}
