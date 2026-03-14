<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class CreateCourse {
    public function execute($data){
        DB::transaction(function() use ($data) {

        });
    }
}