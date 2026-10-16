<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliverablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     $deliverables = [
        ['name' => 'course map', 'offset_days' => 14],
        ['name' => 'prototype modules', 'offset_days' => 35],
        ['name' => 'all modules', 'offset_days' => 63],
        ['name' => 'syllabus and intro', 'offset_days' => 77],
        ['name' => 'final course', 'offset_days' => 90]
     ];

     foreach ($deliverables as $deliverable){
        DB::table('deliverables')->insert([
            'name' => $deliverable['name'],
            'offset_days' => $deliverable['offset_days']
        ]);
     }
       
}
}