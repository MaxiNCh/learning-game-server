<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!QuestionType::find(1)) {
            QuestionType::create([
                'id' => '1',
                'text' => 'Four variants',
            ]);
        }
    }
}
