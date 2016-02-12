<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            'name' => 'Rock',
        ]);

        DB::table('genres')->insert([
            'name' => 'Pop',
        ]);

        DB::table('genres')->insert([
            'name' => 'Metal',
        ]);

    }
}
