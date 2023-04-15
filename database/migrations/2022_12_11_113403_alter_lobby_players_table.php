<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lobby_players', function (Blueprint $table) {
            $table->id();
            $table->dropIndex('lobby_players_username_unique');
            $table->unique(['username', 'lobby_id'], 'lobby_players_username_lobby_id_idx');
        });

        Schema::table('player_answers', function (Blueprint $table) {
            $table->dropForeign('player_answers_user_id_foreign');
            $table->dropColumn('user_id');
            $table->foreignId('player_id')->constrained('lobby_players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_answers', function (Blueprint $table) {
            $table->dropForeign('player_answers_player_id_foreign');
            $table->dropColumn('player_id');
            $table->foreignId('user_id')->constrained();
        });

        Schema::table('lobby_players', function (Blueprint $table) {
            $table->dropPrimary();
            $table->unsignedInteger('id')->change();
            $table->dropColumn('id');
            $table->dropIndex('lobby_players_username_lobby_id_idx');
            $table->unique('username');
        });
    }
};
