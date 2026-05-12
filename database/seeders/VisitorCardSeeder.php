<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitorCardSeeder extends Seeder
{

    public function run(): void
    {
        foreach (range(101, 120) as $number) {

            DB::table('visitor_card')->updateOrInsert(

                ['card_no' => $number],

                [
                    'is_assigned' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
