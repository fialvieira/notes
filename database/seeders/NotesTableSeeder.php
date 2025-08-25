<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create multiple notes
        DB::table('notes')->insert([
            [
                'user_id' => 1,
                'title' => 'First Note',
                'text' => 'This is the content of the first note.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 2,
                'title' => 'Second Note',
                'text' => 'This is the content of the second note.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 2,
                'title' => 'Second Note',
                'text' => 'This is the content of the second note.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 3,
                'title' => 'Third Note',
                'text' => 'This is the content of the third note.',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ]);
    }
}
