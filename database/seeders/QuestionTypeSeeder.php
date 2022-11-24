<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_types')->insertOrIgnore([
            ['id' => 1, 'text' => 'Quiz'],
            ['id' => 2, 'text' => 'True or False'],
        ]);
    }
}
